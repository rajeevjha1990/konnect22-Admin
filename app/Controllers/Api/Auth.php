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
  public function volunteer_register()
{
    $this->validation->setRules([
        'volntr_name' => [
            'label'  => 'Name',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Name is required.'
            ]
        ],
        'volntr_mobile' => [
            'label'  => 'Mobile Number',
            'rules'  => 'required|numeric|min_length[10]|is_unique[volunteer.volntr_mobile]',
            'errors' => [
                'required'   => 'Mobile number is required.',
                'numeric'    => 'Mobile number must contain only digits.',
                'min_length' => 'Mobile number must be at least 10 digits.',
                'is_unique'  => 'This mobile number is already registered.'
            ]
        ],
        'volntr_password' => [
            'label'  => 'Password',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Password is required.'
            ]
        ]
    ]);

    if (!$this->validation->withRequest($this->request)->run()) {
        return $this->response->setStatusCode(400)->setJSON([
            'status' => false,
            'err' => $this->validation->getErrors()
        ]);
    }

    $volunteerModel = new \App\Models\M_volunteer();

    $insertData = [
        'volntr_name'     => $this->request->getVar('volntr_name'),
        'volntr_mobile'   => $this->request->getVar('volntr_mobile'),
        'volntr_email'    => $this->request->getVar('volntr_email'),
        'volntr_password'=> password_hash($this->request->getVar('volntr_password'), PASSWORD_DEFAULT),
    ];

    $insert = $volunteerModel->insert($insertData);

    if ($insert) {
        return $this->response->setJSON([
            'status' => true,
            'msg'    => 'Registration successful.'
        ]);
    } else {
        return $this->response->setStatusCode(500)->setJSON([
            'status' => false,
            'msg'    => 'Failed to register user.'
        ]);
    }
}


    // ------------------------------------------
    // Login
    // ------------------------------------------
public function login()
{
    $this->validation->setRules([
        'mobile' => [
            'label' => 'Mobile Number',
            'rules' => 'required|regex_match[/^[0-9]{10}$/]',
            'errors' => [
                'required' => 'Mobile number is required.',
                'regex_match' => 'Please enter a valid 10-digit mobile number.'
            ]
        ],
        'password' => [
            'label' => 'Password',
            'rules' => 'required',
            'errors' => ['required' => 'Password is required.']
        ]
    ]);

    if (!$this->validation->withRequest($this->request)->run()) {
        return $this->response->setStatusCode(451)->setJSON([
            'status' => false,
            'errors' => $this->validation->getErrors()
        ]);
    }

    $mobile   = $this->request->getVar('mobile');
    $password = $this->request->getVar('password');

    $m_volunteer = new \App\Models\M_volunteer();
    $volunteer = $m_volunteer->getPassword($mobile);

    if (!$volunteer) {
        return $this->response->setStatusCode(404)->setJSON([
            'status' => false,
            'msg' => 'Mobile number not registered.'
        ]);
    }

    $stored_hash = trim($volunteer->volntr_password);

    if (!password_verify($password, $stored_hash)) {
        return $this->response->setStatusCode(403)->setJSON([
            'status' => false,
            'msg' => 'Incorrect password.'
        ]);
    }

    // Generate Auth Key
    $auth = json_encode(["id" => $volunteer->volntr_id]);
    $authkey = $this->encrypter->encrypt($auth);

    return $this->response->setJSON([
        "authkey"  => bin2hex($authkey),
        "volntrid" => $volunteer->volntr_id,
        "message"  => "You are Successfully Logged In",
        'status'   => true,
    ]);
}
  public function get_volunteer()
    {
      $resp_data["volunteer"] = $this->volunteerData;
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

    $volunteerModel = new \App\Models\M_volunteer();
    $volunteer = $volunteerModel->where('volntr_mobile', $mobile)->first();
    if (!$volunteer) {
        return $this->response->setStatusCode(404)->setJSON([
            'status' => false,
            'msg' => 'Mobile number not found.'
        ]);
    }

    $hashPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    $result = $volunteerModel->password_reset($volunteer['volntr_id'], $hashPassword);

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
    $vlntrId=$this->volunteerData->volntr_id;
    $volunteerModel = new \App\Models\M_volunteer();
    $resp_data["profile"] = $volunteerModel->get_volunteer($vlntrId);
    return json_encode($resp_data);
  }
  public function update_profile()
    {
      $profiledata=array(
          'volntr_name'=>$this->request->getVar('volntr_name'),
          'volntr_mobile'=>$this->request->getVar('volntr_mobile'),
          'volntr_email'=>$this->request->getVar('volntr_email'),
          'volntr_ep_temp'=>$this->request->getVar('volntr_ep_temp'),
          'volntr_qualification'=>$this->request->getVar('volntr_qualification'),
          'volntr_join_date'=>$this->request->getVar('volntr_join_date'),
          'volntr_address'=>$this->request->getVar('volntr_address'),
          'volntr_pincode'=>$this->request->getVar('volntr_pincode'),
          'volntr_image'=>$this->request->getVar('volntr_image'),
      );
      $volunteerModel = new \App\Models\M_volunteer();
      $vlntrId=$this->volunteerData->volntr_id;
      $result=$volunteerModel->update_profile($profiledata,$vlntrId);
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

    $volunteerModel = new \App\Models\M_volunteer();
    $mobile = $this->request->getVar('mobile');
    $volunteer = $volunteerModel->checkRegister($mobile);

    // ❌ Not registered
    if (!$volunteer) {
        return $this->response->setStatusCode(403)->setJSON([
            'status' => false,
            'err' => 'Mobile number not registered.'
        ]);
    }

    // ✔ Registered user — send OTP
    $generatedOtp = rand(1000, 9999);
    $otpExpiry = gmdate('Y-m-d\TH:i:s\Z', strtotime('+2 minutes'));
    $hashotp = password_hash($generatedOtp, PASSWORD_DEFAULT);

    $volunteerModel->setOtp($volunteer->volntr_id, $hashotp, $otpExpiry);

    return $this->response->setJSON([
        'status' => true,
        'msg' => 'OTP sent successfully.',
        'expiryTime' => $otpExpiry,
        'mobile' => $mobile,
        'generatedotp' => $generatedOtp
    ]);
}
public function verify_forgot_otp()
{
    $volunteerModel = new \App\Models\M_volunteer();

    $mobile = $this->request->getVar('mobile');
    $otp    = $this->request->getVar('otp');

    if (!$mobile || !$otp) {
        return $this->response->setStatusCode(400)->setJSON([
            'err' => 'Mobile number and OTP are required.'
        ]);
    }

    $volunteer = $volunteerModel->checkRegister($mobile);
    if (!$volunteer) {
        return $this->response->setStatusCode(404)->setJSON([
            'err' => 'Mobile number not registered or not verified.'
        ]);
    }

  if (strtotime($volunteer->otp_expires_at) < time()) {
    return $this->response->setStatusCode(403)->setJSON([
        'err' => 'OTP expired.'
    ]);
}

  if (!password_verify($otp, $volunteer->volntr_otp_code)) {
      return $this->response->setStatusCode(403)->setJSON([
          'err' => 'Invalid OTP.'
      ]);
  }
    // Clear OTP
    $volunteerModel->clearOtp($volunteer->volntr_id);
    return $this->response->setJSON([
        'msg'     => 'OTP verified successfully.',
        'consumer_id' => $volunteer->volntr_id
    ]);
}

}
?>
