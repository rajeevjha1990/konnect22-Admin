<?php

namespace App\Models;

use CodeIgniter\Model;

class M_order_item extends Model
{
    protected $table = 'order_items';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'order_id',
        'product_id',
        'price',
        'qty',
        'vendor_id'
    ];

    public function insert_item($data)
    {
        return $this->insert($data);
    }
}