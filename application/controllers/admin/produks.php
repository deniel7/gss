<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Produks extends MY_Controller {
    private $judul = 'Daftar Pesanan';
    
    
    public function __construct() {
        parent::__construct();
        parent::default_meta();
        $this->data->judul = $this->template->get_judul();
        $this->data->metadata = $this->template->get_metadata();
//        $this->load->model('pesanan_m');
//        $this->load->model('kategori_m');
//        $this->load->library('pagination');
//        $this->data->metadata = $this->template->get_metadata();
//        $this->data->judul = $this->template->get_judul();
//        
//        $this->data->username = $this->session->userdata('username');
//        $this->data->cabang = $this->session->userdata('kode_cabang');
//	
//	$this->load->model('konfirmasi_m');
//	$this->load->helper(array('form', 'url'));
    }
    
    public function index(){
        //$this->data->pesanan = $this->pesanan_m->get_all();
        //$this->data->base_url = base_url().'/admin/pesanan/index';
		
	//$this->data->total_rows = $this->db->count_all('order');
//	$this->data->per_page = $this->config->item('hlm');
//	$this->data->uri_segment = 4;
//        $this->pagination->initialize($this->data);
//	
//        $this->data->pesanan = $this->pesanan_m->get_new_orders();
//	$this->data->list_cab= $this->pesanan_m->list_cab('kode_cabang','nama_cabang');
	$this->data->multiuser = $this->session->userdata('multiuser');
        parent::_view('produk/lists',$this->data);
    }

}
