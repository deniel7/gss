<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
    private $rule = array(
            array (
                'field' => 'user_id',
                'label' => 'User ID',
                'rules' => 'required',
            ),
            array (
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required',
            )
            
    );
    
    public function __construct() {
        parent::__construct();
        
        $this->load->model('option_m');
        
        $this->template->use_asset()->set_judul('Form Login')->set_css('login');
        $this->template->use_asset()->set_css(array('bootstrap.min','metisMenu.min','sb-admin-2'));
        $this->data->metadata = $this->template->get_metadata();
        $this->data->judul = $this->template->get_judul();
    }
    
    public function index() {
        $user_id = $this->input->post('user_id');
        $password = $this->input->post('password');
        
        //check cabang mana yg login
        
        //echo $username .'-'. $kode_cabang;
        $this->load->library('form_validation'); 
        $this->form_validation->set_rules($this->rule);
        if ($this->form_validation->run()) {
            $this->autentifikasi->admin_login($user_id,$password);
            $this->session->set_flashdata('pesan', $user_id);
            
            redirect(site_url('admin'));
            
        }
            
        $this->_view('login',$this->data);
    }
    
    private function _view($filename,$data) {
        $this->load->view('admin/header',$data);
        $this->load->view($filename,$data);
        $this->load->view('admin/footer',$data);
    }
}

?>