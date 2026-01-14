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
    $data=$this->data;
    $m_states = new \App\Models\M_state();
    $data['states']=$m_states->allStates();
    $data['admin_name'] = $this->session->get('admin_name');
    echo view('includes/header',$data);
    echo view('includes/sidebar');
    echo view('states',$data);
    echo view('includes/footer');
  }
public function districts($id)
  {
    $data=$this->data;
    $m_districts = new \App\Models\M_district();
    $m_states = new \App\Models\M_state();
    $data['state']=$m_states->state($id);
    $data['districts']=$m_districts->state_districts($id);
    $data['admin_name'] = $this->session->get('admin_name');
    echo view('includes/header',$data);
    echo view('includes/sidebar',$data);
    echo view('districts',$data);
    echo view('includes/footer');
  }

public function new_district($id)
  {
    $data=$this->data;
    $m_districts = new \App\Models\M_district();
    $m_states = new \App\Models\M_state();
    $data['state']=$m_states->state($id);
    $data['admin_name'] = $this->session->get('admin_name');
    echo view('includes/header',$data);
    echo view('includes/sidebar',$data);
    echo view('district_form',$data);
    echo view('includes/footer');
  }
public function edit_district($districtid,$stateId)
  {
    $data=$this->data;
    $m_district = new \App\Models\M_district();
    $m_states = new \App\Models\M_state();
    $data['state']=$m_states->state($stateId);
    $data['district']=$m_district->get_district($districtid,$stateId);
    $data['admin_name'] = $this->session->get('admin_name');
    echo view('includes/header',$data);
    echo view('includes/sidebar',$data);
    echo view('district_form',$data);
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
/*Block Function*/
public function blocks($districtid)
  {
    $data=$this->data;
    $m_block = new \App\Models\M_block();
    $m_district = new \App\Models\M_district();
    $data['district']=$m_district->get_district($districtid);
    $data['blocks']=$m_block->district_blocks($districtid);
    $data['admin_name'] = $this->session->get('admin_name');
    echo view('includes/header',$data);
    echo view('includes/sidebar',$data);
    echo view('blocks',$data);
    echo view('includes/footer');
  }
  public function new_block($districtid)
    {
      $data=$this->data;
      $m_block = new \App\Models\M_block();
      $m_district = new \App\Models\M_district();
      $data['district']=$m_district->get_district($districtid);
      $data['admin_name'] = $this->session->get('admin_name');
      echo view('includes/header',$data);
      echo view('includes/sidebar',$data);
      echo view('block_form',$data);
      echo view('includes/footer');
    }
  public function edit_block($blockid,$districtId)
    {
      $data=$this->data;
      $m_block = new \App\Models\M_block();
      $m_district = new \App\Models\M_district();
      $data['district']=$m_district->get_district($districtId);
      $data['block']=$m_block->get_block($blockid);
      $data['admin_name'] = $this->session->get('admin_name');
      echo view('includes/header',$data);
      echo view('includes/sidebar',$data);
      echo view('block_form',$data);
      echo view('includes/footer');
    }
  public function save_block()
  {
      $id        = $this->request->getPost('block_id');
      $district_id  = $this->request->getPost('block_district');
      $name      = $this->request->getPost('block_name');

      $data = [
          'block_district'       => $district_id,
          'block_name'  => $name
      ];
      $m_block = new \App\Models\M_block();
      if (empty($id)) {
          $resp = $m_block->insert_block($data);
          $msg  = "Block added successfully";
      } else {
          $resp = $m_block->update_block($id, $data);
          $msg  = "Block updated successfully";
      }
      if ($resp) {
          return $this->response->setJSON([
              "status"   => true,
              "message"  => $msg,
              "redirect" => base_url('common/blocks/'.$district_id)
          ]);
      } else {
          return $this->response->setJSON([
              "status"  => false,
              "message" => "Error, try again.."
          ]);
      }
    }
  public function delete_block($id)
  {
      $m_block = new \App\Models\M_block();
      $data = $m_block->delete_block($id);
      $response = [];
      if ($data === false) {
          $response['success'] = false;
          $response['err']     = "Block not removed.";
      } else {
          $response['success'] = true;
          $response['message'] = "Block removed successfully.";
          $response['reload']  = 1;
      }
      return $this->response
            ->setHeader('Content-Type', 'application/json')
            ->setBody(json_encode($response));
      }
/*Village Function*/
public function villages($blockid)
  {
    $data=$this->data;
    $m_block = new \App\Models\M_block();
    $m_village = new \App\Models\M_village();
    $data['block']=$m_block->get_block($blockid);
    $data['villages']=$m_village->block_villages($blockid);
    $data['admin_name'] = $this->session->get('admin_name');
    echo view('includes/header',$data);
    echo view('includes/sidebar',$data);
    echo view('villages',$data);
    echo view('includes/footer');
  }
  public function new_village($blockid)
    {
      $m_block = new \App\Models\M_block();
      $data=$this->data;
      $data['block']=$m_block->get_block($blockid);
      $data['admin_name'] = $this->session->get('admin_name');
      echo view('includes/header',$data);
      echo view('includes/sidebar');
      echo view('village_form',$data);
      echo view('includes/footer');
    }
  public function edit_village($villageId,$blockId)
    {
      $m_block = new \App\Models\M_block();
      $m_village = new \App\Models\M_village();
      $data=$this->data;
      $data['block']=$m_block->get_block($blockId);
      $data['village']=$m_village->get_village($villageId);
      $data['admin_name'] = $this->session->get('admin_name');
      echo view('includes/header',$data);
      echo view('includes/sidebar');
      echo view('village_form',$data);
      echo view('includes/footer');
    }
  public function save_village()
  {
      $id        = $this->request->getPost('village_id');
      $block_id  = $this->request->getPost('village_block');
      $name      = $this->request->getPost('village_name');

      $data = [
          'village_block'       => $block_id,
          'village_name'  => $name
      ];
      $m_village = new \App\Models\M_village();
      if (empty($id)) {
          $resp = $m_village->insert_village($data);
          $msg  = "Village added successfully";
      } else {
          $resp = $m_village->update_village($id, $data);
          $msg  = "Village updated successfully";
      }
      if ($resp) {
          return $this->response->setJSON([
              "status"   => true,
              "message"  => $msg,
              "redirect" => base_url('common/villages/'.$block_id)
          ]);
      } else {
          return $this->response->setJSON([
              "status"  => false,
              "message" => "Error, try again.."
          ]);
      }
    }
  public function delete_village($id)
  {
      $m_village = new \App\Models\M_village();
      $data = $m_village->delete_village($id);
      $response = [];
      if ($data === false) {
          $response['success'] = false;
          $response['err']     = "Village not removed.";
      } else {
          $response['success'] = true;
          $response['message'] = "Village removed successfully.";
          $response['reload']  = 1;
      }
      return $this->response
            ->setHeader('Content-Type', 'application/json')
            ->setBody(json_encode($response));
      }
public function associate_details($vlntrId)
  {
    $m_group=new \App\Models\M_group();
    $data=$this->data;
    $m_saintri_distribution=new \App\Models\M_saintri_distribution();
    $m_volunteer=new \App\Models\M_volunteer();
    $data['groups']=$m_group->get_groups($vlntrId);
    $data['saintridistributions']=$m_saintri_distribution->saintri_distribution($vlntrId);
    $data['volunteerdetails']=$m_volunteer->get_volunteer($vlntrId);
    $data['admin_name'] = $this->session->get('admin_name');
    echo view('includes/header',$data);
    echo view('includes/sidebar');
    echo view('associate_details',$data);
    echo view('includes/footer');
  }
public function filter_associate_data()
{
    $from = $this->request->getPost('from_date');
    $to = $this->request->getPost('to_date');
    $volunteer = $this->request->getPost('associate_id');
    
  $m_group=new \App\Models\M_group();
  $m_saintri_distribution=new \App\Models\M_saintri_distribution();

    $groups = $m_group->filterGroups($volunteer, $from, $to);
    $saintri = $m_saintri_distribution->filterSaintri($volunteer, $from, $to);

    return json_encode([
        "groups" => $groups,
        "saintri" => $saintri
    ]);
}
 public function sanitry_orders($programid)

{
    $data = $this->data; 
    $m_program_apply = new \App\Models\M_program_apply();
    $data['orders'] = $m_program_apply->get_orders($programid);
    echo view('includes/header', $data);
    echo view('includes/sidebar', $data); 
    echo view('sanitary_orders', $data);
    echo view('includes/footer');
}

    public function order_assigned($pincode)
    {
      $data=$this->data;
      $m_program_apply = new \App\Models\M_program_apply();
      $data['admin_name'] = $this->session->get('admin_name');
      $data['orders']=$m_program_apply->get_orders();
      echo view('includes/header',$data);
      echo view('includes/sidebar');
      echo view('sanitary_orders',$data);
      echo view('includes/footer');
    }
public function change_assign_order($orderId, $pincode, $programid, $associateid = 0)

{
    $m_program_apply = new \App\Models\M_program_apply();
    $m_program = new \App\Models\M_program();
    $m_volunteer = new \App\Models\M_volunteer();
    $data=$this->data;
    $data['admin_name'] = $this->session->get('admin_name');
    $data['programdetails'] = $m_program->get_program($programid);
    $data['associates'] = $m_volunteer->associatesbyPincode($pincode);
    $data['assignedorders'] = $m_program_apply->assigned_order($orderId, $pincode);
    echo view('includes/header', $data);
    echo view('includes/sidebar');
    echo view('change_assign_order', $data); 
    echo view('includes/footer'); 
}

public function re_assign_order()
{
    $orderId     = $this->request->getPost('order_id');
    $associateid = $this->request->getPost('associate_id');
    $programid   = $this->request->getPost('program_id');
    $pincode     = $this->request->getPost('pincode');

    $m_program_apply = new \App\Models\M_program_apply();
    $resp = $m_program_apply->change_assigne($orderId, $associateid);
    
    $targetUrl = base_url("common/change_assign_order/$orderId/$pincode/$programid/$associateid");

    if ($resp) {
        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                "status"   => true,
                "message"  => "Associate changed successfully",
                "redirect" => $targetUrl
            ]);
        }
        return redirect()->to($targetUrl);
    } else {
        return $this->response->setJSON(["status" => false, "message" => "Error, try again.."]);
    }
}

}
?>
