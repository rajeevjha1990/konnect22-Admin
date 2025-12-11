<?php

namespace App\Models;

use CodeIgniter\Model;

class M_group extends Model
{
    protected $table = 'group';

    protected $allowedFields = [
        'group_id',
        'group_name',
        'group_volunteer',
        'group_program',
        'group_noof_member',
        'group_epno',
        'group_senior_epno',
        'group_start_date',
        'group_status',
        'group_created',
    ];
  public function get_groups($vlntrId)
    {
      //$this->where('group_status',1);
      $this->where('group_volunteer',$vlntrId);
      return $this->get()->getResult();
    }
  public function get_groupdata($groupId)
    {
      $this->select('group_id as group_id,group_name as group_name,
      group_volunteer as group_volunteer,group_program as program_id,group_noof_member as group_noof_member,
      group_epno as ep_no,group_senior_epno as senior_ep_no,group.group_start_date as group_start_date');
      $this->where('group_id',$groupId);
      return $this->get()->getRow();
    }

  public function insertGroup($groupData)
    {
      return  $this->insert($groupData);
    }
public function permission_granted($groupId)
  {
    $this->where('group_id',$groupId);
    $this->set('group_status',2);
    $resp= $this->update();
    return $resp?true:false;
  }
public function update_group($groupId, $groupData)
  {
    $this->where('group_id',$groupId);
    $this->set($groupData);
    $this->set('group_status',1);
    $resp= $this->update();
    return $resp?true:false;
  }
public function today_created_group($vlntrId)
{
    $today = date('Y-m-d');
    return $this->where('group_volunteer', $vlntrId)
                ->where('group_start_date', $today)
                ->get()
                ->getResult();
  }
public function get_allGroupCount($volunteer_id)
{
    return $this->builder()
        ->where('group_volunteer', $volunteer_id)
        ->countAllResults();
}
    public function filterGroups($id,$from, $to)
    {
      return $this->where('group_volunteer', $id)
                    ->where('group_start_date >=', $from)
                    ->where('group_start_date <=', $to)
                    ->findAll();
    }


}
?>
