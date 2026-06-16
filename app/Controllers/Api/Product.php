<?php
namespace App\Controllers\Api;

use App\Controllers\BaseAuthController;

class Product extends BaseAuthController
{
    protected $session;
    protected $validation;
    protected $request;

    public function __construct()
    {
        $this->session    = \Config\Services::session();
        $this->validation = \Config\Services::validation();
        $this->request    = \Config\Services::request();
    }
public function get_categories()
    {
        $m_category = new \App\Models\M_category();
        $response['categoies'] = $m_category->get_categories();
        return json_encode($response);
    }
public function get_products()
{
    $m_product = new \App\Models\M_product();
    $response['products'] = $m_product->getProducts();
    return json_encode($response);
}
 public function search_products()
{
    $keyword = $this->request->getVar('keyword');
    $m_product = new \App\Models\M_product();

    $response['products']
        = $m_product->searchProducts($keyword);

    return json_encode($response);
}
public function get_featured_products()
{
    $m_product = new \App\Models\M_product();

    $response['products'] = $m_product->getFeaturedProducts();

    return json_encode($response);
}
public function get_banners()
{
    $m_product = new \App\Models\M_banner();
    $response['banners'] = $m_product->getBanners();
    return json_encode($response);
}
}
?>