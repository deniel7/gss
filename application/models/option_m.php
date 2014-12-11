<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Option_m extends MY_Model {
    
    private $tabel_foto = 'banner';
    
    public function __construct(){
        parent::__construct();
        parent::set_table('BIAYA','id');
    }
    
    
    public function gbr_banner(){

        $gbr = $this->db->get('banner');
    
        return $gbr;

    }
    
    function tambah_gbr($uploadedFiles,$thumb)
    {		
        $array = array('image'=>$uploadedFiles,'thumb'=>$thumb);
    
        $this->db->set($array);
    
        $this->db->insert('banner',$array);
	
    }
    
    
    function get_data_banner(){

    $data_gbr = $this->db->get_where('banner',array('id_banner'=>$this->uri->segment(3)));

    return $data_gbr;

    }
    
    
    public function hapus($id) {
        
    
        $this->db->where(array('id_banner'=>$id));
        
        $data = $this->db->get($this->tabel_foto)->row();
        //echo $data->image;
        
        if($this->db->delete($this->tabel_foto,array('id_banner'=>$id))) {
            
            unlink('./images/banner/'.$data->image);
            unlink('./images/banner/thumb/'.$data->thumb);
            
        }
    
    }
    
    function count_banner()
    {	
		$this->db->select('COALESCE(COUNT(id_banner),0) banner_count', FALSE);
		$this->db->from('`banner`');
				
		$query = $this->db->get();
		
		
		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				return $row['banner_count'];
			}
		}
		
		return 0;
    }
    
    public function option(){

        //$query = $this->db->get('option');
        //$query->result_array();
        
        $this->db->select('*', FALSE);
	$this->db->from('`BIAYA`');
        
        $query = $this->db->get();
        
        if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				return $row['biaya'];
			}
		}
        
        return 0;

    }
    
    public function ubah($id,$biaya){
        $data = array( 'biaya'=>$biaya
                        );
        
            if($this->option_m->update($id,$data)){
                return true;
            }
        
        return false;
    }
    
    
    
    
    public function biaya(){
	$data = array();
        $array_keys_values = $this->db->query("select * from BIAYA");
        foreach($array_keys_values ->result() as $row){
            $data[$row->biaya] =  $row->region.' = Rp. '.$row->biaya;
        }
        return $data;		
	
    }
    
}
?>