<?php

class Slide_banner extends MY_Controller {
	private $judul = 'Pengaturan Slide Banner';
	
	private $datas = array(
        'dir' => array(
            'original' => 'images/banner/',
            'thumb' => 'images/banner/thumb/'
        ),
        'total' => 0,
        'images' => array(),
        'error' => ''
	);
	
	public function __construct(){
		parent::__construct();
		parent::set_judul($this->judul);
		parent::default_meta();
		$this->load->model('option_m');
		
		$this->data->metadata = $this->template->get_metadata();
		$this->data->judul = $this->template->get_judul();
		$this->data->username = $this->session->userdata('username');
		$this->data->cabang = $this->session->userdata('kode_cabang');
		

	}
	
	function index()
	{
		//$this->load->library('pagination');
		//$this->load->library('table');
		//
		$this->data->base_url = base_url().'/admin/slide_banner/index';
		$this->data->gbr = $this->option_m->gbr_banner();
		//
		//$this->data->total_rows = $this->db->count_all('produk');
		//$this->data->per_page = 2;
		//$this->pagination->initialize($this->data);
		//$this->data->produk = $this->produk_m->getThumbs($this->data->per_page,$this->uri->segment(4,0));
		
		parent::_view('slide_banner/list',$this->data);
	}
	
	
	public function tambah()
	{
		$this->data->count_banner = $this->option_m->count_banner();
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('userfile','userfile','required'|'xss_clean');
		
		//echo $this->data->count_banner;
		
		if ($this->data->count_banner == 6){
			$this->data->error = "Jumlah maksimum gambar sudah mencapai jumlah maksimum (6 buah)";
			parent::_modal('slide_banner/tambah',$this->data);
		
		}else{
		
			if($this->form_validation->run()==FALSE){
			
			    parent::_modal('slide_banner/tambah',$this->data);
			
			}else if($this->input->post('go_upload')){
			    
			    $new_file_name = 'banner';
			    $config['upload_path'] = 'images/banner';
			    $config['allowed_types'] = 'gif|jpg|png';
			    $config['max_size']	= '500';
			    $config['max_width']  = '960';
			    $config['max_height']  = '300';
			    $config['file_name'] = $new_file_name;
			    
		
			    $this->load->library('upload', $config);
			    
			    
			    if ( ! $this->upload->do_upload())
			    {
				   $this->data->error = $this->upload->display_errors();
				   parent::_modal('slide_banner/tambah',$this->data);
		
			    }
			    else{
		 
			    
			    $file=$this->upload->data();
			    $this->load->library('image_lib');
			    //$new_img = $this->datas['dir'].$file['file_name'];
			    
			    $c_img = array(
				'image_library'     => 'gd2',
				'source_image'      => $file['full_path'],
				'maintain_ratio'    => FALSE,
				'width'             => 960,
				'height'            => 300,
				'new_image'	    => $file['file_name']
			    );
			    
			    
			    
			    $uploadedFiles = $file['file_name']; 
			    
			    $new_image = $this->datas['dir']['thumb'].'thumb_'.$file['file_name'];
			    
			    $c_img_lib = array(
				'image_library'     => 'gd2',
				'source_image'      => $file['full_path'],
				'maintain_ratio'    => TRUE,
				'width'             => 100,
				'height'            => 100,
				'new_image'         => $new_image,
				'new_name'	    => 'thumb_'.$file['file_name']
			    );
			    
			    //$this->load->library('image_lib', $c_img);
			    $this->image_lib->initialize($c_img);
			    $this->image_lib->resize();
			    $this->image_lib->clear();
			    //$this->load->library('image_lib', $c_img_lib);
			    $this->image_lib->initialize($c_img_lib);
			    $this->image_lib->resize();
			    $thumb = $c_img_lib['new_name']; 
			    
			    
			    $this->load->model('option_m','',TRUE);
			    $this->option_m->tambah_gbr($uploadedFiles,$thumb);
			    //redirect(base_url().'admin/slide_banner/');
			    $this->data->sukses = "Gambar berhasil ditambahkan";
			    parent::_modal('slide_banner/tambah',$this->data);
			    }
			}
		}
	     
	}
	
	
	public function hapus($id= 0){
		$id OR redirect(site_url('admin/slide_banner'));
		
		$this->option_m->hapus($id);
		
		//if($this->session->userdata('user_id') != $id){
		//    $this->option_m->hapus($id);   
		//} else {
		//    $this->session->set_flashdata('user_note','<p class="msg warning">Anda tidak diperkenankan menghapus diri anda sendiri.</p>');        
		//}
		
		redirect(site_url('admin/slide_banner'));
	}
}

?>