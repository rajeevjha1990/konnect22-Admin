<?php

namespace App\Models;

use CodeIgniter\Model;

class M_associate_new_order extends Model
{
    protected $table = 'associate_new_order';

    protected $allowedFields = [
        'id',
        'order_id',
        'program_id',
        'associate_id',
        'status',
        'created',
    ];
   public function insert_apply($data)
  {
    return  $this->insert($data);
  }
public function get_orders()
    {
        $this->where('order_status',0);
        $this->select('p.name,new_sanitary_order.*');
        $this->join('programs p','p.id=new_sanitary_order.program_id','left');
        return $this->get()->getResult();
    }
}
?>
