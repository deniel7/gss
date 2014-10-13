<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Controller {
    public function __construct() {
        parent::__construct();
        parent::default_meta();
        $this->data->judul = $this->template->get_judul();
        $this->data->metadata = $this->template->get_metadata();
    }
    
    public function index() {
        $this->load->model('pesanan_m');
        
        $this->data->cabang = $this->session->userdata('kode_cabang');
        //$cb = $this->session->userdata('kode_cabang');
        
        $this->data->username = $this->session->userdata('username');
        parent::_view('page',$this->data);
    }
    
    public function logout() {
        $this->autentifikasi->logout();
        redirect (site_url().'/admin');
    }
    
}
?>
