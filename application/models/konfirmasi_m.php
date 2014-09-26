<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Konfirmasi_m extends MY_Model {
    
    public function __construct(){
        parent::__construct();
        //parent::set_table('user_data','id_user_data');
        parent::set_table('konfirmasi','id_konfirmasi');
    }
    
    function insert($insert = array())
    {		
		//$date = date('Y-m-d');
                //$array = array('pembuat'=>$pembuat, 'header'=>$header, 'tanggal'=>$date,
                //               'isi1'=>$isi1, 'isi2'=>$isi2, 'isi3'=>$isi3, 'isi4'=>$isi4,
                //               'detail'=>$detail,'gambar'=>$bg,'id_kategori'=>$kat,'email'=>$email,'telepon'=>$telepon);
		$this->db->set($insert);
		$this->db->insert('konfirmasi');
    }

    function get_all_page($limit1='',$limit2=''){
	$data = array();
	$sql = "SELECT * FROM konfirmasi order by id_konfirmasi DESC LIMIT ".$limit2;
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
    
    function konfirmasi(){
                
                $string_query       	= "select * from konfirmasi order by id_konfirmasi DESC";  
		$query          	= $this->db->query($string_query);              
		
		$config['base_url']     = base_url().'kontens/iklan_kolom_all/'; 
                $config['total_rows']	= $query->num_rows();  
		$config['per_page']     = '6';  
		$num            	= $config['per_page'];  
		$config['uri_segment']  = 3; 
                $offset         	= $this->uri->segment(3,0);  
		$offset         	= ( ! is_numeric($offset) || $offset < 1) ? 0 : $offset;  
		  
		if(empty($offset))  
		{  
		    $offset=0;  
		}  
		  
		//$config['base_url']     = base_url().'index.php/kontens/index/'.$this->uri->segment(3,0)."/".$this->uri->segment(4,0);
                $this->pagination->initialize($config);         
		  
		$data_konfirm= $this->db->query($string_query." limit $offset,$num");    
		//$data_guest['base']	= $this->config->item('base_url');  
	      
		return $data_konfirm;		
                
    }
    
    function SearchResult2($perPage,$uri,$search_tg1,$search_tg2,$search_orderno)
    {
     //$array = array('tanggal <' => $search_tg2);
     
     $this->db->select('*');
     $this->db->from('konfirmasi');
     //$this->db->where('tanggal >=', $search_tg1);
     //$this->db->where('tanggal <=', $search_tg2);
     $this->db->like('order_no', $search_orderno);
     
        if(!empty($search_orderno)){
           
	    $this->db->like("order_no",$search_orderno);
	
	}
	else if (!empty($search_tg1) && !empty($search_tg2)){
	    $this->db->where('tanggal >=', $search_tg1);
	    $this->db->where('tanggal <=', $search_tg2);
	}
         
         $this->db->order_by('id_konfirmasi','desc');
         $data = $this->db->get('', $perPage, $uri);
      
         if($data->num_rows() > 0)
            return $data->result();
         else
            return null;
    }
    
    function SearchResult($perPage,$uri,$search_tg1,$search_tg2,$search_orderno)
    {
     
     $this->db->select('*');
     $this->db->from('konfirmasi');
     
	if (($search_tg1 == 0) || ($search_tg2 == 0)){
		
		$this->db->like('order_no', $search_orderno);
		
	}
        else if (($search_orderno == 0)){
			$this->db->where('tanggal >=', $search_tg1);
			$this->db->where('tanggal <=', $search_tg2);
			
	}else{
			$this->db->like('order_no', $search_orderno);
			$this->db->where('tanggal >=', $search_tg1);
			$this->db->where('tanggal <=', $search_tg2);
			

	}
	
         $this->db->order_by('id_konfirmasi','desc');
         $data = $this->db->get('', $perPage, $uri);
      
         if($data->num_rows() > 0)
            return $data->result();
         else
            return null;
    }
    
    function count_new_konfirmasi()
    {	
		$this->db->select('COALESCE(COUNT(id_konfirmasi),0) konfirmasi_count', FALSE);
		$this->db->from('konfirmasi');
		$this->db->where_in('status', '0');
				
		$query = $this->db->get();
		
		//echo $this->db->last_query();		
		
		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				return $row['konfirmasi_count'];
			}
		}
		
		return 0;
    }

//CEK STATUS KONFIRMASI sudah / blom    
//    function cek_k($id = 0)
//    {
//	
//	$this->db->select('order_no');
//	$this->db->from('order');
//	$this->db->where('id_order',$id);
//	$query = $this->db->get();
//	
//	if ($query->num_rows() > 0)
//	{
//		foreach ($query->result_array() as $row)
//		{
//			$a = $row['order_no'];
//		}
//	}
//	
//	$this->db->select('order_no');
//	$this->db->from('konfirmasi');
//	$this->db->where('order_no',$a);
//	$this->db->where('status','1');
//	$q = $this->db->get();
//	
//	if ($q->num_rows() > 0)
//	{
//		foreach ($query->result_array() as $r)
//		{
//			return $r['order_no'];
//		}
//	}
//	
//	return 0;
//	
//    }
}
?>
