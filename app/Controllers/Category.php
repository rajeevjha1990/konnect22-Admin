<?php

namespace App\Controllers;

use App\Models\M_category;

class Category extends BaseController
{
    protected $session;
    protected $validation;
    protected $request;
    protected $categoryModel;
    protected $data = [];

    public function __construct()
    {
        $this->session       = \Config\Services::session();
        $this->validation    = \Config\Services::validation();
        $this->request       = \Config\Services::request();
        $this->categoryModel = new M_category();
    }

    private function setCommonData()
    {
        $this->data['admin'] = [
            'admin_name' => session()->get('admin_name'),
            'type'       => session()->get('type')
        ];

        $this->data['admin_name'] = session()->get('admin_name');
    }

    public function index()
    {
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/');
        }

        $this->setCommonData();

        $this->data['categories'] =
            $this->categoryModel->get_categories();

        echo view('includes/header', $this->data);
        echo view('includes/sidebar', $this->data);
        echo view('category', $this->data);
        echo view('includes/footer');
    }

    public function add()
    {
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/');
        }

        $this->setCommonData();

        echo view('includes/header', $this->data);
        echo view('includes/sidebar', $this->data);
        echo view('new_category', $this->data);
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
                    ROOTPATH.'public/uploads/categories/',
                    $image
                );
            }
        }

        $data = [
            'name' =>
                trim($this->request->getPost('category_name')),
            'status' =>
                $this->request->getPost('status')
        ];

        if (!empty($image)) {
            $data['image_url'] = $image;
        }

        if (empty($id)) {

            $resp =
                $this->categoryModel->saveCategory($data);

            $msg = "Category added successfully";

        } else {

            $resp =
                $this->categoryModel->updateCategory(
                    $id,
                    $data
                );

            $msg = "Category updated successfully";
        }

        if ($resp) {

            return $this->response->setJSON([
                'status'   => true,
                'message'  => $msg,
                'redirect' => base_url('category')
            ]);

        } else {

            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Error, try again.'
            ]);
        }
    }

    public function edit($id)
    {
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/');
        }

        $this->setCommonData();

        $this->data['category'] =
            $this->categoryModel->getCategory($id);
        echo view('includes/header', $this->data);
        echo view('includes/sidebar', $this->data);
        echo view('new_category', $this->data);
        echo view('includes/footer');
    }

    public function delete($id)
    {
        $resp =
            $this->categoryModel->deleteCategory($id);
        return $this->response->setJSON([
            'status'   => $resp ? true : false,
            'message'  => $resp
                ? 'Category deleted successfully'
                : 'Delete failed',
            'redirect' => base_url('categories')
        ]);
    }

    public function search()
    {
        $keyword =
            $this->request->getGet('keyword');

        $this->setCommonData();

        $this->data['categories'] =
            $this->categoryModel->searchCategories(
                $keyword
            );

        echo view('includes/header', $this->data);
        echo view('includes/sidebar', $this->data);
        echo view('categories', $this->data);
        echo view('includes/footer');
    }
}