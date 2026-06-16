<?php

namespace App\Controllers;

use App\Models\M_banner;

class Banner extends BaseController
{
    protected $session;
    protected $request;
    protected $bannerModel;
    protected $data = [];

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->request = \Config\Services::request();

        $this->bannerModel = new M_banner();
    }

    private function setCommonData()
    {
        $this->data['admin'] = [
            'admin_name' => session()->get('admin_name'),
            'type'       => session()->get('type')
        ];
    }

    public function index()
    {
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/');
        }

        $this->setCommonData();

        $this->data['banners'] =
            $this->bannerModel->getBanners();

        echo view('includes/header', $this->data);
        echo view('includes/sidebar', $this->data);
        echo view('banners', $this->data);
        echo view('includes/footer');
    }

    public function add()
    {
        $this->setCommonData();

        echo view('includes/header', $this->data);
        echo view('includes/sidebar', $this->data);
        echo view('new_banner', $this->data);
        echo view('includes/footer');
    }

    public function save()
    {
        $id = $this->request->getPost('id');

        $image = '';

        if (!empty($_FILES['image']['name'])) {

            $file = $this->request->getFile('image');

            if ($file->isValid()) {

                $image = time().'_'.$file->getRandomName();

                $file->move(
                    ROOTPATH.'public/uploads/banners/',
                    $image
                );
            }
        }

        $data = [

            'title'    => $this->request->getPost('title'),
            'subtitle' => $this->request->getPost('subtitle'),

        ];

        if (!empty($image)) {
            $data['image'] = $image;
        }

        if (empty($id)) {

            $resp = $this->bannerModel->saveBanner($data);
  
            $msg = "Banner added successfully";

        } else {

            $resp = $this->bannerModel->updateBanner(
                $id,
                $data
            );

            $msg = "Banner updated successfully";
        }

        return $this->response->setJSON([
            'status'   => $resp ? true : false,
            'message'  => $msg,
            'redirect' => base_url('banner')
        ]);
    }

    public function edit($id)
    {
        $this->setCommonData();

        $this->data['banner'] =
            $this->bannerModel->getBanner($id);

        echo view('includes/header', $this->data);
        echo view('includes/sidebar', $this->data);
        echo view('new_banner', $this->data);
        echo view('includes/footer');
    }

    public function delete($id)
    {
        $resp = $this->bannerModel->deleteBanner($id);

        return $this->response->setJSON([
            'status'   => $resp ? true : false,
            'message'  => 'Banner deleted successfully',
            'redirect' => base_url('banner')
        ]);
    }
}
?>
