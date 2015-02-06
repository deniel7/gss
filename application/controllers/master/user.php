<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends MY_Controller {
    private $judul = 'User';
    
    private $rules = array (
                        array(
                                 'field'   => 'username', 
                                 'label'   => 'Username', 
                                 'rules'   => 'alpha_numeric|required|max_length[15]|min_length[6]'
                              ),
                        array(
                                 'field'   => 'email', 
                                 'label'   => 'Email', 
                                 'rules'   => 'valid_email|required'
                              ),
                        array(
                                 'field'   => 'password', 
                                 'label'   => 'Password', 
                                 'rules'   => 'alpha_numeric|required|max_length[20]|min_length[6]'
                              ),
                        array(
                                 'field'   => 'cabang', 
                                 'label'   => 'Cabang', 
                                 'rules'   => 'alpha_numeric|required'
                              ),
                        array(
                                 'field'   => 'level', 
                                 'label'   => 'Level', 
                                 'rules'   => 'alpha_numeric|required'
                              ),
                        
                        array(
                                 'field'   => 'conf_password', 
                                 'label'   => 'Confirm Password', 
                                 'rules'   => 'alpha_numeric|required|max_length[20]|matches[password]'
                              )
                         );
    private $edit_rules = array (
                        array(
                                 'field'   => 'username', 
                                 'label'   => 'Username', 
                                 'rules'   => 'alpha_numeric|required|max_length[15]|min_length[6]'
                              ),
                        array(
                                 'field'   => 'email', 
                                 'label'   => 'Email', 
                                 'rules'   => 'valid_email|required'
                              ),
                        array(
                                 'field'   => 'new_password', 
                                 'label'   => 'Password Baru', 
                                 'rules'   => 'alpha_numeric|required|max_length[20]|min_length[6]'
                              ),
                        array(
                                 'field'   => 'conf_password', 
                                 'label'   => 'Confirm Password', 
                                 'rules'   => 'alpha_numeric|required|max_length[20]|matches[new_password]'
                              )
                         );
    private $login_rules = array (
                        array(
                                 'field'   => 'username', 
                                 'label'   => 'Username', 
                                 'rules'   => 'alpha_numeric|required|max_length[15]|min_length[6]'
                              ),
                        array(
                                 'field'   => 'password', 
                                 'label'   => 'Password', 
                                 'rules'   => 'alpha_numeric|required|max_length[20]|min_length[6]'
                              )
                         );
    private $profile_rules = array (
                        array(
                                 'field'   => 'nama_depan', 
                                 'label'   => 'Nama Depan', 
                                 'rules'   => 'alpha|required'
                              ),
                        array(
                                 'field'   => 'nama_belakang', 
                                 'label'   => 'Nama Belakang', 
                                 'rules'   => 'alpha'
                              ),
                        array(
                                 'field'   => 'alamat', 
                                 'label'   => 'Alamat', 
                                 'rules'   => 'utf8|required|max_length[200]'
                              ),
                        array(
                                 'field'   => 'phone', 
                                 'label'   => 'Telephone', 
                                 'rules'   => 'numeric'
                              ),
                        array(
                                 'field'   => 'kode_pos', 
                                 'label'   => 'Kode Pos', 
                                 'rules'   => 'numeric'
                              )
                         );
    
    public function __construct() {
        parent::__construct();
        parent::set_judul($this->judul);
        parent::default_meta();
        $this->load->model('user_m');
        $this->load->model('pesanan_m');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->form_validation->set_error_delimiters('<p class="msg warning">', '</p>');
        
        $this->data->metadata = $this->template->get_metadata();
        $this->data->judul = $this->template->get_judul();
        
        $this->data->username = $this->session->userdata('username');
        $this->data->cabang = $this->session->userdata('kode_cabang');
        
    }
    
    public function index(){
        //$this->data->user = $this->user_m->get_all();
        
        $this->data->base_url = base_url().'/admin/user/index';
	
	$this->data->total_rows = $this->db->count_all('user');
	$this->data->per_page = $this->config->item('hlm');
	$this->data->uri_segment = 4;
        $this->pagination->initialize($this->data);
	$this->data->user = $this->user_m->get_all_page($this->data->per_page,$this->uri->segment(4,0));
        
        parent::_view('user/list',$this->data);
    }
    
    public function tambah() {
        $this->form_validation->set_rules($this->rules);
        if($this->form_validation->run()) {
            $username = $this->input->post('username');
            $email = $this->input->post('email');
            $level = $this->input->post('level');
            $cabang = $this->input->post('cabang');
            $password = $this->input->post('password');
            
            
            if(!$this->autentifikasi->tambah_admin($username,$email,$level,$cabang,$password)) {
                $this->data->error = '<div class="error">Username telah digunakan</div>';
            } else {
                $this->data->sukses = '<div class="sukses">Proses registrasi berhasil</div>';
            }
        }
        $this->data->list_cab= $this->pesanan_m->list_cab('kode_cabang','nama_cabang');
        $this->data->username = set_value('username');
        $this->data->email = set_value('email');
        $this->data->cabang = set_value('cabang');
        $this->data->level = set_value('level');
     
        parent::_modal('user/form_register',$this->data);
    }
    
    public function profile($id = 0) {
        $this->load->model('profile_m');
        
        $data = $this->profile_m->get_by(array('user_id'=>$id));
        
        $this->form_validation->set_rules($this->profile_rules);
        if($this->form_validation->run()) {
            $insert = array(    'nama_depan'    =>  $this->input->post('nama_depan'),
                                'nama_belakang' =>  $this->input->post('nama_belakang'),
                                'alamat'        =>  $this->input->post('alamat'),
                                'kode_pos'      =>  $this->input->post('kode_pos'),
                                'phone'         =>  $this->input->post('phone'));
            if($data){
                if($this->profile_m->update($data->id_user_data,$insert)){
                    $this->data->sukses = '<div class="sukses">profile berhasil diperbaharui </div>';
                }
            }else{
                $insert['user_id'] = $id;
                if($this->profile_m->insert($insert)){
                    $this->data->sukses = '<div class="sukses">Profile berhasil diisikan</div>';
                }
            }
        }
        
        if($data){
            $this->data->nama_depan = $data->nama_depan;
            $this->data->nama_belakang = $data->nama_belakang;
            $this->data->alamat = $data->alamat;
            $this->data->kode_pos = $data->kode_pos;
            $this->data->phone = $data->phone;
        }else{
            $this->data->nama_depan = set_value('nama_depan');
            $this->data->nama_belakang = set_value('nama_belakang');
            $this->data->alamat = set_value('alamat');
            $this->data->kode_pos = set_value('kode_pos');
            $this->data->phone = set_value('phone');    
        }
        
        parent::_modal('user/form_profile',$this->data);
    }
    
    public function ubah($id = 0) {
        $data = $this->user_m->get($id);
        $this->data->list_cab= $this->pesanan_m->list_cab('kode_cabang','nama_cabang');
        $this->data->list_cab_sel= $this->pesanan_m->list_cab_sel('kode_cabang','nama_cabang');
        
        
        $this->form_validation->set_rules($this->edit_rules);
        if($this->form_validation->run()) {
            $username = $this->input->post('username');
            $email = $this->input->post('email');
            $password = $this->input->post('new_password');
            $level = $this->input->post('level');
            $cabang = $this->input->post('cabang');
            
            if(!$this->autentifikasi->ubah_admin($id,$username,$email,$password,$level,$cabang)) {
                $this->data->error = '<div class="error">Username telah digunakan</div>';
            } else {
                $this->data->sukses = '<div class="sukses">Proses registrasi berhasil</div>';
            }
        }
        
        if($data){
            $this->data->username = $data->username;
            $this->data->email = $data->email;
            $this->data->level = $data->level;
            //$this->data->cabang = $data->cabang;
            
        }else{
            $this->data->username = set_value('username');
            $this->data->email = set_value('email');
            $this->data->level = set_value('level');
            //$this->data->cabang = set_value('cabang');
        }
        
        parent::_modal('user/form_edit',$this->data);
    }
    
    public function record($id = 0) {
        $this->load->model('order_m');
        $this->load->model('profile_m');
        
        $this->data->profile = $this->profile_m->get_by(array('user_id'=>$id));
        
        $this->data->order = $this->order_m->get_record(array('user_id'=>$id));
        
        parent::_view('user/record',$this->data);
    }
    
    public function detail($id = 0) {
        $this->load->model('order_m');
        if ($this->input->post('submit')){
            $this->order_m->update_by(array('id_order'=>$id),array('status_order'=>$this->input->post('status')));
            $this->data->sukses = 'Data berhasil diperbaharui';   
        } else {
            $this->data->detail = $this->order_m->get_record(array('id_order'=>$id),true);
        }
        
        parent::_modal('laporan/detail',$this->data);
    }
    
    public function hapus($id = 0) {
        $id OR redirect(site_url('admin/user'));
        
        if($this->session->userdata('user_id') != $id){
            $this->user_m->hapus($id);   
        } else {
            $this->session->set_flashdata('user_note','<p class="msg warning">Anda tidak diperkenankan menghapus diri anda sendiri.</p>');        
        }
        
        redirect(site_url('admin/user'));
    }
    
    public function aktifasi($id = 0, $aktif = 0) {
        
        $id OR redirect(site_url('admin/user'));
        
        
        if($this->session->userdata('user_id') != $id){
            $this->user_m->update($id,array('status'=>$aktif));
            
            $mail_sent = false;
            $sql = "SELECT email FROM user WHERE id_user = ".$id;
            $hasil = $this->db->query($sql);
            $data = $hasil->result();
            foreach($data as $row):
            
            $email = $row->email;
            
            endforeach;
        
                $this->load->library('email');
                $this->config->load('mail_config',true);
                $this->email->set_mailtype("html");
                
                $this->email->from('a@yahoo.com');
                $this->email->to($email);
                $this->email->subject('Registrasi Yogya E-Commerce');
                
                //$this->email->message('Terima kasih, permohonan Anda untuk mendaftar sebagai pengguna Yogya E-Commerce sudah berhasil dan Anda sudah dapat melakukan login.');
                $msg = $this->load->view('email/reg_sukses', '', true);
                
                
                $this->email->message($msg); 
                
                
                if ($this->email->send())
                {
                    # If $mail_sent = true; it will show a success message.
                    $mail_sent = true;
                }
        
        $this->session->set_flashdata('user_note','<p class="msg done">User sudah diaktifkan | Pesan email Registrasi berhasil dikirimkan kepada user.</p>');
        
        }else{
            $this->session->set_flashdata('user_note','<p class="msg warning">Anda tidak diperkenankan menonaktifkan diri anda sendiri.</p>');
        }
        
        redirect(site_url('admin/user'));
    }
    
    public function email_ditolak($id = 0) {
        $id OR redirect(site_url('admin/user'));
        
        
        if($this->session->userdata('user_id') != $id){
        $mail_sent = false;
        $sql = "SELECT email FROM user WHERE id_user = ".$id;
        $hasil = $this->db->query($sql);
        $data = $hasil->result();
        foreach($data as $row):
        
        $email = $row->email;
        
        endforeach;
        
                # Loading email library of Codeigniter
                $this->load->library('email');
                # Loading configuration file mail_config.php
                $this->config->load('mail_config',true);
                $this->email->set_mailtype("html");
                # Setting email address and name of the person sending the email
                $this->email->from('a@yahoo.com');
                # Setting email address of the recipient
                $this->email->to($email);
                
                # Setting email subject
                $this->email->subject('Registrasi Yogya E-Commerce');
                # Setting email message body
                //$this->email->message('Mohon maaf permohonan Anda untuk mendaftar sebagai pengguna Yogya E-Commerce masih ditolak, dikarenakan beberapa syarat yang belum terpenuhi.');
                
                $msg = $this->load->view('email/reg_tolak', '', true);
                $this->email->message($msg); 
                
                # If mail sending successful
                if ($this->email->send())
                {
                    # If $mail_sent = true; it will show a success message.
                    $mail_sent = true;
                }
        
        $this->session->set_flashdata('user_note','<p class="msg done">Pesan email Penolakan Registrasi berhasil dikirimkan.</p>');
        }else{
            $this->session->set_flashdata('user_note','<p class="msg warning">Anda tidak diperkenankan menonaktifkan diri anda sendiri.</p>');
        }
        
        redirect(site_url('admin/user'));
    }
    
    public function search(){
        
        if(isset($_POST['submit']))
        {
            $data['search_name'] = $this->input->post('search_name');
            $data['search_mem'] = $this->input->post('search_mem');
            $data['level'] = $this->input->post('level');
            
            //set session user data untuk pencarian, untuk paging pencarian
            $this->session->set_userdata('sess_name', $data['search_name']);
            $this->session->set_userdata('sess_mem', $data['search_mem']);
            $this->session->set_userdata('sess_level', $data['level']);
            
        } else {
            $data['search_name'] = $this->session->userdata('sess_name');
            $data['search_mem'] = $this->session->userdata('sess_mem');
            $data['level'] = $this->session->userdata('sess_level');
        }
    
        $this->db->select('*');
        $this->db->from('user');
        //$this->db->join('user_data', 'user.id_user = user_data.user_id');
        
        if($data['search_name'] !=NULL && $data['search_mem'] == NULL){
            $this->db->like('username', $data['search_name']);
            //echo"a";
        
        }else if($data['search_name'] ==NULL && $data['search_mem'] != NULL){
            $this->db->like('CONCAT(membercard)', $data['search_mem']);
            //echo"b";
        
        }else if($data['search_name'] ==NULL && $data['search_mem'] == NULL && $data['level'] != NULL){
            $this->db->like('CONCAT(level)', $data['level']);
            //echo"c";
        
        }else{
            $this->db->like('CONCAT(username)', $data['search_name']);
            $this->db->like('CONCAT(membercard)', $data['search_mem']);    
            //echo"d";
        }
        
        
        //Pagination init
        $pagination['base_url'] 		= base_url().'/admin/user/search/';
        $pagination['total_rows'] 		= $this->db->count_all_results();
        $pagination['full_tag_open'] 	        = "<div class=\"pagination\">";
        $pagination['full_tag_close'] 	        = "</div>";
        $pagination['cur_tag_open'] 	        = "<span class=\"current\">";
        $pagination['cur_tag_close'] 	        = "</span>";
        $pagination['num_tag_open'] 	        = "<span class=\"disabled\">";
        $pagination['num_tag_close'] 	        = "</span>";
        $pagination['per_page'] 		= $this->config->item('hlm');
        $pagination['uri_segment'] 		= 4;
        $pagination['num_links'] 		= 4;
    
        $this->pagination->initialize($pagination);
    
        $this->data->user = $this->user_m->SearchResult($pagination['per_page'],$this->uri->segment(4,0),$data['search_name'],$data['search_mem'],$data['level']);
    
        $this->load->vars($this->data);
        
	parent::_view('user/list',$this->data);
    }
}
