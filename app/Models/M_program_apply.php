<?php

namespace App\Models;

use CodeIgniter\Model;

class M_program_apply extends Model
{
    protected $table = 'new_sanitary_order';

    protected $allowedFields = [
        'order_id',
        'program_id',
        'order_name',
        'order_number',
        'order_pincode',
        'order_address',
        'amount',
        'payment_mode',
        'payment_status',
        'transaction_id',
        'order_address',
        'admin_created',
    ];
   public function insert_apply($data)
  {
    return  $this->insert($data);
  }
}
?>
