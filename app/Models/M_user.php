<?php

namespace App\Models;

use CodeIgniter\Model;

class M_user extends Model
{
    protected $table = 'user';

    protected $allowedFields = [
        'user_id',
        'user_name',
        'user_mobile',
        'user_email',
        'user_otp',
        'otp_verified',
        'user_password',
        'user_pincode',
        'user_state',
        'user_district',
        'user_block',
        'user_village',
        'user_status',
        'user_created',
    ];
public function insert_user($data)
    {
          return  $this->insert($data);
    }
public function get_user($userId)
    {
       return $this->where('user_id', $userId)
                ->get()->getRow();
            }
public function userlogin($username)
{
    return $this->where('user_email', $username)
                ->orWhere('user_mobile', $username)
                ->get()->getRow();
}

public function new_password_set($userid,$user_pwd)
    {
      $this->set('user_otp',$user_pwd);
      $this->where('user_id',$userid);
      if($this->update()){
        return true;
      }else {
        return false;
      }
    }
  public function getuserData($userid)
    {
      $this->where('user_id',$userid);
      $this->select('user_otp');
      return  $this->get()->getRow();
    }
public function checkRegister($mobile)
    {
      $this->where('user_mobile', $mobile);
      return  $this->get()->getRow();
    }
public function otp_update($userid,$userdata)
    {
        $this->where('user_id',$userid);
        return $this->update($userdata);
    }
public function update_profile($profiledata,$userid)
    {
        $this->where('user_id',$userid);
        $this->set($profiledata);
        return $this->update();
    }

}
?>
