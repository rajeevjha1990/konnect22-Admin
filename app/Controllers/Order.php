<?php

namespace App\Controllers;

use App\Models\M_order;

class Order extends BaseController
{
    protected $session;
    protected $orderModel;
    protected $data = [];

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->orderModel = new M_order();
    }

    private function setCommonData()
    {
        $this->data['admin'] = [
            'admin_name' => session()->get('admin_name'),
            'type'       => session()->get('type')
        ];
    }

public function index()
{
    if (!$this->session->get('logged_in')) {
        return redirect()->to('/');
    }

    $this->setCommonData();

    $this->data['orders'] = $this->orderModel
        ->select('orders.*, user.user_name as user_name')
        ->join('user', 'user.user_id = orders.user_id', 'left')
        ->orderBy('orders.id', 'DESC')
        ->findAll();
    echo view('includes/header', $this->data);
    echo view('includes/sidebar', $this->data);
    echo view('order_view', $this->data);
    echo view('includes/footer');
}
public function details($id)
{
     if (!$this->session->get('logged_in')) {
            return redirect()->to('/');
        }

        $this->setCommonData();

    $m_order = new \App\Models\M_order();

    $data['items'] = $m_order->get_order_details($id);

    if (empty($data['items'])) {
        return redirect()->to(base_url('order'));
    }
         echo view('includes/header', $this->data);
        echo view('includes/sidebar');
        echo view('order_details', $data);
        echo view('includes/footer');
}
    public function status($id)
    {
        $status = $this->request->getPost('status');

        $this->orderModel->update($id, [
            'status' => $status
        ]);

        return redirect()->to(base_url('order'));
    }
}