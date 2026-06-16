<?php

namespace App\Controllers\Api;

use App\Controllers\BaseAuthController;

class Wishlist extends BaseAuthController
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

    public function add_to_wishlist()
    {
        $user_id    = $this->userData->user_id;
        $product_id = $this->request->getPost('product_id');

        if (empty($user_id) || empty($product_id)) {
            return $this->response->setJSON([
                'status' => false,
                'msg'    => 'Required fields missing'
            ]);
        }

        $wishlistModel = new \App\Models\M_wishlist();

        return $this->response->setJSON(
            $wishlistModel->addToWishlist($user_id, $product_id)
        );
    }

    public function get_wishlist()
    {
        $user_id = $this->userData->user_id;

        $wishlistModel = new \App\Models\M_wishlist();

        return $this->response->setJSON([
            'status'   => true,
            'wishlist' => $wishlistModel->getWishlistList($user_id)
        ]);
    }

    public function remove_wishlist()
    {
        $user_id    = $this->userData->user_id;
        $product_id = $this->request->getPost('product_id');

        $wishlistModel = new \App\Models\M_wishlist();

        return $this->response->setJSON(
            $wishlistModel->removeItem($user_id, $product_id)
        );
    }
}
?>