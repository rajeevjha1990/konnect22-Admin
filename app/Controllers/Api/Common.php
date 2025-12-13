<?php
namespace App\Controllers\Api;

use App\Controllers\BaseAuthController;

class Common extends BaseAuthController
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
    public function qualifications()
      {
        $m_qualification = new \App\Models\M_qualification();
        $response['qualifications']=$m_qualification->get_qualifications();
        return json_encode($response);
      }
public function getPrograms()
  {
    $m_program = new \App\Models\M_program();
    $response['programs']=$m_program->get_programs();
    return json_encode($response);
  }
public function epGropus()
  {
    $m_group = new \App\Models\M_group();
    $vlntrId=$this->volunteerData->volntr_id;
    $response['groups']=$m_group->get_groups($vlntrId);
    return json_encode($response);
  }
public function getProgramsAndGroups()
  {
    $m_program = new \App\Models\M_program();
    $m_group   = new \App\Models\M_group();
    $vlntrId = $this->volunteerData->volntr_id;
    $response = [
        'programs' => $m_program->get_programs(),
        'groups'   => $m_group->get_groups($vlntrId)
    ];
    return json_encode($response);
}

public function new_group()
{
    $groupId = $this->request->getVar('group_id');
    $groupData = [
        'group_volunteer'     =>$this->volunteerData->volntr_id,
        'group_program'     => $this->request->getVar('program_id'),
        'group_name'     => $this->request->getVar('group_name'),
        'group_epno'        => $this->request->getVar('ep_no'),
        'group_senior_epno' => $this->request->getVar('senior_ep_no'),
        'group_noof_member' => $this->request->getVar('no_of_members'),
        'group_start_date' => $this->request->getVar('group_start_date'),
    ];
    $groupmembers = $this->request->getVar('members');
    if (is_string($groupmembers)) {
        $groupmembers = json_decode($groupmembers, true);
    }
    $m_group = new \App\Models\M_group();
    $m_group_member = new \App\Models\M_group_member();
    if (!empty($groupId)) {
        $m_group->update_group($groupId, $groupData);
        $m_group_member->where('groupid', $groupId)->delete();

      if (!empty($groupmembers)) {
            $batchData = [];
            foreach ($groupmembers as $member) {
                $batchData[] = [
                    'groupid' => $groupId,
                    'epno'    => $this->request->getVar('ep_no'),
                    'name'    => $member['name'],
                    'mobile'  => $member['mobile']
                ];
            }
            $m_group_member->insertBatch($batchData);
        }
        return $this->response->setJSON([
            'status' => true,
            'msg'    => 'Group updated successfully.'
        ]);
    }
    $insert = $m_group->insertGroup($groupData);
    $group_id = $m_group->insertID();

    if ($insert && $group_id && !empty($groupmembers)) {
        $mobiles = array_column($groupmembers, 'mobile');

        $existingMobiles = $m_group_member->checkduplicateMobile($mobiles);
        if (!empty($existingMobiles)) {
            $existingMobileList = array_column($existingMobiles, 'mobile');
            return $this->response->setStatusCode(409)->setJSON([
                'status' => false,
                'msg' => 'Duplicate mobile numbers found: ' . implode(', ', $existingMobileList)
            ]);
        }
        $batchData = [];
        foreach ($groupmembers as $member) {
            $batchData[] = [
                'groupid' => $group_id,
                'epno'    => $this->request->getVar('ep_no'),
                'name'    => $member['name'],
                'mobile'  => $member['mobile']
            ];
        }
        $result = $m_group_member->insertBatch($batchData);
    }

    if (!empty($result)) {
        return $this->response->setJSON([
            'status' => true,
            'msg'    => 'New Group Created Successfully with members.'
        ]);
    } else {
        return $this->response->setStatusCode(500)->setJSON([
            'status' => false,
            'msg'    => 'Failed to create new group.'
        ]);
    }
}
public function getMembers()
  {
    $groupid=$this->request->getVar('groupId');
    $m_group_member= new \App\Models\M_group_member();
    $response['groupmembers']=$m_group_member->get_group_members($groupid);
    return json_encode($response);
  }
public function update_role()
  {
    $memberId=$this->request->getVar('memberId');
    $role=$this->request->getVar('role');
    $m_group_member= new \App\Models\M_group_member();
    $result=$m_group_member->update_role($memberId,$role);
    if($result){
      return $this->response->setJSON([
          'status' => true,
          'msg'    => 'Member role update.'
      ]);
    }
  }
public function request_edit_group()
  {
    $requestdata=array(
      'request_id'=>$this->volunteerData->volntr_id,
      'group_id'=>$this->request->getVar('groupId'),
      'reason'=>$this->request->getVar('reason')
    );

    $m_request= new \App\Models\M_request();
    $result =$m_request->request_insert($requestdata);
    if($result){
      return $this->response->setJSON([
          'status' => true,
          'msg' => 'Your request to edit the group has been successfully submitted.'
      ]);
    }
  }
public function getAllEditRequests()
  {
    $m_request= new \App\Models\M_request();
    $response['allrequests']=$m_request->get_all_edit_request();
    return json_encode($response);
  }
public function get_groupdata()
  {
    $groupId=$this->request->getVar('groupId');
    $m_group= new \App\Models\M_group();
    $m_group_member= new \App\Models\M_group_member();
    $response['groupdata']=$m_group->get_groupdata($groupId);
    $response['members']=$m_group_member->get_group_members($groupId);
    return json_encode($response);
  }
public function get_states()
  {
  $m_state= new \App\Models\M_state();
  $response['states']=$m_state->allStates();
  return json_encode($response);
  }
public function state_districts()
  {
  $stateId=$this->request->getVar('stateId');
  $m_district= new \App\Models\M_district();
  $response['districts']=$m_district->state_districts($stateId);
  return json_encode($response);
  }
public function district_blocks()
  {
  $districtId=$this->request->getVar('districtId');
  $m_block= new \App\Models\M_block();
  $response['blocks']=$m_block->district_blocks($districtId);
  return json_encode($response);
  }

public function block_villages()
  {
  $blockId=$this->request->getVar('blockId');
  $m_village= new \App\Models\M_village();
  $response['villages']=$m_village->block_villages($blockId);
  return json_encode($response);
  }


public function saintri_distribution()
{
    $mobile = $this->request->getVar('mobile');
    $m_saintri = new \App\Models\M_saintri_distribution();

    //  Old active record
    $oldRecord = $m_saintri->getOldRecord($mobile);

    if ($oldRecord) {
        $m_saintri->updateOldRecord($oldRecord->id);
    }

    //  Last paid membership (for yearly check)
    $lastPaid = $m_saintri->getLastMembershipPaid($mobile);

    $membershipAmount = 0; // default: no charge

    if (!$lastPaid) {
        //  First time member → full charge
        $membershipAmount = $this->request->getVar('membership_amount');
    } else {
        $lastPaidDate = strtotime($lastPaid->issue_date);
        $oneYearLater = strtotime('+1 year', $lastPaidDate);

        if (time() >= $oneYearLater) {
            //  1 saal complete → charge again
            $membershipAmount = $this->request->getVar('membership_amount');
        } else {
            //  1 saal complete nahi hua → FREE renewal
            $membershipAmount = 0;
        }
    }

    //  NEW INSERT DATA
    $saintriData = [
        'volunteer_id' => $this->volunteerData->volntr_id,
        'member_name' => $oldRecord->member_name ?? $this->request->getVar('member_name'),
        'age' => $oldRecord->age ?? $this->request->getVar('age'),
        'guardian' => $oldRecord->guardian ?? $this->request->getVar('guardian'),
        'village' => $oldRecord->village ?? $this->request->getVar('village'),
        'post' => $oldRecord->post ?? $this->request->getVar('block_id'),
        'district' => $oldRecord->district ?? $this->request->getVar('district_id'),
        'state' => $oldRecord->state ?? $this->request->getVar('state_id'),
        'pincode' => $oldRecord->pincode ?? $this->request->getVar('pincode'),
        'mobile' => $mobile,

        //  YEARLY MEMBERSHIP CONTROL
        'membership_amount' => $membershipAmount,

        'issue_date' => date('Y-m-d'),
        'status' => 1,
        'created' => date('Y-m-d H:i:s')
    ];

    $result = $m_saintri->insert($saintriData);

    if ($result) {
        return $this->response->setJSON([
            'status' => true,
            'msg' => ($membershipAmount > 0)
                ? 'Membership renewed with payment.'
                : 'Re-issue successful (No membership charge).'
        ]);
    }

    return $this->response->setJSON([
        'status' => false,
        'msg' => 'Distribution failed.'
    ]);
}
public function distributed_saintries()
{
    $vlntrId = $this->volunteerData->volntr_id;

    //Pagination Inputs from App
    $page  = $this->request->getGet('pageno') ?? 1;
    $limit = $this->request->getGet('limit') ?? 20;

    $page  = (int)$page;
    $limit = (int)$limit;
    $offset = ($page - 1) * $limit;

    $m_saintri = new \App\Models\M_saintri_distribution();

    $data = $m_saintri->distributed_saintries(
        $vlntrId,
        $limit,
        $offset
    );

      return json_encode($data);
    }
  public function get_allsainetriCount()
    {
      $vlntrId = $this->volunteerData->volntr_id;
      $m_saintri = new \App\Models\M_saintri_distribution();
      $response['countsaintri']=$m_saintri->get_allsainetriCount($vlntrId);
      return json_encode($response);
    }
  public function get_allGroupCount()
    {
      $vlntrId = $this->volunteerData->volntr_id;
      $m_group = new \App\Models\M_group();
      $response['countgroup']=$m_group->get_allGroupCount($vlntrId);
      return json_encode($response);
    }
}
?>
