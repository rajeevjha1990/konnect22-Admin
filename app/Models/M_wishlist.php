<?php

namespace App\Models;

use CodeIgniter\Model;

class M_wishlist extends Model
{
    protected $table = 'wishlist';
    protected $primaryKey = 'wishlist_id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'user_id',
        'product_id',
        'status',
        'created',
    ];

    public function addToWishlist($user_id, $product_id)
    {
        $existing = $this
            ->where('user_id', $user_id)
            ->where('product_id', $product_id)
            ->first();

        if ($existing) {
            return [
                'status' => true,
                'msg' => 'Already in wishlist'
            ];
        }

        $this->insert([
            'user_id'    => $user_id,
            'product_id' => $product_id,
            'status'     => 1,
        ]);

        return [
            'status' => true,
            'msg' => 'Product added to wishlist'
        ];
    }

    public function getWishlistList($user_id)
    {
        return $this->db->table('wishlist w')
            ->select('
                w.wishlist_id,
                p.id,
                p.name,
                p.price,
                p.image_webp
            ')
            ->join('products p', 'p.id = w.product_id')
            ->where('w.user_id', $user_id)
            ->where('w.status', 1)
            ->get()
            ->getResultArray();
    }

    public function removeItem($user_id, $product_id)
    {
        $this->where('user_id', $user_id)
            ->where('product_id', $product_id)
            ->delete();

        return [
            'status' => true,
            'msg' => 'Item removed from wishlist'
        ];
    }
}
?>