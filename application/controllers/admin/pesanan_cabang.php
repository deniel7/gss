<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pesanan_Cabang extends MY_Controller {
    private $judul = 'Daftar Pesanan';
    
    public function __construct() {
        parent::__construct();
        parent::set_judul($this->judul);
        parent::default_meta();
        $this->load->model('pesanan_cabang_m');
        $this->load->model('kategori_m');
        $this->load->library('pagination');
        $this->template->set_js('jcrop')->set_css('jcrop');
        $this->data->metadata = $this->template->get_metadata();
        $this->data->judul = $this->template->get_judul();
	
	
	$this->data->username = $this->session->userdata('username');
        $this->data->cabang = $this->session->userdata('kode_cabang');
    }
    
    public function index(){
        $this->data->cabang = $this->session->userdata('kode_cabang');
        
	$this->data->base_url = base_url().'/admin/pesanan_cabang/index';
	
	//PAGINATION FIX berdasar cabang
	
	$cabangs = $this->data->cabang;
	$query = $this->db->query("SELECT * FROM `order` where kode_cabang ='$cabangs'");
	$result = $query->num_rows();
	
//	$this->data->total_rows = $this->db->count_all('order');
	$this->data->total_rows = $result;
	$this->data->per_page = $this->config->item('hlm');
	$this->data->uri_segment = 4;
        $this->pagination->initialize($this->data);
	
        $this->data->pesanan = $this->pesanan_cabang_m->get_all_page($this->data->per_page,$this->uri->segment(4,0),$this->data->cabang);
	$this->data->list_cab= $this->pesanan_cabang_m->list_cab('kode_cabang','nama_cabang');
        //$this->data->total_pesanan = $this->pesanan_cabang_m->count_pesanan($this->data->cabang);
	
	parent::_view('pesanan_cabang/list',$this->data);
    }
    
    public function detail($id = 0) {
        
	$this->data->cabang = $this->session->userdata('kode_cabang');
        
        $this->data->list_cab = $this->kategori_m->list_cab('kode_cabang','nama_cabang');
        
        $this->data->detail = $this->pesanan_cabang_m->get_record(array('id_order'=>$id),true);
        
	$this->data->total_pesanan = $this->pesanan_cabang_m->count_pesanan($this->data->cabang);
	
        parent::_view('pesanan_cabang/detail',$this->data);

    }
    
    public function search(){
        
	$this->data->total_pesanan = $this->pesanan_cabang_m->count_pesanan($this->data->cabang);
	
        if(isset($_POST['submit']))
        {
            $data['search_mem'] = $this->input->post('search_mem');
            $data['search_orderno'] = $this->input->post('search_orderno');
            $data['search_tg1'] = $this->input->post('search_tg1');
            $data['search_tg2'] = $this->input->post('search_tg2');
            
            
            //set session user data untuk pencarian, untuk paging pencarian
            $this->session->set_userdata('sess_mem', $data['search_mem']);
            $this->session->set_userdata('sess_orderno', $data['search_orderno']);
            $this->session->set_userdata('sess_tg1', $data['search_tg1']);
            $this->session->set_userdata('sess_tg2', $data['search_tg2']);
            
            
        } else {
            $data['search_mem'] = $this->session->userdata('sess_mem');
            $data['search_orderno'] = $this->session->userdata('sess_orderno');
            $data['search_tg1'] = $this->session->userdata('sess_tg1');
            $data['search_tg2'] = $this->session->userdata('sess_tg2');
            
        }    
        
	$this->data->cabang = $this->session->userdata('kode_cabang');
	
        $this->db->select('*');
        $this->db->from('order');
        $this->db->join('user', 'user.id_user = order.user_id');
        $this->db->join('user_data', 'user.id_user = user_data.user_id');
        $this->db->join('cabang', 'order.kode_cabang = cabang.kode_cabang');
	$this->db->where('order.kode_cabang', $this->data->cabang);
        
        if (($data['search_tg1'] != 0) && ($data['search_tg2'] != 0) && ($data['search_mem'] == 0) && ($data['search_orderno'] == 0)){
            
            $this->db->where('tanggal_masuk >=', $data['search_tg1']);
	    $this->db->where('tanggal_masuk <=', $data['search_tg2']);
            
        }
	
        else if(($data['search_tg1'] == 0) && ($data['search_tg2'] == 0) && ($data['search_mem'] == 0) && ($data['search_orderno'] != 0)){
            
            $this->db->like('order_no', $data['search_orderno']);
            
        }
        
        else if(($data['search_tg1'] == 0) && ($data['search_tg2'] == 0) && ($data['search_mem'] != 0) && ($data['search_orderno'] != 0)){
            
            
            $this->db->like('order_no', $data['search_orderno'])
                     ->like('membercard', $data['search_mem']);

        }
        
        else if(($data['search_tg1'] != 0) && ($data['search_tg2'] != 0) && ($data['search_mem'] == 0) && ($data['search_orderno'] != 0)){
            
            
            $this->db->like('order_no', $data['search_orderno'])
                     ->where('tanggal_masuk >=', $data['search_tg1'])
                     ->where('tanggal_masuk <=', $data['search_tg2']);
            
        }
        
        
        
        else if(($data['search_tg1'] != 0) && ($data['search_tg2'] != 0) && ($data['search_mem'] != 0) && ($data['search_orderno'] == 0)){
            
            
            $this->db->like('membercard', $data['search_mem']);
            $this->db->where('tanggal_masuk >=', $data['search_tg1']);
            $this->db->where('tanggal_masuk <=', $data['search_tg2']);
            
        }
        
        
        //TIGA
        
        else if(($data['search_tg1'] != 0) && ($data['search_tg2'] != 0) && ($data['search_mem'] != 0) && ($data['search_orderno'] != 0)){
            
            $this->db->like('membercard', $data['search_mem']);
            $this->db->like('order_no', $data['search_orderno']);
            $this->db->where('tanggal_masuk >=', $data['search_tg1']);
            $this->db->where('tanggal_masuk <=', $data['search_tg2']);
            
        }
        
        
        
        else{
            
            $this->db->like('order_no', $data['search_orderno']);
            $this->db->like('membercard', $data['search_mem']);
            $this->db->where('tanggal_masuk >=', $data['search_tg1']);
	    $this->db->where('tanggal_masuk <=', $data['search_tg2']);
            
        }
        
        //Pagination init
        $pagination['base_url'] 		= base_url().'/admin/pesanan_cabang/search/';
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
        
        $this->data->list_cab= $this->pesanan_cabang_m->list_cab('kode_cabang','nama_cabang');
        $this->data->pesanan = $this->pesanan_cabang_m->SearchResult($pagination['per_page'],$this->uri->segment(4,0),$data['search_orderno'],$data['search_mem'],$data['search_tg1'],$data['search_tg2'],$this->data->cabang);
        
        $this->load->vars($this->data);
        
	parent::_view('pesanan_cabang/list',$this->data);
    }
    
}
