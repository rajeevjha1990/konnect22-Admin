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
    // Agar edit case hai (order_id aaya hai)
    if ($this->request->getVar('order_id')) {
        $this->validation->setRule('mobile', 'Mobile', 'required');
    } else {
        // New apply case me mobile unique hona chahiye
        $this->validation->setRule(
            'mobile','Mobile','required' );
    }

    // Common validations
    $this->validation->setRule('name', 'Name', 'required');
    $this->validation->setRule('program_id', 'Program', 'required');
    $this->validation->setRule('payment_mode', 'Payment Method', 'required');

    $this->validation->withRequest($this->request);

    if (!$this->validation->run()) {
        $this->response->setStatusCode(451);
        $response = [
            'err' => $this->validation->getErrors()
        ];
        return json_encode($response);
    }

    // Data array
    $applyData = [
        'program_id'    => $this->request->getVar('program_id'),
        'order_name'          => $this->request->getVar('name'),
        'order_number'        => $this->request->getVar('mobile'),
        'order_pincode'         => $this->request->getVar('pincode'),
        'order_address'         => $this->request->getVar('address'),
        'amount'         => $this->request->getVar('amount'),
        'payment_mode'=> $this->request->getVar('payment_mode'), 
        'payment_status'=> $this->request->getVar('payment_status') ?? 'pending',
    ];

    $m_apply = new \App\Models\M_program_apply();

    // Update or Insert
    if ($this->request->getVar('order_id')) {
        $id = $this->request->getVar('order_id');
        $res = $m_apply->update_apply($id, $applyData);
    } else {
        $res = $m_apply->insert_apply($applyData);
    }

    if ($res) {
        $response = [
            'status' => true,
            'msg'    => 'Program applied successfully',
        ];
        return json_encode($response);
    } else {
        $response = [
            'status' => false,
            'msg'    => 'Error, try again...'
        ];
        return json_encode($response);
    }
}

}
?>
