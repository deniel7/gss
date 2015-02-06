<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Picking_list extends MY_Controller {
    private $judul = 'Print Picking List';
    private $rules = array (
                        array(
                                 'field'   => 'plu', 
                                 'label'   => 'PLU', 
                                 'rules'   => 'utf8'
                              ),
                        
                         );
    
    public function __construct() {
        parent::__construct();
        parent::set_judul($this->judul);
        parent::default_meta();
        $this->load->model('produk_m');
        $this->load->model('kategori_m');
        $this->load->model('pesanan_m');
        $this->load->model('pesanan_cabang_m');
	
	
        $this->template->set_js('jcrop')->set_css('jcrop');
        $this->data->metadata = $this->template->get_metadata();
        $this->data->judul = $this->template->get_judul();
	
	$this->data->username = $this->session->userdata('username');
        $this->data->cabang = $this->session->userdata('kode_cabang');
    }
    
    public function index(){
        //$this->data->produk = $this->produk_m->get_all();
        
        //parent::_view('produk/list',$this->data);
    
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
        $this->data->kategori = $this->input->post('kategori');
        
	$this->data->cabang = $this->session->userdata('kode_cabang');   
	$this->data->total_pesanan = $this->pesanan_cabang_m->count_pesanan($this->data->cabang);
	    
	
        //parent::_modal('produk/form',$this->data);
        parent::_view('picking_list/form',$this->data);
    }
    
    
    public function prints(){
        $order_no =  $this->input->post('order_no');
        $cabang = $this->input->post('cabang');
	
        //CEK PUSAT Ato Cabang
	if($cabang != 'PST'){
	
	//CEK STATUS ORDER = COnfirmed     -- CABANG
	$this->db->select('order.id_order, order.order_no, order.user_id, order.tanggal_masuk, order.status_order, order.total_item, order.total_biaya, order.metode_pembayaran,order.kode_cabang,order.status_print,
			    user.id_user, user.membercard, user.username, user.email, user.telepon, 
			    user_data.id_user_data,user_data.user_id, user_data.nama_depan, user_data.nama_belakang, user_data.alamat, user_data.kode_pos, user_data.propinsi_id, user_data.phone,
			    order_data.id_order_data, order_data.order_id, order_data.produk_id, order_data.kuantitas, order_data.subtotal,
			    produk.id_produk, produk.kategori_id, produk.plu, produk.plu_descriptor, produk.nama_produk, produk.url_produk, produk.harga_jual,
			    sku_tilcode.entry_number, sku_tilcode.PLU');
		$this->db->from('order');
                $this->db->join('user','user.id_user=order.user_id');
                $this->db->join('user_data','user_data.user_id=user.id_user');
                $this->db->join('order_data','order.id_order = order_data.order_id');
                $this->db->join('produk','produk.id_produk = order_data.produk_id');
                $this->db->join('sku_tilcode','produk.plu = sku_tilcode.plu');
		$this->db->where('status_order','2');
                $this->db->where('order_no',$order_no);
		$this->db->where('order.kode_cabang',$cabang);
                $q = $this->db->get();
	}else{
	//CEK STATUS ORDER = COnfirmed    -- PUSAT
        $this->db->select('order.id_order, order.order_no, order.user_id, order.tanggal_masuk, order.status_order, order.total_item, order.total_biaya, order.metode_pembayaran,order.kode_cabang,order.status_print,
			    user.id_user, user.membercard, user.username, user.email, user.telepon, 
			    user_data.id_user_data,user_data.user_id, user_data.nama_depan, user_data.nama_belakang, user_data.alamat, user_data.kode_pos, user_data.propinsi_id, user_data.phone,
			    order_data.id_order_data, order_data.order_id, order_data.produk_id, order_data.kuantitas, order_data.subtotal,
			    produk.id_produk, produk.kategori_id, produk.plu, produk.plu_descriptor, produk.nama_produk, produk.url_produk, produk.harga_jual,
			    sku_tilcode.entry_number, sku_tilcode.PLU');
		$this->db->from('order');
                $this->db->join('user','user.id_user=order.user_id');
                $this->db->join('user_data','user_data.user_id=user.id_user');
                $this->db->join('order_data','order.id_order = order_data.order_id');
                $this->db->join('produk','produk.id_produk = order_data.produk_id');
                $this->db->join('sku_tilcode','produk.plu = sku_tilcode.plu');
		$this->db->where('status_order','2');
                $this->db->where('order_no',$order_no);
                $q = $this->db->get();
	}
		//SIDEBAR Total pesanan
		$this->data->cabang = $this->session->userdata('kode_cabang');
		$this->data->total_pesanan = $this->pesanan_cabang_m->count_pesanan($this->data->cabang);
		
                   
        if($q->result_array() == NULL){
            $this->data->q = $q;
            parent::_view('picking_list/gagal',$this->data);
                
        }else{
        
                //CEK Sudah pernah di PRINT belum
                $this->db->select('status_print');
                $this->db->from('order');
                $this->db->where('order_no',$order_no);
                $this->db->where('status_print','0');
                $data_p = $this->db->get();
        
        if($data_p->result_array() != NULL){
            $this->data->q = $q;
            $this->pesanan_m->update_by(array('order_no'=>$order_no),array('status_print'=>'PRINTED'));
       
	
	$this->data->total_pesanan = $this->pesanan_cabang_m->count_pesanan($this->data->cabang);
	
	parent::_view('picking_list/print',$this->data);
                
                
        }else{
            //Eksekusi status sudah di print 2x
            $this->data->q = $q;
	    $this->pesanan_m->update_by(array('order_no'=>$order_no),array('status_print'=>'COPIED'));
            $this->data->total_pesanan = $this->pesanan_cabang_m->count_pesanan($this->data->cabang);
	    parent::_view('picking_list/print',$this->data);
        
        }
    }
}
    
    public function gagal(){
        parent::_view('admin/picking_list/gagal');
        
    }
}