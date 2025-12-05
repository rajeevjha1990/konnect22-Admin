<?php
namespace App\Controllers;

use App\Models\M_admin;

class Admin_auth extends BaseController
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

    public function login()
    {
        $error = session()->getFlashdata('error');
        return view('login', ['error' => $error]);
    }

    public function dologin()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $adminModel = new M_admin();
        $admin = $adminModel->adminlogin($username);
        if ($admin) {
            if (password_verify($password, $admin->admin_password)) {
                $this->session->set([
                    "logged_in"   => true,
                    "id"          => $admin->admin_id,
                    "admin_name"  => $admin->admin_name ?? '',
                ]);
                return redirect()->to('/dashboard');
            } else {
                return redirect()->to('/')->with('error', 'Incorrect password. Please try again.');
            }
        } else {
            return redirect()->to('/')->with('error', 'Username or mobile number not found.');
        }
    }
public function logout()
{
    $session = session();
    $session->destroy();
    return redirect()->to(base_url('/'))
                     ->with('message', 'You have been logged out successfully.');
}
public function group_edit_requests()
  {
    $m_group_edit_request = new \App\Models\M_request();
      if (!session()->get('logged_in')) {
          return redirect()->to('/');
      }
    $admindata['admin_name'] = $this->session->get('admin_name');
    $reqdata['groupeditrequests']=$m_group_edit_request->get_edit_requests();
      echo view('includes/header',$admindata);
      echo view('includes/sidebar');
      echo view('group_edit_requests',$reqdata);
      echo view('includes/footer');
   }
  public function permission_granted($Id,$groupId)
    {
    $m_request = new \App\Models\M_request();
    $m_group = new \App\Models\M_group();
    $response = [];
    $result=$m_request->update_request($Id,$groupId);

    if ($result){
        $m_group->permission_granted($groupId);
        $response['success'] = true;
        $response['message']= "permission granted for group edit.";
        $response['reload']  = 1;
    }
    return $this->response
          ->setHeader('Content-Type', 'application/json')
          ->setBody(json_encode($response));
    }
  public function volunteers()
    {
      $m_volunteer = new \App\Models\M_volunteer();
      $admindata['admin_name'] = $this->session->get('admin_name');
      $respdata['volunteers']=$m_volunteer->get_volunteers();
      echo view('includes/header',$admindata);
      echo view('includes/sidebar');
      echo view('volunteers',$respdata);
      echo view('includes/footer');
    }
public function programs()
  {
    $m_program = new \App\Models\M_program();
    $admindata['admin_name'] = $this->session->get('admin_name');
    $respdata['programs']=$m_program->get_programs();
    echo view('includes/header',$admindata);
    echo view('includes/sidebar');
    echo view('programs',$respdata);
    echo view('includes/footer');
  }
public function new_program()
  {
    $admindata['admin_name'] = $this->session->get('admin_name');
    echo view('includes/header',$admindata);
    echo view('includes/sidebar');
    echo view('program_form');
    echo view('includes/footer');
  }
public function edit_program($id)
  {
    $m_program = new \App\Models\M_program();
    $admindata['admin_name'] = $this->session->get('admin_name');
    $programdata['program']=$m_program->get_program($id);
    echo view('includes/header',$admindata);
    echo view('includes/sidebar');
    echo view('program_form',$programdata);
    echo view('includes/footer');
  }
  public function save_program()
  {
      $id = $this->request->getPost('id');
      $rules = [
          'name'        => 'required',
          'short_desc'  => 'required',
          'icon'        => 'required',
      ];

      $this->validation->setRules($rules, [
          'name' => [
              'required' => 'Program name is required.'
          ],
          'short_desc' => [
              'required' => 'Short description is required.'
          ],
          'icon' => [
              'required' => 'Program icon name is required.'
          ]
      ]);

      if (!$this->validation->withRequest($this->request)->run()) {
          return $this->response->setJSON([
              'status' => false,
              'err'    => $this->validation->getErrors()
          ]);
      }
      $data = [
          'icon'       => $this->request->getPost('icon'),
          'name'       => $this->request->getPost('name'),
          'short_desc' => $this->request->getPost('short_desc'),
      ];

      $m_program = new \App\Models\M_program();

      if (!empty($id)) {
          $resp = $m_program->update_program($data, $id);
          $msg  = "Program updated successfully";
      } else {
          $resp = $m_program->insert_program($data);
          $msg  = "Program added successfully";
      }

      if ($resp) {
          return $this->response->setJSON([
              "status"   => true,
              "message"  => $msg,
              "redirect" => base_url('adminauth/programs')
          ]);
      } else {
          return $this->response->setJSON([
              "status"  => false,
              "message" => "Error, try again.."
          ]);
      }
  }
public function delete_program($id)
{
    $m_program = new \App\Models\M_program();
    $data = $m_program->delete_program($id);
    $response = [];
    if ($data === false) {
        $response['success'] = false;
        $response['err']     = "Program not removed.";
    } else {
        $response['success'] = true;
        $response['message'] = "Program removed successfully.";
        $response['reload']  = 1;
    }
    return $this->response
          ->setHeader('Content-Type', 'application/json')
          ->setBody(json_encode($response));
        }

public function volunteer_groups($volunteerId)
  {
    $m_volunteer = new \App\Models\M_volunteer();
    $m_group = new \App\Models\M_group();
    $admindata['admin_name'] = $this->session->get('admin_name');
    $respdata['volunteer']=$m_volunteer->get_volunteer($volunteerId);
    $respdata['groups']=$m_group->get_groups($volunteerId);
    echo view('includes/header',$admindata);
    echo view('includes/sidebar');
    echo view('volunteer_groups',$respdata);
    echo view('includes/footer');
  }
public function group_members($groupId,$volunteerId)
  {
    $m_group_member = new \App\Models\M_group_member();
    $m_group = new \App\Models\M_group();
    $m_volunteer = new \App\Models\M_volunteer();
    $admindata['admin_name'] = $this->session->get('admin_name');
    $respdata['volunteer']=$m_volunteer->get_volunteer($volunteerId);
    $respdata['group']=$m_group->get_groupdata($groupId);
    $respdata['groupmembers']=$m_group_member->get_group_members($groupId);
    echo view('includes/header',$admindata);
    echo view('includes/sidebar');
    echo view('group_members',$respdata);
    echo view('includes/footer');
  }
public function new_associate()
  {
    $m_qualification = new \App\Models\M_qualification();
    $respdata['qualifications']=$m_qualification->get_qualifications();
    $admindata['admin_name'] = $this->session->get('admin_name');
    echo view('includes/header',$admindata);
    echo view('includes/sidebar');
    echo view('associate_form',$respdata);
    echo view('includes/footer');
  }

public function save_volunteer()
{
    $id = $this->request->getPost('id');
    $rules = [
        'volntr_ep_temp'   => 'required',
        'volntr_name'      => 'required',
        'volntr_mobile'    => 'required|numeric|exact_length[10]',
        'volntr_email'     => 'permit_empty|valid_email',
        'volntr_join_date' => 'required',
    ];

    if (empty($id)) {
        $rules['volntr_password'] = 'required|min_length[6]';
    }

    $this->validation->setRules($rules, [
        'volntr_ep_temp' => ['required' => 'Temp EP Number is required.'],
        'volntr_name' => ['required' => 'Full name is required.'],
        'volntr_mobile' => [
            'required' => 'Mobile number is required.',
            'numeric' => 'Mobile number must contain only digits.',
            'exact_length' => 'Mobile number must be exactly 10 digits.'
        ],
        'volntr_email' => [
            'valid_email' => 'Please enter a valid email address.'
        ],
        'volntr_join_date' => [
            'required' => 'Joining date is required.'
        ],
        'volntr_password' => [
            'required' => 'Password is required.',
            'min_length' => 'Password must be at least 6 characters long.'
        ]
    ]);

    if (!$this->validation->withRequest($this->request)->run()) {
        return $this->response->setJSON([
            'status' => false,
            'err' => $this->validation->getErrors()
        ]);
    }
    $data = [
        'volntr_ep_temp'        => $this->request->getPost('volntr_ep_temp'),
        'volntr_name'           => $this->request->getPost('volntr_name'),
        'volntr_qualification' => $this->request->getPost('volntr_qualification'),
        'volntr_mobile'         => $this->request->getPost('volntr_mobile'),
        'volntr_email'          => $this->request->getPost('volntr_email'),
        'volntr_address'        => $this->request->getPost('volntr_address'),
        'volntr_pincode'        => $this->request->getPost('volntr_pincode'),
        'volntr_join_date'      => $this->request->getPost('volntr_join_date'),
    ];

    if (empty($id)) {
        $data['volntr_password'] = password_hash(
            $this->request->getPost('volntr_password'),
            PASSWORD_DEFAULT
        );
    }

    $m_volunteer = new \App\Models\M_volunteer();

    if (empty($id)) {
        $exists = $m_volunteer->volunteer_exits($data['volntr_mobile']);
        if ($exists) {
            return $this->response->setJSON([
                "status"  => false,
                "message" => "Mobile number already registered!",
            ]);
        }
    }

    if (!empty($id)) {
        $resp = $m_volunteer->edit_volunteer($data, $id);
        $msg = "Associate updated successfully";
    } else {
        $resp = $m_volunteer->insert_volunteer($data);
        $msg = "Associate added successfully";
    }

    if ($resp) {
        return $this->response->setJSON([
            "status"  => true,
            "message" => $msg,
            "redirect" => base_url('adminauth/volunteers')
        ]);
    } else {
        return $this->response->setJSON([
            "status" => false,
            "message" => "Error, try again.."
        ]);
    }
}
public function edit_associate($id)
  {
    $m_qualification = new \App\Models\M_qualification();
    $m_volunteer = new \App\Models\M_volunteer();
    $respdata['qualifications']=$m_qualification->get_qualifications();
    $respdata['associate']=$m_volunteer->get_volunteer($id);
    $admindata['admin_name'] = $this->session->get('admin_name');
    echo view('includes/header',$admindata);
    echo view('includes/sidebar');
    echo view('associate_form',$respdata);
    echo view('includes/footer');
  }
public function delete_associate($id)
{
    $m_volunteer = new \App\Models\M_volunteer();
    $data = $m_volunteer->delete_associate($id);
    $response = [];
    if ($data === false) {
        $response['success'] = false;
        $response['err']     = "Associate not removed.";
    } else {
        $response['success'] = true;
        $response['message'] = "Associate removed successfully.";
        $response['reload']  = 1;
    }
    return $this->response
          ->setHeader('Content-Type', 'application/json')
          ->setBody(json_encode($response));
        }
}
?>
