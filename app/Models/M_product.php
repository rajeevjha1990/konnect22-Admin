<?php

namespace App\Models;

use CodeIgniter\Model;

class M_product extends Model
{
    protected $table = 'products';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'vendor_id',
        'category_id',
        'name',
        'description',
        'price',
        'mrp',
        'stock_quantity',
        'alert_quantity',
        'image_webp',
        'is_featured',
        'status',
        'created_at',
    ];

    public function get_products()
    {
        return $this->where('status', 'available')
                    ->findAll();
    }
    public function getProducts()
    {
        return $this->select('products.*, vendors.shop_name, categories.name as catname')
                    ->join('vendors', 'vendors.id = products.vendor_id', 'left')
                    ->join('categories', 'categories.id = products.category_id', 'left')
                    ->orderBy('products.id', 'DESC')
                    ->findAll();
    }

    public function getProduct($id)
    {
        $this->where('id',$id);
        return $this->get()->getRow();
    }

    public function saveProduct($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->insert($data);
    }

    public function updateProduct($id, $data)
    {
        return $this->update($id, $data);
    }

    public function deleteProduct($id)
    {
        return $this->delete($id);
    }

public function searchProducts($keyword)
{
    return $this->select('products.*')
                ->like('products.name', $keyword)
                ->orderBy('products.id', 'DESC')
                ->findAll();
}
public function getFeaturedProducts()
{
    return $this->where('status', 'available')
                ->where('is_featured', 1)
                ->orderBy('id', 'DESC')
                ->findAll();
}
}
?>