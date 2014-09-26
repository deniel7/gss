<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pesanan_m extends MY_Model {
    private $tabel_foto = 'foto_produk';
    
    public function __construct(){
        parent::__construct();
        parent::set_table('order','id_order');
    }
    
    public function get_all() {
        //$this->db->order_by('id_order');
        //$this->db->join('order_data','order_data.order_id=order.id_order');
        //return parent::get_all();
        
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
    
    public function get_all_page($limit1='',$limit2='') {
        
        $data = array();
	$sql = "SELECT * FROM `order` a JOIN `user` b JOIN user_data c JOIN cabang d 
                WHERE a.user_id = b.id_user AND c.user_id = b.id_user AND a.kode_cabang = d.kode_cabang ORDER BY a.id_order DESC LIMIT ".$limit2;
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
    
    
    function SearchResult($perPage,$uri,$search_orderno,$search_mem,$search_tg1,$search_tg2,$status,$search_cab)
    {
        
        $this->db->select('*');
        $this->db->from('order');
        $this->db->join('user', 'user.id_user = order.user_id');
        $this->db->join('user_data', 'user.id_user = user_data.user_id');
        $this->db->join('cabang', 'order.kode_cabang = cabang.kode_cabang');
        
        //ORDER No
        if (($search_orderno != 0) && ($search_mem == 0) && ($search_tg1 == 0) && ($search_tg2 == 0) && ($status == NULL) && ($search_cab == 0)){
	    
            $this->db->where('order_no', $search_orderno);
            echo"a";
        }
        
        //no member
        else if (($search_orderno == 0) && ($search_mem != 0) && ($search_tg1 == 0) && ($search_tg2 == 0) && ($status == NULL) && ($search_cab == 0)){
            $this->db->where('membercard', $search_mem);
            echo"b";
        }
        
	//Tanggal
        else if (($search_orderno == 0) && ($search_mem == 0) && ($search_tg1 != 0) && ($search_tg2 != 0) && ($status == NULL) && ($search_cab == NULL)){
            $this->db->where('tanggal_masuk >=', $search_tg1);
	    $this->db->where('tanggal_masuk <=', $search_tg2);
            echo"c";
        }
	
	//Status
        else if (($search_orderno == 0) && ($search_mem == 0) && ($search_tg1 == 0) && ($search_tg2 == 0) && ($status != NULL) && ($search_cab == 0)){
            $this->db->where('status_order', $status);
            echo"d";
        }
	
	//Cabang
        else if (($search_orderno == 0) && ($search_mem == 0) && ($search_tg1 == 0) && ($search_tg2 == 0) && ($status == NULL) && ($search_cab != NULL)){
            $this->db->like('order.kode_cabang', $search_cab);
            echo"e";
        }
	
	//orderno + nomember
        else if (($search_orderno != 0) && ($search_mem != 0) && ($search_tg1 == 0) && ($search_tg2 == 0) && ($status == NULL) && ($search_cab == 0)){
            $this->db->where('order_no', $search_orderno);
            $this->db->where('membercard', $search_mem);
            echo"f";
        }
	
	//orderno + tanggal
        else if (($search_orderno != 0) && ($search_mem == 0) && ($search_tg1 != 0) && ($search_tg2 != 0) && ($status == NULL) && ($search_cab == 0)){
            $this->db->where('order_no', $search_orderno);
            $this->db->where('tanggal_masuk >=', $search_tg1);
	    $this->db->where('tanggal_masuk <=', $search_tg2);
            echo"g";
        }
	
	//orderno + status
        else if (($search_orderno != 0) && ($search_mem == 0) && ($search_tg1 == 0) && ($search_tg2 == 0) && ($status != NULL) && ($search_cab == 0)){
            $this->db->where('order_no', $search_orderno);
            $this->db->where('status_order', $status);
            echo"h";
        }
	
	//orderno + CABANG
        else if (($search_orderno != 0) && ($search_mem == 0) && ($search_tg1 == 0) && ($search_tg2 == 0) && ($status == NULL) && ($search_cab != 0)){
            $this->db->where('order_no', $search_orderno);
            $this->db->like('order.kode_cabang', $search_cab);
            echo"i";
        }
	
	//nomember + tanggal
        else if (($search_orderno == 0) && ($search_mem != 0) && ($search_tg1 != 0) && ($search_tg2 != 0) && ($status == NULL) && ($search_cab == 0)){
            $this->db->where('membercard', $search_mem);
            $this->db->where('tanggal_masuk >=', $search_tg1);
	    $this->db->where('tanggal_masuk <=', $search_tg2);
            echo"j";
        }
	
	//nomember + status
        else if (($search_orderno == 0) && ($search_mem != 0) && ($search_tg1 == 0) && ($search_tg2 == 0) && ($status != NULL) && ($search_cab == 0)){
            $this->db->where('membercard', $search_mem);
            $this->db->where('status_order', $status);
            echo"k";
        }
	
	//tanggal + status
        else if (($search_orderno == 0) && ($search_mem == 0) && ($search_tg1 != 0) && ($search_tg2 != 0) && ($status != NULL) && ($search_cab == 0)){
            $this->db->where('tanggal_masuk >=', $search_tg1);
	    $this->db->where('tanggal_masuk <=', $search_tg2);
            $this->db->where('status_order', $status);
            echo"l";
        }
	
	//tanggal + cabang
        else if (($search_orderno == 0) && ($search_mem == 0) && ($search_tg1 != 0) && ($search_tg2 != 0) && ($status == NULL) && ($search_cab != NULL)){
            
                $this->db->like('order.kode_cabang', $search_cab);
                $this->db->where('tanggal_masuk >=', $search_tg1);
                $this->db->where('tanggal_masuk <=', $search_tg2);
		
            echo"m";
        }
	
	//orderno + member + tanggal
        else if (($search_orderno != 0) && ($search_mem != 0) && ($search_tg1 != NULL) && ($search_tg2 != NULL) && ($status == NULL) && ($search_cab == NULL)){
		$this->db->where('order_no', $search_orderno);
                $this->db->where('membercard', $search_mem);
                $this->db->where('tanggal_masuk >=', $search_tg1);
                $this->db->where('tanggal_masuk <=', $search_tg2);
		
            echo"n";
        }
	
        else{
            
            $this->db->where('order_no', $search_orderno);
            $this->db->where('membercard', $search_mem);
            $this->db->where('status_order', $status);
            $this->db->like('order.kode_cabang', $search_cab);
            $this->db->where('tanggal_masuk >=', $search_tg1);
	    $this->db->where('tanggal_masuk <=', $search_tg2);
            echo "x";
        }
	 
         $this->db->order_by('id_order','asc');
         $data = $this->db->get('', $perPage, $uri);
         
         if($data->num_rows() > 0)
            return $data->result();
         else
            return null;
    }
    
}

?>