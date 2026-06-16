<?php

namespace App\Models;

use CodeIgniter\Model;

class M_banner extends Model
{
    protected $table = 'banners';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'image',
        'title',
        'subtitle',
        'status',
        'created'
    ];

    public function getBanners()
    {
        return $this->orderBy('id', 'DESC')
                    ->findAll();
    }

    public function getBanner($id)
    {
        $this->where('id',$id);
        return $this->get()->getRow();
    }

    public function saveBanner($data)
    {
        return $this->insert($data);
    }

    public function updateBanner($id, $data)
    {
        return $this->update($id, $data);
    }

    public function deleteBanner($id)
    {
        return $this->delete($id);
    }
}
?>
