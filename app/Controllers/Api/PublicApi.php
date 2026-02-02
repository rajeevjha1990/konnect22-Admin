<?php
namespace App\Controllers\Api;

use App\Controllers\BaseController;

class PublicApi extends BaseController
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

    public function apply_program()
    {
        // Validation
        $this->validation->setRule('mobile', 'Mobile', 'required');
        $this->validation->setRule('name', 'Name', 'required');
        $this->validation->setRule('program_id', 'Program', 'required');
        $this->validation->setRule('payment_mode', 'Payment Method', 'required');

        if (!$this->validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status' => false,
                'errors' => $this->validation->getErrors()
            ]);
        }

        // Order Data
        $applyData = [
            'program_id'    => $this->request->getVar('program_id'),
            'order_name'    => $this->request->getVar('name'),
            'order_number'  => $this->request->getVar('mobile'),
            'order_pincode' => $this->request->getVar('pincode'),
            'order_address' => $this->request->getVar('address'),
            'amount'        => $this->request->getVar('amount'),
            'payment_mode'  => $this->request->getVar('payment_mode'), 
            'payment_status'=> $this->request->getVar('payment_status') ?? 'pending',
            'order_status'  => 'new'
        ];

        $m_apply = new \App\Models\M_program_apply();

        // Insert new order
        $orderId = $m_apply->insert($applyData, true);

        if (!$orderId) {
            return $this->response->setJSON([
                'status' => false,
                'msg'    => 'Failed to create order'
            ]);
        }

        // 🔥 AUTO ASSIGN
        $assignedVolunteerId = $this->auto_assign_volunteer($orderId);

        return $this->response->setJSON([
            'status' => true,
            'msg'    => 'Program applied successfully',
            'order_id' => $orderId,
            'assigned_volunteer_id' => $assignedVolunteerId
        ]);
    }

    /**
     * 🔥 Auto assign volunteer
     */
private function auto_assign_volunteer($orderId)
{
    $m_volunteer = new \App\Models\M_volunteer();
    $m_apply     = new \App\Models\M_program_apply();

    //  Get order
    $order = $m_apply->getOrderById($orderId);
    if (!$order) return null;

    $orderPincode = $order['order_pincode'];

    //  Get same pincode volunteers
    $volunteers = $m_volunteer->getVolunteersByPincode($orderPincode);
    if (empty($volunteers)) return null;

    $selectedVolunteer = null;
    $minOrders = PHP_INT_MAX;
    $oldestTime = null;

    foreach ($volunteers as $vol) {

        $orderCount = $m_apply->get_applycounts($vol['volntr_id']);
        $lastTime   = $vol['last_assigned_at'];

        //  Never assigned = top priority
        if (empty($lastTime)) {
            $selectedVolunteer = $vol['volntr_id'];
            break;
        }

        if (
            $orderCount < $minOrders ||
            ($orderCount == $minOrders && strtotime($lastTime) < strtotime($oldestTime ?? date('Y-m-d H:i:s')))
        ) {
            $minOrders = $orderCount;
            $oldestTime = $lastTime;
            $selectedVolunteer = $vol['volntr_id'];
        }
    }

    if (!$selectedVolunteer) return null;

    // 3 Assign order
    $m_apply->assignVolunteerToOrder($orderId, $selectedVolunteer);

    //  Update volunteer time
    $m_volunteer->updateLastAssignedTime($selectedVolunteer);

    return $selectedVolunteer;
}
public function get_new_events()
  {
    $m_event = new \App\Models\M_event();
    $response['events']=$m_event->get_events();
    return json_encode($response);
  }

}
?>