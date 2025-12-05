<?php
namespace App\Controllers;

use App\Models\M_admin;

class Common extends BaseController
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

public function states()
  {
    $m_states = new \App\Models\M_state();
    $respdata['states']=$m_states->allStates();
    $admindata['admin_name'] = $this->session->get('admin_name');
    echo view('includes/header',$admindata);
    echo view('includes/sidebar');
    echo view('states',$respdata);
    echo view('includes/footer');
  }
public function districts($id)
  {
    $m_districts = new \App\Models\M_district();
    $m_states = new \App\Models\M_state();
    $respdata['state']=$m_states->state($id);
    $respdata['districts']=$m_districts->state_districts($id);
    $admindata['admin_name'] = $this->session->get('admin_name');
    echo view('includes/header',$admindata);
    echo view('includes/sidebar');
    echo view('districts',$respdata);
    echo view('includes/footer');
  }

public function new_district($id)
  {
    $m_districts = new \App\Models\M_district();
    $m_states = new \App\Models\M_state();
    $respdata['state']=$m_states->state($id);
    $admindata['admin_name'] = $this->session->get('admin_name');
    echo view('includes/header',$admindata);
    echo view('includes/sidebar');
    echo view('district_form',$respdata);
    echo view('includes/footer');
  }
public function edit_district($districtid,$stateId)
  {
    $m_district = new \App\Models\M_district();
    $m_states = new \App\Models\M_state();
    $respdata['state']=$m_states->state($stateId);
    $respdata['district']=$m_district->get_district($districtid,$stateId);
    $admindata['admin_name'] = $this->session->get('admin_name');
    echo view('includes/header',$admindata);
    echo view('includes/sidebar');
    echo view('district_form',$respdata);
    echo view('includes/footer');
  }
public function save_district()
{
    $id        = $this->request->getPost('district_id');
    $state_id  = $this->request->getPost('state_id');
    $name      = $this->request->getPost('district_name');

    $data = [
        'district_state'       => $state_id,
        'district_name'  => $name
    ];
    $m_district = new \App\Models\M_district();
    if (empty($id)) {
        $resp = $m_district->insert_district($data);
        $msg  = "District added successfully";
    } else {
        $resp = $m_district->update_district($id, $data);
        $msg  = "District updated successfully";
    }
    if ($resp) {
        return $this->response->setJSON([
            "status"   => true,
            "message"  => $msg,
            "redirect" => base_url('common/districts/'.$state_id)
        ]);
    } else {
        return $this->response->setJSON([
            "status"  => false,
            "message" => "Error, try again.."
        ]);
    }
  }
public function delete_district($id)
{
    $m_district = new \App\Models\M_district();
    $data = $m_district->delete_district($id);
    $response = [];
    if ($data === false) {
        $response['success'] = false;
        $response['err']     = "District not removed.";
    } else {
        $response['success'] = true;
        $response['message'] = "District removed successfully.";
        $response['reload']  = 1;
    }
    return $this->response
          ->setHeader('Content-Type', 'application/json')
          ->setBody(json_encode($response));
    }
public function blocks($id)
  {
    $m_block = new \App\Models\M_block();
    $m_district = new \App\Models\M_district();
    $respdata['district']=$m_district->get_district($id);
    $respdata['blocks']=$m_block->district_blocks($id);
    $admindata['admin_name'] = $this->session->get('admin_name');
    echo view('includes/header',$admindata);
    echo view('includes/sidebar');
    echo view('blocks',$respdata);
    echo view('includes/footer');
  }
}
?>
