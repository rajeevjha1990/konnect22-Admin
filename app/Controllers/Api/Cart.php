<?php
namespace App\Controllers\Api;

use App\Controllers\BaseAuthController;
class Cart extends BaseAuthController
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
public function add_to_cart()
{
    $user_id    = $this->userData->user_id;
    $product_id = $this->request->getPost('product_id');
    $quantity   = $this->request->getPost('qty');
    $vendorid   = $this->request->getPost('vendor_id');

    if (empty($user_id) || empty($product_id)) {
        return $this->response->setJSON([
            'status' => false,
            'msg'    => 'Required fields missing'
        ]);
    }

    $cartModel = new \App\Models\M_cart();

    $result = $cartModel->addToCart(
        $user_id,
        $product_id,
        $quantity,
        $vendorid 
    );

    return $this->response->setJSON($result);
}
public function get_cart()
{
    $user_id = $this->userData->user_id;

        $cartModel = new \App\Models\M_cart();


    return $this->response->setJSON([
        'status' => true,
        'cart' => $cartModel->getCartList($user_id)
    ]);
    
}
public function update_cart_qty()
{
    $user_id = $this->userData->user_id;
    $product_id = $this->request->getPost('product_id');
    $action = $this->request->getPost('action');

        $cartModel = new \App\Models\M_cart();


    return $this->response->setJSON(
        $cartModel->updateQty($user_id, $product_id, $action)
    );
}
public function remove_cart_item()
{
    $user_id = $this->userData->user_id;
    $product_id = $this->request->getPost('product_id');

       $cartModel = new \App\Models\M_cart();


    return $this->response->setJSON(
        $cartModel->removeItem($user_id, $product_id)
    );
}
   }
?>