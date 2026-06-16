<?php

namespace App\Models;

use CodeIgniter\Model;

class M_order extends Model
{
    protected $table = 'orders';

    protected $primaryKey = 'id';

    protected $allowedFields = [

        'order_no',

        'user_id',

        'order_name',
        'order_number',

        'order_address',
        'order_city',
        'order_pincode',
        'order_landmark',

        'subtotal',
        'shipping',
        'discount',
        'total',

        'payment_mode',
        'payment_status',

        'status',

        'estimated_delivery',

        'created_at'
    ];

    public function insert_order($data)
    {
        return $this->insert($data, true);
    }
public function get_orders($userid)
{
    return $this
        ->select('
            orders.*,
            order_items.product_id,
            order_items.vendor_id,
            order_items.qty,
            order_items.price,

            products.name as product_name,
            products.image_webp as image_webp,

            vendors.owner_name as vendor_name,
            vendors.mobile as vendor_mobile
        ')
        ->join(
            'order_items',
            'order_items.order_id = orders.id',
            'left'
        )
        ->join(
            'products',
            'products.id = order_items.product_id',
            'left'
        )
        ->join(
            'vendors',
            'vendors.id = order_items.vendor_id',
            'left'
        )
        ->where('orders.user_id', $userid)
        ->orderBy('orders.id', 'DESC')
        ->findAll();
}
public function get_order_details($orderId)
{
    return $this
        ->db
        ->table('order_items')
        ->select('
            order_items.*,

            orders.order_no,
            orders.total,
            orders.order_name,
            orders.order_number,
            orders.order_address,
            orders.order_city,
            orders.order_pincode,
            orders.order_landmark,
            orders.payment_mode,
            orders.payment_status,
            orders.status,

            products.name as product_name,
            products.image_webp,

            vendors.owner_name as vendor_name
        ')
        ->join('orders','orders.id=order_items.order_id')
        ->join('products','products.id=order_items.product_id')
        ->join('vendors','vendors.id=order_items.vendor_id')
        ->where('order_items.order_id',$orderId)
        ->get()
        ->getResultArray();
}
}
?>