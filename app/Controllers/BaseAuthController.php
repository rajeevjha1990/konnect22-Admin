<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class BaseAuthController extends Controller
{
    protected $request;
    protected $userId;
    protected $userData;
    protected $encrypter;

    public $public_methods = [
        "login",
        "user_register",
        "create_password",
        "verify_otp",
        "forgot_password",
        "reset_password",
        "user_login"
    ];

    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);

        $this->request = $request;
        $this->encrypter = \Config\Services::encrypter();

        $currentMethod = $this->request->getUri()->getSegment(3);

        if (in_array($currentMethod, $this->public_methods)) {
            return;
        }

        // ==========================
        // AUTH CHECK
        // ==========================

        $authKey = trim($this->request->getHeaderLine('SVJAuthkey'));

        if (empty($authKey)) {
            $this->unauthorized('SVJAuthkey header missing');
        }

        try {

            if (!ctype_xdigit($authKey)) {
                throw new \Exception('Auth key is not valid hex string');
            }

            $binaryKey = hex2bin($authKey);

            if ($binaryKey === false) {
                throw new \Exception('hex2bin failed');
            }

            $decrypted = $this->encrypter->decrypt($binaryKey);

            if (!$decrypted) {
                throw new \Exception('Token decrypt failed');
            }

            $data = json_decode($decrypted, true);

            if (!is_array($data)) {
                throw new \Exception('JSON decode failed');
            }

            if (!isset($data['user_id'])) {
                throw new \Exception('User ID missing in token');
            }

            $this->userId = $data['user_id'];
          
            $userModel = new \App\Models\M_user();

            $this->userData = $userModel->get_user($this->userId);

            if (!$this->userData) {
                throw new \Exception('User not found');
            }

        } catch (\Throwable $e) {

            return $response
                ->setStatusCode(401)
                ->setJSON([
                    'status' => false,
                    'error'  => $e->getMessage(),
                    'authkey_received' => $authKey
                ])
                ->send();

            exit;
        }
    }

    protected function unauthorized($message = 'Unauthorized')
    {
        return $this->response
            ->setStatusCode(401)
            ->setJSON([
                'status' => false,
                'error' => $message
            ])
            ->send();
    }
}