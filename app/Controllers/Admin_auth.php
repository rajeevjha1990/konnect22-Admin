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
    $data=$this->data;
    $data['admin_name'] = $this->session->get('admin_name');
    $data['groupeditrequests']=$m_group_edit_request->get_edit_requests();
      echo view('includes/header',$data);
      echo view('includes/sidebar',$data);
      echo view('group_edit_requests',$data);
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
    $data=$this->data;
    $m_volunteer = new \App\Models\M_volunteer();
    $m_group = new \App\Models\M_group();
    $m_saintri_distribution = new \App\Models\M_saintri_distribution();

    $data['admin_name'] = $this->session->get('admin_name');

    $volunteers = $m_volunteer->get_volunteers();

    // Loop through volunteers and add flags
    foreach ($volunteers as $key => $value) {
        // Check if volunteer has any groups
        $vlngroup = $m_group->today_created_group($value->volntr_id);
        $volunteers[$key]->has_group = !empty($vlngroup);

        // Check if volunteer has any Saintri distributed
        $vlnsaintridistributed = $m_saintri_distribution->today_distributed_saintri($value->volntr_id);
        $volunteers[$key]->has_saintri = !empty($vlnsaintridistributed);
    }

    $respdata['volunteers'] = $volunteers;

    echo view('includes/header', $data);
    echo view('includes/sidebar',$data);
    echo view('volunteers', $respdata);
    echo view('includes/footer');
}

public function programs()
  {
    $data=$this->data;
    $m_program = new \App\Models\M_program();
    $data['admin_name'] = $this->session->get('admin_name');
    $respdata['programs']=$m_program->get_programs();
    echo view('includes/header',$data);
    echo view('includes/sidebar',$data);
    echo view('programs',$respdata);
    echo view('includes/footer');
  }
public function new_program()
  {
    $data=$this->data;
    $data['admin_name'] = $this->session->get('admin_name');
    echo view('includes/header',$data);
    echo view('includes/sidebar',$data);
    echo view('program_form');
    echo view('includes/footer');
  }
public function edit_program($id)
  {
    $data=$this->data;
    $m_program = new \App\Models\M_program();
    $data['admin_name'] = $this->session->get('admin_name');
    $programdata['program']=$m_program->get_program($id);
    echo view('includes/header',$data);
    echo view('includes/sidebar',$data);
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
    $data=$this->data;
    $m_volunteer = new \App\Models\M_volunteer();
    $m_group = new \App\Models\M_group();
    $data['admin_name'] = $this->session->get('admin_name');
    $respdata['volunteer']=$m_volunteer->get_volunteer($volunteerId);
    $respdata['groups']=$m_group->get_groups($volunteerId);
    echo view('includes/header',$data);
    echo view('includes/sidebar',$data);
    echo view('volunteer_groups',$respdata);
    echo view('includes/footer');
  }
public function saintri_distribution($volunteerId)
  {
    $data=$this->data;
    $m_volunteer = new \App\Models\M_volunteer();
    $m_saintri_distribution = new \App\Models\M_saintri_distribution();
    $data['admin_name'] = $this->session->get('admin_name');
    $respdata['volunteer']=$m_volunteer->get_volunteer($volunteerId);
    $respdata['saintridistributions']=$m_saintri_distribution->saintri_distribution($volunteerId);

    echo view('includes/header',$data);
    echo view('includes/sidebar',$data);
    echo view('saintridistributions',$respdata);
    echo view('includes/footer');
  }
public function group_members($groupId,$volunteerId)
  {
    $data=$this->data;
    $m_group_member = new \App\Models\M_group_member();
    $m_group = new \App\Models\M_group();
    $m_volunteer = new \App\Models\M_volunteer();
    $data['admin_name'] = $this->session->get('admin_name');
    $respdata['volunteer']=$m_volunteer->get_volunteer($volunteerId);
    $respdata['group']=$m_group->get_groupdata($groupId);
    $respdata['groupmembers']=$m_group_member->get_group_members($groupId);
    echo view('includes/header',$data);
    echo view('includes/sidebar',$data);
    echo view('group_members',$respdata);
    echo view('includes/footer');
  }

public function new_associate()
  {
    $data=$this->data;
    $m_qualification = new \App\Models\M_qualification();
    $respdata['qualifications']=$m_qualification->get_qualifications();
    $data['admin_name'] = $this->session->get('admin_name');
    echo view('includes/header',$data);
    echo view('includes/sidebar',$data);
    echo view('associate_form',$respdata);
    echo view('includes/footer');
  }

public function save_volunteer()
{
    $id = $this->request->getPost('id');
    // VALIDATION RULES
    $rules = [
        'volntr_ep_temp'   => 'required',
        'volntr_name'      => 'required',
        'volntr_mobile'    => 'required|numeric|exact_length[10]',
        'volntr_email'     => 'permit_empty|valid_email',
        'volntr_join_date' => 'required',
    ];

    // CUSTOM ERROR MESSAGES
    $this->validation->setRules($rules, [
        'volntr_ep_temp' => ['required' => 'Temp EP Number is required.'],
        'volntr_name' => ['required' => 'Full name is required.'],
        'volntr_mobile' => [
            'required'     => 'Mobile number is required.',
            'numeric'      => 'Mobile number must contain only digits.',
            'exact_length' => 'Mobile number must be exactly 10 digits.'
        ],
        'volntr_email' => [
            'valid_email' => 'Please enter a valid email address.'
        ],
        'volntr_join_date' => [
            'required' => 'Joining date is required.'
        ]
    ]);

    // VALIDATION FAILED
    if (!$this->validation->withRequest($this->request)->run()) {
        return $this->response->setJSON([
            'status' => false,
            'err'    => $this->validation->getErrors()
        ]);
    }

    // COLLECT FORM DATA
    $data = [
        'volntr_ep_temp'       => $this->request->getPost('volntr_ep_temp'),
        'volntr_name'          => $this->request->getPost('volntr_name'),
        'volntr_qualification' => $this->request->getPost('volntr_qualification'),
        'volntr_mobile'        => $this->request->getPost('volntr_mobile'),
        'volntr_email'         => $this->request->getPost('volntr_email'),
        'volntr_address'       => $this->request->getPost('volntr_address'),
        'volntr_pincode'       => $this->request->getPost('volntr_pincode'),
        'volntr_join_date'     => $this->request->getPost('volntr_join_date'),
    ];

    // CREATE PASSWORD ONLY FOR NEW REGISTRATION
    if (empty($id)) {
        $data['volntr_password'] = password_hash(
            $this->request->getPost('volntr_mobile'),
            PASSWORD_DEFAULT
        );
    }
    // MODEL
    $m_volunteer = new \App\Models\M_volunteer();

    // CHECK ALREADY REGISTERED MOBILE FOR NEW ENTRY
    if (empty($id)) {
        $exists = $m_volunteer->volunteer_exits($data['volntr_mobile']);
        if ($exists) {
            return $this->response->setJSON([
                "status"  => false,
                "message" => "Mobile number already registered!",
            ]);
        }
    }

    // INSERT OR UPDATE
    if (!empty($id)) {
        $resp = $m_volunteer->edit_volunteer($data, $id);
        $msg  = "Associate updated successfully";
    } else {
        $resp = $m_volunteer->insert_volunteer($data);
        $msg  = "Associate added successfully";
    }

    // FINAL RESPONSE
    if ($resp) {
        return $this->response->setJSON([
            "status"   => true,
            "message"  => $msg,
            "redirect" => base_url('adminauth/volunteers')
        ]);
    } else {
        return $this->response->setJSON([
            "status"  => false,
            "message" => "Error, try again.."
        ]);
    }
}
public function edit_associate($id)
  {
    $data=$this->data;
    $m_qualification = new \App\Models\M_qualification();
    $m_volunteer = new \App\Models\M_volunteer();
    $respdata['qualifications']=$m_qualification->get_qualifications();
    $respdata['associate']=$m_volunteer->get_volunteer($id);
    $data['admin_name'] = $this->session->get('admin_name');
    echo view('includes/header',$data);
    echo view('includes/sidebar',$data);
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
public function save_event_master()
{
    $id = $this->request->getPost('event_id');

    // VALIDATION RULES
    $rules = [
        'event_name' => 'required',
        'event_date' => 'required',
        'event_icon' => 'permit_empty|is_image[event_icon]|max_size[event_icon,2048]|mime_in[event_icon,image/jpg,image/jpeg,image/png,image/gif]',
    ];

    // CUSTOM ERROR MESSAGES
    $this->validation->setRules($rules, [
        'event_name' => [
            'required' => 'Event name is required.'
        ],
        'event_date' => [
            'required' => 'Event date is required.'
        ],
        'event_icon' => [
            'is_image' => 'The uploaded file must be an image.',
            'max_size' => 'The image file size must not exceed 2MB.',
            'mime_in' => 'The image must be a valid type (JPG, JPEG, PNG, GIF).'
        ]
    ]);

    // VALIDATION FAILED
    if (!$this->validation->withRequest($this->request)->run()) {
        return $this->response->setJSON([
            'status' => false,
            'err'    => $this->validation->getErrors()
        ]);
    }

    // COLLECT DATA
    $eventName = trim($this->request->getPost('event_name'));

    $data = [
        'event_name' => $eventName,
        'event_date' => $this->request->getPost('event_date'),
    ];

    // MODEL
    $m_event = new \App\Models\M_event();

    // Get old event for update
    $oldEvent = null;
    if (!empty($id)) {
        $oldEvent = $m_event->find($id);
    }

    // ICON UPLOAD
    $file = $this->request->getFile('event_icon');
    if ($file && $file->isValid() && !$file->hasMoved()) {
        // Delete old icon if exists
        if ($oldEvent && !empty($oldEvent->event_icon)) {
            $oldIconPath = FCPATH . 'uploads/event_icons/' . $oldEvent->event_icon;
            if (file_exists($oldIconPath)) {
                unlink($oldIconPath);
            }
        }

        // Ensure upload directory exists
        $uploadPath = FCPATH . 'uploads/event_icons/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $iconName = $file->getRandomName();
        $tempPath = $file->getTempName();
        $targetPath = $uploadPath . $iconName;
        if (move_uploaded_file($tempPath, $targetPath)) {
            $data['event_icon'] = $iconName;
        } else {
            return $this->response->setJSON([
                "status"  => false,
                "message" => "Failed to upload the image. Please try again."
            ]);
        }
    }

    //UNIQUE NAME CHECK (ONLY VALIDATION)
    if ($m_event->event_name_exists($eventName, $id)) {
        return $this->response->setJSON([
            "status"  => false,
            "message" => "This event name already exists!"
        ]);
    }

    // INSERT OR UPDATE
    if (!empty($id)) {
        $resp = $m_event->update_event($data, $id);
        $msg  = "Event updated successfully";
    } else {
        $resp = $m_event->insert_event($data);
        $msg  = "Event added successfully";
    }

    // FINAL RESPONSE
    if ($resp) {
        return $this->response->setJSON([
            "status"   => true,
            "message"  => $msg,
            "redirect" => base_url('adminauth/events')
        ]);
    } else {
        return $this->response->setJSON([
            "status"  => false,
            "message" => "Error, try again.."
        ]);
    }
}
public function events()
  {
    $data=$this->data;
    $m_event = new \App\Models\M_event();
    $data['admin_name'] = $this->session->get('admin_name');
    $respdata['events']=$m_event->get_events();
    echo view('includes/header',$data);
    echo view('includes/sidebar',$data);
    echo view('events',$respdata);
    echo view('includes/footer');
  }
public function new_event()
  {
    $data=$this->data;
    $data['admin_name'] = $this->session->get('admin_name');
    echo view('includes/header',$data);
    echo view('includes/sidebar',$data);
    echo view('event_form');
    echo view('includes/footer');
  }
public function edit_event($id)
  {

    $data=$this->data;
    $m_event = new \App\Models\M_event();
    $data['admin_name'] = $this->session->get('admin_name');
    $eventdata['event']=$m_event->get_event($id);
  
    echo view('includes/header',$data);
    echo view('includes/sidebar',$data);
    echo view('event_form',$eventdata);
    echo view('includes/footer');
  }
public function create_notification()
  {
    $data=$this->data;
    $data['admin_name'] = $this->session->get('admin_name');
    echo view('includes/header',$data);
    echo view('includes/sidebar',$data);
    echo view('create_notification');
    echo view('includes/footer');
  }
public function save_notification()
{
    $id = $this->request->getVar('id');
    // Validation rules
    $rules = [
        'nftn_title' => 'required',
        'nftn_text'  => 'required',
    ];

    $this->validation->setRules($rules, [
        'nftn_title' => [
            'required' => 'Notification title is required.'
        ],
        'nftn_text' => [
            'required' => 'Notification text is required.'
        ]
    ]);

    if (!$this->validation->withRequest($this->request)->run()) {
        return $this->response->setJSON([
            'status' => false,
            'err'    => $this->validation->getErrors()
        ]);
    }

    // Data to save
    $data = [
        'nftn_title' => $this->request->getVar('nftn_title'),
        'nftn_text'  => $this->request->getVar('nftn_text'),
    ];

    $m_notification = new \App\Models\M_notification();

    if (!empty($id)) {
        // update
        $resp = $m_notification->update_notification($data, $id);
        $msg  = "Notification updated successfully";
    } else {
        // insert
        $resp = $m_notification->insert_notification($data);
        $msg  = "Notification added successfully";
    }

    if ($resp) {
        return $this->response->setJSON([
            "status"   => true,
            "message"  => $msg,
            "redirect" => base_url('adminauth/notifications')
        ]);
    } else {
        return $this->response->setJSON([
            "status"  => false,
            "message" => "Error, try again.."
        ]);
    }
}
public function notifications()
  {
    $data=$this->data;
    $m_notification = new \App\Models\M_notification();
    $data['admin_name'] = $this->session->get('admin_name');
    $respdata['notifications']=$m_notification->get_notifications();
    echo view('includes/header',$data);
    echo view('includes/sidebar',$data);
    echo view('notifications',$respdata);
    echo view('includes/footer');
  }
  public function edit_notification($id)
  {

    $data=$this->data;
    $m_notification = new \App\Models\M_notification();
    $data['admin_name'] = $this->session->get('admin_name');
    $notificationdata['notification']=$m_notification->get_notification($id);
  
    echo view('includes/header',$data);
    echo view('includes/sidebar',$data);
    echo view('create_notification',$notificationdata);
    echo view('includes/footer');
  }
public function delete_notification($id)
{
    $m_notification = new \App\Models\M_notification();
    $data = $m_notification->delete_notification($id);
    $response = [];
    if ($data === false) {
        $response['success'] = false;
        $response['err']     = "Notification not removed.";
    } else {
        $response['success'] = true;
        $response['message'] = "Notification removed successfully.";
        $response['reload']  = 1;
    }
    return $this->response
          ->setHeader('Content-Type', 'application/json')
          ->setBody(json_encode($response));
        }
public function messages()
 {
    $data=$this->data;
    $msgModel = new M_message();
    $data['messages'] = $msgModel->get_all_messages();
    echo view('admin/includes/header');
    echo view('admin/message_list', $data);
    echo view('admin/includes/footer');
    }
public function create_message()
    {
        $userModel = new M_user();
        $data['users'] = $userModel->findAll();

        echo view('admin/includes/header');
        echo view('admin/message_create', $data);
        echo view('admin/includes/footer');
    }

public function send_message()
{
    $users = $this->request->getPost('user_ids'); // array
    $data = [
        'msg_title' => $this->request->getPost('title'),
        'msg_text'  => $this->request->getPost('text')
    ];

    $msgModel = new \App\Models\M_message();
    $msg_id = $msgModel->insert($data);

    if ($msg_id) {
        $userMsgModel = new \App\Models\M_user_message();

        foreach ($users as $uid) {
            $userMsgModel->insert([
                'user_id' => $uid,
                'msg_id'  => $msg_id
            ]);
        }
    }
        return redirect()->back()->with('success', 'Message sent');
    }

}
?>
