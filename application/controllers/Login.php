<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('session'));
        $this->load->model('Modelo_main');
        $this->load->helper(array('form', 'html', 'url'));
      
    }

	
	public function index(){
       
        $this->load->view('login.php','',FALSE);
		
	}

  public function mainView()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        if(isset($username) && isset($password) && !empty($password) && !empty($username))
        {
           
            $total = $this->Modelo_main->count_results_users($username, $password);
            if($total == 1)
            {
                $dataUser = $this->Modelo_main->get_all_data_users_specific($username, $password);

                $array_session = array('id'=>$dataUser->adminId);
                $this->session->set_userdata($array_session);

                if($this->session->userdata('id'))
                {
                   redirect('Productos');
                    /*$aside = $this->load->view('companies/left_menu', '', TRUE);
                    $content = $this->load->view('companies/main_view', '', TRUE);
                    $this->load->view('main/template', array('aside'=>$aside,
                                                             'content'=>'',
                                 'included_js'=>array('statics/js/modules/menu.js')));*/
                }
                else{
                }
            }
            else{
                redirect('Login');
            }
        }
        else{
            redirect('Login');
        }
    }
   
 public function hola(){
    echo 'test';
 }
    
}
