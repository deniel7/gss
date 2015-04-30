<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Receiving extends MY_Controller {
    private $judul = 'Daftar Pesanan';
    
    
    public function __construct() {
        parent::__construct();
        parent::set_judul($this->judul);
        parent::default_meta();
        $this->load->model('pesanan_m');
        $this->load->model('kategori_m');
        $this->load->library('pagination');
        $this->data->metadata = $this->template->get_metadata();
        $this->data->judul = $this->template->get_judul();
        
        $this->data->username = $this->session->userdata('username');
        $this->data->cabang = $this->session->userdata('kode_cabang');
	
	$this->load->model('konfirmasi_m');
	$this->load->helper(array('form', 'url'));
    }
    
    public function index(){
        //$this->data->pesanan = $this->pesanan_m->get_all();
        //$this->data->base_url = base_url().'/admin/pesanan/index';
		
	//$this->data->total_rows = $this->db->count_all('order');
	$this->data->per_page = $this->config->item('hlm');
	$this->data->uri_segment = 4;
        $this->pagination->initialize($this->data);
	
        $this->data->pesanan = $this->pesanan_m->get_all_receiving();
	$this->data->list_cab= $this->pesanan_m->list_cab('kode_cabang','nama_cabang');
	
	
	
        parent::_view('receiving/list',$this->data);
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
            $config['allowed_types'] = 'gif|jpeg|png|jpg|JPG';
            $config['max_size']	= '500';
            //$config['max_width']  = '9';
            //$config['max_height']  = '7';
	    $receiving_time = date('Y-m-d H:i:s');
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
	    
	    
	    
	    $this->pesanan_m->update_by(array('id_order'=>$id),array('RECEIVING_DN'=>$uploadedFiles, 'receiving_dn_time'=>$receiving_time));
	    
	    redirect(base_url().'admin/receiving/');
	    //$this->load->view('admin/add_prod',$data);
	    }
       
        
	} else {
	    //CEK STATUS KONFIRMASI sudah / blom
	    $this->data->cek_dn = $this->pesanan_m->cek_DN($id);
            
	    //$this->data->detail = $this->pesanan_m->get_record(array('id_order'=>$id),true);
	    $this->data->detail = $this->pesanan_m->get_all_detail_trans(array('id_order'=>$id),true);
	    //echo $this->db->last_query();
        }
        parent::_view('receiving/detail',$this->data);
        //parent::_modal('pesanan/detail',$this->data);
    }
    

    public function submit_pesanan(){
        
        if(isset($_POST['submit']))
        {
	    $data['nomor'] = $this->input->post('nomor');
	    
	    echo $data['nomor'];
	}
    }

}
