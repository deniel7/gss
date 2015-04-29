<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Produk_m extends MY_Model {
    private $tabel_foto = 'foto_produk';
    
    public function __construct(){
        parent::__construct();
        parent::set_table('DC_STOCK_MASTER','PLU');
	
	
    }
    
    public function get_all() {
        $this->db->order_by('kategori_id');
        $this->db->join('kategori','kategori.id_kategori=produk.kategori_id');
        return parent::get_all();

    }
    
    function get_all_page($limit1='',$limit2=''){
			$data = array();
			$sql = "SELECT * FROM produk a JOIN kategori b WHERE a.kategori_id = b.id_kategori LIMIT ".$limit2;
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
    
    public function get_all_produk(){
        $data = array();
        $this->db->where(array('produk.topsales'=>'1','produk.status_produk'=>'1'));
        $i=0;
        
        foreach ($this->get_all() as $item){
            
            $data[$i] = $item;
            $this->db->where(array('produk_id'=>$item->id_produk,'default'=>'1'));
            
            if($this->db->get('foto_produk')->num_rows() > 0){
                $this->db->where(array('produk_id'=>$item->id_produk,'default'=>'1'));
                $foto = $this->db->get('foto_produk')->result();
                
                foreach ($foto as $pic) {
                    $data[$i]->image = $pic->image;
                    $data[$i]->thumb = $pic->thumb;
                }
            
            }else{
                $data[$i]->image = '';
                $data[$i]->thumb = '';
            }
            $i++;
        }
        return $data;
    }
    
    public function get_all_produk_sup(){
        $data = array();
        //$this->db->where(array('produk.status_produk'=>'1'));
        
	
	    $this->db->join('foto_produk b','b.produk_id = a.id_produk');
	    $this->db->from('produk a');
	    $this->db->where(array('a.status_produk'=>'1'));
	    $this->db->join('kategori c','c.id_kategori = a.kategori_id');
	    $this->db->join('kategori d','d.id_kategori = c.parent');
	    $this->db->join('kategori e','e.id_kategori = d.parent');
	    $this->db->where(array('e.id_kategori'=>'151'));
	    $this->db->where(array('b.default'=>'1'));
	    $this->db->order_by('Rand()');
	    $this->db->limit(25);
	    $query = $this->db->get();
	    $i=0;
        
        foreach ($query->result() as $item){
            
            $data[$i] = $item;
            $this->db->where(array('produk_id'=>$item->id_produk,'default'=>'1'));
            
	    
            if($this->db->get('foto_produk')->num_rows() > 0){
                $this->db->where(array('produk_id'=>$item->id_produk,'default'=>'1'));
                $foto = $this->db->get('foto_produk')->result();
                
                foreach ($foto as $pic) {
                    $data[$i]->image = $pic->image;
                    $data[$i]->thumb = $pic->thumb;
                }
            
            }else{
                $data[$i]->image = '';
                $data[$i]->thumb = '';
            }
            $i++;
        }
        return $data;
    }
    
    public function get_all_produk_fash(){
        $data = array();
        //$this->db->where(array('produk.status_produk'=>'1'));
        
	
	    $this->db->join('foto_produk b','b.produk_id = a.id_produk');
	    $this->db->from('produk a');
	    $this->db->where(array('a.status_produk'=>'1'));
	    $this->db->join('kategori c','c.id_kategori = a.kategori_id');
	    $this->db->join('kategori d','d.id_kategori = c.parent');
	    $this->db->join('kategori e','e.id_kategori = d.parent');
	    $this->db->where(array('e.id_kategori'=>'39'));
	    $this->db->where(array('b.default'=>'1'));
	    $this->db->order_by('Rand()');
	    $this->db->limit(25);
	    $query = $this->db->get();
	    //echo $this->db->last_query();
	    $i=0;
        
        foreach ($query->result() as $item){
            
            $data[$i] = $item;
            $this->db->where(array('produk_id'=>$item->id_produk,'default'=>'1'));
            
	    
            if($this->db->get('foto_produk')->num_rows() > 0){
                $this->db->where(array('produk_id'=>$item->id_produk,'default'=>'1'));
                $foto = $this->db->get('foto_produk')->result();
                
                foreach ($foto as $pic) {
                    $data[$i]->image = $pic->image;
                    $data[$i]->thumb = $pic->thumb;
                }
            
            }else{
                $data[$i]->image = '';
                $data[$i]->thumb = '';
            }
            $i++;
        }
        return $data;
    }
    
    public function get_all_produk_dep(){
                $kat = $this->uri->segment(3,0);
                //$string_query           = "select * from produk a,kategori b, foto_produk c Where a.kategori_id = b.id_kategori AND a.id_produk = c.produk_id AND c.default = 1 AND b.url =".$this->uri->segment(3,0).";
		$string_query           = "SELECT * FROM produk a 
					    JOIN kategori b ON a.kategori_id = b.id_kategori 
					    JOIN kategori c ON c.id_kategori = b.parent
					    JOIN kategori d ON d.id_kategori = c.parent
					    JOIN foto_produk e ON  a.id_produk = e.produk_id 
					    WHERE e.default = 1 
					    AND status_produk = 1 
					    AND d.url = '$kat'";
                $query          	= $this->db->query($string_query);              
		
                $config['base_url']     = base_url().'/store/department/'.$this->uri->segment(3,0);
                $config['total_rows']	= $query->num_rows();  
		$config['per_page']     = '9';  
		$num            	= $config['per_page'];  
		$config['uri_segment']  = 4; 
                $offset         	= $this->uri->segment(4,0);  
		$offset         	= ( ! is_numeric($offset) || $offset < 1) ? 0 : $offset;  
		  
		if(empty($offset))  
		{  
		    $offset=0;  
		}  
		  
		
                $this->pagination->initialize($config);         
		
		$data= $this->db->query($string_query." limit $offset,$num");    
		
                return $data->result();
    }
    
    public function get_link_div(){
	$kat = $this->uri->segment(3,0);
	
	$data = array();
	$sql = "SELECT DISTINCT a.nama_kategori, a.url, b.nama_kategori AS p
		FROM kategori a
		JOIN kategori b ON b.id_kategori = a.parent
		WHERE a.url ='".$kat."'";
	
	$query = $this->db->query($sql);    
	//echo $this->db->last_query();
	//$data = $query->row();
	
	return $query;
	
    }
    
    public function get_all_produk_div(){
                $kat = $this->uri->segment(3,0);
                //$string_query           = "select * from produk a,kategori b, foto_produk c Where a.kategori_id = b.id_kategori AND a.id_produk = c.produk_id AND c.default = 1 AND b.url =".$this->uri->segment(3,0).";
		$string_query           = "SELECT * FROM produk a 
					    JOIN kategori b ON a.kategori_id = b.id_kategori 
					    JOIN kategori c ON c.id_kategori = b.parent
					    JOIN foto_produk e ON  a.id_produk = e.produk_id 
					    WHERE e.default = 1 
					    AND status_produk = 1 
					    AND c.url = '$kat'";
                $query          	= $this->db->query($string_query);              
		
                $config['base_url']     = base_url().'/store/divisi/'.$this->uri->segment(3,0);
                $config['total_rows']	= $query->num_rows();  
		$config['per_page']     = '9';  
		$num            	= $config['per_page'];  
		$config['uri_segment']  = 4; 
                $offset         	= $this->uri->segment(4,0);  
		$offset         	= ( ! is_numeric($offset) || $offset < 1) ? 0 : $offset;  
		  
		if(empty($offset))  
		{  
		    $offset=0;  
		}  
		  
		
                $this->pagination->initialize($config);         
		
		$data= $this->db->query($string_query." limit $offset,$num");    
		
                return $data->result();
    }
    
    public function get_all_produk2(){
                $kat = $this->uri->segment(3,0);
                //$string_query           = "select * from produk a,kategori b, foto_produk c Where a.kategori_id = b.id_kategori AND a.id_produk = c.produk_id AND c.default = 1 AND b.url =".$this->uri->segment(3,0).";
		$string_query           = "select * from produk a,kategori b, foto_produk c Where a.kategori_id = b.id_kategori AND a.id_produk = c.produk_id AND c.default = 1 AND status_produk = 1 AND b.url = '$kat'";
                $query          	= $this->db->query($string_query);              
		
                $config['base_url']     = base_url().'/store/kategori/'.$this->uri->segment(3,0);
                $config['total_rows']	= $query->num_rows();  
		$config['per_page']     = '9';  
		$num            	= $config['per_page'];  
		$config['uri_segment']  = 4; 
                $offset         	= $this->uri->segment(4,0);  
		$offset         	= ( ! is_numeric($offset) || $offset < 1) ? 0 : $offset;  
		  
		if(empty($offset))  
		{  
		    $offset=0;  
		}  
		  
		
                $this->pagination->initialize($config);         
		
		$data= $this->db->query($string_query." limit $offset,$num");    
		
                return $data->result();
    }
    
    
    public function get_link_map(){
	$kat = $this->uri->segment(3,0);
	
	$data = array();
	$sql = "SELECT a.nama_kategori, a.url, b.nama_kategori AS p, b.url AS p_url, c.nama_kategori AS gp, c.url AS gp_url
		FROM kategori a
		JOIN kategori b ON b.id_kategori = a.parent
		JOIN kategori c ON c.id_kategori = b.parent
		WHERE a.url ='".$kat."'";
	
	$query = $this->db->query($sql);    
	//echo $this->db->last_query();
	//$data = $query->row();
	
	return $query;
	
    }
    
    public function get_link_subdiv(){
	$kat = $this->uri->segment(3,0);
	
	$sql = "SELECT DISTINCT a.url FROM kategori a
		JOIN kategori b ON b.id_kategori = a.parent
		JOIN produk c ON a.id_kategori = c.kategori_id
		JOIN foto_produk d ON d.produk_id = c.id_produk
		WHERE b.url = '".$kat."'"; 
	
	$query = $this->db->query($sql);    
	
	return $query;
	
    }
    
    public function get_link_subdep(){
	$kat = $this->uri->segment(3,0);
	
	$sql = "SELECT DISTINCT b.url FROM kategori a
		JOIN kategori b ON b.id_kategori = a.parent
		JOIN kategori d ON d.id_kategori = b.parent
		JOIN produk c ON a.id_kategori = c.kategori_id
		JOIN foto_produk e ON c.id_produk = e.produk_id
		WHERE d.url = '".$kat."'"; 
	
	$query = $this->db->query($sql);    
	
	return $query;
	
    }
    
    public function get_recomended_produk($id_produk){
        $data = array();
        $this->db->join('produk b','b.kategori_id = a.kategori_id');
	$this->db->join('foto_produk c','c.produk_id = b.id_produk');
	$this->db->from('produk a');
	$this->db->where(array('a.id_produk'=>$id_produk,'a.status_produk'=>'1'));
	$this->db->where(array('c.default'=>'1'));
	$this->db->order_by('Rand()');
	$this->db->limit(5);
        $i=0;
        $query = $this->db->get();
	
        foreach ($query->result() as $item){
            
            $data[$i] = $item;
            $this->db->where(array('produk_id'=>$item->id_produk,'default'=>'1'));
            
            if($this->db->get('foto_produk')->num_rows() > 0){
                $this->db->where(array('produk_id'=>$item->id_produk,'default'=>'1'));
                $foto = $this->db->get('foto_produk')->result();
                
                foreach ($foto as $pic) {
                    $data[$i]->image = $pic->image;
                    $data[$i]->thumb = $pic->thumb;
                }
            
            }else{
                $data[$i]->image = '';
                $data[$i]->thumb = '';
            }
            $i++;
        }
        return $data;
    }
    
    
    function count_empty_name(){
			
			$sql = "SELECT COUNT(nama_produk) FROM produk WHERE nama_produk IS NULL OR nama_produk =''";
			
			$query = $this->db->query($sql);    
			$data = $query->row();
			
			return $data;
    }
    
    function get_all_empty_name($limit1='',$limit2=''){
			$data = array();
			$sql = "SELECT * FROM produk a JOIN kategori b
				WHERE a.kategori_id = b.id_kategori
				AND a.nama_produk = '' OR nama_produk IS NULL LIMIT ".$limit2;
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
    
    function count_empty_pic(){
			
			$sql = "SELECT COUNT(id_produk) FROM produk
				LEFT JOIN foto_produk ON foto_produk.produk_id = produk.id_produk
				WHERE
				foto_produk.produk_id IS NULL";
			
			$query = $this->db->query($sql);    
			$data = $query->row();
			
			return $data;
    }
    
    function count_topsales(){
			
			$sql = "SELECT COUNT(topsales) FROM produk
				WHERE
				produk.topsales = '1'";
			
			$query = $this->db->query($sql);    
			$data = $query->row();
			
			return $data;
			
			
    }
    
    function get_all_empty_pic($limit1='',$limit2=''){
			$data = array();
			$sql = "SELECT * FROM produk
				LEFT JOIN foto_produk ON foto_produk.produk_id = produk.id_produk
				LEFT JOIN kategori ON produk.kategori_id = kategori.id_kategori
				WHERE
				foto_produk.produk_id IS NULL LIMIT ".$limit2;
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
    
    function get_topsales($limit1='',$limit2=''){
			$data = array();
			$sql = "SELECT * FROM produk
				LEFT JOIN foto_produk ON foto_produk.produk_id = produk.id_produk
				LEFT JOIN kategori ON produk.kategori_id = kategori.id_kategori
				WHERE
				produk.topsales = '1' LIMIT ".$limit2;
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
    
    /*SEKSI GAMBAR*/
    
    public function tambah_gambar($data = array()){
        $this->db->insert($this->tabel_foto,$data);
        $id = $this->db->insert_id();
    }
    
    public function get_gambar($id = 0) {
        $this->db->where(array('produk_id'=>$id));
        return $this->db->get($this->tabel_foto)->result();
    }
    
    public function set_default($id = 0, $id_foto = 0) {
        $data1 = array('default'=>0);
        $this->db->where(array('produk_id'=>$id));
        if($this->db->update($this->tabel_foto,$data1)) {
            $this->_set_to_default($id_foto);
            return true;
        }
        return false;
    }
    
    public function hapus_foto($id_foto= 0){
        $this->db->where(array('id_foto_produk'=>$id_foto));
        $data = $this->db->get($this->tabel_foto)->row();
        if($this->db->delete($this->tabel_foto,array('id_foto_produk'=>$id_foto))) {
            if(file_exists($data->image)){
                unlink($data->image);
            }
            if(file_exists($data->thumb)){
                unlink($data->thumb);
            }
        }
    }
    
    private function _set_to_default($id_foto = 0) {
        $data2 = array('default'=>1);
        $this->db->where(array('id_foto_produk'=>$id_foto));
        $this->db->update($this->tabel_foto,$data2);
    }
    
    function getThumbs($limit1='',$limit2=''){
			$data = array();
			$sql = "SELECT * FROM produk a JOIN foto_produk b WHERE a.id_produk = b.produk_id AND thumb <> '' LIMIT ".$limit2;
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
    
    function SearchResult($perPage,$uri,$search_name,$dc_site_code,$store_site_code,$multiuser)
    {
	if($multiuser == 0){
	//$this->db->select('*');
	//$this->db->from('DC_STOCK_MASTER');
	//$this->db->join('MS_MASTER', 'DC_STOCK_MASTER.SUBCLASS = MS_MASTER.MS_CHILD');
	//$this->db->join('STORE_SALES_MASTER', 'DC_STOCK_MASTER.ARTICLE_CODE = STORE_SALES_MASTER.ARTICLE_CODE');
	//$this->db->where('DC_SITE_CODE',$dc_site_code);
	//$this->db->where('STORE_SITE_CODE',$store_site_code);
	//$this->db->group_by('DC_STOCK_MASTER.ARTICLE_CODE');
	$st="ART_ATTRIB.END_DATE >= CURDATE() AND ART_ATTRIB.START_DATE <= CURDATE()";
	  
	$this->db->select('*');
	$this->db->from('DC_STOCK_MASTER');
	$this->db->join('ART_ATTRIB', 'DC_STOCK_MASTER.ARTICLE_CODE = ART_ATTRIB.ART_CODE');
	$this->db->join('DELIVARABLE_MASTER', 'DC_STOCK_MASTER.ARTICLE_CODE = DELIVARABLE_MASTER.ARTICLE_CODE');
	$this->db->join('STORE_SALES_MASTER', 'DC_STOCK_MASTER.ARTICLE_CODE = STORE_SALES_MASTER.ARTICLE_CODE');
	$this->db->where('DC_STOCK_MASTER.DC_SITE_CODE',$dc_site_code);
	$this->db->where('STORE_SALES_MASTER.STORE_SITE_CODE',$store_site_code);
	$this->db->where($st, NULL, FALSE);
	
	}else{
	    //echo "<br/> ini juga multiuser loh";
	    
	    $this->db->select('*');
	    $this->db->from('DC_STOCK_MASTER');
	    $this->db->join('ART_ATTRIB', 'DC_STOCK_MASTER.ARTICLE_CODE = ART_ATTRIB.ART_CODE');
	    $this->db->join('DELIVARABLE_MASTER', 'DC_STOCK_MASTER.ARTICLE_CODE = DELIVARABLE_MASTER.ARTICLE_CODE');
	    $this->db->join('STORE_SALES_MASTER', 'DC_STOCK_MASTER.ARTICLE_CODE = STORE_SALES_MASTER.ARTICLE_CODE');
	    $this->db->where($st, NULL, FALSE);
	}
	
	
        if($search_name !='')
	{
	    $this->db->like('DC_STOCK_MASTER.ARTICLE_CODE', strtoupper($search_name));
	    //$this->db->or_like('DC_STOCK_MASTER.PLU',$search_name);
	    //$this->db->group_by('DC_STOCK_MASTER.ARTICLE_CODE');
	    $this->db->or_like('DC_STOCK_MASTER.ARTICLE_DESC', strtoupper($search_name));
	    //echo $this->db->last_query();
	    
	}
	
         
	 $this->db->group_by('DC_STOCK_MASTER.ARTICLE_CODE');
         
	 $data = $this->db->get('', $perPage, $uri);
	    
         if($data->num_rows() > 0)
            return $data->result();
         else
            return null;
    }
    
    function list_kat($id_kategori,$nama_kategori){
        $result = array();
        $array_keys_values = $this->db->query("select * from kategori WHERE status='1'");
        foreach($array_keys_values ->result() as $row){
            $result[$row->id_kategori] = $row->nama_kategori;
        }
        //$results = array_merge(array('' => '- Pilih Kategori -'), $result);
        
        return $result;
    }
    
    function SearchResult_front($perPage,$uri,$search_name, $filterId=null,$search_dc_site_code, $search_store_site_code)
    {
		$this->db->select('*');
		$this->db->from('DC_STOCK_MASTER');
		$this->db->join('MS_MASTER', 'DC_STOCK_MASTER.SUBCLASS = MS_MASTER.MS_CHILD');
		$this->db->join('STORE_SALES_MASTER', 'DC_STOCK_MASTER.ARTICLE_CODE = STORE_SALES_MASTER.ARTICLE_CODE');
		$this->db->where('DC_SITE_CODE',15199);
		$this->db->where('STORE_SITE_CODE',15102);
		
		
		if (!empty($filterId))
		{
			$this->db->where_in('DC_STOCK_MASTER.ARTICLE_CODE', $filterId);
		}
		else if(!empty($search_name))
		{
			$this->db->like("CONCAT(DC_STOCK_MASTER.PLU)",$search_name);  
		}		

		//$this->db->order_by('id_produk','asc');
		//$data = $this->db->get('', $perPage, $uri);
		
		$this->db->limit($perPage, $uri);
		
		$data = $this->db->get();
		echo $this->db->last_query();
		if($data->num_rows() > 0)
		{
			return $data->result();
		}
		else
		{
			return null;
		}
    }
    
    
    
    function who_imp(){
	$sql = "SELECT * FROM `user` WHERE import_time = (SELECT MAX(`import_time`) AS import_time FROM (`user`))";
	
	$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
	return $data;
	
	
	//$this->db->select_max('import_time');
	//$this->db->select('*');
	//$this->db->from('user');
	//$this->db->where('import_time', $sql);
	//$data = $this->db->get();
	//
	//echo $this->db->last_query();
	
	//return $data->result();
	//$data = $query->row();
	//		
	//		return $data;
	
//	if($data->num_rows() > 0)
//            return $data->result();
//         else
//            return null;
    }
    
    
    //NEW GSS
    
    //Select produk berdasarkan category
    public function get_category_product($dc_site_code,$store_site_code){
                $kat = $this->uri->segment(3,0);
                //$string_query           = "select * from produk a,kategori b, foto_produk c Where a.kategori_id = b.id_kategori AND a.id_produk = c.produk_id AND c.default = 1 AND b.url =".$this->uri->segment(3,0).";
		//$string_query           = "select * from DC_STOCK_MASTER a,MS_MASTER b, STORE_SALES_MASTER c
		//			    Where a.SUBCLASS = b.MS_CHILD
		//			    AND a.ARTICLE_CODE = c.ARTICLE_CODE
		//			    AND a.SUBCLASS = '$kat'
		//			    AND a.DC_SITE_CODE = '$dc_site_code'
		//			    AND c.STORE_SITE_CODE = $store_site_code
		//			    GROUP BY a.ARTICLE_CODE
		//			    ";
					    
		$string_query           = "select * from DC_STOCK_MASTER a,ART_ATTRIB b, STORE_SALES_MASTER c, DELIVARABLE_MASTER d
		
					    Where a.ARTICLE_CODE = b.ART_CODE
					    AND a.ARTICLE_CODE = c.ARTICLE_CODE
					    AND a.ARTICLE_CODE = d.ARTICLE_CODE
					    AND b.ATTRIB_CODE = '$kat'
					    AND a.DC_SITE_CODE = '$dc_site_code'
					    AND c.STORE_SITE_CODE = '$store_site_code'
					    AND CURDATE() BETWEEN b.START_DATE AND b.END_DATE
					    GROUP BY a.ARTICLE_CODE
			    ";
                $query          	= $this->db->query($string_query);              
		
                $config['base_url']     = base_url().'/store/kategori/'.$this->uri->segment(3,0);
                $config['total_rows']	= $query->num_rows();  
		$config['per_page']     = '9';  
		$num            	= $config['per_page'];  
		$config['uri_segment']  = 4; 
                $offset         	= $this->uri->segment(4,0);  
		$offset         	= ( ! is_numeric($offset) || $offset < 1) ? 0 : $offset;  
		  
		if(empty($offset))  
		{  
		    $offset=0;  
		}  
		  
		
                $this->pagination->initialize($config);         
		
		$data= $this->db->query($string_query." limit $offset,$num");    
		//echo $this->db->last_query();
                return $data->result();
    }
    
    public function get_hdr_cat(){
	$kat = $this->uri->segment(3,0);
	
	$data = array();
	$sql = "SELECT a.nama_kategori, a.url, b.nama_kategori AS p, b.url AS p_url, c.nama_kategori AS gp, c.url AS gp_url
		FROM kategori a
		JOIN kategori b ON b.id_kategori = a.parent
		JOIN kategori c ON c.id_kategori = b.parent
		WHERE a.url ='".$kat."'";
	
	$query = $this->db->query($sql);    
	//echo $this->db->last_query();
	//$data = $query->row();
	
	return $query;
	
    }
    
    public function get_by_url($url,$store_site_code,$dc_site_code) {
	$string_query           = "select DISTINCT(a.ARTICLE_CODE),a.PLU,a.ARTICLE_DESC,c.SV,STOCK_QTY,BOOK_QTY, CONFIRM_QTY,SALES_UNIT_PRICE, THUMB, IMG1, IMG2, IMG3, a.STOCK_COST from DC_STOCK_MASTER a,MS_MASTER b, STORE_SALES_MASTER c
				    Where a.SUBCLASS = b.MS_CHILD
				    AND a.ARTICLE_CODE = c.ARTICLE_CODE
				    AND a.DC_SITE_CODE = '$dc_site_code'
				    AND c.STORE_SITE_CODE = $store_site_code
				    AND a.ARTICLE_CODE = $url
				    GROUP BY a.ARTICLE_CODE
					    ";
        $query          	= $this->db->query($string_query);              
	$data= $this->db->query($string_query);   
	
	return $data->result();
    }
    
    public function get_by_url2($url,$store_site_code,$dc_site_code) {
	$string_query           = "select DISTINCT(a.ARTICLE_CODE),c.PLU,c.SV,a.ARTICLE_DESC,STOCK_QTY,SALES_UNIT_PRICE from DC_STOCK_MASTER a,MS_MASTER b, STORE_SALES_MASTER c
				    Where a.SUBCLASS = b.MS_CHILD
				    AND a.ARTICLE_CODE = c.ARTICLE_CODE
				    AND a.DC_SITE_CODE = '$dc_site_code'
				    AND c.STORE_SITE_CODE = $store_site_code
				    AND a.ARTICLE_CODE = $url
				    AND c.SV = 2
					    ";
        $query          	= $this->db->query($string_query);              
	$data= $this->db->query($string_query);   
	
	return $data->result();
    }
    
    public function get_by_url3($url,$store_site_code,$dc_site_code) {
	$string_query           = "select DISTINCT(a.ARTICLE_CODE),c.PLU,c.SV,a.ARTICLE_DESC,STOCK_QTY,SALES_UNIT_PRICE from DC_STOCK_MASTER a,MS_MASTER b, STORE_SALES_MASTER c
				    Where a.SUBCLASS = b.MS_CHILD
				    AND a.ARTICLE_CODE = c.ARTICLE_CODE
				    AND a.DC_SITE_CODE = '$dc_site_code'
				    AND c.STORE_SITE_CODE = $store_site_code
				    AND a.ARTICLE_CODE = $url
				    AND c.SV = 3
					    ";
        $query          	= $this->db->query($string_query);              
	$data= $this->db->query($string_query);   
	
	return $data->result();
    }
    
    public function get_master_produk() {
        
        $data = array();
	$sql = "select * from DC_STOCK_MASTER
		
		";
	    
	    $hasil = $this->db->query($sql);
	    if($hasil->num_rows() > 0){
		$data = $hasil->result();
	    }
	    
	    $hasil->free_result();
	    return $data;
    }
    
    
    
    
    
    
    
}

?>
