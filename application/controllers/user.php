<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
    private $rules = array (
                        
                        array(
                                 'field'   => 'userId', 
                                 'label'   => 'userId', 
                                 'rules'   => 'alpha_numeric|required|max_length[15]|min_length[8]'
                              ),
                        
                        array(
                                 'field'   => 'username', 
                                 'label'   => 'Username', 
                                 'rules'   => 'required|max_length[15]|min_length[6]'
                              ),
                        
                        array(
                                 'field'   => 'password', 
                                 'label'   => 'Password', 
                                 'rules'   => 'alpha_numeric|required|max_length[20]|min_length[6]'
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
                                 'field'   => 'user_id', 
                                 'label'   => 'NIK', 
                                 'rules'   => 'numeric|required|max_length[15]|min_length[6]'
                              ),
                        array(
                                 'field'   => 'password', 
                                 'label'   => 'password', 
                                 'rules'   => 'alpha_numeric|required|max_length[20]|min_length[5]'
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
        $this->load->helper('text');
        
        $this->load->model('option_m');
        //$option = $this->option_m->get_by(array('nama_opsi'=>'store_option'));
        //foreach (unserialize($option->value_opsi) as $key => $val){
        //    $this->data->$key = $val;
        //}
        
        
        $this->template->set_template('palmtree');
        //$this->template->set_css(array('store'));
        $this->load->model('kategori_m');
        $this->load->model('user_m');
        $this->load->model('konfirmasi_m');
        $this->load->model('konfirmasi_pesanan_m');
        
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('ion_auth');
        
        $this->form_validation->set_error_delimiters('<p class="alert-error">', '</p>');
        
        $this->data->kategori = $this->kategori_m->kategori_menu_list;
        $this->data->cart = $this->cart->contents();
        
        $is_active = $this->autentifikasi->sudah_login();
        $is_allow = $this->autentifikasi->role(array('user','admin'));
        $this->data->logged_in = $is_active && $is_allow;
        $this->data->side = 0;
    }
    
    public function index() {
        $this->template->set_judul('Centralize Delivery & Inventory')
        ->set_css('style')
        ->set_parsial('sidebar','sidebar_view',$this->data)
        ->set_parsial('topmenu','top_view',$this->data)
        ->render('front',$this->data); 
    }
    
    public function login() {
        $this->form_validation->set_rules($this->login_rules);
        if($this->form_validation->run()) {
            $user_id = $this->input->post('user_id');
            $password = $this->input->post('password');
            $store_site_code = $this->input->post('store_site_code');
            
            
            if(!$this->autentifikasi->login($user_id,$password,$store_site_code)) {
                $this->session->set_flashdata('pesan', '<div class="alert-error" style="text-align:center">Maaf, Proses Login Gagal <br/><br/>Ada kesalahan input pada Cabang / NIK / password Anda<br/><br/>Silahkan mencoba Login kembali</div><br/><br/><br/>');
                //$this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect(site_url('user/login'));
                //echo "gagal";
                
            } else {
                
                $this->session->set_flashdata('pesan', '<div class="sukses">SELAMAT DATANG : '.$this->session->userdata('user_desc').'</div>');
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect(site_url('store/'));
                //echo"berhasil";
            }
        }
        
        //$this->session->set_flashdata('message', $this->ion_auth->messages());
        
        
        $this->data->site_master = $this->user_m->site_master();
       
       $this->template->set_judul('Centralize Delivery & Inventory')
        ->set_css('bootstrap')
        ->set_css('base')
        ->set_css('bootstrap-responsive')
        ->set_css('font-awesome')
        //->set_css('prettify')
        
        ->set_parsial('topmenu','top_view',$this->data)
        ->render('user_login',$this->data);   
    }
    
    public function logout(){
        $this->autentifikasi->logout();
        redirect(base_url('store/'));
    }
    
    public function register() {
        
        $this->form_validation->set_rules($this->rules);
        
        $this->data->site_master = $this->user_m->site_master();
        
        if($this->form_validation->run()) {
            $userId = $this->input->post('userId');
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $store_site_code = $this->input->post('store_site_code');
            
            if(!$this->autentifikasi->tambah($userId,$username,$password,$store_site_code)) {
                
                $this->data->error = '<div class="alert-error">Gold User ID telah digunakan</div>';
            
            } else {
                
                $this->data->sukses = '<div class="alert-success">Proses registrasi berhasil.</div>';
            }
        }
        
        $this->data->username = set_value('username');
        $this->data->email = set_value('email');
        
        $this->template->set_judul('Griyatron Support System')
        ->set_css('bootstrap')
        ->set_css('base')
        ->set_css('bootstrap-responsive')
        ->set_css('font-awesome')
        ->set_css('prettify')
        
        ->set_parsial('topmenu','top_view',$this->data)
        ->render('register',$this->data); 
    }
    
    public function profile() {
        $this->load->model('profile_m');
        
        $data = $this->profile_m->get_by(array('user_id'=>$this->session->userdata('user_id')));
        
        $this->form_validation->set_rules($this->profile_rules);
        if($this->form_validation->run()) {
            $insert = array(    'nama_depan'    =>  $this->input->post('nama_depan'),
                                'nama_belakang' =>  $this->input->post('nama_belakang'),
                                'alamat'        =>  $this->input->post('alamat'),
                                'kode_pos'      =>  $this->input->post('kode_pos'),
                                'phone'         =>  $this->input->post('phone'));
            if($data){
                if($this->profile_m->update($data->id_user_data,$insert)){
                    redirect(site_url('user/profile'));
                }
            }else{
                $insert['user_id'] = $this->session->userdata('user_id');
                if($this->profile_m->insert($insert)){
                    redirect(site_url('user/profile'));
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
        
        $this->template->set_judul('Yogya E-Commerce')
        ->set_css('sidestyle')
        //->set_parsial('sidebar','sidebar_view',$this->data)
        //->set_parsial('slidebanner','slide_banner',$this->data)
        ->set_parsial('topmenu','top_view',$this->data)
        ->render('profile',$this->data);
    }
    
    public function edit() {
        $id = $this->session->userdata('user_id');
        $level = $this->session->userdata('level');
        
        $data = $this->user_m->get($id);
        
        $this->form_validation->set_rules($this->edit_rules);
        if($this->form_validation->run()) {
            $username = $this->input->post('username');
            $email = $this->input->post('email');
            $password = $this->input->post('new_password');
            
            if(!$this->autentifikasi->ubah($id,$username,$email,$password,$level)) {
                $this->data->error = '<div class="error">Username telah digunakan</div>';
            } else {
                $this->data->sukses = '<div class="sukses">Proses registrasi berhasil</div>';
            }
        }
        
        if($data){
            $this->data->username = $data->username;
            $this->data->email = $data->email;
        }else{
            $this->data->username = set_value('username');
            $this->data->email = set_value('email');
        }
        
        $this->template->set_judul('Yogya E-Commerce')
        ->set_css('sidestyle')
        //->set_parsial('sidebar','sidebar_view',$this->data)
        ->set_parsial('topmenu','top_view',$this->data)
        ->render('edit',$this->data); 
    }
    
    public function record(){
        $this->load->helper('date');
        $this->load->model('order_m');
        
        $this->data->base_url = base_url().'/user/record';
		
	$id = $this->session->userdata('user_id');
        
        $this->db->select('*');
        $this->db->from('order');
        $this->db->join('user', 'user.id_user = order.user_id');
        $this->db->join('user_data', 'user.id_user = user_data.user_id');
	
        $a =  "select user_id FROM `order` WHERE user_id LIKE '".$id."'";
        $query = $this->db->query($a);
        
        if(($query->num_rows() > 0)){
           
            $this->db->like('id_user', $id);
            
        }
        
        $pagination['base_url'] 		= base_url().'/user/record/';
        $pagination['total_rows'] 		= $this->db->count_all_results();
        $pagination['full_tag_open'] 	        = "<div class=\"paging_record\">";
        $pagination['full_tag_close'] 	        = "</div>";
        $pagination['cur_tag_open'] 	        = "<span class=\"current\">";
        $pagination['cur_tag_close'] 	        = "</span>";
        $pagination['num_tag_open'] 	        = "<span class=\"disabled\">";
        $pagination['num_tag_close'] 	        = "</span>";
        $pagination['per_page'] 		= "1";
        $pagination['uri_segment'] 		= 3;
        $pagination['num_links'] 		= 3;
    
        $this->pagination->initialize($pagination);
        
        $this->data->order = $this->order_m->get_record_page($pagination['per_page'],$this->uri->segment(3,0),$id);
        
        $this->load->vars($this->data);
        
        
        $this->template->set_judul('Yogya E-Commerce')
        ->set_css('sidestyle')
        ->set_parsial('sidebar','sidebar_view',$this->data)
        ->set_parsial('topmenu','top_view',$this->data)
        ->render('record',$this->data);
        
    }
    
    public function detail_record($id = 0) {
        $this->load->model('pesanan_m');
        //$this->load->model('option_m');
        
        $this->data->biaya= $this->option_m->option();
        
        
        $this->data->detail = $this->pesanan_m->get_record(array('id_order'=>$id),true);
        
        
        $this->template->set_judul('Yogya E-Commerce')
        ->set_css('sidestyle')
        ->set_parsial('sidebar','sidebar_view',$this->data)
        ->set_parsial('topmenu','top_view',$this->data)
        ->render('detail_record',$this->data);
    }
    
    public function favorit(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->add_fav_rules);
        
        
        $this->load->helper('date');
        $this->load->model('pesanan_m');
        $this->data->base_url = base_url().'/user/favorit';
	$this->load->model('order_m');	
	$id = $this->session->userdata('user_id');
        
        $this->db->select('*');
        $this->db->from('favoritku');
        $this->db->join('user', 'user.id_user = favoritku.user_id');
        $this->db->join('user_data', 'user.id_user = user_data.user_id');
        $this->db->group_by('nama');       
	
        $a =  "select user_id FROM `favoritku` WHERE user_id LIKE '".$id."'";
        $query = $this->db->query($a);
        
        if(($query->num_rows() > 0)){
           
            $this->db->like('id_user', $id);
            
        }
        
        $pagination['base_url'] 		= base_url().'/user/favorit/';
        $pagination['total_rows'] 		= $this->db->count_all_results();
        $pagination['full_tag_open'] 	        = "<div class=\"paging_record\">";
        $pagination['full_tag_close'] 	        = "</div>";
        $pagination['cur_tag_open'] 	        = "<span class=\"current\">";
        $pagination['cur_tag_close'] 	        = "</span>";
        $pagination['num_tag_open'] 	        = "<span class=\"disabled\">";
        $pagination['num_tag_close'] 	        = "</span>";
        $pagination['per_page'] 		= "10";
        $pagination['uri_segment'] 		= 3;
        $pagination['num_links'] 		= 3;
    
        $this->pagination->initialize($pagination);
        
        $this->data->order = $this->order_m->get_favorit_page($pagination['per_page'],$this->uri->segment(3,0),$id);
        
        
        if($this->form_validation->run()) {
            if($this->input->post('submit')) {
                $data =  array (    'nama' =>  $this->input->post('nama'),
                                    'user_id' =>$id
                                );
                $this->pesanan_m->tambah_fav($data);
                    $this->data->sukses = 'Data Berhasil di tambahkan';
                //}
                redirect (site_url('user/favorit'));
            }
        }    
            
        $this->load->vars($this->data);
        
        $this->template->set_judul('Yogya E-Commerce')
        ->set_css('sidestyle')
        //->set_parsial('sidebar','sidebar_view',$this->data)
        ->set_parsial('topmenu','top_view',$this->data)
        ->render('favorit',$this->data);
        
    }
    
    public function tambah_fav() {
        $this->load->library('form_validation');
        $this->load->model('pesanan_m');
        
        $this->form_validation->set_error_delimiters('<p class="msg warning">', '</p>');
        $id = $this->session->userdata('user_id');
        
        $this->form_validation->set_rules($this->add_fav_rules);
        
        if($this->form_validation->run()) {
            $data =  array (    'nama' =>  $this->input->post('nama'),
                                'user_id' =>$id
                            );
            if ($this->pesanan_m->tambah_fav($data)) {
                $this->data->sukses = 'Data Berhasil di tambahkan';
            }
        }
        
        $this->template->set_judul('Yogya E-Commerce')
        ->set_css('style')
        ->set_parsial('sidebar','sidebar_view',$this->data)
        ->set_parsial('topmenu','top_view',$this->data)
        ->render('favorit',$this->data);
        
    }
    
    public function detail_fav($nama) {
        $this->load->model('pesanan_m');
        
        $id = $this->session->userdata('user_id');
               
        $this->data->detail = $this->pesanan_m->get_fav($nama,$id);
        //$this->data->detail = $this->pesanan_m->get_all_page($this->data->per_page,$this->uri->segment(4,0));
        
        $this->data->side = 1;
        
        $this->template->set_judul('Yogya E-Commerce')
        ->set_css('style')
        ->set_parsial('sidebar','sidebar_view',$this->data)
        ->set_parsial('topmenu','top_view',$this->data)
        ->render('detail_fav',$this->data);
    }
    
    public function hapus_detail_fav($nama = 0) {
        $this->load->model('pesanan_m');
        
        $nama OR redirect(site_url('user/favorit'));
        
        $this->pesanan_m->delete_fav(urldecode($nama));
        
        redirect(site_url('user/favorit'));
    }
    
    public function delete_det_fav($id_fav = 0) {
        $this->load->model('pesanan_m');
        
        $id_fav OR redirect(site_url('user/detail_fav'));
        
        $this->pesanan_m->delete_det_fav($id_fav);
        
        redirect(site_url('user/detail_fav'));
    }
    
    public function konfirmasi() {
        $this->load->model('user_m');
        
        $data = $this->user_m->get_by(array('id_user'=>$this->session->userdata('user_id')));
        
        $this->form_validation->set_rules($this->konfirmasi_rules);
        if($this->form_validation->run()) {
            $order_no = $this->input->post('order_no',TRUE);
            
            $insert = array(    'nama'          =>  $this->input->post('nama'),
                                'email'         =>  $this->input->post('email'),
                                'order_no'      =>  $this->input->post('order_no'),
                                'nominal'       =>  $this->input->post('nominal'),
                                'tanggal'       =>  $this->input->post('tanggal'),
                                'dari_rekening' =>  $this->input->post('dari_rekening'),
                                'norek'         =>  $this->input->post('norek'),
                                'rekening_tujuan' =>  $this->input->post('rekening_tujuan'));
            
            //Cek menghindari input order_no 2x
                $this->db->select('order_no');
                $this->db->from('konfirmasi');
                $this->db->where('order_no',$order_no);
                $data_p = $this->db->get();
            
            //Cek menghindari input order_no 2x
                $this->db->select('order_no');
                $this->db->from('order');
                $this->db->where('order_no',$order_no);
                $data_ceking = $this->db->get();
        
            if($data_p->result_array() != NULL){
                $this->data->error = '<div class="error">Nomor Order Anda sudah pernah digunakan untuk konfirmasi</div>';
            
            }else if($data_ceking->result_array() == NULL){
            
                $this->data->error = '<div class="error">Nomor Order Anda salah, hubungi Customer Service kami untuk informasi</div>';
                
            }else if($this->input->post('rekening_tujuan') == 0){
            
                $this->data->error = '<div class="error">Pilih Rekening Tujuan Anda</div>';
        
            
            }else{
            
            $this->load->library('email');
            $this->config->load('mail_config',true);
            $this->email->from($this->input->post('email'));
            $this->email->to($this->config->item('to','mail_config'));
            $this->email->subject('Konfirmasi Pembayaran E-Commerce');
           
            //$this->email->message($this->input->post('jumlah',true));
            
            $this->email->set_mailtype("html");
                
                
            if($this->input->post('rekening_tujuan') == 1)
            {
                $rek_tuj = 'BCA';
                
            }else{
                $rek_tuj = 'Mandiri';
            }
            
            $message =
                '
                Nama : <b>'.$this->input->post('nama').'</b>
                <br/><br/>
                Order No : <b>'.$this->input->post('order_no').'</b>
                <br/><br/>
                Nominal : <b>'.$this->input->post('nominal').'</b>
                <br/><br/>
                Tanggal : <b>'.$this->input->post('tanggal').'</b>
                <br/><br/>
                Dari Rek : <b>'.$this->input->post('dari_rekening').'</b>
                <br/><br/>
                Nomor Rek : <b>'.$this->input->post('norek').'</b>
                <br/><br/>
                Rek Tujuan : <b>'.$rek_tuj.'</b>'
                ;
                
                $this->email->message($message);
            
            # If mail sending successful
            if ($this->email->send())
            {
                # If $mail_sent = true; it will show a success message.
                
                $mail_sent = true;
                
            }
            
            
            $this->konfirmasi_m->insert($insert);
            $this->data->sukses = '<div class="sukses">Konfirmasi Pembayaran Berhasil Dikirim, Pesanan Anda sedang diproses.</div>';
            # Showing Contact Form
            //$this->load->view('contact_sukses',$data);
            }
        }
        
        if($data){
            $this->data->email = $data->email;
            
        }else{
            $this->data->email = set_value('email');
              
        }
        
        $this->template->set_judul('Yogya E-Commerce')
        ->set_css('style')
        ->set_parsial('sidebar','sidebar_view',$this->data)
        ->set_parsial('topmenu','top_view',$this->data)
        ->render('konfirmasi',$this->data);
        
    }
    
    public function konfirmasi_pesanan() {
        $this->load->model('user_m');
        $this->form_validation->set_rules($this->konfirmasi_pesanan_rules);
        if($this->form_validation->run()) {
            $id = $this->session->userdata('user_id');
            
            $order_no = $this->input->post('order_no',TRUE);
            $nama_pengirim = $this->input->post('nama_pengirim',TRUE);
            
            $query =  $this->db->get_where('order',array('order_no' => $order_no));
            
            if( $query->num_rows() == 0 )
            {
                $this->data->error = '<div class="error">Kesalahan pada input Nomor Order Anda</div>';
            
            }else{
                
                    $a =  "select * FROM `order` WHERE user_id LIKE '".$id."' AND order_no LIKE '".$order_no."' ";
                    $query = $this->db->query($a);
        
                    if(($query->num_rows() > 0)){
                            
                            $this->konfirmasi_pesanan_m->insert($order_no, $nama_pengirim,$id);
                            $this->data->sukses = '<div class="sukses">Konfirmasi Pesanan Berhasil, Kami tunggu pesanan Anda selanjutnya.</div>';
                    }else{
                            $this->data->error = '<div class="error">Konfirmasi Gagal, Nomor Order Anda salah / tidak ada</div>';
                    }
            }
        }
        
        
        $this->template->set_judul('Yogya E-Commerce')
        ->set_css('sidestyle')
        ->set_parsial('sidebar','sidebar_view',$this->data)
        ->set_parsial('topmenu','top_view',$this->data)
        ->render('konfirmasi_pesanan',$this->data);
        
    }
    
    
    private function _set_captcha()
    {
        $this->load->helper('string');
        $vals = array(
           'img_path' => './captcha/',
           'img_url' => base_url().'/captcha/',
           'img_width' => '120',
           'img_height' => 30,
           'expiration' => 3600,
           'word'   =>random_string('numeric', 6)
        );
      
        $cap = create_captcha($vals);
      
        $data = array(
           'captcha_time' => $cap['time'],
           'ip_address' => $this->input->ip_address(),
           'word' => $cap['word']
        );
      
        $query = $this->db->insert_string('captcha', $data);
        $this->db->query($query);
        return $cap;
    }
    
    public function term_condition() {
        
        $this->template->set_judul('Yogya E-Commerce')
        ->set_css('style')
        ->set_parsial('sidebar','sidebar_view',$this->data)
        ->set_parsial('topmenu','top_view',$this->data)
        ->render('term_condition',$this->data); 
    }
    
    public function cara_belanja() {
        
        $this->template->set_judul('Yogya E-Commerce')
        ->set_css('style')
        ->set_parsial('sidebar','sidebar_view',$this->data)
        ->set_parsial('topmenu','top_view',$this->data)
        ->render('cara_belanja',$this->data); 
    }
    
    function valid_captcha($str)
    {
       // First, delete old captchas
       $expiration = time()-3600; // Two hour limit
       $this->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration);
     
       // Then see if a captcha exists:
       $sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";
       $binds = array($str, $this->input->ip_address(), $expiration);
       $query = $this->db->query($sql, $binds);
       $row = $query->row();
     
       if ($row->count == 0)
       {
          $this->form_validation->set_message('valid_captcha', 'Kolom kode Captcha tidak valid');
          return FALSE;
       }
       else
       {
          return TRUE;
       }
    }
}