<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//session_start(); //we need to call PHP's session object to access it through CI
class konfirmasi extends MY_Controller {
private $judul = 'Konfirmasi Pembayaran';

public function __construct() {
        parent::__construct();
        parent::set_judul($this->judul);
	parent::default_meta();
        $this->load->model('konfirmasi_m');
        $this->load->library('pagination');
	$this->data->metadata = $this->template->get_metadata();
	$this->data->judul = $this->template->get_judul();
	$this->data->username = $this->session->userdata('username');
        $this->data->cabang = $this->session->userdata('kode_cabang');
    }

public function index(){
     
	$this->load->model('konfirmasi_m','',TRUE);
	$this->load->library('pagination');
	//$this->data->data_konfirm = $this->konfirmasi_m->konfirmasi();
        
	$this->data->base_url = base_url().'/admin/konfirmasi/index';
		
	$this->data->total_rows = $this->db->count_all('konfirmasi');
	$this->data->per_page = $this->config->item('hlm');
	$this->data->uri_segment = 4;
        $this->pagination->initialize($this->data);
	$this->data->data_konfirm = $this->konfirmasi_m->get_all_page($this->data->per_page,$this->uri->segment(4,0));
		
	
	parent::_view('konfirmasi/index',$this->data);
	
}

public function aktifasi($ids = 0, $aktif = 0) {
        //echo $ids;
        //$id OR redirect(site_url('konfirmasi/index'));
        
	$mail_sent = false;
        $sql = "SELECT email FROM konfirmasi WHERE id_konfirmasi = ".$ids;
        $hasil = $this->db->query($sql);
        $data = $hasil->result();
        
	foreach($data as $row):
            
		$email = $row->email;
            
        endforeach;
	
        if($aktif == 1){
            
	    $this->konfirmasi_m->update($ids,array('status'=>$aktif));
	    
	    
        
                $this->load->library('email');
             
                $this->config->load('mail_config',true);
                
                $this->email->from('a@yahoo.com');
                $this->email->to($email);
                $this->email->subject('Konfirmasi Yogya E-Commerce');
                $this->email->message('Terima kasih, proses pembayaran dan konfirmasi Anda sudah diterima, pesanan Anda sedang diproses.');
                
                if ($this->email->send())
                {
                    # If $mail_sent = true; it will show a success message.
                    $mail_sent = true;
                }
        
        $this->session->set_flashdata('user_note','<p class="msg done">Status konfirmasi sudah diaktifkan | Pesan email pemberitahuan sudah dikirimkan kepada user.</p>');
        
	
	}else{
        
	    $this->session->set_flashdata('user_note','<p class="msg warning">Anda tidak diperkenankan menonaktifkan diri anda sendiri.</p>');
        
	}
        
        redirect(site_url('admin/konfirmasi'));
    }

public function search(){
        
	
        if(isset($_POST['submit']))
        {
            $data['search_orderno'] = $this->input->post('search_orderno');
	    $data['search_tg1'] = $this->input->post('search_tg1');
            $data['search_tg2'] = $this->input->post('search_tg2');
            
	    
            //set session user data untuk pencarian, untuk paging pencarian
            $this->session->set_userdata('sess_orderno', $data['search_orderno']);
	    $this->session->set_userdata('sess_tg1', $data['search_tg1']);
            $this->session->set_userdata('sess_tg2', $data['search_tg2']);
            
        } else {
            $data['search_orderno'] = $this->session->userdata('sess_orderno');
	    $data['search_tg1'] = $this->session->userdata('sess_tg1');
            $data['search_tg2'] = $this->session->userdata('sess_tg2');
        }
	
	
	$this->db->select('*');
        $this->db->from('konfirmasi');
        
	
	if (($data['search_tg1'] == 0) || ($data['search_tg2'] == 0)){
		
		$this->db->like('order_no', $data['search_orderno']);
		
	}
	else if (($data['search_orderno'] == 0)){
			$this->db->where('tanggal >=', $data['search_tg1']);
			$this->db->where('tanggal <=', $data['search_tg2']);
			
	}else{
			$this->db->like('order_no', $data['search_orderno']);
			$this->db->where('tanggal >=', $data['search_tg1']);
			$this->db->where('tanggal <=', $data['search_tg2']);
			

	}
	
        //Pagination init
        $pagination['base_url'] 		= base_url().'/admin/konfirmasi/search/';
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
    
	$this->data->data_konfirm = $this->konfirmasi_m->SearchResult($pagination['per_page'],$this->uri->segment(4,0),$data['search_tg1'],$data['search_tg2'],$data['search_orderno']);
        $this->load->vars($this->data);
	
	parent::_view('konfirmasi/index',$this->data);
}

}
