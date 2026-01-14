<?php
namespace App\Controllers;

class Dashboard extends BaseController
{
    protected $session;

    public function __construct()
    {

     $m_program = new \App\Models\M_program();

        $this->session = \Config\Services::session();
       $this->sidebar_programs = $m_program->get_programs();

    }
public function index()
{
    if (!session()->get('logged_in')) {
        return redirect()->to('/');
    }

    // Alag se model call karne ki zaroorat nahi hai
    echo view('includes/header', $this->data);
    echo view('includes/sidebar', $this->data);
    echo view('dashboard', $this->data);
    echo view('includes/footer');

}


}
?>
