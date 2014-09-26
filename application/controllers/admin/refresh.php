<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Refresh extends CI_Controller {
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
        $this->load->model('pesanan_m');
        $this->data->total_pesanan = $this->pesanan_m->count_new_pesanan();
        
        $this->load->model('user_m');
	$this->data->total_n_user = $this->user_m->count_new_user();
        
        $data = array();
        $data['result'] = '<a href='.site_url('admin/pesanan').'>Pesanan Baru : '.$this->data->total_pesanan.'</a>';
        $data['result2'] = '<a href='.site_url('admin/user').'>User Baru : '.$this->data->total_n_user.'</a>';
        
        echo json_encode($data);
    }
    
    
    public function c_pesanan_cbg(){
        $this->load->model('pesanan_cabang_m');
	    
        $total_pesanan = 0;
        foreach ($this->pesanan_cabang_m->count_pesanan($this->data->cabang) as $tot)
        {
            $total_pesanan = $tot;
        }
        
        
        
        $data = array();
        $data['result'] = '<a href='.site_url('admin/pesanan_cabang').'>Pesanan Baru : '.$total_pesanan.'</a>';
        echo json_encode($data);
    }
}

?>
