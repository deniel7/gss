<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Produk extends MY_Controller {

    
    public function __construct() {
        parent::__construct();
        parent::default_meta();
        $this->load->model('produk_m');
        $this->load->model('kategori_m');
        
        
        //$this->template->set_js('jcrop')->set_css('jcrop');
        $this->data->metadata = $this->template->get_metadata();
        $this->data->judul = $this->template->get_judul();
	
	$this->data->multiuser = $this->session->userdata('multiuser');
    }
    
    public function index(){
        //$this->data->produk = $this->produk_m->get_all();
        //$this->data->produk = $this->produk_m->get_all_pag();
        
                $this->load->library('pagination');
		
		$this->data->produk = $this->produk_m->get_master_produk();
		//$this->data->base_url = base_url().'/admin/produk/index';
		
		//$this->data->total_rows = $this->db->count_all('produk');
//		$this->data->per_page = $this->config->item('hlm');
//		$this->data->uri_segment = 4;
//                $this->pagination->initialize($this->data);
//		$this->data->produk = $this->produk_m->get_all_page($this->data->per_page,$this->uri->segment(4,0));
//		
//		foreach($this->kategori_m->kategori as $key => $val) {
//		    $this->data->list_kategori[$val['id_kategori']] = $val['nama_kategori'];
//		}
//		
//		$this->data->total_topsales = $this->produk_m->count_topsales();
//		$this->data->total_empty_name = $this->produk_m->count_empty_name();
//		$this->data->total_empty_pic = $this->produk_m->count_empty_pic();
//		$this->data->who_imp = $this->produk_m->who_imp();
        
        parent::_view('produk/list',$this->data);
    }
    
    public function list_empty_name(){
        
                $this->load->library('pagination');
		
		$this->data->base_url = base_url().'/admin/produk/list_empty_name';
		
		$this->data->total_rows = $this->db->count_all('produk');
		$this->data->per_page = $this->config->item('hlm');
		$this->data->uri_segment = 4;
                $this->pagination->initialize($this->data);
		$this->data->produk = $this->produk_m->get_all_empty_name($this->data->per_page,$this->uri->segment(4,0));
		
		foreach($this->kategori_m->kategori as $key => $val) {
		    $this->data->list_kategori[$val['id_kategori']] = $val['nama_kategori'];
		}
		
		$this->data->total_empty_name = $this->produk_m->count_empty_name();
		$this->data->total_empty_pic = $this->produk_m->count_empty_pic();
		$this->data->who_imp = $this->produk_m->who_imp();
        
        parent::_view('produk/list',$this->data);
    }
    
    public function list_empty_pic(){
        
                $this->load->library('pagination');
		
		$this->data->base_url = base_url().'/admin/produk/list_empty_pic';
		
		$this->data->total_rows = $this->db->count_all('produk');
		$this->data->per_page = $this->config->item('hlm');
		$this->data->uri_segment = 4;
                $this->pagination->initialize($this->data);
		$this->data->produk = $this->produk_m->get_all_empty_pic($this->data->per_page,$this->uri->segment(4,0));
		
		foreach($this->kategori_m->kategori as $key => $val) {
		    $this->data->list_kategori[$val['id_kategori']] = $val['nama_kategori'];
		}
		
		$this->data->total_empty_name = $this->produk_m->count_empty_name();
		$this->data->total_empty_pic = $this->produk_m->count_empty_pic();
		$this->data->who_imp = $this->produk_m->who_imp();
        
        parent::_view('produk/list',$this->data);
    }
    
    public function list_top_sales(){
        
                $this->load->library('pagination');
		
		$this->data->base_url = base_url().'/admin/produk/list_top_sales';
		
		$total = 0;
		foreach ($this->produk_m->count_topsales() as $tot_topsales)
		
		{
		    
		    $total=$tot_topsales;
		}
		
		$this->data->total_rows = $total;
		
		$this->data->per_page = $this->config->item('hlm');
		$this->data->uri_segment = 4;
                $this->pagination->initialize($this->data);
		$this->data->produk = $this->produk_m->get_topsales($this->data->per_page,$this->uri->segment(4,0));
		
		foreach($this->kategori_m->kategori as $key => $val) {
		    $this->data->list_kategori[$val['id_kategori']] = $val['nama_kategori'];
		}
		
		$this->data->total_topsales = $this->produk_m->count_topsales();
		$this->data->total_empty_name = $this->produk_m->count_empty_name();
		$this->data->total_empty_pic = $this->produk_m->count_empty_pic();
		$this->data->who_imp = $this->produk_m->who_imp();
        
        parent::_view('produk/list',$this->data);
    }
    
    public function tambah() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<p class="msg warning">', '</p>');
        
        foreach($this->kategori_m->kategori as $key => $val) {
            $this->data->list_kategori[$val['id_kategori']] = $val['nama_kategori'];
        }
        
        $this->form_validation->set_rules($this->rules);
        
        if($this->form_validation->run()) {
            $data =  array (    'nama_produk'   =>  $this->input->post('nama_produk'),
                                'url_produk'    =>  underscore($this->input->post('nama_produk')),
                                'plu'   	=>  $this->input->post('plu'),
                                'kategori_id'   =>  $this->input->post('kategori'),
                                'harga_jual'    =>  $this->input->post('harga'),
                                'stok'          =>  $this->input->post('stok'),
				'topsales'    =>  $this->input->post('topsales'),
                                'deskripsi_produk'=>  $this->input->post('deskripsi')
                            );
            if ($this->produk_m->insert($data)) {
                $this->data->sukses = 'Data Berhasil di tambahkan';
            }
        }
        
        $this->data->nama_produk = set_value('nama_produk');
        $this->data->plu = set_value('plu');
        $this->data->deskripsi = set_value('deskripsi');
        $this->data->harga = set_value('harga');
        $this->data->stok = set_value('stok');
        $this->data->topsales = set_value('topsales');
	$this->data->kategori = $this->input->post('kategori');
        
        parent::_modal('produk/form',$this->data);
    }
    
    public function ubah($id = 0) {
        $id OR redirect(site_url('admin/produk'));
        
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<p class="msg warning">', '</p>');
        
        foreach($this->kategori_m->kategori as $key => $val) {
            $this->data->list_kategori[$val['id_kategori']] = $val['nama_kategori'];
        }
        
        $data_lama = $this->produk_m->get($id);
        $this->data->gambar = $this->produk_m->get_gambar($id);
        
        $this->form_validation->set_rules($this->rules);
        
        if($this->form_validation->run()) {
            $data =  array (    'nama_produk'   =>  $this->input->post('nama_produk'),
                                'url_produk'    =>  underscore($this->input->post('nama_produk')),
                                'plu'   	=>  $this->input->post('plu'),
                                'kategori_id'   =>  $this->input->post('kategori'),
                                'harga_jual'    =>  $this->input->post('harga'),
                                'harga_baru'    =>  $this->input->post('harga_baru'),
                                'stok'          =>  $this->input->post('stok'),
				'topsales'      =>  $this->input->post('topsales'),
                                'deskripsi_produk'     =>  $this->input->post('deskripsi')
                            );
            if ($this->produk_m->update($id,$data)) {
                $this->data->sukses = 'Data Berhasil di ubah';
                redirect(site_url('admin/produk'));
            }
        }
        
        if(!$this->input->post('submit')){
            $this->data->id = $data_lama->id_produk;
            //ID di ata hanya digunakan untuk inisiasi halaman penambahan gambar
            $this->data->nama_produk = $data_lama->nama_produk;
            $this->data->plu = $data_lama->plu;
            $this->data->kategori = $data_lama->kategori_id;
            $this->data->harga = $data_lama->harga_jual;
            $this->data->harga_baru = $data_lama->harga_baru;
            $this->data->stok = $data_lama->stok;
            $this->data->topsales = $data_lama->topsales;
	    $this->data->deskripsi = $data_lama->deskripsi_produk;
        } else {
            $this->data->id = $data_lama->id_produk;
	    $this->data->nama_produk = set_value('nama_produk');
            $this->data->plu = set_value('plu');
            $this->data->kategori = $this->input->post('kategori');
            $this->data->harga = set_value('harga');
            $this->data->harga_baru = set_value('harga_baru');
            $this->data->stok = set_value('stok');
	    $this->data->topsales = set_value('topsales');
            $this->data->deskripsi = set_value('deskripsi');
        }     
        
        parent::_view('produk/detil',$this->data);
    }
    
    public function hapus($id = 0) {
        $id OR redirect(site_url('admin/produk'));
        
        $this->produk_m->delete($id);
        
        redirect(site_url('admin/produk'));
    }
    
    public function aktifasi($id = 0, $aktif = 0) {
        $id OR redirect(site_url('admin/produk'));
        
        $this->produk_m->update($id,array('status_produk'=>$aktif));
        
        redirect(site_url('admin/produk'));
    }
    
    public function set_default($id = 0,$id_foto = 0) {
        $id OR redirect(site_url('admin/produk'));
        
        $this->produk_m->set_default($id,$id_foto);
        
        redirect(site_url('admin/produk/gambar/'.$id));
    }
    
    public function hapus_foto($id = 0,$id_foto = 0) {
        $id OR redirect(site_url('admin/produk'));
        
        $this->produk_m->hapus_foto($id_foto);
        
        redirect(site_url('admin/produk/gambar/'.$id));
    }
    
    
    public function gambar($id = 0) {
        $id OR redirect(site_url('admin/produk'));
        $this->data->produk = $this->produk_m->get($id);
        $this->data->gambar = $this->produk_m->get_gambar($id);
        
        $this->load->library('jcrop');
      
                $prefix =  md5($this->data->produk->url_produk);
				$this->data->prefix = $prefix;
				$this->data->target_w = 200;
				$this->data->target_h = 200;
				$setdata = array(
					'prefix'=>$prefix,
					'folder'=>'uploads/produk/',
					'thumb_folder'=>'uploads/produk/thumb/',
					'target_w'=>$this->data->target_w,
					'target_h'=>$this->data->target_h,
					'create_thumb'=>TRUE
					);
				$this->jcrop->set_data($setdata);
				$action_form = site_url($this->uri->uri_string());
				
						
				//Upload Process
				if(isset($_POST[$prefix.'submit'])) {
					$this->jcrop->uploading(& $status);
					$this->data->status = $status;
				}
				
				//Saving data
				if(isset($_POST[$prefix.'save'])) {
				    
					$this->jcrop->produce(& $pic_loc,& $pic_path,& $thumb_loc,& $thumb_path);
					$input = array(	'produk_id'=>$this->data->produk->id_produk ,
                                    'image'=>$pic_path,
                                    'thumb'=>$thumb_path);
					
                    $this->produk_m->tambah_gambar($input);
                    
                    //$this->hotels->update($id,$input);
                    redirect(site_url('admin/produk/ubah/'.$id));
					
				}
                
                //Cancel uploading image
				if(isset($_POST[$prefix.'cancel'])) {
					$this->jcrop->cancel();
				}
				
				//Cek if image has uploaded
				if($this->jcrop->is_uploaded(& $thepicture,& $orig_w,& $orig_h,& $ratio)){
					$this->data->orig_w = $orig_w;
					$this->data->orig_h = $orig_h;
					$this->data->ratio = $ratio;
					$this->data->thepicture = $thepicture;	
					$this->data->form = $this->jcrop->show_form($action_form,TRUE);
					
				}else{
					$this->data->form = $this->jcrop->show_form($action_form);
				}
        
       
        
        parent::_view('produk/gambar',$this->data);
    }
    
    
}
