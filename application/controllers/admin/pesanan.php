<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pesanan extends MY_Controller {
    private $judul = 'Daftar Pesanan';
    
    
    public function __construct() {
        parent::__construct();
        parent::set_judul($this->judul);
        parent::default_meta();
        $this->load->model('pesanan_m');
        $this->load->model('kategori_m');
        $this->load->library('pagination');
        $this->template->set_js('jcrop')->set_css('jcrop');
        $this->data->metadata = $this->template->get_metadata();
        $this->data->judul = $this->template->get_judul();
        
        $this->data->username = $this->session->userdata('username');
        $this->data->cabang = $this->session->userdata('kode_cabang');
	
	$this->load->model('konfirmasi_m');
	$this->load->helper(array('form', 'url'));
    }
    
    public function index(){
        //$this->data->pesanan = $this->pesanan_m->get_all();
        $this->data->base_url = base_url().'/admin/pesanan/index';
		
	//$this->data->total_rows = $this->db->count_all('order');
	$this->data->per_page = $this->config->item('hlm');
	$this->data->uri_segment = 4;
        $this->pagination->initialize($this->data);
	
        $this->data->pesanan = $this->pesanan_m->get_all_transaksi();
	$this->data->list_cab= $this->pesanan_m->list_cab('kode_cabang','nama_cabang');
        parent::_view('pesanan/list',$this->data);
    }
    
    public function detail($id = 0) {
        
        //$cab = $this->input->post('cab',TRUE);
        //if ($this->input->post('submit')){
            
            //$this->pesanan_m->update_by(array('id_order'=>$id),array('FLAG'=>2));
            //$this->data->sukses = 'Data berhasil diperbaharui';
   
	$this->load->library('form_validation');
        
        
	$this->form_validation->set_rules('userfile','userfile','required'|'xss_clean');
	
        
        if($this->input->post('go_upload')){
	     
	    $config['upload_path'] = 'uploads/receiving/';
            $config['allowed_types'] = 'gif|jpeg|png';
            $config['max_size']	= '500';
            //$config['max_width']  = '9';
            //$config['max_height']  = '7';

            $this->load->library('upload', $config);
	    
            
	    if (!$this->upload->do_upload())
            {
                   $this->data->error = $this->upload->display_errors();
		   $this->data->detail = $this->pesanan_m->get_all_detail_trans(array('id_order'=>$id),true);
            }
            else{
 
            
	    //$data=$this->upload->do_upload('gambar');
	    $file=$this->upload->data();
	    $uploadedFiles = $file['file_name']; 
	    
	    
	    
	    $this->pesanan_m->update_by(array('id_order'=>$id),array('RECEIVING_DN'=>$uploadedFiles));
	    
	    redirect(base_url().'admin/pesanan/');
	    //$this->load->view('admin/add_prod',$data);
	    }
       
        
	} else {
	    //CEK STATUS KONFIRMASI sudah / blom
	    $this->data->cek_dn = $this->pesanan_m->cek_DN($id);
            
	    //$this->data->detail = $this->pesanan_m->get_record(array('id_order'=>$id),true);
	    $this->data->detail = $this->pesanan_m->get_all_detail_trans(array('id_order'=>$id),true);
	    //echo $this->db->last_query();
        }
        parent::_view('pesanan/detail',$this->data);
        //parent::_modal('pesanan/detail',$this->data);
    }
    
    public function search(){
        
        if(isset($_POST['submit']))
        {
            $data['search_mem'] = $this->input->post('search_mem');
            $data['search_orderno'] = $this->input->post('search_orderno');
            $data['search_tg1'] = $this->input->post('search_tg1');
            $data['search_tg2'] = $this->input->post('search_tg2');
            $data['status'] = $this->input->post('status');
            $data['search_cab'] = $this->input->post('search_cab');
            $data['waktu'] = $this->input->post('waktu');
	    
            //set session user data untuk pencarian, untuk paging pencarian
            $this->session->set_userdata('sess_mem', $data['search_mem']);
            $this->session->set_userdata('sess_orderno', $data['search_orderno']);
            $this->session->set_userdata('sess_tg1', $data['search_tg1']);
            $this->session->set_userdata('sess_tg2', $data['search_tg2']);
            $this->session->set_userdata('sess_status', $data['status']);
            $this->session->set_userdata('sess_cab', $data['search_cab']);
	    $this->session->set_userdata('sess_waktu', $data['waktu']);
            
        } else {
            $data['search_mem'] = $this->session->userdata('sess_mem');
            $data['search_orderno'] = $this->session->userdata('sess_orderno');
            $data['search_tg1'] = $this->session->userdata('sess_tg1');
            $data['search_tg2'] = $this->session->userdata('sess_tg2');
            $data['status'] = $this->session->userdata('sess_status');
            $data['search_cab'] = $this->session->userdata('sess_cab');
	    $data['waktu'] = $this->session->userdata('sess_waktu');
        }
	//echo $data['waktu'];
            
        $this->db->select('*');
        $this->db->from('order');
        $this->db->join('user', 'user.id_user = order.user_id');
        $this->db->join('user_data', 'user.id_user = user_data.user_id');
        $this->db->join('cabang', 'order.kode_cabang = cabang.kode_cabang');
        
        if (($data['search_tg1'] != 0) && ($data['search_tg2'] != 0) && ($data['search_mem'] == 0) && ($data['status'] == 0) && ($data['search_cab'] == 0) && ($data['search_orderno'] == 0)){
		
	   $a =  "select kode_cabang FROM `order` WHERE kode_cabang LIKE '".$data['search_cab']."'";
           $query = $this->db->query($a);
           
           if(($query->num_rows() > 0)){
           
                $this->db->like('order.kode_cabang', $data['search_cab']);
                $this->db->where('tanggal_masuk >=', $data['search_tg1']);
                $this->db->where('tanggal_masuk <=', $data['search_tg2']);
            
            
           }else{
            
            $this->db->where('tanggal_masuk >=', $data['search_tg1']);
	    $this->db->where('tanggal_masuk <=', $data['search_tg2']);
            
           }
        }
        
        
        else if(($data['search_tg1'] == 0) && ($data['search_tg2'] == 0) && ($data['search_mem'] == 0) && ($data['status'] != 0) || (empty($data['status']))  && ($data['search_cab'] == 0) && ($data['search_orderno'] == 0)){
            
            $a =  "select kode_cabang FROM `order` WHERE kode_cabang LIKE '".$data['search_cab']."'";
           $query = $this->db->query($a);
           
           if(($query->num_rows() > 0)){
                $this->db->like('status_order', $data['status']);
                $this->db->like('order.kode_cabang', $data['search_cab']);
            
            
           }else{
            
            $this->db->like('status_order', $data['status']);
            
           }
        }
        
        else if(($data['search_tg1'] == 0) && ($data['search_tg2'] == 0) && ($data['search_mem'] == 0) && ($data['status'] == 0) && ($data['search_cab'] != NULL) && ($data['search_orderno'] == 0)){
            
            $this->db->like('order.kode_cabang', $data['search_cab']);
            
        }
	
	else if(($data['search_tg1'] == 0) && ($data['search_tg2'] == 0) && ($data['search_mem'] == 0) && ($data['status'] == 0) && ($data['search_cab'] == 0) && ($data['search_orderno'] == 0) && ($data['waktu'] != 0)){
            
            $this->db->where('order.waktu_ambil', $data['waktu']);
            echo $data['waktu'];
        }
        
        else if(($data['search_tg1'] == 0) && ($data['search_tg2'] == 0) && ($data['search_mem'] == 0) && ($data['status'] == 0) && ($data['search_cab'] == 0) && ($data['search_orderno'] != 0)){
            
            $this->db->like('order_no', $data['search_orderno']);
            
        }
        
        else if(($data['search_tg1'] == 0) && ($data['search_tg2'] == 0) && ($data['search_mem'] != 0) && ($data['status'] == 0) && ($data['search_cab'] == 0) && ($data['search_orderno'] != 0)){
            
            $a =  "select kode_cabang FROM `order` WHERE kode_cabang LIKE '".$data['search_cab']."'";
            $query = $this->db->query($a);
           
           if(($query->num_rows() > 0)){
           
                $this->db->like('membercard', $data['search_mem'])
                     ->like('order_no', $data['search_orderno'])
                     ->like('order.kode_cabang', $data['search_cab']);
            
               
           }else{
            
            $this->db->like('order_no', $data['search_orderno'])
                     ->like('membercard', $data['search_mem']);

           }
        }
        
        else if(($data['search_tg1'] != 0) && ($data['search_tg2'] != 0) && ($data['search_mem'] == 0) && ($data['status'] == 0) && ($data['search_cab'] == 0) && ($data['search_orderno'] != 0)){
            
           $a =  "select kode_cabang FROM `order` WHERE kode_cabang LIKE '".$data['search_cab']."'";
           $query = $this->db->query($a);
           
           if(($query->num_rows() > 0)){
           
            $this->db->like('order_no', $data['search_orderno'])
                     ->where('tanggal_masuk >=', $data['search_tg1'])
                     ->where('tanggal_masuk <=', $data['search_tg2'])
                     ->like('order.kode_cabang', $data['search_cab']);
                       
           }else{
            
            $this->db->like('order_no', $data['search_orderno'])
                     ->where('tanggal_masuk >=', $data['search_tg1'])
                     ->where('tanggal_masuk <=', $data['search_tg2']);
            
           }
        }
        
        else if(($data['search_tg1'] == 0) && ($data['search_tg2'] == 0) && ($data['search_mem'] == 0) && ($data['status'] != 0) && ($data['search_cab'] == 0) && ($data['search_orderno'] != 0)){
            
            $this->db->like('order_no', $data['search_orderno'])
                     ->like('status_order', $data['status']);
            
        }
        
        else if(($data['search_tg1'] == 0) && ($data['search_tg2'] == 0) && ($data['search_mem'] == 0) && ($data['status'] == 0) && ($data['search_cab'] != 0) && ($data['search_orderno'] != 0)){
            
            $this->db->like('order_no', $data['search_orderno'])
                     ->like('order.kode_cabang', $data['search_cab']);
            
        }
        
        else if(($data['search_tg1'] != 0) && ($data['search_tg2'] != 0) && ($data['search_mem'] != 0) && ($data['status'] == 0) && ($data['search_cab'] == 0) && ($data['search_orderno'] == 0)){
            
           $a =  "select kode_cabang FROM `order` WHERE kode_cabang LIKE '".$data['search_cab']."'";
           $query = $this->db->query($a);
           
           if(($query->num_rows() > 0)){
           
            $this->db->like('membercard', $data['search_mem']);
            $this->db->where('tanggal_masuk >=', $data['search_tg1']);
            $this->db->where('tanggal_masuk <=', $data['search_tg2']);
            $this->db->like('order.kode_cabang', $data['search_cab']);
                
            
           }else{
            
            $this->db->like('membercard', $data['search_mem']);
            $this->db->where('tanggal_masuk >=', $data['search_tg1']);
            $this->db->where('tanggal_masuk <=', $data['search_tg2']);
            
           }
        }
        
        else if(($data['search_tg1'] == 0) && ($data['search_tg2'] == 0) && ($data['search_mem'] != 0) && ($data['status'] != 0) && ($data['search_cab'] == 0) && ($data['search_orderno'] == 0)){
            
            $this->db->like('membercard', $data['search_mem'])
                     ->like('status_order', $data['status']);
            
        }
        
        else if(($data['search_tg1'] == 0) && ($data['search_tg2'] == 0) && ($data['search_mem'] != 0) && ($data['status'] == 0) && ($data['search_cab'] != NULL) && ($data['search_orderno'] == 0)){
           
           $a =  "select kode_cabang FROM `order` WHERE kode_cabang LIKE '".$data['search_cab']."'";
           $query = $this->db->query($a);
           
           if(($query->num_rows() > 0)){
           
                $this->db->like('membercard', $data['search_mem'])
                         ->like('order.kode_cabang', $data['search_cab']);
                
           }else{
                $this->db->like('membercard', $data['search_mem']);
                
           }
            
        }
        
        else if(($data['search_tg1'] != 0) && ($data['search_tg2'] != 0) && ($data['search_mem'] == 0) && ($data['status'] != 0) && ($data['search_cab'] == 0) && ($data['search_orderno'] == 0)){
            
           $a =  "select kode_cabang FROM `order` WHERE kode_cabang LIKE '".$data['search_cab']."'";
           $query = $this->db->query($a);
           
           if(($query->num_rows() > 0)){
           
            $this->db->like('status_order', $data['status']);
            $this->db->where('tanggal_masuk >=', $data['search_tg1']);
            $this->db->where('tanggal_masuk <=', $data['search_tg2']);
            $this->db->like('order.kode_cabang', $data['search_cab']);
        
           }else{
            $this->db->like('status_order', $data['status']);
            $this->db->where('tanggal_masuk >=', $data['search_tg1']);
            $this->db->where('tanggal_masuk <=', $data['search_tg2']);
            
           }
        }
        
        //TIGA
        
        else if(($data['search_tg1'] != 0) && ($data['search_tg2'] != 0) && ($data['search_mem'] != 0) && ($data['status'] == 0) && ($data['search_cab'] == 0) && ($data['search_orderno'] != 0)){
            
            $this->db->like('membercard', $data['search_mem']);
            $this->db->like('order_no', $data['search_orderno']);
            $this->db->where('tanggal_masuk >=', $data['search_tg1']);
            $this->db->where('tanggal_masuk <=', $data['search_tg2']);
            
        }
        
        else if(($data['search_tg1'] == 0) && ($data['search_tg2'] == 0) && ($data['search_mem'] != 0) && ($data['status'] != 0) && ($data['search_cab'] == 0) && ($data['search_orderno'] != 0)){
            
            $this->db->like('membercard', $data['search_mem']);
            $this->db->like('order_no', $data['search_orderno']);
            $this->db->like('status_order', $data['status']);
            
        }
        
        else if(($data['search_tg1'] != 0) && ($data['search_tg2'] != 0) && ($data['search_mem'] != 0) && ($data['status'] != 0) && ($data['search_cab'] == 0) && ($data['search_orderno'] == 0)){
            
            $this->db->like('membercard', $data['search_mem']);
            $this->db->where('tanggal_masuk >=', $data['search_tg1']);
            $this->db->where('tanggal_masuk <=', $data['search_tg2']);
            $this->db->like('status_order', $data['status']);
            
           
        }
        
        else if(($data['search_tg1'] != 0) && ($data['search_tg2'] != 0) && ($data['search_mem'] == 0) && ($data['status'] != 0) && ($data['search_cab'] == 0) && ($data['search_orderno'] != 0)){
            
            $this->db->like('order_no', $data['search_orderno']);
            $this->db->where('tanggal_masuk >=', $data['search_tg1']);
            $this->db->where('tanggal_masuk <=', $data['search_tg2']);
            $this->db->like('status_order', $data['status']);
            
            
        }
        
        else{
            
            $this->db->like('order_no', $data['search_orderno']);
            $this->db->like('membercard', $data['search_mem']);
            $this->db->like('status_order', $data['status']);
            $this->db->like('order.kode_cabang', $data['search_cab']);
            $this->db->where('tanggal_masuk >=', $data['search_tg1']);
	    $this->db->where('tanggal_masuk <=', $data['search_tg2']);
            
        }
        
        //Pagination init
        $pagination['base_url'] 		= base_url().'/admin/pesanan/search/';
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
        
        $this->data->list_cab= $this->pesanan_m->list_cab('kode_cabang','nama_cabang');
        $this->data->pesanan = $this->pesanan_m->SearchResult($pagination['per_page'],$this->uri->segment(4,0),$data['search_orderno'],$data['search_mem'],$data['search_tg1'],$data['search_tg2'],$data['status'],$data['search_cab'],$data['waktu']);
        
        $this->load->vars($this->data);
        
	parent::_view('pesanan/list',$this->data);
    }
    



    public function submit_pesanan(){
        
        if(isset($_POST['submit']))
        {
	    $data['nomor'] = $this->input->post('nomor');
	    
	    echo $data['nomor'];
	}
    }

}
