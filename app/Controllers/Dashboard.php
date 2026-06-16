<?php
namespace App\Controllers;

class Dashboard extends BaseController
{
    protected $session;

    public function __construct()
    {

     $this->session = \Config\Services::session();

    }
public function index()
{
    if (!session()->get('logged_in')) {
        return redirect()->to('/');
    }

    

    echo view('includes/header');
    echo view('includes/sidebar');
    echo view('dashboard');
    echo view('includes/footer');

}


}
?>
