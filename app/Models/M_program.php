<?php

namespace App\Models;

use CodeIgniter\Model;

class M_program extends Model
{
    protected $table = 'programs';

    protected $allowedFields = [
        'id',
        'icon',
        'name',
        'short_desc',
        'status',
        'created_at',
        'updated_at',
    ];
public function get_programs()
  {
    $this->where('status',1);
    return $this->get()->getResult();
  }
public function get_program($id)
  {
    $this->where('id',$id);
    return $this->get()->getRow();
  }
public function insert_program($data)
  {
    return  $this->insert($data);
  }
public function update_program($data,$id)
  {
    $this->set($data);
    $this->where('id',$id);
    return $this->update();
  }
  public function delete_program($id)
    {
      $this->set('status',0);
      $this->where('id',$id);
      return $this->update();
    }
}
?>
