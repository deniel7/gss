<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Import_m extends MY_Model {
    
    public function __construct(){
        parent::__construct();
        parent::set_table('sku_tilcode','PLU');
    }
    
    function tambahsku($dataarray)
    {
        for($i=0;$i<count($dataarray);$i++){
            $data = array(
                'entry_number'=>$dataarray[$i]['entry_number'],
		'PLU'=>$dataarray[$i]['PLU']
            );
            //$this->db->insert('sku_tilcode', $data);
        
	    $query_string = "INSERT INTO sku_tilcode (entry_number, PLU) VALUES ('".$data['entry_number']."','".$data['PLU']."') ON DUPLICATE KEY UPDATE entry_number ='".$data['entry_number']."',PLU='".$data['PLU']."'";
	    $query = $this->db->query($query_string); 
	}
    }
    
    
    function update_sku($dataarray)
    {
        for($i=1;$i<count($dataarray);$i++){
            $data = array(
                'entry_number'=>$dataarray[$i]['entry_number'],
		'PLU'=>$dataarray[$i]['PLU']
            );
            $param = array(
               'entry_number'=>$dataarray[$i]['entry_number']
            );
            $this->db->where($param);
           return $this->db->update('sku_tilcode',$data);   
        }
    }
    
    function search_chapter($dataarray){
	for($i=1;$i<count($dataarray);$i++){
	      $search = array(
		  'PLU'=>$dataarray[$i]['PLU']
	      );
	}
	  
	$data = array();
	    $this->db->where($search);
	    $this->db->limit(1);
	
	$Q = $this->db->get('sku_tilcode');
	
	if($Q->num_rows() > 0){
	    $data = $Q->row_array();
	}
	
	$Q->free_result();
	return $data;
   }
   
   function hapus()
    {
        $sql = "TRUNCATE TABLE sku_tilcode";
			
	$query = $this->db->query($sql);    
    }
    
    function updates($dataarray)
    {
        for($i=0;$i<count($dataarray);$i++){
            $data = array(
                'nama'=>$dataarray[$i]['nama'],
                'alamat'=>$dataarray[$i]['alamat'],
		'plu'=>$dataarray[$i]['plu']
        );
	}
	
	$data['plu'] = $a;
	
	$query = $this->db->join('plu_tab', 'user.plu = plu_tab.plu');
		 $this->db->set($a , 'plu_tab.alias');
		 $this->db->update('user',$a);
	
	return $query->result();
	
    }
    
    function generates()
    {
        $sql = "UPDATE produk t1 
	        INNER JOIN kategori t2 
                 ON t1.kategori_id = t2.kode_kategori
		SET t1.kategori_id = t2.id_kategori, t1.url_produk = REPLACE(t1.plu_descriptor, ' ', '_');
		";
		
	$query = $this->db->query($sql);    
    }
    
    function generates_url()
    {
        $sql = "UPDATE produk SET url_produk = REPLACE(plu_descriptor, ' ', '_');";
	
	$query = $this->db->query($sql);    
    }
    
    function search_produk_imp($dataarray){
	for($i=1;$i<count($dataarray);$i++){
	      $search = array(
		  'plu'=>$dataarray[$i]['plu']
	      );
	}
	  
	$data = array();
	    $this->db->where($search);
	    $this->db->limit(1);
	
	$Q = $this->db->get('produk');
	
	if($Q->num_rows() > 0){
	    $data = $Q->row_array();
	}
	
	$Q->free_result();
	return $data;
   }
   
   function update_produk($dataarray)
    {
//        for($i=1;$i<count($dataarray);$i++){
//            $data = array(
//                'plu'=>$dataarray[$i]['plu'],
//		'plu_descriptor'=>$dataarray[$i]['plu_descriptor'],
//		'kategori_id'=>$dataarray[$i]['kategori_id'],
//		'harga_jual'=>$dataarray[$i]['harga_jual']
//            );
//            $param = array(
//               'plu'=>$dataarray[$i]['plu']
//            );
//            $this->db->where($param);
//           return $this->db->update('produk',$data);   
//        }
	$this->tambah_produk($dataarray);
    }
    
    function tambah_produk($dataarray)
    {
        $query_string = "UPDATE produk SET status_produk = '0'";
	$query = $this->db->query($query_string);
	
	for($i=0;$i<count($dataarray);$i++){
            $data = array(
		'plu'=>$dataarray[$i]['plu'],
		'plu_descriptor'=>$dataarray[$i]['plu_descriptor'],
		'kategori_id'=>$dataarray[$i]['kategori_id'],
		'harga_jual'=>$dataarray[$i]['harga_jual']
            );
	//$this->db->insert('produk', $data);
	
	//$query_string = "INSERT INTO produk (plu, plu_descriptor, kategori_id, harga_jual) VALUES ('".$data['plu']."', ".$this->db->escape($data['plu_descriptor']).",'".$data['kategori_id']."', ".$data['harga_jual'].") ON DUPLICATE KEY UPDATE plu_descriptor=".$this->db->escape($data['plu_descriptor']).",kategori_id='".$data['kategori_id']."', harga_jual = ".$data['harga_jual']."";
	$query_string = "REPLACE INTO produk (plu, plu_descriptor, kategori_id, harga_jual, status_produk) VALUES ('".$data['plu']."', ".$this->db->escape($data['plu_descriptor']).",'".$data['kategori_id']."', ".$data['harga_jual'].",'1')";
	$query = $this->db->query($query_string); 
	
	}
    }
    
    function kosong()
    {
        $sql = "TRUNCATE TABLE produk";
	
	$query = $this->db->query($sql);    
    }
    
    function log_import($username)
    {
	$this->load->helper('date');
	$datestring = "%Y-%m-%d %H:%i:%a";
	$time = time();
	
	$waktu = mdate($datestring, $time);
	
	$this->db->where('username', $username);
	return $this->db->update('user', array('import_time' => $waktu));
	
    }
    
}
?>