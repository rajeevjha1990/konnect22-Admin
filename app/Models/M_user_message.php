<?php namespace App\Models;

use CodeIgniter\Model;

class M_user_message extends Model
{
    protected $table = 'user_messages';
    protected $allowedFields = [
        'user_id',
        'msg_id',
        'is_read',
        'read_at'
    ];
}
?>