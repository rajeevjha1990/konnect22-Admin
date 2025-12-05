<?php

namespace App\Models;

use CodeIgniter\Model;

class M_block extends Model
{
    protected $table = 'blocks';
    protected $allowedFields = [
        'block_id',
        'block_name',
        'block_district',
        'block_status',
        'block_created',
    ];

  public function district_blocks($districtId)
    {
      $this->where('block_district',$districtId);
      $this->where('block_status',1);
      return $this->get()->getResult();
    }
  public function get_block($id,$districtId)
    {
      $this->where('block_id',$id);
      $this->where('block_district',$districtId);
      return $this->get()->getRow();
    }
  public function insert_block($data)
    {
      return  $this->insert($data);
    }
  public function update_block($id,$data)
    {
      $this->set($data);
      $this->where('block_id',$id);
      return $this->update();
    }
  public function delete_block($id)
    {
      $this->set('block_status',0);
      $this->where('block_id',$id);
      return $this->update();
    }
}
?>
