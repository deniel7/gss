<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gold_Process extends MY_Controller {
    public function __construct() {
        parent::__construct();
        parent::default_meta();
        $this->data->judul = $this->template->get_judul();
        $this->data->metadata = $this->template->get_metadata();
    }
    
    public function index() {
        $this->load->model('pesanan_m');
        $this->data->pesanan = $this->pesanan_m->get_gold_process();
        $this->data->cabang = $this->session->userdata('kode_cabang');
        //$cb = $this->session->userdata('kode_cabang');
        //$this->load->model('pesanan_m');
	$this->data->total_pesanan = $this->pesanan_m->count_new_pesanan();
        $this->data->gold_proc = $this->pesanan_m->count_gold_process();
        $this->data->print_order = $this->pesanan_m->count_print_order();
        
        $this->data->username = $this->session->userdata('username');
	$this->data->multiuser = $this->session->userdata('multiuser');
        parent::_view('gold_process',$this->data);
    }
    
    public function logout() {
        $this->autentifikasi->logout();
        redirect (site_url().'/admin');
    }
    
}
?>
