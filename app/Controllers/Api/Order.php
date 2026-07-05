<?php
namespace App\Controllers\Api;

use App\Controllers\BaseAuthController;

class Order extends BaseAuthController
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

public function place_order()
{
    $this->validation->setRules([
        'mobile'         => 'required',
        'address'        => 'required',
        'pincode'        => 'required',
        'payment_method' => 'required',
        'total_amount'   => 'required',

    ]);

    if (!$this->validation->withRequest($this->request)->run()) {

        return $this->response->setJSON([
            'status' => false,
            'errors' => $this->validation->getErrors()
        ]);
    }

    $m_order = new \App\Models\M_order();

    $orderData = [

        'order_no' => $this->request->getVar('order_id'),

        'user_id' => $this->userData->user_id,

        'order_number' => $this->request->getVar('mobile'),

        'order_address' => $this->request->getVar('address'),

        'order_pincode' => $this->request->getVar('pincode'),

        'order_landmark' => $this->request->getVar('landmark'),

        'subtotal' => $this->request->getVar('subtotal'),

        'shipping' => $this->request->getVar('delivery_charge'),

        'discount' => $this->request->getVar('discount'),

        'total' => $this->request->getVar('total_amount'),

        'payment_mode' => $this->request->getVar('payment_method'),

        'payment_status' => 'pending',

        'status' => 'Pending',

        'estimated_delivery' =>
            $this->request->getVar('estimated_delivery'),

        'created_at' => date('Y-m-d H:i:s')
    ];

    $insertId = $m_order->insert_order($orderData);

    if (!$insertId) {

        return $this->response->setJSON([
            'status' => false,
            'msg' => 'Order creation failed'
        ]);
    }

   $items = json_decode($this->request->getVar('items'), true);
    if (!empty($items) && is_array($items)) {
        $m_order_item = new \App\Models\M_order_item();
        foreach ($items as $item) {
            $itemData = [
                'order_id' => $insertId,
                'product_id' => $item['id'] ?? 0,
                'price' => $item['price'] ?? 0,
                'qty' => $item['quantity'] ?? 1,
                'vendor_id'=>$item['vendor_id'] ?? 0
            ];
            $m_order_item->insert_item($itemData);
        }
        
    }
    $m_cart = new \App\Models\M_cart();

    $m_cart->delete_user_cart($this->userData->user_id);
    return $this->response->setJSON([
        'status' => true,
        'order_id' => $insertId,
        'order_no' => $this->request->getVar('order_id'),
        'msg' => 'Order created successfully'
    ]);
}
public function my_orders()
    {
        $m_order = new \App\Models\M_order();
        $response['orders'] = $m_order->get_orders($this->userData->user_id);
          
        return json_encode($response);
    }
public function cancel_order()
{
    $order_id = $this->request->getVar('order_id');

    $m_order = new \App\Models\M_order();

    $order = $m_order->where('id', $order_id)
                     ->where('user_id', $this->userData->user_id)
                     ->first();

    if (!$order) {
        return $this->response->setJSON([
            'status' => false,
            'msg' => 'Order not found'
        ]);
    }

    if (in_array($order['status'], ['Shipped', 'Delivered'])) {
        return $this->response->setJSON([
            'status' => false,
            'msg' => 'Order cannot be cancelled'
        ]);
    }

    $m_order->update($order_id, [
        'status' => 'Cancelled'
    ]);

    return $this->response->setJSON([
        'status' => true,
        'msg' => 'Order cancelled successfully'
    ]);
}
}
?>