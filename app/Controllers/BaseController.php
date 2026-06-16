<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
// 1. Model ko yahan import karein
use App\Models\M_program;

abstract class BaseController extends Controller
{
    protected $request;
    protected $helpers = [];
    protected $session;
    
    // 2. Ek global variable banayein data ke liye
    protected $data = [];

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Session load karein
        $this->session = \Config\Services::session();

        // 3. Programs ka data globally load karein

        $this->data['admin_name'] = $this->session->get('admin_name');

        // CORS Headers (Aapka existing code)
        $response->setHeader('Access-Control-Allow-Origin', '*')
             ->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE')
             ->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization');
    }
}
