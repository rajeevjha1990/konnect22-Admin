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

}
?>
