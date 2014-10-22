<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    private $default_view ;
    private $judul = 'Centralize Delivery & Inventory | Administrator' ;
    
    public function __construct(){
        parent::__construct();
        
        if (!$this->autentifikasi->sudah_login()) redirect (site_url('login'));
        if (!$this->autentifikasi->role(array('admin'))) redirect (site_url('login'));
        
        $this->default_view = $this->load->_ci_view_path;
        $this->load->_ci_view_path = $this->default_view.'admin/';
        
        $this->template->use_asset();
    }
    
    public function default_meta() {
        $this->template->set_css(array('bootstrap.min','metisMenu.min','sb-admin-2','timeline','morris'))
        ->set_js(array('jquery-1.11.0','bootstrap.min','metisMenu.min','sb-admin-2'))
        ->set_judul($this->judul);
        return $this;
    }
    
    public function onecol_meta() {
        $this->template->set_css(array('reset','main','1col','style','mystyle','colorbox'))
        ->set_js(array('jquery','switcher','toggle','ui.core','ui.tabs','jquery.colorbox.min'))
        ->set_judul($this->judul);
        return $this;
    }
    
    public function set_judul($judul = '') {
        $this->judul = $this->judul.'| '.$judul;
        return $this;
    }
    
    protected function _view($view,$data) {
        if (!$this->autentifikasi->sudah_pusat()){
            $view_cabang = $view;
            //echo $this->uri->segment(1).'/'.$this->uri->segment(2);
            $link = explode('/',uri_string());
            
            if(count($link) == 2){
                
                switch ($link[0].'/'.$link[1]) {
                    case 'admin/produk':
                        $view_cabang = "forbidden";
                        break;
                    case 'admin/kategori':
                        $view_cabang = "forbidden";
                        break;
                    case 'admin/user':
                        $view_cabang = "forbidden";
                        break;
                    case 'admin/laporan_penjualan':
                        $view_cabang = "forbidden";
                        break;
                    case 'admin/pengaturan':
                        $view_cabang = "forbidden";
                        break;
		    case 'admin/slide_banner':
                        $view_cabang = "forbidden";
                        break;
                }
            }
        }
        
            //$this->data->total_pesanan = $this->pesanan_cabang_m->count_pesanan($this->data->cabang);
	    //$this->load->model('pesanan_m');
	    //$this->data->total_pesanan = $this->pesanan_m->count_new_pesanan();
	    
	    $this->load->model('user_m');
	    $this->data->total_n_user = $this->user_m->count_new_user();
	    
	    $this->load->model('konfirmasi_m');
	    $this->data->total_new_konfirmasi = $this->konfirmasi_m->count_new_konfirmasi();	
			
            
            $this->load->view('header',$data);
            $this->load->view('topmenu',$data);
            $this->load->view('sidebar',$data);
            $this->load->view($view,$data);
            $this->load->view('bottom',$data);
            $this->load->view('footer',$data);
            
        
    }
    
    protected function _modal($view,$data) {
        $this->load->view('header',$data);
        $this->load->view($view,$data);
        $this->load->view('footer',$data);
    }
    
    
    protected function _view_onecol($view,$data) {
        if (!$this->autentifikasi->sudah_pusat()){
            $view_cabang = $view;
            //echo $this->uri->segment(1).'/'.$this->uri->segment(2);
            $link = explode('/',uri_string());
            
            if(count($link) == 2){
                
                switch ($link[0].'/'.$link[1]) {
                    case 'admin/produk':
                        $view_cabang = "forbidden";
                        break;
                    case 'admin/kategori':
                        $view_cabang = "forbidden";
                        break;
                    case 'admin/user':
                        $view_cabang = "forbidden";
                        break;
                    case 'admin/laporan_penjualan':
                        $view_cabang = "forbidden";
                        break;
                    case 'admin/pengaturan':
                        $view_cabang = "forbidden";
                        break;
		    case 'admin/slide_banner':
                        $view_cabang = "forbidden";
                        break;
                }
            }
        }
        
	
        if ($this->autentifikasi->sudah_pusat())
        {
            //$this->data->total_pesanan = $this->pesanan_cabang_m->count_pesanan($this->data->cabang);
	    $this->load->model('pesanan_m');
	    $this->data->total_pesanan = $this->pesanan_m->count_new_pesanan();
	    
	    $this->load->model('user_m');
	    $this->data->total_n_user = $this->user_m->count_new_user();
	    
	    $this->load->model('konfirmasi_m');
	    $this->data->total_new_konfirmasi = $this->konfirmasi_m->count_new_konfirmasi();	
			
            
            $this->load->view('header',$data);
            $this->load->view('topmenu',$data);
            $this->load->view('nosidebar',$data);
            $this->load->view($view,$data);
            $this->load->view('bottom',$data);
            $this->load->view('footer',$data);
            
        }else{
            $this->load->model('pesanan_cabang_m');
	    
	    $total_pesanan = 0;
	    foreach ($this->pesanan_cabang_m->count_pesanan($this->data->cabang) as $tot)
	    {
		$total_pesanan = $tot;
	    }
	    $this->data->total_pesanan = $total_pesanan;
            
	    
	    $this->load->view('header',$data);
            $this->load->view('topmenu',$data);
            $this->load->view('sidebar_cabang',$data);
            $this->load->view($view_cabang,$data);
            $this->load->view('bottom',$data);
            $this->load->view('footer',$data);
        }
    }
}

?>
