<?php

namespace App\Models;

use CodeIgniter\Model;

class M_program_apply extends Model
{
    protected $table = 'new_sanitary_order';
    protected $primaryKey = 'order_id';  
    protected $allowedFields = [
    'order_id',
    'program_id',
    'associate_id',  
    'order_name',
    'order_number',
    'order_pincode',
    'order_address',
    'amount',
    'payment_mode',
    'payment_status',
    'transaction_id',
    'order_status',
    'order_created',
    'assigned_at',    
];

   public function insert_apply($data)
  {
    return  $this->insert($data);
  }
public function get_orders($programid)
    {
        $this->where('order_status',0);
        $this->where('program_id',$programid);
        $this->select('p.name,v.volntr_name,v.volntr_ep_temp,new_sanitary_order.*');
        $this->join('programs p','p.id=new_sanitary_order.program_id','left');
        $this->join('volunteer v','v.volntr_id=new_sanitary_order.associate_id','left');
        $this->orderBy('order_id','DESC');
        return $this->get()->getResult();
    }
public function getOrderById($orderId)
{
    return $this->where('order_id', $orderId)->first();
}

public function get_applycounts($associateId)
{
    return $this->where('associate_id', $associateId)
                ->where('order_status !=', 1)
                ->countAllResults();
}
public function assignVolunteerToOrder($orderId, $volunteerId)
{
    return $this->where('order_id', $orderId)->set([
        'associate_id' => $volunteerId,
        'order_status' => 'assigned',
        'assigned_at'  => date('Y-m-d H:i:s')
    ])->update();
}
public function assigned_order($orderId, $pincode)
{
     
        $this->where('order_id',$orderId);
        $this->where('order_pincode',$pincode);
        return $this->get()->getRow();
    }
public function change_assigne($orderId, $volunteerId)
{
    return $this->where('order_id', $orderId)->set([
        'associate_id' => $volunteerId,
        'assigned_at'  => date('Y-m-d H:i:s')
    ])->update();
}
}
?>
