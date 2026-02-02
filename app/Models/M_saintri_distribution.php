<?php

namespace App\Models;

use CodeIgniter\Model;

class M_saintri_distribution extends Model
{
    protected $table = 'saintri_distribution';

    protected $allowedFields = [
        'id',
        'member_name',
        'age',
        'guardian',
        'village',
        'block',
        'police_station',
        'district',
        'state',
        'pincode',
        'aadhar',
        'mobile',
        'membership_amount',
        'volunteer_id',
        'issue_date',
        'status',
        'created',
    ];

  public function saintri_insert($saintriData)
    {
      return  $this->insert($saintriData);
    }
public function updatedata($id,$updateData)
    {
      $this->set($updateData);
      $this->where('id',$id);
      return $this->update();
    }
  public function getOldRecord($mobile)
  {
      $this->where('mobile', $mobile);
      $this->where('status', 1);
      return  $this->get()->getRow();
    }
  public function updateOldRecord($id)
    {
        return $this->update($id, [
            'status' => 0
        ]);
    }
public function getLastMembershipPaid($mobile)
{
    return $this->where('mobile', $mobile)
                ->where('membership_amount >', 0)
                ->orderBy('issue_date', 'DESC')
                ->get()
                ->getRow();
}

public function distributed_saintries($volntrId, $limit = 20, $offset = 0)
{
    return $this->where('volunteer_id', $volntrId)
                ->where('status', 1)
                ->orderBy('id', 'DESC')
                ->limit($limit, $offset)
                ->get()
                ->getResult();
}
public function saintri_distribution($volntrId)
{
    $builder = $this->db->table('saintri_distribution');
    $today = date('Y-m-d');

    $builder->select('saintri_distribution.*, d.district_name');
    $builder->join('district d', 'd.district_id = saintri_distribution.district', 'left');
    $builder->where('saintri_distribution.volunteer_id', $volntrId);
    $builder->where('saintri_distribution.status', 1);
    $builder->where('issue_date',  $today);
    $builder->orderBy('saintri_distribution.id', 'DESC');

    $query = $builder->get();
    if (!$query) {
        die;
    }

    return $query->getResult();
}
public function today_distributed_saintri($vlntrId)
{
    $today = date('Y-m-d');
    return $this->where('volunteer_id', $vlntrId)
                ->where('issue_date', $today)
                ->get()
                ->getResult();
  }
public function get_allsainetriCount($volunteer_id)
{
    return $this->builder()
        ->where('volunteer_id', $volunteer_id)
        ->where('status', 1)
        ->countAllResults();
}

public function filterSaintri($id, $from, $to) {
    return $this
        ->select('saintri_distribution.*, d.district_name')
        ->join('district d', 'd.district_id = saintri_distribution.district', 'left')
        ->where('volunteer_id', $id)
        ->where('status', 1)
        ->where('DATE(issue_date) >=', $from)
        ->where('DATE(issue_date) <=', $to)
        ->get()
        ->getResult();
}
public function get_sainnetri($id)
{
    return $this->builder()
        ->where('id', $id)
        ->get()
        ->getRow();
}

}
?>
