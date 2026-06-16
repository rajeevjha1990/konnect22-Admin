<?php

namespace App\Models;

use CodeIgniter\Model;

class M_category extends Model
{
    protected $table = 'categories';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'id',
        'name',
        'image_url',
        'status',
        'created_at',
    ];

    public function get_categories()
    {
        return $this->where('status', 'active')
                    ->findAll();
    }
    public function getCategory($id)
    {
        return $this->where('id', $id)->first();
    }

    public function saveCategory($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');

        return $this->insert($data);
    }

    public function updateCategory($id, $data)
    {
        return $this->update($id, $data);
    }

public function deleteCategory($id)
{
    return $this->where('id', $id)
                ->set(['status' => 'inactive'])
                ->update();
}

    public function searchCategories($keyword)
    {
        return $this->like('category_name', $keyword)
                    ->orderBy('id', 'DESC')
                    ->findAll();
    }

    public function totalCategories()
    {
        return $this->countAllResults();
    }

    public function activeCategories()
    {
        return $this->where('status', 'Active')->findAll();
    }
}
?>