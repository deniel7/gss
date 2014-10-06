<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pesanan_m extends MY_Model {
    private $tabel_foto = 'foto_produk';
    
    public function __construct(){
        parent::__construct();
        parent::set_table('SUPPLIER_ORDER_HEADER','id_order');
    }
    
    public function get_all() {
        //$this->db->order_by('id_order');
        //$this->db->join('order_data','order_data.order_id=order.id_order');
        //return parent::get_all();
        
        $this->db->join('USER_MASTER','USER_MASTER.USER_ID=order.user_id');
        $this->db->join('user_data','user_data.order_no=user.id_user');
        
        $data = parent::get_array();
        foreach ($data as $key=>$val){
            $this->db->where(array('order_id'=>$val['id_order']));
            $this->db->join('produk','produk.id_produk = order_data.produk_id');
            
            $detail = $this->db->get('order_data')->result_array();
            $data[$key]['detail'] = $detail;
            
            switch($data[$key]['status_order']) {
                case '-1':
                $data[$key]['status_order_text'] = '<div style="color:silver;">Cancel</div>';
                continue;
		
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
            $result['0'] = '-DI KIRIM-';
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
    
    
    function SearchResult($perPage,$uri,$search_orderno,$search_mem,$search_tg1,$search_tg2,$status,$search_cab,$waktu)
    {
        
        $this->db->select('*');
        $this->db->from('order');
        $this->db->join('user', 'user.id_user = order.user_id');
        $this->db->join('user_data', 'user.id_user = user_data.user_id');
        $this->db->join('cabang', 'order.kode_cabang = cabang.kode_cabang');
        
         
         if (($search_tg1 != 0) && ($search_tg2 != 0) && ($search_mem == 0) && ($status == 0) && ($search_cab == 0) && ($search_orderno == 0)){
	    
            $a =  "select kode_cabang FROM `order` WHERE kode_cabang LIKE '".$search_cab."'";
            $query = $this->db->query($a);
            
            if(($query->num_rows() > 0)){
                $this->db->like('order.kode_cabang', $search_cab);
                $this->db->where('tanggal_masuk >=', $search_tg1);
                $this->db->where('tanggal_masuk <=', $search_tg2);
                
                
            }else{
                
	    $this->db->where('tanggal_masuk >=', $search_tg1);
	    $this->db->where('tanggal_masuk <=', $search_tg2);
            
            }
        }
        
        else if(($search_tg1 == 0) && ($search_tg2 == 0) && ($search_mem == 0) && ($status != 0) || (empty($status)) && ($search_cab == 0) && ($search_orderno == 0)){
            
            $a =  "select kode_cabang FROM `order` WHERE kode_cabang LIKE '".$search_cab."'";
            $query = $this->db->query($a);
            
            if(($query->num_rows() > 0)){
                $this->db->like('status_order', $status);
                $this->db->like('order.kode_cabang', $search_cab);
               
                
            }else{
            
            $this->db->like('status_order', $status);
            
            }
        }
        
        else if(($search_tg1 == 0) && ($search_tg2 == 0) && ($search_mem == 0) && ($status == 0) && ($search_cab != NULL) && ($search_orderno == 0)){
            
            $this->db->like('order.kode_cabang', $search_cab);
           
        }
        
	else if(($search_tg1 == 0) && ($search_tg2 == 0) && ($search_mem == 0) && ($status == 0) && ($search_cab == 0) && ($search_orderno == 0) && ($waktu != 0)){
            
            $this->db->where('order.waktu_ambil', $waktu);
            //echo"waktu";
        }
	
        else if(($search_tg1 == 0) && ($search_tg2 == 0) && ($search_mem == 0) && ($status == 0) && ($search_cab == 0) && ($search_orderno != 0)){
            
            $this->db->like('order_no', $search_orderno);
            
        }
        
        else if(($search_tg1 == 0) && ($search_tg2 == 0) && ($search_mem != 0) && ($status == 0) && ($search_cab == 0) && ($search_orderno != 0)){
            
            $a =  "select kode_cabang FROM `order` WHERE kode_cabang LIKE '".$search_cab."'";
            $query = $this->db->query($a);
            
            if(($query->num_rows() > 0)){
                $this->db->like('order_no', $search_orderno)
                     ->like('membercard', $search_mem)
                     ->like('status_order', $status)
                     ->like('order.kode_cabang', $search_cab);
                
                
            }else{
            
            $this->db->like('order_no', $search_orderno)
                     ->like('membercard', $search_mem);
            
            
            }
        }
        
        else if(($search_tg1 != 0) && ($search_tg2 != 0) && ($search_mem == 0) && ($status == 0) && ($search_cab == 0) && ($search_orderno != 0)){
            
            $a =  "select kode_cabang FROM `order` WHERE kode_cabang LIKE '".$search_cab."'";
            $query = $this->db->query($a);
            
            if(($query->num_rows() > 0)){
               $this->db->like('order_no', $search_orderno)
                     ->where('tanggal_masuk >=', $search_tg1)
                     ->where('tanggal_masuk <=', $search_tg2)
                     ->like('order.kode_cabang', $search_cab);
            
            
            }else{
            
            $this->db->like('order_no', $search_orderno)
                     ->where('tanggal_masuk >=', $search_tg1)
                     ->where('tanggal_masuk <=', $search_tg2);
            
            }
        }
        
        else if(($search_tg1 == 0) && ($search_tg2 == 0) && ($search_mem == 0) && ($status != 0) && ($search_cab == 0) && ($search_orderno != 0)){
            
            $this->db->like('order_no', $search_orderno)
                     ->like('status_order', $status);
            
        }
        
        else if(($search_tg1 == 0) && ($search_tg2 == 0) && ($search_mem == 0) && ($status == 0) && ($search_cab != 0) && ($search_orderno != 0)){
            
            $this->db->like('order_no', $search_orderno)
                     ->like('order.kode_cabang', $search_cab);
            
        }
        
        else if(($search_tg1 != 0) && ($search_tg2 != 0) && ($search_mem != 0) && ($status == 0) && ($search_cab == 0) && ($search_orderno == 0)){
            
            $a =  "select kode_cabang FROM `order` WHERE kode_cabang LIKE '".$search_cab."'";
            $query = $this->db->query($a);
            
            if(($query->num_rows() > 0)){
                $this->db->like('membercard', $search_mem);
                $this->db->where('tanggal_masuk >=', $search_tg1);
                $this->db->where('tanggal_masuk <=', $search_tg2);
                $this->db->like('order.kode_cabang', $search_cab);
            
            
            }else{
            
                $this->db->like('membercard', $search_mem);
                $this->db->where('tanggal_masuk >=', $search_tg1);
                $this->db->where('tanggal_masuk <=', $search_tg2);
                
            }
        }
        
        else if(($search_tg1 == 0) && ($search_tg2 == 0) && ($search_mem != 0) && ($status != 0) && ($search_cab == 0) && ($search_orderno == 0)){
            
            $this->db->like('membercard', $search_mem)
                     ->like('status_order', $status);
            
        }
        
        else if(($search_tg1 == 0) && ($search_tg2 == 0) && ($search_mem != 0) && ($status == 0) && ($search_cab != NULL) && ($search_orderno == 0)){
            
            $a =  "select kode_cabang FROM `order` WHERE kode_cabang LIKE '".$search_cab."'";
            $query = $this->db->query($a);
            
            if(($query->num_rows() > 0)){
                $this->db->like('membercard', $search_mem)
                     ->like('order.kode_cabang', $search_cab);
            }else{
                $this->db->like('membercard', $search_mem);
                
            
            }
        }
        
        else if(($search_tg1 != 0) && ($search_tg2 != 0) && ($search_mem == 0) && ($status != 0) && ($search_cab == 0) && ($search_orderno == 0)){
            
            $a =  "select kode_cabang FROM `order` WHERE kode_cabang LIKE '".$search_cab."'";
            $query = $this->db->query($a);
            
            if(($query->num_rows() > 0)){
                $this->db->like('status_order', $status);
                $this->db->like('order.kode_cabang', $search_cab);
                $this->db->where('tanggal_masuk >=', $search_tg1);
                $this->db->where('tanggal_masuk <=', $search_tg2);
            
                
            }else{
            
            $this->db->like('status_order', $status);
            $this->db->where('tanggal_masuk >=', $search_tg1);
	    $this->db->where('tanggal_masuk <=', $search_tg2);
            
            }
        }
        
        //TIGA
        
        else if(($search_tg1 != 0) && ($search_tg2 != 0) && ($search_mem != 0) && ($status == 0) && ($search_cab == 0) && ($search_orderno != 0)){
            
            $this->db->like('order_no', $search_orderno);
            $this->db->like('membercard', $search_mem);
            $this->db->where('tanggal_masuk >=', $search_tg1);
	    $this->db->where('tanggal_masuk <=', $search_tg2);
            
            
        }
        
        else if(($search_tg1 == 0) && ($search_tg2 == 0) && ($search_mem != 0) && ($status != 0) && ($search_cab == 0) && ($search_orderno != 0)){
            
            $this->db->like('order_no', $search_orderno);
            $this->db->like('membercard', $search_mem);
            $this->db->like('status_order', $status);
            
            
        }
        
        else if(($search_tg1 != 0) && ($search_tg2 != 0) && ($search_mem != 0) && ($status != 0) && ($search_cab == 0) && ($search_orderno == 0)){
            
            $this->db->like('membercard', $search_mem);
            $this->db->where('tanggal_masuk >=', $search_tg1);
	    $this->db->where('tanggal_masuk <=', $search_tg2);
            $this->db->like('status_order', $status);
                     
          
            
        }
        
        else if(($search_tg1 != 0) && ($search_tg2 != 0) && ($search_mem == 0) && ($status != 0) && ($search_cab == 0) && ($search_orderno != 0)){
            
            $this->db->like('order_no', $search_orderno);
            $this->db->where('tanggal_masuk >=', $search_tg1);
	    $this->db->where('tanggal_masuk <=', $search_tg2);
            $this->db->like('status_order', $status);
                     
           
            
        }
        
        else{
            
            $this->db->like('order_no', $search_orderno);
            $this->db->like('membercard', $search_mem);
            $this->db->like('status_order', $status);
            $this->db->like('order.kode_cabang', $search_cab);
            $this->db->where('tanggal_masuk >=', $search_tg1);
	    $this->db->where('tanggal_masuk <=', $search_tg2);
           
        }
         
         $this->db->order_by('id_order','asc');
         $data = $this->db->get('', $perPage, $uri);
         
	 
         if($data->num_rows() > 0)
            return $data->result();
         else
            return null;
    }      
    
    function count_new_pesanan()
    {	
		$this->db->select('COALESCE(COUNT(id_order),0) order_count', FALSE);
		$this->db->from('`order`');
		$this->db->where_in('status_order', '1');
				
		$query = $this->db->get();
		
		//echo $this->db->last_query();		
		
		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				return $row['order_count'];
			}
		}
		
		return 0;
    }
    
    public function tambah_fav($data = array()) {
        //if(parent::insert($data)){
            //$id = $this->db->insert_id();
            
	    $id = $this->session->userdata('user_id');
	   
	    foreach ($data as $item){
                $detail = array( 
                                 'nama'=>$data['nama'],
                                 'user_id'=>$id );
                
		
	    }
	    //echo $detail['nama'];
	    //echo "<br/>";
	    //echo $id;
	    $this->db->insert('favoritku',$detail);
            //return true;
        //}
        return false;
    }
    
    public function delete_fav($nama= 0){
	
        $this->db->delete('favoritku',array('nama'=>$nama));
        
    }
    
    public function get_fav($nama,$id) {

	$data = array();
	$sql = "SELECT * FROM `favoritku` a JOIN `produk` b  
                WHERE a.produk_id = b.id_produk AND a.user_id = ? AND a.nama LIKE ?";
	    
	$hasil = $this->db->query($sql,array($id,urldecode($nama)));
	
	if($hasil->num_rows() > 0){
	    $data = $hasil->result();
	}
	
	$hasil->free_result();
	return $data;
	
    }
    
    public function delete_det_fav($id= 0){
	
        $this->db->delete('favoritku',array('id_fav'=>$id));
        
    }
    
    public function update_list($data1,$data2){
//	for($i=1;$i<count($data);$i++){
//            $data = array(
//                'qty'=>$data[$i]['qty']
//            );
//            $param = array(
//               'id_fav'=>$data[$i]['id_fav']
//            );
//            
	   $this->db->where('id_fav', $data1);
	   $this->db->update('favoritku', $data2); 
           //echo $this->db->last_query();
	    
	//}
	//echo $data['qty'];
	//    echo "<br/>";
	//    echo $param['id_fav'];
	
	//foreach($data as $a):
	//    echo $a['qty'];
	//    echo "<br/>";
	//    echo $a['id_fav'];
	//endforeach;
    }
    
    
    //GSS NEW
    public function get_transaksi($limit1='',$limit2='',$store_site_code) {
        
        $data = array();
	$sql = "select * from SUPPLIER_ORDER_HEADER
		JOIN USER_MASTER ON USER_MASTER.USER_ID = SUPPLIER_ORDER_HEADER.user_id
		WHERE STORE_SITE_CODE = ".$store_site_code."
		ORDER BY id_order DESC LIMIT ".$limit2;
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
    
    public function get_detail_trans($id = 0,$get_user = FALSE) {
        $this->db->where($id);
        if ($get_user){
            $this->db->join('user_data','user_data.ORDER_NO_GTRON = SUPPLIER_ORDER_HEADER.ORDER_NO_GTRON');
        }
        $data = parent::get_array();
        foreach ($data as $key=>$val){
            $this->db->where(array('id_order'=>$val['id_order']));
            $this->db->join('DC_STOCK_MASTER','DC_STOCK_MASTER.ARTICLE_CODE = SUPPLIER_ORDER_DETAIL.ARTICLE_CODE');
            
            $detail = $this->db->get('SUPPLIER_ORDER_DETAIL')->result_array();
            $data[$key]['detail'] = $detail;
                  
        } 
        return $data;
    }
    
    public function print_pembeli($ordernumb) {
        
        $data = array();
	$sql = "select * from SUPPLIER_ORDER_HEADER
		JOIN USER_MASTER ON USER_MASTER.USER_ID = SUPPLIER_ORDER_HEADER.user_id
		JOIN user_data ON SUPPLIER_ORDER_HEADER.ORDER_NO_GTRON = user_data.ORDER_NO_GTRON
		WHERE SUPPLIER_ORDER_HEADER.ORDER_NO_GTRON =".$ordernumb;
	    
	    $hasil = $this->db->query($sql);
	    if($hasil->num_rows() > 0){
		$data = $hasil->result();
	    }
	    
	    $hasil->free_result();
	    return $data;
    }
    
    public function print_transaksi($ordernumb,$store_site_code) {
        
        $data = array();
	$sql = "select * from SUPPLIER_ORDER_HEADER
		JOIN SUPPLIER_ORDER_DETAIL ON SUPPLIER_ORDER_HEADER.id_order = SUPPLIER_ORDER_DETAIL.id_order
		JOIN DC_STOCK_MASTER ON DC_STOCK_MASTER.ARTICLE_CODE = SUPPLIER_ORDER_DETAIL.ARTICLE_CODE
		JOIN STORE_SALES_MASTER ON STORE_SALES_MASTER.ARTICLE_CODE = SUPPLIER_ORDER_DETAIL.ARTICLE_CODE
		WHERE SUPPLIER_ORDER_HEADER.ORDER_NO_GTRON =".$ordernumb."
		AND STORE_SITE_CODE =".$store_site_code;
		
		
	    
	    $hasil = $this->db->query($sql);
	    if($hasil->num_rows() > 0){
		$data = $hasil->result();
	    }
	    
	    $hasil->free_result();
	    return $data;
	
    
    }
    
    //ADMIN
    public function get_all_transaksi($limit1='',$limit2='',$store_site_code) {
        
        $data = array();
	$sql = "select * from SUPPLIER_ORDER_HEADER
		JOIN USER_MASTER ON USER_MASTER.USER_ID = SUPPLIER_ORDER_HEADER.user_id
		JOIN SITE_MASTER ON SITE_MASTER.SITE_CODE = SUPPLIER_ORDER_HEADER.SITE_CODE
		ORDER BY id_order DESC";
	    
	    $hasil = $this->db->query($sql);
	    if($hasil->num_rows() > 0){
		$data = $hasil->result();
	    }
	    
	    $hasil->free_result();
	    return $data;
    }
    
    public function get_all_detail_trans($id = 0,$get_user = FALSE) {
        $this->db->where($id);
        if ($get_user){
            $this->db->join('user_data','user_data.ORDER_NO_GTRON = SUPPLIER_ORDER_HEADER.ORDER_NO_GTRON');
        }
        $data = parent::get_array();
        foreach ($data as $key=>$val){
            $this->db->where(array('id_order'=>$val['id_order']));
            $this->db->join('DC_STOCK_MASTER','DC_STOCK_MASTER.ARTICLE_CODE = SUPPLIER_ORDER_DETAIL.ARTICLE_CODE');
            
            $detail = $this->db->get('SUPPLIER_ORDER_DETAIL')->result_array();
            $data[$key]['detail'] = $detail;
                  
        } 
        return $data;
	
    }
}

?>
