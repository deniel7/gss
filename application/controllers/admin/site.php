<?php

class Site extends MY_Controller {
	private $judul = 'Laporan Penjualan';
    
	public function __construct(){
		parent::__construct();
		parent::set_judul($this->judul);
		parent::default_meta();
		$this->load->model('order_m');
		$this->load->model('produk_m');
		$this->data->metadata = $this->template->get_metadata();
		$this->data->judul = $this->template->get_judul();
	}
	
	function index()
	{
		$this->load->library('pagination');
		$this->load->library('table');
		
		$this->data->base_url = base_url().'/admin/site/index';
		
		$this->data->total_rows = $this->db->count_all('produk');
		$this->data->per_page = 2;
		$this->pagination->initialize($this->data);
		$this->data->produk = $this->produk_m->getThumbs($this->data->per_page,$this->uri->segment(4,0));
		
		parent::_view('laporan_penjualan/site_view',$this->data);
	}
	
}