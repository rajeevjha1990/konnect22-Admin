<?php

namespace App\Models;

use CodeIgniter\Model;

class M_district extends Model
{
    protected $table = 'district';
    protected $allowedFields = [
        'district_id',
        'district_name',
        'district_state',
        'district_status',
        'district_created',
    ];

  public function state_districts($stateId)
    {
      $this->where('district_state',$stateId);
      $this->where('district_status',1);
      return $this->get()->getResult();
    }
  public function get_district($id,$stateId=null)
    {
      $this->where('district_id',$id);
      if (!empty($stateId)) {
          $this->where('district_state', $stateId);
      }
      return $this->get()->getRow();
    }
  public function insert_district($data)
    {
      return  $this->insert($data);
    }
  public function update_district($id,$data)
    {
      $this->set($data);
      $this->where('district_id',$id);
      return $this->update();
    }
  public function delete_district($id)
    {
      $this->set('district_status',0);
      $this->where('district_id',$id);
      return $this->update();
    }
}
?>
