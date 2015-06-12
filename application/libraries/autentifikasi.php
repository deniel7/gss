<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('STATUS_ACTIVATED', '1');
define('STATUS_NOT_ACTIVATED', '0');
define('ALLOW', '1');
define('NOT_ALLOW', '0');

Class Autentifikasi {
    private $ci;
    private $error =  array();
    
    public function __construct() {
        $this->ci = & get_instance();
        $this->ci->load->model('user_m');
    }
    
    public function login($user_id,$password) {
	
        if ((strlen($user_id) > 0) AND (strlen($password) > 0)) {
            
	    if ($user = $this->ci->user_m->get_by_userId($user_id)) {

		if ($user->PASSWORD == md5($password)) {
                    $status = 1;
		    $level ='user';
		    
		    $this->ci->session->set_userdata(array(
								'user_id'	=> $user->USER_ID,
								'user_desc'	=> $user->USERNAME,
								'store_site_code'	=> $user->STORE_SITE_CODE,
								'site_desc'	=> $user->SITE_DESC,
								'dc_site_code' => $user->DC_SITE_CODE,
								'dc_supp_code' => $user->DC_SUPP_CODE,
								'multiuser' => $user->MULTIUSER,
								'level'	=> $level,
								'logged_in' => TRUE,
								'status'	=> ($status == 1) ? STATUS_ACTIVATED : STATUS_NOT_ACTIVATED,
					));
                    
                    if($status == 0){
                        $this->error = (array('status'=>'Status belum aktif'));
                    } else {
                        return true;
                    }
                }
                $this->error = array('password'=>'Password Keliru');
            }
            
	    $this->error = array('login'=>'Login Tidak Benar');
        }
        return FALSE;
    }
    
    public function admin_login($user_id,$password) {
	$status =1;
	$level = 'admin';
	
        if ((strlen($user_id) > 0) AND (strlen($password) > 0)) {
            if ($user = $this->ci->user_m->get_adminId($user_id)) {
                if ($user->PASSWORD == md5($password)) {
                    //$this->session->sess_expiration = '7200';
		    $this->ci->session->set_userdata(array(
								'user_id'	=> $user->USER_ID,
								'username'	=> $user->USERNAME,
								'status'	=> ($status == 1) ? STATUS_ACTIVATED : STATUS_NOT_ACTIVATED,
								'level'		=> $level,
								'dc_site_code'	=> $user->STORE_SITE_CODE
								
					));
                }
                $this->error = array('password'=>'Password Keliru');
            }
            $this->error = array('login'=>'Login Tidak Benar');
        }
        return FALSE;
    }
    
    public function ho_login($user_id,$password) {
	$status =1;
	$level = 'admin';
	
        if ((strlen($user_id) > 0) AND (strlen($password) > 0)) {
            if ($user = $this->ci->user_m->get_HoId($user_id)) {
                if ($user->PASSWORD == md5($password)) {
                    //$this->session->sess_expiration = '7200';
		    $this->ci->session->set_userdata(array(
								'user_id'	=> $user->USER_ID,
								'username'	=> $user->USERNAME,
								'status'	=> ($status == 1) ? STATUS_ACTIVATED : STATUS_NOT_ACTIVATED,
								'level'		=> $level,
								'dc_site_code'	=> $user->STORE_SITE_CODE
								
					));
                }
                $this->error = array('password'=>'Password Keliru');
            }
            $this->error = array('login'=>'Login Tidak Benar');
        }
        return FALSE;
    }
    
    public function logout() {
        $this->ci->session->set_userdata(array('user_id' => '', 'username' => '', 'status' => '', 'level' => ''));
		$this->ci->session->sess_destroy();
    }
    
    public function tambah_admin($username,$email,$level,$cabang,$password) {
        $data = array(	
			'username'=>$username, 
			'email'=>$email,
			'level'=>$level,
			'kode_cabang'=>$cabang,
                        'password'=>md5($password)
                        
                        );
        /*echo "username : ".$username;
	echo "<br/>";
	echo "email : ".$email;
	echo "<br/>";
	echo "level : ".$level;
	echo "<br/>";
	echo "cabang : ".$cabang;
	echo "<br/>";
	echo "password : ".$password*/;
	if($this->ci->user_m->cek_username($username) && $this->ci->user_m->cek_email($email)){
            if($this->ci->user_m->insert($data)){
                return true;
            }
        }
        return false;
    }
    
    public function tambah($user_id,$username,$password,$store_site_code) {
        $data = array(	
			'USER_ID'=>$user_id,
			'USERNAME'=>$username, 
                        'PASSWORD'=>md5($password),
                        'STORE_SITE_CODE'=>$store_site_code
			
                        );
        if($this->ci->user_m->cek_userId($user_id)){
            if($this->ci->user_m->insert($data)){
                return true;
            }
        }
        return false;
    }
    
    public function ubah_admin($id,$username,$email,$password,$level,$cabang){
        $data = array( 'username'=>$username,
                        'email'=>$email,
                        'password'=>md5($password),
                        'level'=>$level,
			'kode_cabang' => $cabang
                        );
        if($this->ci->user_m->cek_username($username,TRUE) == $id){
            if($this->ci->user_m->update($id,$data)){
                return true;
            }
        }
        return false;
    }
    
    public function ubah($id,$username,$email,$password,$level){
        $data = array( 'username'=>$username,
                        'email'=>$email,
                        'password'=>md5($password),
                        'level'=>$level,
                        );
        if($this->ci->user_m->cek_username($username,TRUE) == $id){
            if($this->ci->user_m->update($id,$data)){
                return true;
            }
        }
        return false;
    }
    
    public function sudah_login($activated = TRUE) {
        return $this->ci->session->userdata('status') == ($activated ? STATUS_ACTIVATED : STATUS_NOT_ACTIVATED);
	
    }
    
    //CEK LOGIN apakah cabang pusat
    public function sudah_pusat() {
        return $this->ci->session->userdata('kode_cabang') =='PST';
    }
    
    public function role($level = array()) {
        foreach ($level as $key=>$val){
            $status = $this->ci->session->userdata('level') == $val ? ALLOW : NOT_ALLOW;
            if ($status == 1){break;} 
        }
        return $status;
    }
    
    
}

?>