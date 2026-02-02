<?php

namespace App\Models;

use CodeIgniter\Model;

class M_admin extends Model
{
    protected $table = 'messages';
    protected $primaryKey = 'msg_id';
    protected $allowedFields = [
        'msg_title',
        'msg_text',
        'msg_status'
    ];
public function get_all_messages()
    {
        return $this->where('msg_status', 1)
                    ->orderBy('msg_id', 'DESC')
                    ->findAll();
    }
}
?>