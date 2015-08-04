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
        $this->data->pesanan = $this->pesanan_m->get_all_transaksi();
        
        $this->data->username = $this->session->userdata('username');
	//$this->data->multiuser = $this->session->userdata('multiuser');
        $this->data->dc_site_code = $this->session->userdata('dc_site_code');
	parent::_view('page',$this->data);
    }
    
    public function comp_stok(){
	$this->load->model('user_m');
	$this->data->multiuser = $this->session->userdata('multiuser');
	$this->data->site_master = $this->user_m->site_master();
	parent::_view('pilihcabang',$this->data);
    }
    
    public function virturiil(){
	$this->data->dc_site_code = $this->session->userdata('dc_site_code');
        $this->load->model('produk_m');
	$this->load->model('user_m');
	$this->data->multiuser = $this->session->userdata('multiuser');
	$this->data->site_master = $this->user_m->site_master();
	
	$dc_site_code = $this->input->post('dc_site_code');
        $this->data->stok = $this->produk_m->virturiil($dc_site_code);
	//$this->data->cabang = $this->user_m->get_cabang_desc($store_site_code);
	
        parent::_view('virturiil',$this->data);
    }
    
    public function logout() {
        $this->autentifikasi->logout();
        redirect (site_url().'/admin');
    }
    
}
?>
