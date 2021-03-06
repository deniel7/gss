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
    
    
    function count_new_pesanan()
    {	
		$this->db->select('COALESCE(COUNT(id_order),0) order_count', FALSE);
		$this->db->from('SUPPLIER_ORDER_HEADER');
		$this->db->where_in('FLAG', '1');
		
		$query = $this->db->get();
			
		
		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				return $row['order_count'];
			}
		}
		
		return 0;
    }
    
    function count_gold_process()
    {	
		$this->db->select('COALESCE(COUNT(id_order),0) order_count', FALSE);
		$this->db->from('SUPPLIER_ORDER_HEADER');
		$this->db->where_in('FLAG', '3');
		$this->db->or_where_in('FLAG', '2');
		
		$query = $this->db->get();
			
		
		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				return $row['order_count'];
			}
		}
		
		return 0;
    }
    
    function count_print_order()
    {	
	
	$sql = "select COALESCE(COUNT(id_order),0) order_count
		from SUPPLIER_ORDER_HEADER
		WHERE SUPPLIER_ORDER_HEADER.STRUK_STATUS = 1
		AND SUPPLIER_ORDER_HEADER.PRINT_STATUS = 0
		AND (SUPPLIER_ORDER_HEADER.FLAG = 7
		OR SUPPLIER_ORDER_HEADER.FLAG = 5)
		";
	
	    $hasil = $this->db->query($sql);
	    if($hasil->num_rows() > 0){
		foreach ($hasil->result_array() as $row)
		{
			return $row['order_count'];
		}
	    }
	    
	    return 0;
	
	
	
	
	//$this->db->select('COALESCE(COUNT(id_order),0) order_count', FALSE);
	//$this->db->from('SUPPLIER_ORDER_HEADER');
	//
	//$this->db->where('FLAG', '5');
	//$this->db->or_where('FLAG', '7');
	//$this->db->where('STRUK_STATUS', '1');
	//$this->db->where('PRINT_STATUS', '0');
	//
	//$query = $this->db->get();
	
	
	//if ($query->num_rows() > 0)
	//{
	//	foreach ($query->result_array() as $row)
	//	{
	//		return $row['order_count'];
	//	}
	//}
	//
	//return 0;
    }
    
    function count_receiving()
    {
	
	$sql = "select COALESCE(COUNT(id_order),0) order_count
		from SUPPLIER_ORDER_HEADER
		WHERE
		
		SUPPLIER_ORDER_HEADER.RECEIVING_DN IS NULL
		AND SUPPLIER_ORDER_HEADER.PRINT_STATUS > 0
		AND (SUPPLIER_ORDER_HEADER.FLAG = 7
		OR SUPPLIER_ORDER_HEADER.FLAG = 5)
		
		";
	
	    $hasil = $this->db->query($sql);
	    if($hasil->num_rows() > 0){
		foreach ($hasil->result_array() as $row)
		{
			return $row['order_count'];
		}
	    }
	    
	    return 0;
	
	
	
		//$this->db->select('COALESCE(COUNT(id_order),0) order_count', FALSE);
		//$this->db->from('SUPPLIER_ORDER_HEADER');
		//$this->db->where_in('FLAG', '7');
		//$this->db->where('RECEIVING_DN', NULL);
		//$this->db->where('PRINT_STATUS', '1');
		//
		//$query = $this->db->get();
		//
		//
		//if ($query->num_rows() > 0)
		//{
		//	foreach ($query->result_array() as $row)
		//	{
		//		return $row['order_count'];
		//	}
		//}
		//
		//return 0;
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
    public function get_transaksi($store_site_code) {
        
        $data = array();
	$sql = "select * from SUPPLIER_ORDER_HEADER
		JOIN USER_MASTER ON USER_MASTER.USER_ID = SUPPLIER_ORDER_HEADER.user_id
		WHERE STORE_SITE_CODE = ".$store_site_code."
		ORDER BY id_order DESC";
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
            $this->db->where('SUPPLIER_ORDER_DETAIL.cancel !=', 1);
	    
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
		WHERE SUPPLIER_ORDER_HEADER.ORDER_NO_GTRON ='$ordernumb'";
	    
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
		WHERE SUPPLIER_ORDER_HEADER.ORDER_NO_GTRON ='$ordernumb'
		AND STORE_SALES_MASTER.SV = SUPPLIER_ORDER_DETAIL.SV
		AND STORE_SITE_CODE =".$store_site_code;
		
		
	    
	    $hasil = $this->db->query($sql);
	    if($hasil->num_rows() > 0){
		$data = $hasil->result();
	    }
	    
	    $hasil->free_result();
	    return $data;
	
    
    }
    
    public function update_user_booking($data = array(), $ordernumb, $catatan) {
        
        //for($i=0; $i < count($data['ORDER_NO_GTRON']); $i++){
	
        $this->db->set('a.nama_depan', $data['nama_depan']);
        $this->db->set('a.nama_belakang', $data['nama_belakang']);
	$this->db->set('a.alamat', $data['alamat']);
	$this->db->set('a.kode_pos', $data['kode_pos']);
	$this->db->set('a.phone', $data['phone']);
	$this->db->set('a.penerima', $data['penerima']);
        $this->db->set('b.catatan', $catatan);
        
        $this->db->where('a.ORDER_NO_GTRON', $ordernumb);
        $this->db->where('b.ORDER_NO_GTRON', $ordernumb);
        $this->db->update('user_data as a, SUPPLIER_ORDER_HEADER as b');
        
	//}
         //var_dump($data['nama_depan']);
	 
    }
    
    
    public function get_pending_transaksi() {
        
        $data = array();
//	$sql = "select id_order, ORDER_NO_GTRON, tanggal_masuk, waktu_confirm, TOTAL_BIAYA_INPUT, USERNAME, MID(`SITE_STORE_CODE`,4,20) as SITE_STORE_CODE , no_struk, updated_by, struk_update_time 
//	from SUPPLIER_ORDER_HEADER JOIN USER_MASTER ON USER_MASTER.USER_ID = SUPPLIER_ORDER_HEADER.user_id JOIN SITE_MASTER
//	ON SITE_MASTER.SITE_CODE = SUPPLIER_ORDER_HEADER.SITE_CODE
//	WHERE (SUPPLIER_ORDER_HEADER.updated_by IS NOT NULL AND `STRUK_STATUS` = 1)
//	OR `STRUK_STATUS` = 2 OR `STRUK_STATUS` = 3 OR `STRUK_STATUS` = 4
//	ORDER BY id_order DESC  
//        ";
	
	$sql = "select id_order, ORDER_NO_GTRON, tanggal_masuk, waktu_confirm, TOTAL_BIAYA_INPUT, USERNAME, MID(`SITE_STORE_CODE`,4,20) as SITE_STORE_CODE , no_struk, updated_by, struk_update_time, SUPPLIER_ORDER_HEADER.FLAG, SUPPLIER_ORDER_HEADER.STRUK_STATUS, SUPPLIER_ORDER_HEADER.SITE_CODE
	from SUPPLIER_ORDER_HEADER JOIN USER_MASTER ON USER_MASTER.USER_ID = SUPPLIER_ORDER_HEADER.user_id JOIN SITE_MASTER
	ON SITE_MASTER.SITE_CODE = SUPPLIER_ORDER_HEADER.SITE_CODE
	WHERE (SUPPLIER_ORDER_HEADER.updated_by IS NULL AND SUPPLIER_ORDER_HEADER.STRUK_STATUS != 0 AND SUPPLIER_ORDER_HEADER.STRUK_STATUS != 1 AND SUPPLIER_ORDER_HEADER.FLAG !=4)
	ORDER BY id_order DESC";
	
	    $hasil = $this->db->query($sql);
	    if($hasil->num_rows() > 0){
		$data = $hasil->result();
	    }
	    
	    $hasil->free_result();
	    return $data;
    }
    
    public function get_pending_transaksi_cbg($store_site_code) {
        
        $data = array();
	//$sql = "select id_order, ORDER_NO_GTRON, tanggal_masuk, waktu_confirm, TOTAL_BIAYA_INPUT, USERNAME, MID(`SITE_STORE_CODE`,4,20) as SITE_STORE_CODE , no_struk, updated_by, struk_update_time
	//from SUPPLIER_ORDER_HEADER JOIN USER_MASTER ON USER_MASTER.USER_ID = SUPPLIER_ORDER_HEADER.user_id JOIN SITE_MASTER
	//ON SITE_MASTER.SITE_CODE = SUPPLIER_ORDER_HEADER.SITE_CODE
	//WHERE (SUPPLIER_ORDER_HEADER.updated_by IS NOT NULL AND `STRUK_STATUS` = 1 AND SUPPLIER_ORDER_HEADER.FLAG != 4)
	//OR `STRUK_STATUS` = 2 OR `STRUK_STATUS` = 3 OR `STRUK_STATUS` = 4
	//AND SUPPLIER_ORDER_HEADER.SITE_CODE = ".$store_site_code." ORDER BY id_order DESC ";
	
	$sql = "select id_order, ORDER_NO_GTRON, tanggal_masuk, waktu_confirm, TOTAL_BIAYA_INPUT, USERNAME, MID(`SITE_STORE_CODE`,4,20) as SITE_STORE_CODE , no_struk, updated_by, struk_update_time, SUPPLIER_ORDER_HEADER.FLAG, SUPPLIER_ORDER_HEADER.STRUK_STATUS, SUPPLIER_ORDER_HEADER.SITE_CODE
	from SUPPLIER_ORDER_HEADER JOIN USER_MASTER ON USER_MASTER.USER_ID = SUPPLIER_ORDER_HEADER.user_id JOIN SITE_MASTER
	ON SITE_MASTER.SITE_CODE = SUPPLIER_ORDER_HEADER.SITE_CODE
	WHERE (SUPPLIER_ORDER_HEADER.updated_by IS NULL AND SUPPLIER_ORDER_HEADER.STRUK_STATUS != 0 AND SUPPLIER_ORDER_HEADER.STRUK_STATUS != 1 AND SUPPLIER_ORDER_HEADER.FLAG !=4)
	AND SUPPLIER_ORDER_HEADER.SITE_CODE = ".$store_site_code." ORDER BY id_order DESC";
	
	
	    
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
	$sql = "select id_order, ORDER_NO_GTRON, ORDER_NO_GOLD, SUPPLIER_ORDER_HEADER.FLAG, STRUK_STATUS
		from SUPPLIER_ORDER_HEADER
		JOIN USER_MASTER ON USER_MASTER.USER_ID = SUPPLIER_ORDER_HEADER.user_id
		JOIN SITE_MASTER ON SITE_MASTER.SITE_CODE = SUPPLIER_ORDER_HEADER.SITE_CODE
		WHERE (SUPPLIER_ORDER_HEADER.FLAG != 4
		AND SUPPLIER_ORDER_HEADER.STRUK_STATUS = 1)
		OR SUPPLIER_ORDER_HEADER.STRUK_STATUS = 0 
		ORDER BY id_order DESC";
	    
	    $hasil = $this->db->query($sql);
	    if($hasil->num_rows() > 0){
		$data = $hasil->result();
	    }
	    
	    $hasil->free_result();
	    return $data;
    }
    
    public function get_new_orders() {
        
        $data = array();
	$sql = "select id_order, ORDER_NO_GTRON, MID(SITE_STORE_CODE,4,10) as site_store_code , tanggal_masuk, TOTAL_BIAYA_INPUT, USERNAME, no_struk, SUPPLIER_ORDER_HEADER.FLAG
		from SUPPLIER_ORDER_HEADER
		JOIN USER_MASTER ON USER_MASTER.USER_ID = SUPPLIER_ORDER_HEADER.user_id
		JOIN SITE_MASTER ON SITE_MASTER.SITE_CODE = SUPPLIER_ORDER_HEADER.SITE_CODE
		WHERE SUPPLIER_ORDER_HEADER.FLAG = 1
		ORDER BY id_order DESC";
	    
	    $hasil = $this->db->query($sql);
	    if($hasil->num_rows() > 0){
		$data = $hasil->result();
	    }
	    
	    $hasil->free_result();
	    return $data;
    }
    
    public function get_all_receiving() {
        
        $data = array();
	$sql = "select * from SUPPLIER_ORDER_HEADER
		JOIN USER_MASTER ON USER_MASTER.USER_ID = SUPPLIER_ORDER_HEADER.user_id
		JOIN SITE_MASTER ON SITE_MASTER.SITE_CODE = SUPPLIER_ORDER_HEADER.SITE_CODE
		WHERE
		
		SUPPLIER_ORDER_HEADER.RECEIVING_DN IS NULL
		AND SUPPLIER_ORDER_HEADER.PRINT_STATUS > 0
		AND (SUPPLIER_ORDER_HEADER.FLAG = 7
		OR SUPPLIER_ORDER_HEADER.FLAG = 5)
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
	    $this->db->where_not_in('SUPPLIER_ORDER_DETAIL.cancel',1);
            $this->db->join('DC_STOCK_MASTER','DC_STOCK_MASTER.ARTICLE_CODE = SUPPLIER_ORDER_DETAIL.ARTICLE_CODE');
            
            $detail = $this->db->get('SUPPLIER_ORDER_DETAIL')->result_array();
            $data[$key]['detail'] = $detail;
                  
        } 
        return $data;
	
    }
    
    public function get_printing($limit1='',$limit2='') {
        
        $data = array();
	$sql = "select 
		id_order, ORDER_NO_GTRON,PRINT_STATUS, MID(SITE_STORE_CODE,4,10) as SITE_STORE_CODE, tanggal_masuk, ORDER_DELIVERY_DATE, USERNAME, no_struk, STORE_SITE_CODE
		from SUPPLIER_ORDER_HEADER
		JOIN USER_MASTER ON USER_MASTER.USER_ID = SUPPLIER_ORDER_HEADER.user_id
		JOIN SITE_MASTER ON SITE_MASTER.SITE_CODE = SUPPLIER_ORDER_HEADER.SITE_CODE
		WHERE SUPPLIER_ORDER_HEADER.STRUK_STATUS = 1
		AND (SUPPLIER_ORDER_HEADER.FLAG = 7
		OR SUPPLIER_ORDER_HEADER.FLAG = 5)
		GROUP BY id_order";
	    
	    $hasil = $this->db->query($sql);
	    if($hasil->num_rows() > 0){
		$data = $hasil->result();
	    }
	    
	    $hasil->free_result();
	    return $data;
    }
    
    public function get_gold_process() {
        
        $data = array();
	$sql = "select * from SUPPLIER_ORDER_HEADER
		JOIN USER_MASTER ON USER_MASTER.USER_ID = SUPPLIER_ORDER_HEADER.user_id
		JOIN SITE_MASTER ON SITE_MASTER.SITE_CODE = SUPPLIER_ORDER_HEADER.SITE_CODE
		WHERE SUPPLIER_ORDER_HEADER.FLAG = 3
		ORDER BY id_order DESC";
	    
	    $hasil = $this->db->query($sql);
	    if($hasil->num_rows() > 0){
		$data = $hasil->result();
	    }
	    
	    $hasil->free_result();
	    return $data;
    }
    
    public function cek_DN($id) {
        
        $data = array();
	$sql = "select * from SUPPLIER_ORDER_HEADER
		WHERE id_order ='$id'
		AND FLAG = 7";
	    
	    $hasil = $this->db->query($sql);
	    if($hasil->num_rows() > 0){
		$data = $hasil->result();
	    }
	    
	    $hasil->free_result();
	    return $data;
    }
    
    public function get_riwayat_pembeli() {
        
        $data = array();
	$sql = "select id_order, user_data.ORDER_NO_GTRON, nama_depan, nama_belakang, alamat, phone, MID(SITE_STORE_CODE,4,10) as SITE_STORE_CODE, tanggal_masuk, ORDER_DELIVERY_DATE,  TOTAL_BIAYA_INPUT
		from SUPPLIER_ORDER_HEADER
		JOIN USER_MASTER ON USER_MASTER.USER_ID = SUPPLIER_ORDER_HEADER.user_id
		JOIN SITE_MASTER ON SITE_MASTER.SITE_CODE = SUPPLIER_ORDER_HEADER.SITE_CODE
		JOIN user_data ON user_data.ORDER_NO_GTRON = SUPPLIER_ORDER_HEADER.ORDER_NO_GTRON
		ORDER BY id_order DESC";
	    
	    $hasil = $this->db->query($sql);
	    if($hasil->num_rows() > 0){
		$data = $hasil->result();
	    }
	    
	    $hasil->free_result();
	    return $data;
    }
    
    public function check_nominal_exist($total_biaya_input, $nomor)
    {
	//$this->db->where("TRANS_NO",$nomor);
	$sql ="SELECT *
		FROM `GTRON_POSTRA_TOTAL`
		WHERE `GTRON_POSTRA_TOTAL`.`AMOUNT`= $total_biaya_input AND `TRANS_NO` = $nomor
		AND `GTRON_POSTRA_TOTAL`.`TRANS_DATE` = DATE_ADD(CURDATE(), INTERVAL -1 DAY)
		";
		
	
	$r = $this->db->query($sql);
	
        if($r->num_rows()>0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    public function check_nomor_exist($nomor)
    {
		
        //$this->db->where("AMOUNT",$price);
	$this->db->where("TRANS_NO",$nomor);
        $query=$this->db->get("GTRON_POSTRA_TOTAL");
        if($query->num_rows()>0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
}

?>
