<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Konfirmasi_pesanan_m extends MY_Model {
    
    public function __construct(){
        parent::__construct();
        //parent::set_table('user_data','id_user_data');
        parent::set_table('order','id_order');
    }
    
    public function insert($order_no, $nama_pengirim,$id)
    {		
	$array = array('status_order'=>'4', 'pengirim'=>$nama_pengirim);

        $query = $this->db->where('order_no',$order_no)
			  ->where('user_id',$id)
			  ->update('order',$array);
	
	if($query == 0 ){
	    $this->data->error = '<div class="error">Konfirmasi Gagal</div>';
	}
    }
}
?>