<?php

namespace App\Models;

use CodeIgniter\Model;

class M_village extends Model
{
    protected $table = 'villages';
    protected $allowedFields = [
        'village_id',
        'village_name',
        'village_block',
        'village_status',
        'village_created',
    ];

  public function block_villages($blockId)
    {
      $this->where('village_block',$blockId);
      $this->where('village_status',1);
      return $this->get()->getResult();
    }
  public function get_village($villageid)
    {
      $this->where('village_id',$villageid);
      return $this->get()->getRow();
    }
  public function insert_village($data)
    {
      return  $this->insert($data);
    }
  public function update_village($id,$data)
    {
      $this->set($data);
      $this->where('village_id',$id);
      return $this->update();
    }
  public function delete_village($id)
    {
      $this->set('village_status',0);
      $this->where('village_id',$id);
      return $this->update();
    }
}
?>
