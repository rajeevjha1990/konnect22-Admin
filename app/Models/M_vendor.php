<?php

namespace App\Models;

use CodeIgniter\Model;

class M_vendor extends Model
{
    protected $table            = 'vendors';
    protected $primaryKey       = 'id';
    protected $returnType       = 'object';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'vendor_code',
        'category_id',
        'shop_name',
        'owner_name',
        'mobile',
        'email',
        'address',
        'gst_no',
        'status',
        'created_at'
    ];

    protected $useTimestamps = false;

    /*
    |--------------------------------------------------------------------------
    | Get All Vendor
    |--------------------------------------------------------------------------
    */
    public function getVendors()
{
    return $this->select('vendors.*, categories.name as category_name')
                ->join(
                    'categories',
                    'categories.id = vendors.category_id',
                    'left'
                )
                ->orderBy('vendors.id', 'DESC')
                ->findAll();
}
    /*
    |--------------------------------------------------------------------------
    | Get Single Vendor
    |--------------------------------------------------------------------------
    */
    public function getVendor($id)
    {
        return $this->where('id', $id)->first();
    }

    /*
    |--------------------------------------------------------------------------
    | Insert Vendor
    |--------------------------------------------------------------------------
    */
    public function saveVendor($data)
    {
        if (empty($data['vendor_code'])) {
            $data['vendor_code'] = $this->generateVendorCode();
        }

        $data['created_at'] = date('Y-m-d H:i:s');

        return $this->insert($data);
    }

    /*
    |--------------------------------------------------------------------------
    | Update Vendor
    |--------------------------------------------------------------------------
    */
    public function updateVendor($id, $data)
    {
        return $this->update($id, $data);
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Vendor
    |--------------------------------------------------------------------------
    */
    public function deleteVendor($id)
    {
        return $this->where('id', $id)
                ->set(['status' => 'inactive'])
                ->update();
    }

    /*
    |--------------------------------------------------------------------------
    | Search Vendor
    |--------------------------------------------------------------------------
    */
    public function searchVendor($keyword)
    {
        return $this->groupStart()
                    ->like('shop_name', $keyword)
                    ->orLike('owner_name', $keyword)
                    ->orLike('mobile', $keyword)
                    ->orLike('vendor_code', $keyword)
                    ->groupEnd()
                    ->orderBy('id', 'DESC')
                    ->findAll();
    }

    /*
    |--------------------------------------------------------------------------
    | Total Vendor
    |--------------------------------------------------------------------------
    */
    public function totalVendor()
    {
        return $this->countAllResults();
    }

    /*
    |--------------------------------------------------------------------------
    | Active Vendor
    |--------------------------------------------------------------------------
    */
    public function activeVendor()
    {
        return $this->where('status', 'Active')->findAll();
    }

    /*
    |--------------------------------------------------------------------------
    | Auto Generate Vendor Code
    |--------------------------------------------------------------------------
    */
    public function generateVendorCode()
    {
        $last = $this->orderBy('id', 'DESC')->first();

        if ($last) {
            $num = $last->id + 1;
        } else {
            $num = 1;
        }

        return 'VND' . str_pad($num, 5, '0', STR_PAD_LEFT);
    }
}