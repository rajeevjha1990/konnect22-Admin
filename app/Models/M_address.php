<?php

namespace App\Models;

use CodeIgniter\Model;

class M_address extends Model
{
    protected $table = 'user_address';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'mobile',
        'type',
        'address',
        'landmark',
        'pincode',
        'status',
        'created',
    ];

    public function insert_address($data)
    {
        return $this->insert($data);
    }

    public function getaddresses($userid)
    {
        $this->where('user_id',$userid);
        $this->where('status',1);
        return $this->get()->getResult();
    }  
 public function getaddress($addressid)
    {
        $this->where('id',$addressid);
        return $this->get()->getRow();
    }    
 public function delete_address($addressid)
    {
        $this->where('id',$addressid);
        $this->set('status',0);
        return $this->update();
    }
}
?>
