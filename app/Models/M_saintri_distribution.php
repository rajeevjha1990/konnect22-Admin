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
        'post',
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

    $builder->select('saintri_distribution.*, d.district_name');
    $builder->join('district d', 'd.district_id = saintri_distribution.district', 'left');
    $builder->where('saintri_distribution.volunteer_id', $volntrId);
    $builder->where('saintri_distribution.status', 1);
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
}
?>
