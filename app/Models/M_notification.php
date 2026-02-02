<?php

namespace App\Models;

use CodeIgniter\Model;

class M_notification extends Model
{
    protected $table = 'notification';

    protected $allowedFields = [
        'nftn_id',
        'nftn_title',
        'nftn_text',
        'short_desc',
        'nftn_status',
        'nftn_created',
    ];
public function insert_notification($data)
  {
    return  $this->insert($data);
  }
public function get_notifications()
  {
    $this->where('nftn_status',1);
    return $this->get()->getResult();
  }
public function get_notification($id)
  {
    $this->where('nftn_id',$id);
    return $this->get()->getRow();
  }
public function update_notification($data,$id)
  {
    $this->set($data);
    $this->where('nftn_id',$id);
    return $this->update();
  }
  public function delete_notification($id)
    {
      $this->set('nftn_status',0);
      $this->where('nftn_id',$id);
      return $this->update();
    }
public function get_notifications_with_read_status($user_id)
{
    $this->select('notification.*, IF(un.is_read IS NULL, 0, un.is_read) AS is_read');

    $this->join(
        'user_notifications un',
        'notification.nftn_id = un.notification_id AND un.user_id = ' . (int)$user_id,
        'left'
    );

    $this->where('notification.nftn_status', 1);

    // ONLY UNREAD
    $this->groupStart()
         ->where('un.is_read IS NULL')
         ->orWhere('un.is_read', 0)
         ->groupEnd();

    $this->orderBy('notification.nftn_id', 'DESC');

    return $this->get()->getResult();
}

public function get_unread_notification_count($user_id)
{
    return $this->select('notification.nftn_id')
        ->join(
            'user_notifications un',
            'notification.nftn_id = un.notification_id 
             AND un.user_id = ' . (int)$user_id,
            'left'
        )
        ->where('notification.nftn_status', 1)
        ->groupStart()
            ->where('un.is_read IS NULL')
            ->orWhere('un.is_read', 0)
        ->groupEnd()
        ->countAllResults();
}

}
?>
