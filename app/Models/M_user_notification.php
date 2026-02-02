<?php

namespace App\Models;

use CodeIgniter\Model;

class M_user_notification extends Model
{
    protected $table = 'user_notifications';

    protected $allowedFields = [
        'id',
        'user_id',
        'notification_id',
        'is_read',
        'read_at',
    ];
public function mark_as_read($user_id, $notification_id)
{

    $exists = $this
        ->where('user_id', $user_id)
        ->where('notification_id', $notification_id)
        ->get()
        ->getRow();

    if ($exists) {
        return $this
            ->where('id', $exists->id)
            ->update([
                'is_read' => 1,
                'read_at' => date('Y-m-d H:i:s')
            ]);
    } else {
        return $this->insert([
            'user_id' => $user_id,
            'notification_id' => $notification_id,
            'is_read' => 1,
            'read_at' => date('Y-m-d H:i:s')
        ]);
    }
}


}
?>