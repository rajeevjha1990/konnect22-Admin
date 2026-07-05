<?php

namespace App\Controllers;

use App\Models\M_product;
use App\Models\M_vendor;
use App\Models\M_category;

class Product extends BaseController
{
    protected $session;
    protected $request;
    protected $productModel;
    protected $vendorModel;
    protected $categoryModel;
    protected $data = [];

    public function __construct()
    {
        $this->session       = \Config\Services::session();
        $this->request       = \Config\Services::request();

        $this->productModel  = new M_product();
        $this->vendorModel   = new M_vendor();
        $this->categoryModel = new M_category();
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

        $this->data['products'] =
            $this->productModel->getProducts();

        echo view('includes/header', $this->data);
        echo view('includes/sidebar', $this->data);
        echo view('products', $this->data);
        echo view('includes/footer');
    }

    public function add()
    {
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/');
        }

        $this->setCommonData();

        $this->data['vendors'] =
            $this->vendorModel->getVendors();

        $this->data['categories'] =
            $this->categoryModel->activeCategories();
            
        echo view('includes/header', $this->data);
        echo view('includes/sidebar', $this->data);
        echo view('new_product', $this->data);
        echo view('includes/footer');
    }

    public function save()
{
    $id = $this->request->getPost('id');

    $image = '';

    if (!empty($_FILES['image']['name'])) {

        $file = $this->request->getFile('image');

        if ($file->isValid() && !$file->hasMoved()) {

            $image = time() . '_' . $file->getRandomName();

            $uploadPath = ROOTPATH . 'public/uploads/products/';

            // Upload original image
            $file->move($uploadPath, $image);

            // Resize (Aspect Ratio Maintain)
            \Config\Services::image()
                ->withFile($uploadPath . $image)
                ->resize(
                    1000,     // Max Width
                    1000,     // Max Height
                    true,     // Maintain Aspect Ratio
                    'auto'
                )
                ->save($uploadPath . $image, 90);
        }
    }

    $data = [
        'vendor_id'      => $this->request->getPost('vendor_id'),
        'category_id'    => $this->request->getPost('category_id'),
        'name'           => $this->request->getPost('product_name'),
        'description'    => $this->request->getPost('description'),
        'price'          => $this->request->getPost('price'),
        'mrp'            => $this->request->getPost('sale_price'),
        'stock_quantity' => $this->request->getPost('stock'),
        'status'         => $this->request->getPost('status'),
    ];

    if (!empty($image)) {
        $data['image_webp'] = $image;
    }

    if (empty($id)) {

        $resp = $this->productModel->saveProduct($data);
        $msg  = 'Product added successfully';

    } else {

        $resp = $this->productModel->updateProduct($id, $data);
        $msg  = 'Product updated successfully';
    }

    return $this->response->setJSON([
        'status'   => (bool) $resp,
        'message'  => $msg,
        'redirect' => base_url('product')
    ]);
}

    public function edit($id)
    {
        $this->setCommonData();

        $this->data['product'] =
            $this->productModel->getProduct($id);
        $this->data['vendors'] =
            $this->vendorModel->getVendors();

        $this->data['categories'] =
            $this->categoryModel->activeCategories();

        echo view('includes/header', $this->data);
        echo view('includes/sidebar', $this->data);
        echo view('new_product', $this->data);
        echo view('includes/footer');
    }

    public function delete($id)
    {
        $resp = $this->productModel->deleteProduct($id);

        return $this->response->setJSON([
            'status'   => $resp ? true : false,
            'message'  => 'Product deleted successfully',
            'redirect' => base_url('products')
        ]);
    }
public function toggle_featured($id, $value)
{
    $m_product = new \App\Models\M_product();

    $m_product->update($id, [
        'is_featured' => $value
    ]);

    return redirect()->back();
}

}
?>