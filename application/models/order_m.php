<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_m extends MY_Model {
    
    public function __construct(){
        parent::__construct();
        parent::set_table('SUPPLIER_ORDER_HEADER','id_order');
    }
    
    public function insert($data = array(), $cart = array(),$order_no_gtron) {
        $dc_code = $this->session->userdata('dc_site_code');
        $dc_site_code = $this->session->userdata('store_site_code');
        $flag = 0;
        
        if(parent::insert($data)){
            $id = $this->db->insert_id();
            foreach ($cart as $item){

                $detail = array( 'id_order'=>$id,
                                 'ORDER_NO_GTRON'=>$order_no_gtron,
                                 'ORDER_NO_GOLD'=>0,
                                 'ARTICLE_CODE'=>$item['id'],
                                 'PLU'=>$item['PLU'],
                                 'kuantitas'=>$item['qty'],
                                 'DC_CODE' =>$dc_code,
                                 'SITE_CODE' => $dc_site_code,
                                 'FLAG' => $flag,
                                 'SV' => $item['pembayaran'],
                                 'subtotal'=> $item['subtotal']);
                $this->db->insert('SUPPLIER_ORDER_DETAIL',$detail);
            }
            
            $a =  "select * FROM SUPPLIER_ORDER_HEADER a JOIN user_data b 
                   WHERE a.user_id = b.user_id AND id_order = $id";
            $query = $this->db->query($a);
            if ($query->num_rows() > 0)
            {
               foreach ($query->result() as $row)
               {
                  return $row;                  
               }
               
               
            }
           
        }
        return false;
    }
    
    public function insert_fav($cart = array(),$nama_list) {
        $id = $this->session->userdata('user_id');
            foreach ($cart as $item){
                $detail = array( 'nama'=>$nama_list,
                                 'produk_id'=>$item['id'],
                                 'qty'=>$item['qty'],
                                 'user_id'=>$id);
                $this->db->insert('favoritku',$detail);
                //echo $nama_list;
            }
            //return true;
        //}
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
    
    public function get_record_page($perPage,$uri,$id){
        
//        $data = array();
//	$sql = "SELECT * FROM `order` a JOIN `user` b JOIN user_data c 
//            WHERE a.user_id = b.id_user AND c.user_id = b.id_user AND b.id_user = '$id'  LIMIT ".$limit2;
//	    if($limit1){
//		$sql .= ",".$limit1;
//	    }
//	    $hasil = $this->db->query($sql);
//	    if($hasil->num_rows() > 0){
//		$data = $hasil->result();
//	    }
//	    
//	    $hasil->free_result();
//	
//        return $data;

        $this->db->select('*');
        $this->db->from('order');
        $this->db->join('user', 'user.id_user = order.user_id');
        $this->db->join('user_data', 'user.id_user = user_data.user_id');
        $this->db->order_by("id_order", "desc"); 
        
        $a =  "select user_id FROM `order` WHERE user_id LIKE '".$id."'";
            $query = $this->db->query($a);
            
            if(($query->num_rows() > 0)){
                $this->db->like('id_user', $id);
   
            }
            
        $this->db->order_by('id_order','asc');
         $data = $this->db->get('', $perPage, $uri);
         
         if($data->num_rows() > 0)
            return $data->result();
         else
            return null;
    }
    
    public function get_favorit_page($perPage,$uri,$id){

        $this->db->select('*');
        $this->db->from('favoritku');
        $this->db->join('user', 'user.id_user = favoritku.user_id');
        $this->db->join('user_data', 'user.id_user = user_data.user_id');
        $this->db->where('favoritku.user_id',$id);
        $this->db->group_by("nama", "desc"); 
        
        $a =  "select user_id FROM `favoritku` WHERE user_id LIKE '".$id."'";
            $query = $this->db->query($a);
            
            if(($query->num_rows() > 0)){
                $this->db->like('id_user', $id);
   
            }
            
        $this->db->order_by('id_fav','asc');
         $data = $this->db->get('', $perPage, $uri);
         
         if($data->num_rows() > 0)
            return $data->result();
         else
            return null;
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
    
    public function get_laporan_penjualan($limit1='',$limit2=''){
        
        $data_e = array();
	$sql = "SELECT * FROM `order` a JOIN `user` b WHERE a.user_id = b.id_user LIMIT ".$limit2;
	    if($limit1){
		$sql .= ",".$limit1;
	    }
	    $hasil = $this->db->query($sql);
	    if($hasil->num_rows() > 0){
		$data_e = $hasil->result();
	    }
	    
	    $hasil->free_result();
	    return $data_e;
    }
    
    public function get_total($limit1='',$limit2=''){
        
        $data_ee = array();
	$sqll = "SELECT SUM(total_biaya) as total_biaya FROM `order` a JOIN `user` b WHERE a.user_id = b.id_user AND a.status_order = 4 LIMIT ".$limit2;
	    if($limit1){
		$sqll .= ",".$limit1;
	    }
	    $hasill = $this->db->query($sqll);
	    if($hasill->num_rows() > 0){
		$data_ee = $hasill->result();
	    }
	    
	    $hasill->free_result();
	    return $data_ee;
    
    }
    
    function SearchResult($perPage,$uri,$search_tg1,$search_tg2,$search_cabang)
    {
        $this->db->select('tanggal_masuk, order.kode_cabang, order.order_no, order.total_biaya, user.username');
        $this->db->from('order');
        $this->db->join('user', 'user.id_user = order.user_id');
        $this->db->where('status_order', '4');
        
        if(($search_cabang != 0) && ($search_tg1 == 0) || ($search_tg2 ==0)){

            $this->db->like('order.kode_cabang', $search_cabang);
            
            
        }else {
            
            $a =  "select kode_cabang FROM `order` WHERE kode_cabang LIKE '".$search_cabang."'";
            $query = $this->db->query($a);
            
            if(($query->num_rows() > 0)){
                $this->db->like('order.kode_cabang', $search_cabang)
                         ->where('tanggal_masuk >=', $search_tg1)
                         ->where('tanggal_masuk <=', $search_tg2);
                    
                
            }else{
                $this->db->where('tanggal_masuk >=', $search_tg1);
                $this->db->where('tanggal_masuk <=', $search_tg2);
                
            }
            
        }
         
         $this->db->order_by('id_order','asc');
         $data = $this->db->get('', $perPage, $uri);
      
         if($data->num_rows() > 0)
            return $data->result();
         else
            return null;
    }
    
    function get_total_page($perPage,$uri,$search_tg1,$search_tg2,$search_cabang)
    {
     $this->db->select('SUM(total_biaya) AS total_biaya');
     $this->db->from('order');
     $this->db->join('user', 'user.id_user = order.user_id');
     $this->db->where('status_order', '4');
     
        if(!empty($search_cabang)){

            $this->db->like('order.kode_cabang', $search_cabang);
            
        }else if(!empty($search_tg1) || !empty($search_tg2)){
            $this->db->where('tanggal_masuk >=', $search_tg1);
            $this->db->where('tanggal_masuk <=', $search_tg2);
        
        }else if(!empty($search_tg1) && !empty($data['search_tg2']) && !empty($search_cabang)){
            $this->db->where('tanggal_masuk >=', $search_tg1);
            $this->db->where('tanggal_masuk <=', $search_tg2);
            $this->db->like('order.kode_cabang', $search_cabang);
        }
         
         $this->db->order_by('id_order','asc');
         $data = $this->db->get('', $perPage, $uri);
      
         if($data->num_rows() > 0)
            return $data->result();
         else
            return null;
    }
    
    function list_cab($kode_cabang,$nama_cabang){
        $result = array();
        $array_keys_values = $this->db->query("select * from cabang");
        foreach($array_keys_values ->result() as $row){
            $result[$row->kode_cabang] = $row->nama_cabang;
        }
        
        $results = array_merge(array('' => '- Semua Cabang -'), $result);
        
        return $results;
    }
    
    
    function SearchExport($search_cabang)
    {
        $this->db->select("CONCAT(order.order_no, '|', order.tanggal_masuk, '|', order.kode_cabang, '|', order_data.kuantitas , '|', produk.plu, '|', produk.nama_produk) AS export",FALSE);
        $this->db->from('`order`');
        $this->db->join('user', 'user.id_user = order.user_id');
        $this->db->join('order_data', 'order.id_order = order_data.order_id');
	$this->db->join('produk', 'order_data.produk_id = produk.id_produk');
        $this->db->where('status_order', '4');
        $this->db->like('order.kode_cabang', $search_cabang);
        $this->db->order_by('order.id_order','asc');
        $this->db->where('order.tanggal_masuk <= DATE_ADD(CURRENT_DATE(), INTERVAL -2 HOUR)');
	$this->db->where('order.tanggal_masuk >= DATE_ADD(CURRENT_DATE(), INTERVAL -24 HOUR)');
        
        $data = $this->db->get();
        
        //echo $this->db->last_query();
        
        if($data->num_rows() > 0)
           return $data->result();
        else
           return null;
    }
    
    function SearchExport_o($search_cabang)
    {
        $this->db->select("CONCAT('11',cabang.store_code,';', '\"', UPPER(DATE_FORMAT(order.tanggal_masuk,'%d-%b-%Y')) ,'\"', ';\"cash sales\";', SUM(order.total_biaya), ';1;\"\"')  AS export, CONCAT('11',cabang.store_code,';', '\"', UPPER(DATE_FORMAT(order.tanggal_masuk,'%d-%b-%Y')) ,'\"', ';\"vat - sales\";', SUM(order.total_biaya)* 0.1 , ';11;\"\"') as vat",FALSE);  
        $this->db->from('`order`');
        $this->db->join('user', 'user.id_user = order.user_id');
        $this->db->join('order_data', 'order.id_order = order_data.order_id');
	$this->db->join('produk', 'order_data.produk_id = produk.id_produk');
        $this->db->join('cabang', 'order.kode_cabang = cabang.kode_cabang');
        $this->db->where('status_order', '4');
        $this->db->like('order.kode_cabang', $search_cabang);
        $this->db->order_by('order.id_order','asc');
        $this->db->where('order.tanggal_masuk <= DATE_ADD(CURRENT_DATE(), INTERVAL -2 HOUR)');
	$this->db->where('order.tanggal_masuk >= DATE_ADD(CURRENT_DATE(), INTERVAL -24 HOUR)');
        
        
        $data = $this->db->get();
        //echo $this->db->last_query();
        if($data->num_rows() > 0)
           return $data->result();
        else
           return null;
    }
    
    function SearchExport_o_div($search_cabang)
    {
        $this->db->select("CONCAT('11',cabang.store_code,';', '\"', UPPER(DATE_FORMAT(order.tanggal_masuk,'%d-%b-%Y')) ,'\"', ';\"outright sales\";', SUM(order.total_biaya), ';1;\"',kode_kategori,'\"') AS export",FALSE);  
        $this->db->from('`order`');
        $this->db->join('user', 'user.id_user = order.user_id');
        $this->db->join('order_data', 'order.id_order = order_data.order_id');
	$this->db->join('produk', 'order_data.produk_id = produk.id_produk');
        $this->db->join('kategori', 'produk.kategori_id = kategori.id_kategori');
        $this->db->join('cabang', 'order.kode_cabang = cabang.kode_cabang');
        $this->db->where('status_order', '4');
        
        $this->db->group_by('id_kategori');
        $this->db->where('order.tanggal_masuk <= DATE_ADD(CURRENT_DATE(), INTERVAL -2 HOUR)');
	$this->db->where('order.tanggal_masuk >= DATE_ADD(CURRENT_DATE(), INTERVAL -24 HOUR)');
        $this->db->like('order.kode_cabang', $search_cabang);
        
        $data = $this->db->get();
        //echo $this->db->last_query();
        if($data->num_rows() > 0)
           return $data->result();
        else
           return null;
    }
    
    public function get_users()
    {
        $q = $this->db->select('*')
                        ->from('order')
                        ->get();
         
        if ( $q->num_rows() > 0 )
        {
            return $q->result_array();
        }
    }
    
    function stat_exp()
    {
        
        $data = array();
        
        $sql = "SELECT DISTINCT DATE_FORMAT(tanggal, '%Y-%m-%d') as tanggals, RIGHT(tanggal,9) as jam FROM export_status";
        
        //$sql = "SELECT kode_cabang FROM `order` group by kode_cabang";
        
        $hasil = $this->db->query($sql);
        if($hasil->num_rows() > 0){
                $data = $hasil->result();
        }
        $hasil->free_result();
        return $data;
      
    }
    
    public function update_stat_exp(){

        $this->db->insert('export_status', array('tanggal' => date('Y-m-d H:i:s'))); 
        //echo $this->db->last_query();
    }
    
    public function cabang(){
        $this->db->select('order.kode_cabang, store_code');  
        $this->db->from('`order`');
        $this->db->join('cabang', 'order.kode_cabang = cabang.kode_cabang');
        $this->db->where('order.tanggal_masuk <= DATE_ADD(CURRENT_DATE(), INTERVAL -2 HOUR)');
	$this->db->where('order.tanggal_masuk >= DATE_ADD(CURRENT_DATE(), INTERVAL -24 HOUR)');
        $this->db->group_by('order.kode_cabang');
        
        $data = $this->db->get();
       
        //return $data;
        if($data->num_rows() > 0)
           return $data->result();
        else
           return null;
    }
    
    public function cek_stok($cart = array()){
        //echo "cek stok";
       $stat = 'TRUE';
       $prod = '';
       foreach ($cart as $item){
            $this->db->select('ARTICLE_DESC,STOCK_QTY,BOOK_QTY, CONFIRM_QTY');
            $this->db->from('DC_STOCK_MASTER');
            $this->db->where('ARTICLE_CODE',$item['id']);
            
            $result = $this->db->get()->row();
            
            $book = $result->BOOK_QTY;
            $confirm = $result->CONFIRM_QTY;
            $stok = $result->STOCK_QTY;
            
            $sisa = $stok - $book - $confirm;
            
            if($item['qty'] > $sisa){
                $prod .= $item['id'].'!@#'.$result->ARTICLE_DESC.'###';
            }
            
          
        }  
               
        return $prod;
    }
    
    public function update_booking($order = array(), $total_item, $orderno, $total_cpv) {
        //redirect (site_url('store/transaksi/'));
        //var_dump($order);
 
        for($i=0; $i < count($order['id_order_detail']); $i++){
            
        //$this->db->set('kuantitas', $order['kuantitas'][$i]);
        //$this->db->where('id_order_detail', $order['id_order_detail'][$i]);
        //$this->db->update('SUPPLIER_ORDER_DETAIL');
        //
        //
        //$this->db->set('total_item', $total_item);
        //$this->db->set('COST_PRICE_VALUE', $total_cpv);
        //$this->db->where('ORDER_NO_GTRON', $orderno);
        //$this->db->update('SUPPLIER_ORDER_HEADER');
            
        
        
        $this->db->set('a.kuantitas', $order['kuantitas'][$i]);
        $this->db->set('a.id_order_detail', $order['id_order_detail'][$i]);
        $this->db->set('b.total_item', $total_item);
        $this->db->set('b.COST_PRICE_VALUE', $total_cpv);
        
        $this->db->where('a.id_order_detail', $order['id_order_detail'][$i]);
        $this->db->where('b.ORDER_NO_GTRON', $orderno);
        $this->db->update('SUPPLIER_ORDER_DETAIL as a, SUPPLIER_ORDER_HEADER as b');
        
        
        
        
        }
           
        //return false;   
            
           
    }
}
?>