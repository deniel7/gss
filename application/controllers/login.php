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
         $this->load->model('user_m');
        
        $this->template->use_asset()->set_judul('Form Login')->set_css('login');
        $this->template->use_asset()->set_css(array('bootstrap.min','metisMenu.min','sb-admin-2'));
        $this->data->metadata = $this->template->get_metadata();
        $this->data->judul = $this->template->get_judul();
        $this->data->dc_site_code = $this->user_m->dc_site_code();
    }
    
    public function index() {
        $this->load->library('form_validation'); 
        $this->form_validation->set_rules($this->rule);
        
        $user_id = $this->input->post('user_id');
        $password = $this->input->post('password');
        //$dc_site_code = $this->input->post('dc_site_code');
        
        if ($this->form_validation->run()) {
            //echo $user_id;
            $k = $this->user_m->get_ho($user_id);
            
            if($k == 15100){
                //echo "Ini HO";
                
                if(!$this->autentifikasi->ho_login($user_id,$password)){
                $this->session->set_flashdata('pesan', 'gagal login');
                redirect(site_url('login'));
                }else{
                    redirect(site_url('admin'));
                }
                
            }else{
                //echo "Ini bukan HO";
                $this->autentifikasi->admin_login($user_id,$password);
                //$this->session->set_flashdata('pesan', $user_id);
                redirect(site_url('admin'));
            }
            
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