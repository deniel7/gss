<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Produk extends MY_Controller {
    private $judul = 'Produk';
    private $rules = array (
                        array(
                                 'field'   => 'plu', 
                                 'label'   => 'PLU', 
                                 'rules'   => 'utf8'
                              ),
                        array(
                                 'field'   => 'deskripsi', 
                                 'label'   => 'Deskripsi', 
                                 'rules'   => 'utf8'
                              ),
                        array(
                                 'field'   => 'topsales', 
                                 'label'   => 'Top Sales', 
                                 'rules'   => 'utf8'
                              ),
			array(
                                 'field'   => 'nama_produk', 
                                 'label'   => 'Nama Kategori', 
                                 'rules'   => 'required|utf8'
                              ),
                        array(
                                 'field'   => 'harga', 
                                 'label'   => 'Harga', 
                                 'rules'   => 'required|numeric'
                              ),
                        array(
                                 'field'   => 'harga_baru', 
                                 'label'   => 'Harga Baru', 
                                 'rules'   => 'numeric'
                              ),
                        array(
                                 'field'   => 'stok', 
                                 'label'   => 'Stok', 
                                 'rules'   => 'required|numeric'
                              ),
                         );
    
    public function __construct() {
        parent::__construct();
        parent::set_judul($this->judul);
        parent::default_meta();
        $this->load->model('produk_m');
        $this->load->model('kategori_m');
        $this->load->library('pagination');
        
        $this->template->set_js('jcrop')->set_css('jcrop');
        $this->data->metadata = $this->template->get_metadata();
        $this->data->judul = $this->template->get_judul();
    }
    
    public function index(){
        //$this->data->produk = $this->produk_m->get_all();
        //$this->data->produk = $this->produk_m->get_all_pag();
        
                $this->load->library('pagination');
		
		$this->data->base_url = base_url().'/admin/produk/index';
		
		$this->data->total_rows = $this->db->count_all('produk');
		$this->data->per_page = 10;
		$this->data->uri_segment = 4;
                $this->pagination->initialize($this->data);
		$this->data->produk = $this->produk_m->get_all_page($this->data->per_page,$this->uri->segment(4,0));
		
		foreach($this->kategori_m->kategori as $key => $val) {
		    $this->data->list_kategori[$val['id_kategori']] = $val['nama_kategori'];
		}
		
		$this->data->total_empty_name = $this->produk_m->count_empty_name();
		$this->data->total_empty_pic = $this->produk_m->count_empty_pic();
        
        parent::_view('produk/list',$this->data);
    }
    
    public function list_empty_name(){
        
                $this->load->library('pagination');
		
		$this->data->base_url = base_url().'/admin/produk/list_empty_name';
		
		$this->data->total_rows = $this->db->count_all('produk');
		$this->data->per_page = 10;
		$this->data->uri_segment = 4;
                $this->pagination->initialize($this->data);
		$this->data->produk = $this->produk_m->get_all_empty_name($this->data->per_page,$this->uri->segment(4,0));
		
		foreach($this->kategori_m->kategori as $key => $val) {
		    $this->data->list_kategori[$val['id_kategori']] = $val['nama_kategori'];
		}
		
		$this->data->total_empty_name = $this->produk_m->count_empty_name();
		$this->data->total_empty_pic = $this->produk_m->count_empty_pic();
        
        parent::_view('produk/list',$this->data);
    }
    
    public function list_empty_pic(){
        
                $this->load->library('pagination');
		
		$this->data->base_url = base_url().'index.php/admin/produk/list_empty_pic';
		
		$this->data->total_rows = $this->db->count_all('produk');
		$this->data->per_page = 10;
		$this->data->uri_segment = 4;
                $this->pagination->initialize($this->data);
		$this->data->produk = $this->produk_m->get_all_empty_pic($this->data->per_page,$this->uri->segment(4,0));
		
		foreach($this->kategori_m->kategori as $key => $val) {
		    $this->data->list_kategori[$val['id_kategori']] = $val['nama_kategori'];
		}
		
		$this->data->total_empty_name = $this->produk_m->count_empty_name();
		$this->data->total_empty_pic = $this->produk_m->count_empty_pic();
        
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
    
    public function search(){
        
	
        if(isset($_POST['submit']))
        {
            $data['search_plu'] = $this->input->post('search_plu');
            $data['search_kat'] = $this->input->post('search_kat');
	    $data['search_name'] = $this->input->post('search_name');
            
            //set session user data untuk pencarian, untuk paging pencarian
            $this->session->set_userdata('sess_plu', $data['search_plu']);
            $this->session->set_userdata('sess_kat', $data['search_kat']);
	    $this->session->set_userdata('sess_name', $data['search_name']);
            
        } else {
            $data['search_plu'] = $this->session->userdata('sess_plu');
            $data['search_kat'] = $this->session->userdata('sess_kat');
	    $data['search_name'] = $this->session->userdata('sess_name');
        }
    
        $this->db->select('*');
        $this->db->from('produk');
        $this->db->join('kategori', 'produk.kategori_id = kategori.id_kategori');
//        $this->db->join('foto_produk', 'produk.id_produk = foto_produk.produk_id');
//	$this->db->where('status_produk',1);
//        $this->db->where('default',1);
	
	if($data['search_kat'] != NULL)
	{
	    $this->db->where('id_kategori', $data['search_kat']);
	    
	    //echo $data['search_plu'];
	    //echo "<br/>";
	    //echo $data['search_kat'];
	    //echo "<br/>";
	    echo"a";
	    
	}
	else{
	    $this->db->where('id_kategori', $data['search_kat']);
	    $this->db->like('nama_produk', $data['search_name']);
	    $this->db->like('plu', $data['search_plu']);
	    echo"g";
	}
	//Pagination init
        $pagination['base_url'] 		= base_url().'index.php/admin/produk/search/';
        $pagination['total_rows'] 		= $this->db->count_all_results();
        $pagination['full_tag_open'] 	        = "<div class=\"pagination\">";
        $pagination['full_tag_close'] 	        = "</div>";
        $pagination['cur_tag_open'] 	        = "<span class=\"current\">";
        $pagination['cur_tag_close'] 	        = "</span>";
        $pagination['num_tag_open'] 	        = "<span class=\"disabled\">";
        $pagination['num_tag_close'] 	        = "</span>";
        $pagination['per_page'] 		= "10";
        $pagination['uri_segment'] 		= 4;
        $pagination['num_links'] 		= 4;
	
	$this->data->total_rows = $this->db->count_all('produk');
	
	foreach($this->kategori_m->kategori as $key => $val) {
	    $this->data->list_kategori[$val['id_kategori']] = $val['nama_kategori'];
	}
	
	
        $this->pagination->initialize($pagination);
    
        $this->data->produk = $this->produk_m->SearchResult($pagination['per_page'],$this->uri->segment(4,0),$data['search_plu'],$data['search_kat'],$data['search_name']);
	$this->data->total_empty_name = $this->produk_m->count_empty_name();
	$this->data->total_empty_pic = $this->produk_m->count_empty_pic();
	
	
        $this->load->vars($this->data);
        
	parent::_view('produk/list',$this->data);
    }
}