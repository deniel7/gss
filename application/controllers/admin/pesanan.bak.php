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
    }
    
    public function index(){
        //$this->data->pesanan = $this->pesanan_m->get_all();
        $this->data->base_url = base_url().'index.php/admin/pesanan/index';
		
	$this->data->total_rows = $this->db->count_all('order');
	$this->data->per_page = 3;
	$this->data->uri_segment = 4;
        $this->pagination->initialize($this->data);
	$this->data->pesanan = $this->pesanan_m->get_all_page($this->data->per_page,$this->uri->segment(4,0));
	$this->data->list_cab= $this->pesanan_m->list_cab('kode_cabang','nama_cabang');
        parent::_view('pesanan/list',$this->data);
    }
    
    public function detail($id = 0) {
        //$id OR redirect(site_url('admin/produk'));
        
        //$this->load->library('form_validation');
        //$this->form_validation->set_error_delimiters('<p class="msg warning">', '</p>');
        
        //foreach($this->kategori_m->kategori as $key => $val) {
        //    $this->data->list_kategori[$val['id_kategori']] = $val['nama_kategori'];
        //}
        
        $this->data->list_cab = $this->kategori_m->list_cab('kode_cabang','nama_cabang');
        //$data_lama = $this->produk_m->get($id);
        //$this->data->gambar = $this->produk_m->get_gambar($id);
        
        //$this->form_validation->set_rules($this->rules);
        //
        //if($this->form_validation->run()) {
        //    $data =  array (    
        //                        'kategori_id'   =>  $this->input->post('kategori')
        //                    );
        //    if ($this->produk_m->update($id,$data)) {
        //        $this->data->sukses = 'Data Berhasil di ubah';
        //        redirect(site_url('admin/produk'));
        //    }
        //}
        
        //if(!$this->input->post('submit')){
        //    $this->data->id = $data_lama->id_produk;
        //    //ID di ata hanya digunakan untuk inisiasi halaman penambahan gambar
        //    $this->data->nama_produk = $data_lama->nama_produk;
        //    $this->data->kode = $data_lama->kode_produk;
        //    $this->data->kategori = $data_lama->kategori_id;
        //    $this->data->harga = $data_lama->harga_jual;
        //    $this->data->harga_baru = $data_lama->harga_baru;
        //    $this->data->stok = $data_lama->stok;
        //    $this->data->deskripsi = $data_lama->deskripsi_produk;
        //
        //}     
        
        
        
        
        //$cab = $this->input->post('cab',TRUE);
        if ($this->input->post('submit')){
            
            $this->pesanan_m->update_by(array('id_order'=>$id),array('status_order'=>3,'kode_cabang'=>$this->input->post('cab')));
            $this->data->sukses = 'Data berhasil diperbaharui';   
        } else {
            $this->data->detail = $this->pesanan_m->get_record(array('id_order'=>$id),true);
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
            
            //set session user data untuk pencarian, untuk paging pencarian
            $this->session->set_userdata('sess_mem', $data['search_mem']);
            $this->session->set_userdata('sess_orderno', $data['search_orderno']);
            $this->session->set_userdata('sess_tg1', $data['search_tg1']);
            $this->session->set_userdata('sess_tg2', $data['search_tg2']);
            $this->session->set_userdata('sess_status', $data['status']);
            $this->session->set_userdata('sess_cab', $data['search_cab']);
            
        } else {
            $data['search_mem'] = $this->session->userdata('sess_mem');
            $data['search_orderno'] = $this->session->userdata('sess_orderno');
            $data['search_tg1'] = $this->session->userdata('sess_tg1');
            $data['search_tg2'] = $this->session->userdata('sess_tg2');
            $data['status'] = $this->session->userdata('sess_status');
            $data['search_cab'] = $this->session->userdata('sess_cab');
        }
    
            
        $this->db->select('*');
        $this->db->from('order');
        $this->db->join('user', 'user.id_user = order.user_id');
        $this->db->join('user_data', 'user.id_user = user_data.user_id');
        $this->db->join('cabang', 'order.kode_cabang = cabang.kode_cabang');
        
        //ORDER No
        if (($data['search_orderno'] != 0) && ($data['search_mem'] == 0) && ($data['search_tg1'] == 0) && ($data['search_tg2'] == 0) && ($data['status'] == NULL) && ($data['search_cab'] == 0)){
	    
            $this->db->where('order_no', $data['search_orderno']);
            echo "a";
            
        }
        
        //no member
        else if (($data['search_orderno'] == 0) && ($data['search_mem'] != 0) && ($data['search_tg1'] == 0) && ($data['search_tg2'] == 0) && ($data['status'] == NULL) && ($data['search_cab'] == 0)){
            $this->db->where('membercard', $data['search_mem']);
            echo"b";
        }
        
        //tanggal
        else if (($data['search_orderno'] == 0) && ($data['search_mem'] == 0) && ($data['search_tg1'] != 0) && ($data['search_tg2'] != 0) && ($data['status'] == NULL) && ($data['search_cab'] == NULL)){
            $this->db->where('tanggal_masuk >=', $data['search_tg1']);
	    $this->db->where('tanggal_masuk <=', $data['search_tg2']);
            echo"c";
        }
        
        //status
        else if (($data['search_orderno'] == 0) && ($data['search_mem'] == 0) && ($data['search_tg1'] == 0) && ($data['search_tg2'] == 0) && ($data['status'] != NULL) && ($data['search_cab'] == 0)){
            $this->db->where('status_order', $data['status']);
            echo"d";
        }
        
        //Cabang
        else if (($data['search_orderno'] == 0) && ($data['search_mem'] == 0) && ($data['search_tg1'] == 0) && ($data['search_tg2'] == 0) && ($data['status'] == NULL) && ($data['search_cab'] != NULL)){
            $this->db->like('order.kode_cabang', $data['search_cab']);
            echo"e";
        }
        
        //Orderno + nomember
        else if (($data['search_orderno'] != 0) && ($data['search_mem'] != 0) && ($data['search_tg1'] == 0) && ($data['search_tg2'] == 0) && ($data['status'] == NULL) && ($data['search_cab'] == 0)){
            $this->db->where('order_no', $data['search_orderno']);
            $this->db->where('membercard', $data['search_mem']);
            echo"f";
        }
        
        //Orderno + tanggal
        else if (($data['search_orderno'] != 0) && ($data['search_mem'] == 0) && ($data['search_tg1'] != 0) && ($data['search_tg2'] != 0) && ($data['status'] == NULL) && ($data['search_cab'] == 0)){
            $this->db->where('order_no', $data['search_orderno']);
            $this->db->where('tanggal_masuk >=', $data['search_tg1']);
	    $this->db->where('tanggal_masuk <=', $data['search_tg2']);
            echo"g";
        }
        
        //Orderno + status
        else if (($data['search_orderno'] != 0) && ($data['search_mem'] == 0) && ($data['search_tg1'] == 0) && ($data['search_tg2'] == 0) && ($data['status'] != NULL) && ($data['search_cab'] == 0)){
            $this->db->where('order_no', $data['search_orderno']);
            $this->db->where('status_order', $data['status']);
            echo"h";
        }
        
        //Orderno + Cabang
        else if (($data['search_orderno'] != 0) && ($data['search_mem'] == 0) && ($data['search_tg1'] == 0) && ($data['search_tg2'] == 0) && ($data['status'] == NULL) && ($data['search_cab'] != 0)){
            $this->db->where('order_no', $data['search_orderno']);
            $this->db->like('order.kode_cabang', $data['search_cab']);
            echo"i";
        }
        
        //nomember + tanggal
        else if (($data['search_orderno'] == 0) && ($data['search_mem'] != 0) && ($data['search_tg1'] != 0) && ($data['search_tg2'] != 0) && ($data['status'] == NULL) && ($data['search_cab'] == 0)){
            $this->db->where('membercard', $data['search_mem']);
            $this->db->where('tanggal_masuk >=', $data['search_tg1']);
	    $this->db->where('tanggal_masuk <=', $data['search_tg2']);
            echo"j";
        }
        
        //nomember + status
        else if (($data['search_orderno'] == 0) && ($data['search_mem'] != 0) && ($data['search_tg1'] == 0) && ($data['search_tg2'] == 0) && ($data['status'] != NULL) && ($data['search_cab'] == 0)){
            $this->db->where('membercard', $data['search_mem']);
            $this->db->where('status_order', $data['status']);
            echo"k";
        }
        
        //tanggal + status
        else if (($data['search_orderno'] == 0) && ($data['search_mem'] == 0) && ($data['search_tg1'] != 0) && ($data['search_tg2'] != 0) && ($data['status'] != NULL) && ($data['search_cab'] == 0)){
            $this->db->where('tanggal_masuk >=', $data['search_tg1']);
	    $this->db->where('tanggal_masuk <=', $data['search_tg2']);
            $this->db->where('status_order', $data['status']);
            echo"l";
        }
        
        //tanggal + cabang
        else if (($data['search_orderno'] == 0) && ($data['search_mem'] == 0) && ($data['search_tg1'] != 0) && ($data['search_tg2'] != 0) && ($data['status'] == NULL) && ($data['search_cab'] != NULL)){
            $this->db->where('tanggal_masuk >=', $data['search_tg1']);
	    $this->db->where('tanggal_masuk <=', $data['search_tg2']);
            $this->db->like('order.kode_cabang', $data['search_cab']);
            echo"m";
        }
        
        //orderno + member + tanggal
        else if (($data['search_orderno'] != 0) && ($data['search_mem'] != 0) && ($data['search_tg1'] != 0) && ($data['search_tg2'] != 0) && ($data['status'] == NULL) && ($data['search_cab'] == NULL)){
            $this->db->where('order_no', $data['search_orderno']);
            $this->db->where('membercard', $data['search_mem']);
            $this->db->where('tanggal_masuk >=', $data['search_tg1']);
	    $this->db->where('tanggal_masuk <=', $data['search_tg2']);
            
            echo"n";
        }
        
        else{
            
            $this->db->where('order_no', $data['search_orderno']);
            $this->db->where('membercard', $data['search_mem']);
            $this->db->where('status_order', $data['status']);
            $this->db->like('order.kode_cabang', $data['search_cab']);
            $this->db->where('tanggal_masuk >=', $data['search_tg1']);
	    $this->db->where('tanggal_masuk <=', $data['search_tg2']);
            echo "x";
        }
        
        //Pagination init
        $pagination['base_url'] 		= base_url().'index.php/admin/pesanan/search/';
        $pagination['total_rows'] 		= $this->db->count_all_results();
        $pagination['full_tag_open'] 	        = "<div class=\"pagination\">";
        $pagination['full_tag_close'] 	        = "</div>";
        $pagination['cur_tag_open'] 	        = "<span class=\"current\">";
        $pagination['cur_tag_close'] 	        = "</span>";
        $pagination['num_tag_open'] 	        = "<span class=\"disabled\">";
        $pagination['num_tag_close'] 	        = "</span>";
        $pagination['per_page'] 		= "1";
        $pagination['uri_segment'] 		= 4;
        $pagination['num_links'] 		= 4;
    
        $this->pagination->initialize($pagination);
        
        $this->data->list_cab= $this->pesanan_m->list_cab('kode_cabang','nama_cabang');
        $this->data->pesanan = $this->pesanan_m->SearchResult($pagination['per_page'],$this->uri->segment(4,0),$data['search_orderno'],$data['search_mem'],$data['search_tg1'],$data['search_tg2'],$data['status'],$data['search_cab']);
        
        $this->load->vars($this->data);
        
	parent::_view('pesanan/list',$this->data);
    }
    
}