<?php

namespace App\Controllers;

use App\Models\M_vendor;

class Vendor extends BaseController
{
    protected $session;
    protected $validation;
    protected $request;
    protected $vendorModel;
    protected $data = [];

    public function __construct()
    {
        $this->session     = \Config\Services::session();
        $this->validation  = \Config\Services::validation();
        $this->request     = \Config\Services::request();
        $this->vendorModel = new M_vendor();

    }

    /*
    |--------------------------------------------------------------------------
    | Check Login
    |--------------------------------------------------------------------------
    */
    private function checkLogin()
    {
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/');
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Common Data
    |--------------------------------------------------------------------------
    */
    private function setCommonData()
    {
        $this->data['admin'] = [
            'admin_name' => session()->get('admin_name'),
            'type'       => session()->get('type')
        ];

        $this->data['admin_name'] = session()->get('admin_name');
    }

    /*
    |--------------------------------------------------------------------------
    | Vendor List
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/');
        }

        $this->setCommonData();
    $categoryModel = new \App\Models\M_category();

 $this->data['vendors'] =
            $this->vendorModel->getVendors();
        echo view('includes/header', $this->data);
        echo view('includes/sidebar', $this->data);
        echo view('vendors', $this->data);
        echo view('includes/footer');
    }

    /*
    |--------------------------------------------------------------------------
    | Add Vendor Form
    |--------------------------------------------------------------------------
    */
    public function add()
    {
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/');
        }

        $this->setCommonData();
       
            $categoryModel = new \App\Models\M_category();

        $this->data['categories'] =  $categoryModel->get_categories();
        echo view('includes/header', $this->data);
        echo view('includes/sidebar', $this->data);
        echo view('new_vendor', $this->data);
        echo view('includes/footer');
    }

    /*
    |--------------------------------------------------------------------------
    | Save / Update Vendor
    |--------------------------------------------------------------------------
    */
public function save()
{
    $id = $this->request->getPost('id');

    $rules = [

        'shop_name' => [
            'label' => 'Shop Name',
            'rules' => 'required|min_length[3]'
        ],

        'owner_name' => [
            'label' => 'Owner Name',
            'rules' => 'required|min_length[3]'
        ],

        'mobile' => [
            'label' => 'Mobile Number',
            'rules' => 'required|numeric|exact_length[10]'
        ],

        'email' => [
            'label' => 'Email',
            'rules' => 'required|valid_email'
        ],

        
    ];

    if (!$this->validate($rules)) {

        return $this->response->setJSON([
            'status'  => false,
            'message' => $this->validator->getError(array_key_first($this->validator->getErrors()))
        ]);
    }

    $data = [

        'vendor_code' => $this->generateVendorCode(),
        'category_id'   => trim($this->request->getPost('category_id')),
        'shop_name'   => trim($this->request->getPost('shop_name')),
        'owner_name'  => trim($this->request->getPost('owner_name')),
        'mobile'      => trim($this->request->getPost('mobile')),
        'email'       => trim($this->request->getPost('email')),
        'address'     => trim($this->request->getPost('address')),
        'gst_no'      => trim($this->request->getPost('gst_no')),
    ];

    // Unique validation
    $mobileExists = $this->vendorModel
        ->where('mobile', $data['mobile'])
        ->where('id !=', (int)$id)
        ->first();

    if ($mobileExists) {

        return $this->response->setJSON([
            'status'  => false,
            'message' => 'Mobile number already exists.'
        ]);
    }

    $emailExists = $this->vendorModel
        ->where('email', $data['email'])
        ->where('id !=', (int)$id)
        ->first();

    if ($emailExists) {

        return $this->response->setJSON([
            'status'  => false,
            'message' => 'Email already exists.'
        ]);
    }

    if (empty($id)) {

        $resp = $this->vendorModel->saveVendor($data);

        $msg = 'Vendor added successfully';

    } else {

        unset($data['vendor_code']);

        $resp = $this->vendorModel->updateVendor($id, $data);

        $msg = 'Vendor updated successfully';
    }

    if ($resp) {

        return $this->response->setJSON([
            'status'   => true,
            'message'  => $msg,
            'redirect' => base_url('vendor')
        ]);
    }

    return $this->response->setJSON([
        'status'  => false,
        'message' => 'Error, try again.'
    ]);
}
    /*
    |--------------------------------------------------------------------------
    | Generate Vendor Code
    |--------------------------------------------------------------------------
    */
    private function generateVendorCode()
    {
        $count = $this->vendorModel->countAll() + 1;

        return 'VND' . str_pad($count, 5, '0', STR_PAD_LEFT);
    }

    /*
    |--------------------------------------------------------------------------
    | Edit Vendor
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/');
        }

        $this->setCommonData();
        $categoryModel = new \App\Models\M_category();

        $this->data['categories'] =  $categoryModel->get_categories();
        $this->data['vendor'] = $this->vendorModel->getVendor($id);

        echo view('includes/header', $this->data);
        echo view('includes/sidebar', $this->data);
        echo view('new_vendor', $this->data);
        echo view('includes/footer');
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Vendor
    |--------------------------------------------------------------------------
    */
    public function delete($id)
    {
        $resp = $this->vendorModel->deleteVendor($id);

        if ($resp) {

            return $this->response->setJSON([
                'status'   => true,
                'message'  => 'Vendor deleted successfully',
                'redirect' => base_url('vendor')
            ]);

        } else {

            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Delete failed, try again.'
            ]);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | View Vendor
    |--------------------------------------------------------------------------
    */
    public function view($id)
    {
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/');
        }

        $this->setCommonData();

        $this->data['vendor'] = $this->vendorModel->getVendor($id);

        echo view('includes/header', $this->data);
        echo view('includes/sidebar', $this->data);
        echo view('vendor_view', $this->data);
        echo view('includes/footer');
    }

    /*
    |--------------------------------------------------------------------------
    | Search Vendor
    |--------------------------------------------------------------------------
    */
    public function search()
    {
        $keyword = $this->request->getGet('keyword');

        $this->setCommonData();

        $this->data['vendor'] = $this->vendorModel->searchVendor($keyword);

        echo view('includes/header', $this->data);
        echo view('includes/sidebar', $this->data);
        echo view('vendor', $this->data);
        echo view('includes/footer');
    }
    public function getByCategory($categoryId)
    {
        $vendors = $this->vendorModel
                        ->where('category_id', $categoryId)
                        ->orderBy('owner_name', 'ASC')
                        ->findAll();

        return $this->response->setJSON($vendors);
    }
}
?>