<?php

namespace App\Models;

use CodeIgniter\Model;

class M_cart extends Model
{
    protected $table = 'cart';
    protected $primaryKey = 'cart_id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'user_id',
        'quantity',
        'product_id',
        'vendor_id',
        'status',
        'created',
    ];

    public function addToCart($user_id, $product_id, $quantity = 1,$vendorid)
    {
        $existing = $this
            ->where('user_id', $user_id)
            ->where('product_id', $product_id)
            ->first();

        if ($existing) {

            $newQty = (int)$existing['quantity'] + (int)$quantity;

            $this->update(
                $existing['cart_id'],
                [
                    'quantity' => $newQty
                ]
            );

            return [
                'status' => true,
                'msg' => 'Cart updated successfully'
            ];
        }

        $this->insert([
            'user_id' => $user_id,
            'product_id' => $product_id,
            'quantity' => $quantity,
            'vendor_id'=>$vendorid,
            'status' => 1,
        ]);

        return [
            'status' => true,
            'msg' => 'Product added to cart'
        ];
    }
public function getCartList($user_id)
{
    return $this->db->table('cart c')
        ->select('
            c.cart_id,
            c.quantity,
            c.vendor_id,
            p.id,
            p.name,
            p.price,
            p.image_webp
        ')
        ->join('products p', 'p.id = c.product_id')
        ->where('c.user_id', $user_id)
        ->where('c.status', 1)
        ->get()
        ->getResultArray();
}
public function updateQty($user_id, $product_id, $action)
{
    $cart = $this->where('user_id', $user_id)
                 ->where('product_id', $product_id)
                 ->first();

    if (!$cart) {
        return ['status' => false, 'msg' => 'Cart item not found'];
    }

    $qty = (int)$cart['quantity'];

    if ($action == 'increase') {
        $qty++;
    } else {
        $qty--;
    }

    if ($qty <= 0) {
        $this->delete($cart['cart_id']);
    } else {
        $this->update($cart['cart_id'], [
            'quantity' => $qty
        ]);
    }

    return [
        'status' => true,
        'msg' => 'Quantity updated'
    ];
}

public function removeItem($user_id, $product_id)
{
    $this->where('user_id', $user_id)
         ->where('product_id', $product_id)
         ->delete();

    return [
        'status' => true,
        'msg' => 'Item removed'
    ];
}
public function delete_user_cart($user_id)
{
    return $this->where('user_id', $user_id)->delete();
}
}
?>