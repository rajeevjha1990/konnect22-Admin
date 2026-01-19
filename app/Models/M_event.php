<?php

namespace App\Models;

use CodeIgniter\Model;

class M_event extends Model
{
    protected $table = 'events';

    protected $primaryKey = 'event_id';

    protected $allowedFields = [
        'event_name',
        'event_icon',
        'event_date',
        'event_status',
        'event_created',
    ];

public function event_name_exists($event_name, $ignoreId = null)
{
    $builder = $this->db->table($this->table);
    $builder->where('event_name', $event_name);

    if (!empty($ignoreId)) {
        $builder->where($this->primaryKey . ' !=', $ignoreId);
    }

    return $builder->countAllResults() > 0;
}
public function insert_event($eventdata)
{
  return  $this->insert($eventdata);
}
 public function update_event($data,$id)
  {
    return $this->update($id, $data);
  }
public function get_events()
{
    $fromDate = date('Y-m-d', strtotime('-7 days'));  // 7 din pehle
    $toDate   = date('Y-m-d', strtotime('+7 days'));  // 7 din baad

    return $this->where('event_status', 1)
                ->where('event_date >=', $fromDate)
                ->where('event_date <=', $toDate)
                ->orderBy('event_date', 'ASC')
                ->get()
                ->getResult();
}


  public function get_event($id)
  {
     $this->where('event_id',$id);
     return $this->get()->getRow();
  }
}
?>