<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_m extends MY_Model {
    
    public function __construct(){
        parent::__construct();
        parent::set_table('USER_MASTER','ID_USER');
    }
    
    public function get_by_username($username) {
        if($query = parent::get_by(array('username'=>$username))){
            if ($query->id_user != NULL) return $query;
        }
        return false;
    }
    
    public function cek_username($username,$self = FALSE){
        if($data = parent::get_by(array('username'=>$username))){
            if($self){
                return $data->id_user;
            }else{
                return false;   
            }
        }
        return true;
    }
    
    public function cek_userId($user_id,$self = FALSE){
        if($data = parent::get_by(array('USER_ID'=>$user_id))){
            if($self){
                return $data->ID_USER;
            }else{
                return false;   
            }
        }
        return true;
    }
    
    public function hapus($id) {
        if(parent::delete($id)) {
            if($this->db->table_exists('user_data')){
                $this->db->where(array('user_id'=>$id));   
                $this->db->delete('user_data');
            }
            return true;
        }
        return false;
    }
    
    function get_all_page($limit1='',$limit2=''){
			$data = array();
			$sql = "SELECT * FROM user order by id_user DESC LIMIT ".$limit2;
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
    
    function count_new_user()
    {	
		$this->db->select('COALESCE(COUNT(id_user),0) user_count', FALSE);
		$this->db->from('user');
		$this->db->where_in('status', '0');
				
		$query = $this->db->get();
		
		//echo $this->db->last_query();		
		
		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				return $row['user_count'];
			}
		}
		
		return 0;
    }
    
    function SearchResult($perPage,$uri,$search_name,$search_mem,$level)
    {
     $this->db->select('*');
     $this->db->from('user');
     //$this->db->join('user_data', 'user.id_user = user_data.user_id');
     
        if($search_name !=NULL && $search_mem == NULL){
           
	   $this->db->like("username",$search_name);
            //echo"a"; 
	
	}else if($search_name ==NULL && $search_mem != NULL){
            $this->db->like("membercard",$search_mem);
            //echo"b";
        
        }else if($search_name ==NULL && $search_mem == NULL && $level != NULL){
            $this->db->like("level",$level);
            //echo"c";
        }
        
        else{
            $this->db->like("CONCAT(username)",$search_name);
            $this->db->like("membercard",$search_mem);
            //echo"d";
        }
         
         $this->db->order_by('id_user','asc');
         $data = $this->db->get('', $perPage, $uri);
      
         if($data->num_rows() > 0)
            return $data->result();
         else
            return null;
    }
    
    function count_n_user()
    {
			
		$sql = "SELECT COUNT(status) status_count FROM `user`
				WHERE
				status = '0'";
		
		//$this->db->select('COALESCE(COUNT(`status`),0) status_count2', FALSE);
		//$this->db->from('`user`');			
		//$this->db->where('`status`', 0);
		$this->db->from('user');
		
		$query2 = $this->db->get();
		echo $this->db->last_query();
		var_dump($query2->result_array);			
		
		if ($query2->num_rows() > 0)
		{
			//echo $this->db->last_query();
			
			foreach ($query2->result_array as $row)
			{
				return $row['status_count2'];
			}
		}
		
		return 0;
    }
    
    
    //GRIYATRON SUPPORT SYSTEM
    //public function get_by_userId($userId) {
    //    if($query = parent::get_by(array('USER_ID'=>$userId))){
    //        if ($query->USER_ID != NULL) return $query;
    //    }
    //    return false;
    //}
    
    public function site_master(){
	$data = array();
        $array_keys_values = $this->db->query("select * from SITE_MASTER");
        foreach($array_keys_values ->result() as $row){
            $data[$row->SITE_CODE] = $row->SITE_DESC;
        }
        return $data;		
	
    }
    
    public function dc_site_code(){
	$data = array();
        $array_keys_values = $this->db->query("select * from SITE_MASTER WHERE SITE_TYPE = 0");
        
	$data[15100] = 'USER HO';
	foreach($array_keys_values ->result() as $row){
            $data[$row->SITE_CODE] = $row->SITE_STORE_CODE;
        }
        return $data;		
	
    }
    
    public function get_by_userId($user_id){
			
			$sql = "SELECT *
				FROM USER_MASTER a
				JOIN SITE_MASTER b ON a.STORE_SITE_CODE = b.SITE_CODE
				JOIN DELIVARABLE_MASTER c ON a.STORE_SITE_CODE = c.STORE_SITE_CODE
				WHERE
				a.USER_ID = $user_id";
			
			$query = $this->db->query($sql);    
			$data = $query->row();
			
			return $data;
			
			
    }
    
    public function get_HoId($user_id){
			
			$sql = "SELECT *
				FROM USER_MASTER 
				WHERE
				USER_ID = $user_id
				AND STORE_SITE_CODE = 15100";
			
			
			$query = $this->db->query($sql);    
			$data = $query->row();
			//echo $this->db->last_query();
			return $data;
			
			
    }
    
    public function get_adminId($user_id){
			
			
			$sql = "SELECT *
				FROM USER_MASTER a
				JOIN SITE_MASTER b ON a.STORE_SITE_CODE = b.SITE_CODE				
				WHERE
				b.SITE_TYPE = 0 AND 
				a.USER_ID = $user_id";
			
			$query = $this->db->query($sql);    
			$data = $query->row();
			
			return $data;
			
			
    }
    
    public function get_ho($user_id){
			
			$sql = "SELECT STORE_SITE_CODE
				FROM USER_MASTER
				WHERE
				USER_ID = $user_id";
			
			$query = $this->db->query($sql);    
			$data = $query->row();
			//echo $user_id;
			
			//echo $this->db->last_query();
			
			return $data->STORE_SITE_CODE;
			
			
    }
    
    
    public function get_site_desc($ssc){
			
			$sql = "SELECT *
				FROM SITE_MASTER
				WHERE
				SITE_CODE = $ssc";
			
			$query = $this->db->query($sql);    
			$data = $query->row();
			
			return $data;
			
			
    }
    
    public function get_cabang_desc($store_site_code){
			
			$sql = "SELECT *
				FROM SITE_MASTER 
				WHERE
				SITE_CODE = $store_site_code
				";
			
			$query = $this->db->query($sql);    
			$data = $query->row();
			
			
			return $data->SITE_DESC;
			
			
    }
    
}
?>
