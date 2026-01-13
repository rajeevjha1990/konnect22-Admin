<?php

namespace App\Models;

use CodeIgniter\Model;

class M_volunteer extends Model
{
    protected $table = 'volunteer';

    protected $allowedFields = [
        'volntr_id',
        'volntr_ep_temp',
        'volntr_name',
        'volntr_qualification',
        'volntr_mobile',
        'volntr_email',
        'volntr_pincode',
        'volntr_address',
        'volntr_password',
        'volntr_join_date',
        'volntr_image',
        'volntr_otp_code',
        'otp_expires_at',
        'last_assigned_at',
        'volntr_status',
        'volntr_created',
    ];

public function getPassword($mobile)
  {
    $this->where('volntr_mobile', $mobile);
    return $this->get()->getRow();
  }
  public function get_volunteer($volunteerId)
    {
      $this->where('volntr_id',$volunteerId);
      return $this->get()->getRow();
    }
  public function volunteer_exits($mobile, $volunteerId=null)
      {
        $this->where('volntr_mobile', $mobile);
        if (!empty($volunteerId)) {
            $this->where('volntr_id !=', $volunteerId);
        }
        $query = $this->get(1);
        return $query->getRow();
      }
public function insert_volunteer($data)
  {
  return  $this->insert($data);
  }
public function edit_volunteer($profiledata,$vlntrId)
  {
    $this->set($profiledata);
    $this->where('volntr_id',$vlntrId);
    return $this->update();
  }
public function get_volunteers()
  {
      $this->where('volntr_status',1);
      return $this->get()->getResult();
  }
public function checkRegister($mobile)
  {
    $this->where('volntr_mobile',$mobile);
    return $this->get()->getRow();
  }
public function setOtp($vlntrId, $otpCode, $expiryTime=false)
{

  $this->where('volntr_id',$vlntrId);
  $this->set('volntr_otp_code', $otpCode);
  $this->set('otp_expires_at',$expiryTime);
  return $this->update();
 }
public function clearOtp($vlntrId)
  {
    $this->set('volntr_otp_code	',null);
    $this->set('otp_expires_at',null);
    $this->where('volntr_id',$vlntrId);
    return $this->update();
  }
public function delete_associate($id)
  {
    $this->set('volntr_status',0);
    $this->where('volntr_id',$id);
    return $this->update();
  }
  public function update_profile($profiledata,$vlntrId)
  {
    $this->set($profiledata);
    $this->where('volntr_id',$vlntrId);
    return $this->update();
  }

  public function password_reset($vlntrId, $password)
  {
    $this->where('volntr_id',$vlntrId);
    $this->set('volntr_password', $password);
    return $this->update();
   }
  public function updateLastAssignedTime($volunteerId)
{
    return $this->where('volntr_id', $volunteerId)
                ->set([
                    'last_assigned_at' => date('Y-m-d H:i:s')
                ])
                ->update();
}
public function getVolunteersByPincode($pincode)
{
    return $this->where('volntr_status', 1)
                ->where('volntr_pincode', $pincode)
                ->findAll();
}

}
?>
