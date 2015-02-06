<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Export_penjualan extends MY_Controller {
    private $judul = 'Export Penjualan';
    
    public function __construct() {
        parent::__construct();
        parent::set_judul($this->judul);
        parent::default_meta();
        $this->load->model('order_m');
        
        $this->data->metadata = $this->template->get_metadata();
        $this->data->judul = $this->template->get_judul();
        
        $this->data->username = $this->session->userdata('username');
        $this->data->cabang = $this->session->userdata('kode_cabang');
	$this->load->helper('download');
    }
    
    public function index(){
        
        $this->data->base_url = base_url().'/admin/export_penjualan/index';
	
	$this->data->total_rows = $this->db->count_all('order');
	$this->data->per_page = 3;
	$this->data->uri_segment = 4;
        $this->pagination->initialize($this->data);
	
        $this->data->data_e = 1;
        
        $this->data->list_cab= $this->order_m->list_cab('kode_cabang','nama_cabang');
        $this->data->stat_exp= $this->order_m->stat_exp();
	$this->data->list_cab2 = $this->order_m->cabang();
	
        parent::_view('export_penjualan/list',$this->data);
        
        
    }
    
    public function detail($id = 0) {
        if ($this->input->post('submit')){
            $this->order_m->update_by(array('id_order'=>$id),array('status_order'=>$this->input->post('status')));
            $this->data->sukses = 'Data berhasil diperbaharui';   
        } else {
            $this->data->detail = $this->order_m->get_record(array('id_order'=>$id),true);
        }
        
        parent::_modal('laporan_penjualan/detail',$this->data);
    }
    
    public function search(){
        $this->load->helper('file');
	
        if(isset($_POST['submit']))
        {
            $data['search_cabang'] = $this->input->post('search_cabang');
	    $data['search_tg1'] = $this->input->post('search_tg1');
            $data['search_tg2'] = $this->input->post('search_tg2');
            
            //set session user data untuk pencarian, untuk paging pencarian
            $this->session->set_userdata('sess_cabang', $data['search_cabang']);
	    $this->session->set_userdata('sess_tg1', $data['search_tg1']);
            $this->session->set_userdata('sess_tg2', $data['search_tg2']);
            
        } else {
            $data['search_cabang'] = $this->session->userdata('sess_cabang');
	    $data['search_tg1'] = $this->session->userdata('sess_tg1');
            $data['search_tg2'] = $this->session->userdata('sess_tg2');
        }	
    
        
	$this->db->select("CONCAT(order.order_no, '|', order.tanggal_masuk, '|', order.kode_cabang, '|', order_data.kuantitas , '|', produk.plu, '|', produk.nama_produk) AS export",FALSE);
        $this->db->from('`order`');
        $this->db->join('user', 'user.id_user = order.user_id');
        $this->db->join('order_data', 'order.id_order = order_data.order_id');
	$this->db->join('produk', 'order_data.produk_id = produk.id_produk');
	//$this->db->where('status_order', '4');
	
        if(($data['search_cabang'] != 0) && ($data['search_tg1'] ==0) || ($data['search_tg2'] == 0) ){
        
            $this->db->like('order.kode_cabang', $data['search_cabang']);
            
        
        }else{
           $a =  "select kode_cabang FROM `order` WHERE kode_cabang LIKE '".$data['search_cabang']."'";
           $query = $this->db->query($a);
           
           if(($query->num_rows() > 0)){
                $this->db->where('tanggal_masuk >=', $data['search_tg1'])
                         ->where('tanggal_masuk <=', $data['search_tg2'])
                         ->like('order.kode_cabang', $data['search_cabang']);
                //echo $this->db->last_query();
            
           }else{
            
            $this->db->where('tanggal_masuk >=', $data['search_tg1']);
            $this->db->where('tanggal_masuk <=', $data['search_tg2']);
           
            }
        }
        //Pagination init
        $pagination['base_url'] 		= base_url().'/admin/export_penjualan/search/';
        $pagination['total_rows'] 		= $this->db->count_all_results();
        $pagination['full_tag_open'] 	        = "<div class=\"pagination\">";
        $pagination['full_tag_close'] 	        = "</div>";
        $pagination['cur_tag_open'] 	        = "<span class=\"current\">";
        $pagination['cur_tag_close'] 	        = "</span>";
        $pagination['num_tag_open'] 	        = "<span class=\"disabled\">";
        $pagination['num_tag_close'] 	        = "</span>";
        $pagination['per_page'] 		= $this->config->item('hlm');
        $pagination['uri_segment'] 		= 4;
        $pagination['num_links'] 		= 4;
    
        $this->pagination->initialize($pagination);
    
        $this->data->data_e = $this->order_m->SearchExport($pagination['per_page'],$this->uri->segment(4,0),$data['search_tg1'],$data['search_tg2'],$data['search_cabang']);
        
        $this->data->list_cab= $this->order_m->list_cab('kode_cabang','nama_cabang');
        
        //$this->data->data_ee = $this->order_m->get_total_page($pagination['per_page'],$this->uri->segment(4,0),$data['search_tg1'],$data['search_tg2'],$data['search_cabang']);
        
        $this->load->vars($this->data);
        
	parent::_view('export_penjualan/list',$this->data);
	
    }
    
    public function export(){
        $this->load->helper('file');
       
	$list_cab2 = $this->order_m->cabang();
	$status_export = FALSE;
	
        //Pembagian data textfile for GOLD / ORA
	if(!empty($list_cab2)){
	    foreach($list_cab2 as $cabang){
	    
	    //GOLD
	    $this->data->data_e = $this->order_m->SearchExport($cabang->kode_cabang);
	    
	    //ORAFIN
	    $this->data->data_o = $this->order_m->SearchExport_o($cabang->kode_cabang);	
	    $this->data->data_o_div = $this->order_m->SearchExport_o_div($cabang->kode_cabang);
	    
	    //$this->data->data_ee = $this->order_m->get_total_page($pagination['per_page'],$this->uri->segment(4,0),$data['search_tg1'],$data['search_tg2'],$data['search_cabang']);
	    
	    $this->load->vars($this->data);
	    
	    $vPath = "export";
	    //mkdir($vPath);
	    
	    $ViewData = $this->load->view('export_penjualan/list_export', $this->data, TRUE);
	    $ViewData2 = $this->load->view('export_penjualan/list_export_o', $this->data, TRUE);
	    
		if(empty($this->data->data_e) || empty($this->data->data_o) || empty($this->data->data_o_div)){
		   
		//Make textfile for GOLD
		$filename = 'SALES11'.$cabang->kode_cabang.date("dmy").'.txt';
		//Make textfile for ORAFIN
		$filename2 = 'SALES_'.$cabang->kode_cabang.'_'.date("mdY").'.csv';
		
		
		write_file("$vPath/$filename", $ViewData);
		write_file("$vPath/$filename2", $ViewData2);
		//END Pembagian data textfile for GOLD / ORA
	    
		}else{
		
		//Make textfile for GOLD
		$filename = 'SALES11'.$cabang->store_code.date("dmy").'.txt';
		//Make textfile for ORAFIN
		$filename2 = 'SALES_'.$cabang->store_code.'_'.date("mdY").'.csv';
		
		
		write_file("$vPath/$filename", $ViewData);
		write_file("$vPath/$filename2", $ViewData2);
		//END Pembagian data textfile for GOLD / ORA
		
		//$this->order_m->update_stat_exp();
		
		$status_export = TRUE;
		
		
		}
	    }
	}
	
	if ($status_export)
	{
	    $this->order_m->update_stat_exp();
	    parent::_view('export_penjualan/selesai',$this->data);
	    
	}
	else
	{
	    parent::_view('export_penjualan/gagal',$this->data);
	}
	//redirect(base_url().'export_penjualan/selesai');
    }
    
}