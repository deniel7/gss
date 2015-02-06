<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Refresh_cbg extends CI_Controller {
    private $default_view ;
    private $judul = 'E-Commerce Admin ' ;
    
    public function __construct(){
        parent::__construct();
        
        if (!$this->autentifikasi->sudah_login()) redirect (site_url('login'));
        if (!$this->autentifikasi->role(array('admin'))) redirect (site_url('login'));
        
        $this->default_view = $this->load->_ci_view_path;
        $this->load->_ci_view_path = $this->default_view.'admin/';
        
        $this->template->use_asset();
    }
    
    
    public function index(){
        $this->load->model('pesanan_cabang_m');
	    
        $total_pesanan = 0;
        foreach ($this->pesanan_cabang_m->count_pesanan($this->session->userdata('kode_cabang')) as $tot)
        {
            $total_pesanan = $tot;
        }
        
        
        
        $data = array();
        $data['result'] = '<a href='.site_url('admin/pesanan_cabang').'>Pesanan Baru : '.$total_pesanan.'</a>';
        echo json_encode($data);
    }
}

?>
