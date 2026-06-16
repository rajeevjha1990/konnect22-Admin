<?php
namespace App\Controllers\Api;

use App\Controllers\BaseAuthController;

class Auth extends BaseAuthController
{
    protected $session;
    protected $validation;
    protected $request;

    public function __construct()
    {
        $this->session    = \Config\Services::session();
        $this->validation = \Config\Services::validation();
        $this->request    = \Config\Services::request();
    }

    // ------------------------------------------
    // Register
    // ------------------------------------------
// --- User Registration (Step 1: Send OTP) ---
public function user_register()
{
    $mobile = $this->request->getVar('user_mobile');

    if (!$mobile || strlen($mobile) != 10) {
        return $this->response->setJSON([
            'status' => false,
            'msg' => 'Valid mobile required'
        ]);
    }

    $userModel = new \App\Models\M_user();
    $otp = '8888';//rand(1000, 9999);

    $user = $userModel->where('user_mobile', $mobile)->first();

    // ✅ USER EXISTS
    if ($user) {

        // 👉 अगर verified है
        if ($user['otp_verified'] == 1) {
            return $this->response->setJSON([
                'status' => true,
                'exists' => true,
                'verified' => 1,
                'msg' => 'User already registered. Please login.'
            ]);
        }

        // 👉 NOT VERIFIED → OTP UPDATE (🔥 BEST METHOD)
        $userModel->where('user_mobile', $mobile)
                  ->set([
                      'user_otp' => $otp,
                      'otp_verified' => 0
                  ])
                  ->update();

        // 👉 DEBUG CHECK (optional remove later)
        $updatedUser = $userModel->where('user_mobile', $mobile)->first();

        return $this->response->setJSON([
            'status' => true,
            'exists' => true,
            'verified' => 0,
            'msg' => 'OTP resent successfully',
            'otp' => $updatedUser['user_otp'] // testing
        ]);
    }

    // ✅ NEW USER
    $userModel->insert([
        'user_mobile' => $mobile,
        'user_otp' => $otp,
        'otp_verified' => 0
    ]);

    return $this->response->setJSON([
        'status' => true,
        'exists' => false,
        'verified' => 0,
        'msg' => 'OTP sent successfully',
        'otp' => $otp
    ]);
}
    // --- STEP 2: Verify OTP & Update Status ---
public function verify_otp()
{
    $mobile = $this->request->getVar('mobile');
    $otp    = $this->request->getVar('otp');

    if (!$mobile || !$otp) {
        return $this->response->setJSON([
            'status' => false,
            'msg' => 'Mobile and OTP required'
        ]);
    }

    $userModel = new \App\Models\M_user();
    $user = $userModel->where('user_mobile', $mobile)->first();

    if (!$user || $otp != $user['user_otp']) {
        return $this->response->setJSON([
            'status' => false,
            'msg' => 'Invalid OTP'
        ]);
    }

    // OTP verified only
    $userModel->where('user_mobile', $mobile)
              ->set([
                  'otp_verified' => 1,
                  'user_otp' => null
              ])
              ->update();

    return $this->response->setJSON([
        'status' => true,
        'msg' => 'OTP verified successfully',
        'create_password' => true,
        'mobile' => $mobile
    ]);
}
public function create_password()
{
    $mobile           = $this->request->getVar('mobile');
    $password         = $this->request->getVar('password');
    $confirm_password = $this->request->getVar('confirm_password');

    if (!$mobile || !$password || !$confirm_password) {
        return $this->response->setJSON([
            'status' => false,
            'msg' => 'All fields are required'
        ]);
    }

    if ($password !== $confirm_password) {
        return $this->response->setJSON([
            'status' => false,
            'msg' => 'Password and confirm password must match'
        ]);
    }

    if (strlen($password) < 6) {
        return $this->response->setJSON([
            'status' => false,
            'msg' => 'Password must be at least 6 characters'
        ]);
    }

    $userModel = new \App\Models\M_user();

    $user = $userModel->where('user_mobile', $mobile)->first();

    if (!$user) {
        return $this->response->setJSON([
            'status' => false,
            'msg' => 'User not found'
        ]);
    }

    if ($user['otp_verified'] != 1) {
        return $this->response->setJSON([
            'status' => false,
            'msg' => 'Please verify OTP first'
        ]);
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $userModel->where('user_mobile', $mobile)
              ->set([
                  'user_password' => $hashedPassword
              ])
              ->update();

    // NO AUTHKEY HERE
    return $this->response->setJSON([
        'status'  => true,
        'msg'     => 'Password created successfully',
        'user_id' => $user['user_id']
    ]);
}
// ------------------------------------------
    // Login
    // ------------------------------------------
public function login()
{
    $mobile   = $this->request->getVar('mobile');
    $password = $this->request->getVar('password');

    if (!$mobile || !$password) {
        return $this->response->setJSON([
            'status' => false,
            'msg' => 'Mobile & password required'
        ]);
    }

    $userModel = new \App\Models\M_user();
    $user = $userModel->where('user_mobile', $mobile)->first();

    if (!$user) {
        return $this->response->setJSON([
            'status' => false,
            'msg' => 'User not found'
        ]);
    }

    if ($user['otp_verified'] == 0) {
        return $this->response->setJSON([
            'status' => false,
            'verify_required' => true,
            'msg' => 'Please verify OTP first'
        ]);
    }

    if (!password_verify($password, $user['user_password'])) {
        return $this->response->setJSON([
            'status' => false,
            'msg' => 'Wrong password'
        ]);
    }

    // Generate Auth Token ONLY HERE
    $auth = json_encode([
        'user_id' => $user['user_id']
    ]);

    $authkey = $this->encrypter->encrypt($auth);

    return $this->response->setJSON([
        'status'   => true,
        'msg'      => 'Login successful',
        'authkey'  => bin2hex($authkey),
        'user_id'  => $user['user_id']
    ]);
}

public function get_user()
    {
      $resp_data["user"] = $this->userData;
      return json_encode($resp_data);
    }
public function logout()
    {
        $this->session->destroy();
        return $this->response->setJSON([
            'status' => true,
            'msg' => 'Logout successful.'
        ]);
    }
public function check_mobile_registered()
{
    $this->validation->setRule("mobile", "Mobile", "required|regex_match[/^[1-9][0-9]{9}$/]");
    $this->validation->withRequest($this->request);

    if (!$this->validation->run()) {
        return $this->response->setStatusCode(451)->setJSON([
            "status" => false,
            "err" => $this->validation->getErrors()
        ]);
    }

    $userModel = new \App\Models\M_user();
    $mobile = $this->request->getVar('mobile');
    $user = $userModel->checkRegister($mobile);

    // ❌ Not registered
    if (!$user) {
        return $this->response->setStatusCode(403)->setJSON([
            'status' => false,
            'err' => 'Mobile number not registered.'
        ]);
    }

    // ✔ Registered user — send OTP
    $generatedOtp = rand(1000, 9999);
    $otpExpiry = gmdate('Y-m-d\TH:i:s\Z', strtotime('+2 minutes'));
    $hashotp = password_hash($generatedOtp, PASSWORD_DEFAULT);

    $userModel->setOtp($user->user_id, $hashotp, $otpExpiry);

    return $this->response->setJSON([
        'status' => true,
        'msg' => 'OTP sent successfully.',
        'expiryTime' => $otpExpiry,
        'mobile' => $mobile,
        'generatedotp' => $generatedOtp
    ]);
}
    
public function reset_password()
{
    $this->validation->setRules([
        'mobileno'       => 'required|numeric|min_length[10]',
        'new_password'    => 'required|min_length[6]',
        'confirm_password' => 'required|matches[new_password]'
    ]);

    if (!$this->validation->withRequest($this->request)->run()) {
        return $this->response->setStatusCode(400)->setJSON([
            'status' => false,
            'errors' => $this->validation->getErrors()
        ]);
    }

    $mobile = $this->request->getVar('mobileno');
    $newPassword = $this->request->getVar('new_password');

    $userModel = new \App\Models\M_user();
    $user = $userModel->where('user_mobile', $mobile)->first();
    if (!$user) {
        return $this->response->setStatusCode(404)->setJSON([
            'status' => false,
            'msg' => 'Mobile number not found.'
        ]);
    }

    $hashPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    $result = $userModel->password_reset($user['user_id'], $hashPassword);

    if ($result) {
        return $this->response->setStatusCode(200)->setJSON([
            'status' => true,
            'msg'    => 'Password reset successful.'
        ]);
    } else {
        return $this->response->setStatusCode(500)->setJSON([
            'status' => false,
            'msg'    => 'Password not updated!'
        ]);
    }
}

public function get_profile()
{
    return $this->response->setJSON([
        'status' => true,
        'user'   => $this->userData
    ]);
}
  public function update_profile()
    {
      $profiledata=array(

          'user_name'=>$this->request->getVar('user_name'),
          'user_mobile'=>$this->request->getVar('mobile'),
          'user_email'=>$this->request->getVar('user_email'),
          'user_pincode'=>$this->request->getVar('pincode'),
          'user_state'=>$this->request->getVar('state_id'),
          'user_district'=>$this->request->getVar('district_id'),
          'user_block'=>$this->request->getVar('block_id'),
          'user_village'=>$this->request->getVar('village'),
         
      );
      $userModel = new \App\Models\M_user();
      $userId=$this->userData->user_id;
      $result=$userModel->update_profile($profiledata,$userId);
      if ($result) {
          return $this->response->setJSON([
              'status' => true,
              'msg'    => 'Your profile updated successful.'
          ]);
      } else {
          return $this->response->setStatusCode(500)->setJSON([
              'status' => false,
              'msg'    => 'Failed to register user.'
          ]);
      }
    }

}
?>
