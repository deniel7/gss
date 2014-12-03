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
	$this->data->total_gold_proses = $this->pesanan_m->count_gold_process();
        $this->data->total_print_do = $this->pesanan_m->count_print_order();
        $this->data->total_receiving = $this->pesanan_m->count_receiving();
        
        $data = array();
        $data['result'] = '<a href='.site_url('admin/pesanan').'><p style=color:white>'.$this->data->total_pesanan.'</p></a>';
        $data['result2'] = '<p style=color:white>'.$this->data->total_gold_proses.'</p>';
        $data['result3'] = '<a href='.site_url('admin/delivery_order').'><p style=color:white>'.$this->data->total_print_do.'</p></a>';
	$data['result4'] = '<a href='.site_url('admin/receiving').'><p style=color:white>'.$this->data->total_receiving.'</p></a>';
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
