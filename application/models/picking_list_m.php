<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Picking_List_m extends MY_Model {
    private $tabel_foto = 'foto_produk';
    
    public function __construct(){
        parent::__construct();
        parent::set_table('order','id_order');
    }
    
    public function get_all() {
	
        $this->db->join('user','user.id_user=order.user_id');
        $this->db->join('user_data','user_data.user_id=user.id_user');
        
        $data = parent::get_array();
        foreach ($data as $key=>$val){
            $this->db->where(array('order_id'=>$val['id_order']));
            $this->db->join('produk','produk.id_produk = order_data.produk_id');
            
            $detail = $this->db->get('order_data')->result_array();
            $data[$key]['detail'] = $detail;
            
            switch($data[$key]['status_order']) {
                case '0':
                $data[$key]['status_order_text'] = '<div style="color:red;">Pending</div>';
                continue;
                
                case '1':
                $data[$key]['status_order_text'] = '<div style="color:orange;">Confirmed</div>';
                continue;
                
                case '2':
                $data[$key]['status_order_text'] = '<div style="color:blue;">Picking</div>';
                continue;
                
                case '3':
                $data[$key]['status_order_text'] = '<div style="color:purple;">Shipped</div>';
                continue;
                
                case '4':
                $data[$key]['status_order_text'] = '<div style="color:green;">Closed</div>';
                continue;
            
            }            
        } 
        return $data;
        
    }
    
    public function get_all_page($limit1='',$limit2='',$cabang) {
        
        $data = array();
	$sql = "SELECT * FROM `order` a JOIN `user` b JOIN user_data c JOIN cabang d 
                WHERE a.user_id = b.id_user AND c.user_id = b.id_user AND a.kode_cabang = d.kode_cabang AND a.kode_cabang ='$cabang' ORDER BY a.id_order DESC LIMIT ".$limit2;
	    if($limit1){
		$sql .= ",".$limit1;
	    }
	    $hasil = $this->db->query($sql);
	    if($hasil->num_rows() > 0){
		$data = $hasil->result();
	    }
	    
	    $hasil->free_result();
	    return $data;
        
    }
    
    
    function list_cab($kode_cabang,$nama_cabang){
        $result = array();
        $array_keys_values = $this->db->query("select * from cabang");
        foreach($array_keys_values ->result() as $row){
            $result[0] = '- Cabang -';
            $result[$row->kode_cabang] = $row->nama_cabang;
        }
        //$results = array_merge(array('' => '- Pilih Kategori -'), $result);
        
        return $result;
    }
    
    function list_cab_sel($kode_cabang,$nama_cabang){
       
       $this->db->select('user.id_user,user.kode_cabang,cabang.nama_cabang');
	$this->db->from('user');
	$this->db->join('cabang', 'user.kode_cabang = cabang.kode_cabang');
	$this->db->where('user.id_user',$this->uri->segment(4,0));
	$list_cab_sel = $this -> db -> get();
	
        return $list_cab_sel;
       
    }
    
    
    public function insert($data = array(), $cart = array()) {
        if(parent::insert($data)){
            $id = $this->db->insert_id();
            foreach ($cart as $item){
                $detail = array( 'order_id'=>$id,
                                 'produk_id'=>$item['id'],
                                 'kuantitas'=>$item['qty'],
                                 'subtotal'=>$item['subtotal']);
                $this->db->insert('order_data',$detail);
            }
            return true;
        }
        return false;
    }
    
    public function get_record($id = 0,$get_user = FALSE) {
        $this->db->where($id);
        if ($get_user){
            $this->db->join('user_data','user_data.user_id = order.user_id');
        }
        $data = parent::get_array();
        foreach ($data as $key=>$val){
            $this->db->where(array('order_id'=>$val['id_order']));
            $this->db->join('produk','produk.id_produk = order_data.produk_id');
            
            $detail = $this->db->get('order_data')->result_array();
            $data[$key]['detail'] = $detail;
            
            switch($data[$key]['status_order']) {
                case '0':
                $data[$key]['status_order_text'] = '<div style="color:red;">Pending</div>';
                continue;
                
                case '1':
                $data[$key]['status_order_text'] = '<div style="color:orange;">Confirmed</div>';
                continue;
                
                case '2':
                $data[$key]['status_order_text'] = '<div style="color:blue;">Picking</div>';
                continue;
                
                case '3':
                $data[$key]['status_order_text'] = '<div style="color:purple;">Shipped</div>';
                continue;
                
                case '4':
                $data[$key]['status_order_text'] = '<div style="color:green;">Closed</div>';
                continue;
            
            }          
        } 
        return $data;
    }
    
    public function get_laporan(){
        $this->db->join('user','user.id_user=order.user_id');
        $this->db->join('user_data','user_data.user_id=user.id_user');
        $data = parent::get_array();
        foreach ($data as $key=>$val){
            $this->db->where(array('order_id'=>$val['id_order']));
            $this->db->join('produk','produk.id_produk = order_data.produk_id');
            $detail = $this->db->get('order_data')->result_array();
            $data[$key]['detail'] = $detail;
            
            switch($data[$key]['status_order']) {
                case '0':
                $data[$key]['status_order_text'] = '<div style="color:red;">Pending</div>';
                continue;
                
                case '1':
                $data[$key]['status_order_text'] = '<div style="color:orange;">Confirmed</div>';
                continue;
                
                case '2':
                $data[$key]['status_order_text'] = '<div style="color:blue;">Picking</div>';
                continue;
                
                case '3':
                $data[$key]['status_order_text'] = '<div style="color:purple;">Shipped</div>';
                continue;
                
                case '4':
                $data[$key]['status_order_text'] = '<div style="color:green;">Closed</div>';
                continue;
            
            }     
        } 
        return $data;
    }
    
    
    function count_pesanan($cabang){
			
			$sql = "SELECT COUNT(status_print) FROM `order`
				WHERE
				kode_cabang ='$cabang'
				AND status_print = '0'";
			
			$query = $this->db->query($sql);    
			$data = $query->row();
			
			return $data;
    }
    
    public function get_status($order_no,$cabang){
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
                $data = $this->db->get();
                
                return $data;
    }
}

?>