<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Delivery_order extends MY_Controller {
    private $judul = 'Print Delivery Order';
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
	//$this->load->model('pesanan_cabang_m');
        
        //$this->template->set_js('jcrop')->set_css('jcrop');
        $this->data->metadata = $this->template->get_metadata();
        $this->data->judul = $this->template->get_judul();
	
	$this->data->username = $this->session->userdata('username');
        $this->data->cabang = $this->session->userdata('kode_cabang');
    }
    
    public function index(){
        //$this->data->produk = $this->produk_m->get_all();
        
        //parent::_view('produk/list',$this->data);
    
//        $this->load->library('form_validation');
//        $this->form_validation->set_error_delimiters('<p class="msg warning">', '</p>');
//        
//        foreach($this->kategori_m->kategori as $key => $val) {
//            $this->data->list_kategori[$val['id_kategori']] = $val['nama_kategori'];
//        }
//        
//        $this->form_validation->set_rules($this->rules);
//        
//        if($this->form_validation->run()) {
//            $data =  array (    'nama_produk'   =>  $this->input->post('nama_produk'),
//                                'url_produk'    =>  underscore($this->input->post('nama_produk')),
//                                'plu'   	=>  $this->input->post('plu'),
//                                'kategori_id'   =>  $this->input->post('kategori'),
//                                'harga_jual'    =>  $this->input->post('harga'),
//                                'stok'          =>  $this->input->post('stok'),
//                                'deskripsi_produk'=>  $this->input->post('deskripsi')
//                            );
//            if ($this->produk_m->insert($data)) {
//                $this->data->sukses = 'Data Berhasil di tambahkan';
//            }
//        }
//        
//        $this->data->nama_produk = set_value('nama_produk');
//        $this->data->plu = set_value('plu');
//        $this->data->deskripsi = set_value('deskripsi');
//        $this->data->harga = set_value('harga');
//        $this->data->stok = set_value('stok');
//        $this->data->kategori = $this->input->post('kategori');
//	
//	$this->data->cabang = $this->session->userdata('kode_cabang');
//	$this->data->total_pesanan = $this->pesanan_cabang_m->count_pesanan($this->data->cabang);
//                
        
	$this->data->pesanan = $this->pesanan_m->get_printing();
	
        parent::_view('delivery_order/form',$this->data);
    }
    
    
    public function print_do(){
        $this->load->model('pesanan_m');
	
	$order_no =  $this->input->post('orderno');
	$store_sc = $this->input->post('store_sc');
	$id_order = $this->input->post('id_order');
        
	
	$this->db->select('*');
		$this->db->from('SUPPLIER_ORDER_HEADER');
                $this->db->join('SUPPLIER_ORDER_DETAIL','SUPPLIER_ORDER_HEADER.id_order = SUPPLIER_ORDER_DETAIL.id_order');
                $this->db->join('DC_STOCK_MASTER','DC_STOCK_MASTER.ARTICLE_CODE = SUPPLIER_ORDER_DETAIL.ARTICLE_CODE');
                $this->db->join('STORE_SALES_MASTER','STORE_SALES_MASTER.ARTICLE_CODE = SUPPLIER_ORDER_DETAIL.ARTICLE_CODE');
                $this->db->join('user_data','user_data.ORDER_NO_GTRON = SUPPLIER_ORDER_HEADER.ORDER_NO_GTRON');
		$this->db->where('STORE_SALES_MASTER.SV = SUPPLIER_ORDER_DETAIL.SV');
                $this->db->where('STORE_SITE_CODE',$store_sc);
                $this->db->where('SUPPLIER_ORDER_HEADER.ORDER_NO_GTRON',$order_no);
                $q = $this->db->get();
	
	//echo $this->db->last_query();
	
	
        if($q->result_array() == NULL){
            
	    $this->db->set('PRINT_STATUS', '1');
            
            $this->db->where('ORDER_NO_GTRON', $order_no);
            $this->db->update('SUPPLIER_ORDER_HEADER');
	    
            //parent::_view('delivery_order/gagal',$this->data);
            
	    redirect (site_url('admin/delivery_order/'));
        }else{
            
	    $this->data->q = $q;
	    $this->data->detail = $this->pesanan_m->get_all_detail_trans(array('id_order'=>$id_order),true);
	    //echo $this->db->last_query();
	    
	    //print_r($this->data->detail);
	    
	    parent::_view('delivery_order/print',$this->data);
		
	
    }
}
    
    public function printed(){
        $order_no =  $this->input->post('orderno');
	
            $this->db->set('PRINT_STATUS', '1');
            
            $this->db->where('ORDER_NO_GTRON', $order_no);
            $this->db->update('SUPPLIER_ORDER_HEADER');
	    
	    redirect (site_url('admin/delivery_order/'));
    }
    
    public function gagal(){
        parent::_view('admin/delivery_order/gagal');
        
    }
}