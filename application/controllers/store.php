<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Store extends CI_Controller {
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
                                 'field'   => 'kota', 
                                 'label'   => 'Kota', 
                                 'rules'   => 'required'
                              ),
                        array(
                                 'field'   => 'phone', 
                                 'label'   => 'Telepon', 
                                 'rules'   => 'numeric|required'
                              ),
                        array(
                                 'field'   => 'kode_pos', 
                                 'label'   => 'Kode Pos', 
                                 'rules'   => 'numeric'
                              ),
                         );
    
    private $add_cart = array (
                        array(
                                 'field'   => 'qty', 
                                 'label'   => 'Jumlah Pemesanan', 
                                 'rules'   => 'alpha_numeric|required'
                              ),
                        array(
                                 'field'   => 'colorRadio', 
                                 'label'   => 'Pembayaran', 
                                 'rules'   => 'required'
                              )
                        
                         );
    
    public function __construct() {
        parent::__construct();
        
        //if ($this->session->userdata('logged_in') == FALSE)
        //{
        //  //$this->error = (array('status'=>'Status belum aktif'));
        //  $this->session->set_flashdata('pesan', '<div class="alert-error" style="text-align:center">Session Timeout<br/><br/>Silahkan mencoba Login kembali</div><br/><br/><br/>');
        //  redirect('user/login');
        //   
        //}
        
        $this->load->model('option_m');
        
        $this->load->library('pagination');
        $this->template->set_template('palmtree');
        
        $this->load->model('kategori_m');
        $this->load->model('produk_m');
       
        
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');   
        $this->data->kategori = $this->kategori_m->kategori_menu_list;
        //echo $this->db->last_query();
        $this->data->kat = $this->kategori_m->kat();
        $this->data->cart = $this->cart->contents();
        
        $is_active = $this->autentifikasi->sudah_login();
        $is_allow = $this->autentifikasi->role(array('user','admin'));
        $this->data->logged_in = $is_active && $is_allow;
        
        $this->load->helper('text');
        $this->data->site_master = $this->user_m->site_master();
        $this->data->side = 1;
        $this->data->user_id = $this->session->userdata('user_id');
        $this->data->user_desc = $this->session->userdata('user_desc');
        $this->data->store_site_code = $this->session->userdata('store_site_code');
        $this->data->site_desc = $this->session->userdata('site_desc');
        $this->data->dc_supp_code = $this->session->userdata('dc_supp_code');
        $this->data->dc_site_code = $this->session->userdata('dc_site_code');
        $this->data->multiuser = $this->session->userdata('multiuser');
    }
    
    public function index(){        
        $this->load->model('user_m');
        $ssc = $this->input->post('store_site_code');
        
        if($ssc){
        
        $user = $this->user_m->get_site_desc($ssc);
            
        $this->session->set_userdata(array(
								
								'store_site_code'	=> $ssc,
								'site_desc'	=> $user->SITE_DESC,
								
					));
        
        
        //$this->session->set_userdata('store_site_code', $ssc);
        
        echo "<div class='btn btn-mini btn-primary' style= margin-left:80px>Sekarang, Anda berada di : ";
        echo $user->SITE_DESC."</div>";
        
        //echo $this->data->store_site_code;
        //echo "<br/>";
        //echo $this->data->user_id;
        //echo "<br/>";
        //echo $this->data->site_desc;
        }
        
        
        $this->template->set_judul('Centralize Delivery & Inventory')
        ->set_js('jquery')
        ->set_css('bootstrap')
        ->set_css('base')
        ->set_css('bootstrap-responsive')
        ->set_css('font-awesome')
        ->set_css('mystyle')
        
        ->set_parsial('slidebanner','slide_banner',$this->data)
        ->set_parsial('topmenu','top_view',$this->data)
        ->render('front',$data);   
    }
    
    public function home(){        
        
        
        
        
        $this->template->set_judul('Centralize Delivery & Inventory')
        ->set_js('jquery')
        ->set_css('bootstrap')
        ->set_css('base')
        ->set_css('bootstrap-responsive')
        ->set_css('font-awesome')
        ->set_css('mystyle')
       
        ->set_parsial('sidebar','sidebar_view',$this->data)
        ->set_parsial('topmenu','top_view',$this->data)
        ->render('home',$data);   
    }
    
   
    
    public function department($url = null){
        
        $data['data'] = $this->produk_m->get_all_produk_dep();
       
        $result2 = $this->produk_m->get_link_subdep();
        
        $link = "<td>".$url."</td>";
        
        $data['link_map'] = $link;   
        
        $link2 ="";
        
        if ($result2->num_rows() > 0)
        {
           foreach ($result2->result_array() as $row)
           {
                $link2 .= "<a href='".site_url('store/divisi/'.$row['url'])."' class='button button-red'><span>".$row['url']. "</a>"; 
            
           }
            
           
        }
       $data['link_map2'] = $link2;
        
       
	$this->template->set_judul('Centralize Delivery & Inventory')
        ->set_css('style')
        ->set_parsial('sidebar','sidebar_view',$this->data)
        ->set_parsial('topmenu','top_view',$this->data)
        ->render('store',$data); 
    }
    
    public function divisi($url = null){
        
        $result = $this->produk_m->get_link_div();
        $result2 = $this->produk_m->get_link_subdiv();
        
        $data['data'] = $this->produk_m->get_all_produk_div();
       
        if ($result->num_rows() > 0)
        {
           $row = $result->row_array(); 
        
           $link = "<td><a href='".site_url('store/department/'.$row['p'])."'>".$row['p']. "</a>  >  ".$row['url']."</td>";
        }
        
        $data['link_map'] = $link;
        
        $link2 ="";
        
        if ($result2->num_rows() > 0)
        {
           foreach ($result2->result_array() as $row)
           {
                $link2 .= "<a href='".site_url('store/kategori/'.$row['url'])."' class='button button-red'><span>".$row['url']. "</span></a>"; 
            
           }
            
        
           
        }
       $data['link_map2'] = $link2;
       
	$this->template->set_judul('Centralize Delivery & Inventory System')
        ->set_css('style')
        ->set_parsial('sidebar','sidebar_view',$this->data)
        ->set_parsial('topmenu','top_view',$this->data)
        ->render('store',$data); 
    }
    
    
       
    public function kategori($url = null){
        //if ($this->session->userdata('logged_in') === FALSE)
        //{
        //  //$this->error = (array('status'=>'Status belum aktif'));
        //  $this->session->set_flashdata('pesan', '<div class="alert-error" style="text-align:center">Session Timeout<br/><br/>Silahkan mencoba Login kembali</div><br/><br/><br/>');
        //  redirect('user/login');
        //   
        //}
        
        $result = $this->produk_m->get_link_map();
        
        $hdr_cat = $this->produk_m->get_hdr_cat();
        
        $store_site_code = $this->data->store_site_code;
        $dc_site_code = $this->data->dc_site_code;
        
        if($store_site_code !='' AND $dc_site_code !='')
        {
        
            $data['data'] = $this->produk_m->get_category_product($dc_site_code,$store_site_code);
        
        }else{
            
            $this->session->set_flashdata('login','<div class="alert-danger"><center>Waktu Anda habis, silahkan login kembali.</center></div>');
            redirect('user/login');
        }
        $link = "";
        
        if ($result->num_rows() > 0)
        {
           $row = $result->row_array(); 
        
           $link = "<td><a href='".site_url('store/department/'.$row['gp_url'])."'>".$row['gp_url']. "</a>  >  <a href='".site_url('store/divisi/'.$row['p_url'])."'>".$row['p_url']. "</a> > ".$row['url']."</td>";
        }
        
        
        $data['link_map'] = $link;
        
        $data['search_name'] = '';  
       
	$this->template->set_judul('Centralize Delivery & Inventory')
        ->set_js('jquery')
        ->set_css('bootstrap')
        ->set_css('base')
        ->set_css('bootstrap-responsive')
        ->set_css('font-awesome')
        ->set_css('mystyle')
        ->set_parsial('sidebar','sidebar_view',$this->data)
        ->set_parsial('topmenu','top_view',$this->data)
        ->render('store',$data); 
    }
    
    public function produk($url = null, $id_produk = null){
        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->add_cart);
        
        $url or redirect(site_url());
        
        $store_site_code = $this->data->store_site_code;
        $dc_site_code = $this->data->dc_site_code;
        
        if($store_site_code !='' AND $dc_site_code !='')
        {
            $this->data->produk = $this->produk_m->get_by_url($url,$store_site_code,$dc_site_code);
            
            $this->data->sv2_price = $this->produk_m->get_by_url2($url,$store_site_code,$dc_site_code);
            
             $this->data->sv3_price = $this->produk_m->get_by_url3($url,$store_site_code,$dc_site_code);
        
        }else{
            
            $this->session->set_flashdata('login','<div class="alert-danger"><center>Waktu Anda habis, silahkan login kembali.</center></div>');
            redirect('user/login');
        }
        
        
        $this->template->set_judul('Centralize Delivery & Inventory')
        ->set_js('jquery')
        ->set_css('bootstrap')
        ->set_css('base')
        ->set_css('bootstrap-responsive')
        ->set_css('font-awesome')
        ->set_css('mystyle')
        ->set_parsial('topmenu','top_view',$this->data)
        ->render('single',$this->data);
        
    }
    
    
    public function add_cart() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->add_cart);
        
        $recent_stock = $this->input->post('recent_stock');
            
        if($this->input->post('colorRadio') == 2){
            $price = $this->input->post('pcash');
            $plu = $this->input->post('plu_cash');
        }else{
            $price = $this->input->post('pcredit');
            $plu = $this->input->post('plu_credit');
        }
        
        //$this->form_validation->set_rules('field' => 'colorRadio', 'label' => 'colorRadio', 'rules' => 'required');

        
        if($this->form_validation->run()) {
        
        
        $data = array ( 'id'=>$this->input->post('ARTICLE_CODE'),
                        'name'=>$this->input->post('ARTICLE_DESC'),
                        'qty'=>$this->input->post('qty'),
                        'price'=>$price,
                        'PLU'=>$plu,
                        'pembayaran' => $this->input->post('colorRadio')
                        );
        
        
            if($data['qty'] > $recent_stock){
                
                $this->session->set_flashdata('user_note','<div class="alert-danger">Stok tidak mencukupi</div>');
            
                redirect (site_url($this->input->post('url')));
                
            }else{
            
            $this->cart->insert($data);
            $this->session->set_flashdata('user_note','<div class="alert-success">Produk berhasil ditambahkan ke dalam List Pemesanan.</div><br/><div class=pull-right><a href='.site_url().'store/kategori><span class="btn btn-info">Tambah Produk</span></a><a href='.site_url().'store/checkout>  <span class="btn btn-success">Pemesanan Selesai</span></a></div>');
            
            redirect (site_url($this->input->post('url')));
            }
        
        }else{
        $this->session->set_flashdata('error', validation_errors('<div class="alert-danger">', '</div><br/>'));
        redirect (site_url($this->input->post('url')));
            
        }
        //$this->form_validation->set_message('required', 'Error message');
        //echo (site_url($this->input->post('url')));
        
        
        
    }
    
    
    
    
    
    public function hapus_cart() {
        $this->cart->destroy();
        redirect (site_url());
    }
    
    public function confirm_delete($rowid){
        
        $data = array(
        'rowid'   => $rowid,
        'qty'     => 0
        );
        
        $this->cart->update($data);
        redirect (site_url('store/kategori'));
    }
    
    public function delete(){
        //$id OR redirect(site_url('store/delete'));
        $id = $this->input->post('id');
        $data = array(
        //'rowid'=>$this->input->post('rowid'),
        'rowid'   => $id,
        'qty'     => 0
        );
        
        $this->cart->update($data);
        
        //redirect (site_url('store/checkout'));
    }
    
    public function checkout() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->profile_rules);
        
        $this->load->model('profile_m');
        $this->load->model('order_m');
        $this->load->model('pesanan_m');
        $this->load->model('option_m');
        $this->load->helper('date');
        
        $this->data->biaya= $this->option_m->biaya();
        
        $data = $this->profile_m->get_by(array('user_id'=>$this->session->userdata('user_id')));
        
        
        $this->data->dc_site_code = $this->session->userdata('dc_site_code');
        $this->data->store_site_code = $this->session->userdata('store_site_code');
        
        
        
        $order_no_gtron = $this->input->post('order_no');
        $pembayaran = $this->input->post('pemb');
        
        //$id = $this->session->userdata('user_id');
        
        
        
        //if($_POST) {
        //    $this->cart->update($_POST);   
        //}
        
        if($this->form_validation->run()) {
            $insert = array(    'nama_depan'      =>  $this->input->post('nama_depan'),
                                'nama_belakang'   =>  $this->input->post('nama_belakang'),
                                'alamat'          =>  $this->input->post('alamat'),
                                'kode_pos'        =>  $this->input->post('kode_pos'),
                                'phone'           =>  $this->input->post('phone'),
                                'ORDER_NO_GTRON'  =>  $order_no_gtron
                                );
            
            $total = $this->input->post('total');
            $biaya = $this->input->post('biaya');
            $biaya_nego = $this->input->post('biaya_nego');
            
            //echo $biaya_nego;
            //echo "<br/>";
            //echo $biaya;
            
            if($biaya_nego != 0){
                
                $biaya_kirim = $biaya_nego;
                $total_biaya = $total + $biaya_nego;
                //echo "total biaya nego".$total_biaya."<br/>";
            }else{
               
                
                $biaya_kirim = $biaya;
                $total_biaya = $total + $biaya;
                //echo "biaya".$total_biaya;
            }
            
            //echo $total_biaya;
            $order = array(     'user_id'         =>  $this->session->userdata('user_id'),
                                'FLAG'            =>  '0',
                                'total_biaya'     =>  $total_biaya,
                                'biaya_kirim'     =>  $biaya_kirim,
                                'total_item'      =>  $this->input->post('total_item'),
                                'ORDER_NO_GTRON'  =>  $order_no_gtron,
                                'ORDER_NO_GOLD'   =>  '0',
                                'SITE_CODE'       =>  $this->data->store_site_code,
                                'DC_CODE'         =>  $this->data->dc_site_code
                                
                                );
                                
            
            if($order['total_biaya'] == NULL){
                $this->session->set_flashdata('pesan', '<div class="error">List Pesanan Anda kosong </div><br/><div class="sukses">Silahkan memilih kembali produk yang akan dibeli.</div>');
                
                redirect(site_url('store/order'));
            
            
            
            
            }else{
                
                $insert['user_id'] = $this->session->userdata('user_id');
                
                $cek_stok = $this->order_m->cek_stok($this->cart->contents());
                if($cek_stok == '') {
                    //echo $this->input->post('total_item');
                    //echo "<br/>";
                    //echo $pembayaran;
                    
                    if($this->profile_m->insert($insert)){
                        $this->order_m->insert($order,$this->cart->contents(),$order_no_gtron);
                        $this->cart->destroy();
                        
                        //$this->session->set_flashdata('pesan', '<div class="sukses">Data pesanan telah kami terima, silahkan melakukan proses pembayaran.</div><br/><div class="sukses">Nomor Order Anda : <b>'.$order['ORDER_NO_GTRON'].'</b></div>');
                        redirect(site_url('store/order/'.$order['ORDER_NO_GTRON']));
                    }
                   
                }
                else {
                   
                    $list_prod = explode('###',$cek_stok);
                    $alert ='';
                    
                    foreach($list_prod as $val) {
                        $prod = explode('!@#',$val);
                        
                        $alert.= $prod[1].'<br/>';
                        
                    }
                    
                    $this->data->stok = $alert;
                }
                
            }
        }
        
        if($data){
            $this->data->nama_depan = $data->nama_depan;
            $this->data->nama_belakang = $data->nama_belakang;
            $this->data->alamat = $data->alamat;
            $this->data->kode_pos = $data->kode_pos;
            $this->data->phone = $data->phone;
            //$this->data->order_no = $data->order_no;
            
        }else{
            $this->data->nama_depan = set_value('nama_depan');
            $this->data->nama_belakang = set_value('nama_belakang');
            $this->data->alamat = set_value('alamat');
            $this->data->kode_pos = set_value('kode_pos');
            $this->data->phone = set_value('phone');
            
        }
        
        
        $this->template->set_judul('Centralize Delivery & Inventory')
        ->set_js('jquery')
        ->set_css('bootstrap')
        ->set_css('base')
        ->set_css('bootstrap-responsive')
        ->set_css('font-awesome')
        ->set_css('mystyle')
        ->set_parsial('topmenu','top_view',$this->data)
        ->render('checkout',$this->data); 
    }
    
    public function order($ordernumb) {
        
        
        $this->load->model('pesanan_m');
        
        
        $this->data->dc_site_code = $this->session->userdata('dc_site_code');
        $store_site_code = $this->data->store_site_code;
        
        
        $this->data->pembeli = $this->pesanan_m->print_pembeli($ordernumb);
        $this->data->transaksi = $this->pesanan_m->print_transaksi($ordernumb, $store_site_code);
        
        
        $this->template->set_judul('Centralize Delivery & Inventory')
        ->set_js('jquery')
        ->set_css('bootstrap')
        ->set_css('base')
        ->set_css('bootstrap-responsive')
        ->set_css('font-awesome')
        ->set_css('mystyle')
        ->set_parsial('topmenu','top_view',$this->data)
        ->render('order',$this->data); 
        
    }
    
    public function order_selesai($ordernumb) {
        $this->load->model('pesanan_m');
        
        $store_site_code = $this->data->store_site_code;
        
        //$get = $this->uri->uri_to_assoc();
        //$ordernumb = $get['id'];
        //$this->data->nomor = $ordernumb;
        
        
        $this->data->pembeli = $this->pesanan_m->print_pembeli($ordernumb);
        $this->data->transaksi = $this->pesanan_m->print_transaksi($ordernumb, $store_site_code);
        
        $this->template->set_judul('Centralize Delivery & Inventory')
        ->set_js('jquery')
        ->set_css('bootstrap')
        ->set_css('base')
        ->set_css('bootstrap-responsive')
        ->set_css('font-awesome')
        ->set_css('mystyle')
        ->set_parsial('topmenu','top_view',$this->data)
        ->render('order_selesai',$this->data); 
        
    }
    
    
    
    public function prints(){
        
        error_reporting(0);  //suppress some error message
		$parameters=array(
			'paper'=>'letter',   //paper size
			'orientation'=>'landscape',  //portrait or lanscape
			'type'=>'none',   //paper type: none|color|colour|image
			'options'=>array(0.6, 0.9, 0.8) //I specified the paper as color paper, so, here's the paper color (RGB)
		);
		$this->load->library('pdf', $parameters);  //load ezPdf library with above parameters
		$this->pdf->selectFont(APPPATH.'/third_party/pdf-php/fonts/Helvetica.afm');  //choose font, watch out for the dont location!
		$this->pdf->ezText('Yogya E-Commerce',20);  //insert text with size
                $this->pdf->addText(50,32,8,'Printed on '.date('m/d/Y h:i:s a'));
 
		//get data from database (note: this should be on 'models' but mehhh..), we'll try creating table using ezPdf
		$q=$this->db->query('SELECT username, email, level FROM user');
                //this data will be presented as table in PDF
		$data_table=array();
		foreach ($q->result_array() as $row) {
			$data_table[]=$row;
		}
                //this one is for table header
		$column_header=array(
			'username'=>'username',
			'email'=>'email',
			'level'=>'level'
		);
		$this->pdf->ezTable($data_table, $column_header); //generate table
		$this->pdf->ezSetY(480);  //set vertical position
		//$this->pdf->ezImage(base_url('images/img1.jpg'), 0, 100, 'none', 'center');  //insert image
		$this->pdf->ezStream(array('Content-Disposition'=>'just_random_filename.pdf'));  //force user to download the file as 'just_random_filename.pdf'

        $this->template->set_judul('Centralize Delivery & Inventory')
        ->set_css('style')
        ->set_parsial('sidebar','sidebar_view',$this->data)
        ->set_parsial('topmenu','top_view',$this->data)
        ->render('print',$this->data); 
    
    }
    
    public function search(){
        
        $data['link_map'] = ''; 
        $data['search_name'] ='';
        $data['search_dc_site_code'] = '';
        $data['search_store_site_code'] = '';
        //$data['data'] = $this->produk_m->get_all_produk2();
	
        //$dc_site_code = $this->input->post('dc_site_code');
        //$store_site_code = $this->input->post('store_site_code');
        
        
        if(isset($_POST['submit']))
        {
            $data['search_name'] = $this->input->post('search_name');
            //$data['search_dc_site_code'] = $this->input->post('dc_site_code');
            //$data['search_store_site_code'] = $this->input->post('store_site_code');
            
            
            //$dc_site_code = 15199;
            //$store_site_code = 15102;
            //
            //echo $store_site_code;
            //echo "<br/>";
            //echo $dc_site_code;
            
            //set session user data untuk pencarian, untuk paging pencarian
            $this->session->set_userdata('sess_name', $data['search_name']);
            $this->session->set_userdata('sess_dc_site_code', $data['search_dc_site_code']);
            $this->session->set_userdata('sess_store_site_code', $data['search_store_site_code']);
            
        } else {
            $data['search_name'] = $this->session->userdata('sess_name');
            $data['search_dc_site_code'] = $this->session->userdata('sess_dc_site_code');
            $data['search_store_site_code'] = $this->session->userdata('sess_store_site_code');
        }
		
        if ($this->config->item('enable_sphinx_search') == '0')
        {
                
                $this->db->select('*');
                $this->db->from('DC_STOCK_MASTER');
                $this->db->join('MS_MASTER', 'DC_STOCK_MASTER.SUBCLASS = MS_MASTER.MS_CHILD');
                $this->db->join('STORE_SALES_MASTER', 'DC_STOCK_MASTER.ARTICLE_CODE = STORE_SALES_MASTER.ARTICLE_CODE');
                $this->db->where('DC_SITE_CODE',15199);
                $this->db->where('STORE_SITE_CODE',15102);
                $this->db->like('DC_STOCK_MASTER.PLU', $data['search_name']);
                
        }
        else
        {
                $this->load->library('fsphinxlib');
                $fsphinx = $this->fsphinxlib->create();
                
                $res = $fsphinx->query($data['search_name']);
                
                $foundId = array(0);
                
                if ($res)
                {
                        if (array_key_exists('total_found', $res))
                        {
                                if ($res['total_found'] > 0)
                                {
                                        $foundId = array();
                                        if ( is_array($res["matches"]) )
                                        {
                                                foreach ( $res["matches"] as $key => $docinfo )
                                                {
                                                        $foundId[] = $key;
                                                }
                                        }
                                }
                        }
                }			
                
                if (count($foundId) > 0)
                {
                    
                        
                        $this->db->select('*');
                        $this->db->from('DC_STOCK_MASTER');
                        $this->db->join('MS_MASTER', 'DC_STOCK_MASTER.SUBCLASS = MS_MASTER.MS_CHILD');
                        $this->db->join('STORE_SALES_MASTER', 'DC_STOCK_MASTER.ARTICLE_CODE = STORE_SALES_MASTER.ARTICLE_CODE');
                        $this->db->where('DC_SITE_CODE',15199);
                        $this->db->where('STORE_SITE_CODE',15102);
                        $this->db->where_in('DC_STOCK_MASTER.ARTICLE_CODE', $foundId);
                }	
        }
    
        //Pagination init
        $pagination['base_url'] 		= site_url('/store/search/page/');
        $pagination['total_rows'] 		= $this->db->count_all_results();
        $pagination['full_tag_open'] 	        = "<div class=\"pagination\">";
        $pagination['full_tag_close'] 	        = "</div>";
        $pagination['cur_tag_open'] 	        = "<span class=\"current\">";
        $pagination['cur_tag_close'] 	        = "</span>";
        $pagination['num_tag_open'] 	        = "<span class=\"disabled\">";
        $pagination['num_tag_close'] 	        = "</span>";
        $pagination['per_page'] 		= 1;
        $pagination['uri_segment'] 		= 4;
        $pagination['num_links'] 		= 4;
    
        $this->pagination->initialize($pagination);
    
        if ($this->config->item('enable_sphinx_search') == '0')
		{
			$data['data'] = $this->produk_m->SearchResult_front($pagination['per_page'],$this->uri->segment(4,0),$data['search_name'],$data['search_dc_site_code'],$data['search_store_site_code']);
		}
		else
		{
			$data['data'] = $this->produk_m->SearchResult_front($pagination['per_page'],$this->uri->segment(4,0),$data['search_name'], $foundId,$data['search_dc_site_code'], $data['search_store_site_code']);
		}
		
        $this->load->vars($data);
        
	$this->template->set_judul('Centralize Delivery & Inventory')
        ->set_js('jquery')
        ->set_css('bootstrap')
        ->set_css('base')
        ->set_css('bootstrap-responsive')
        ->set_css('font-awesome')
        ->set_css('mystyle')
       
        ->set_parsial('sidebar','sidebar_view',$this->data)
        ->set_parsial('topmenu','top_view',$this->data)
	->render('store',$data); 
    
    }
    
    
    public function search_prod(){
        
        if(isset($_POST['submit']))
        {
            $data['search_name'] = $this->input->post('search_name');
            $dc_site_code = $this->input->post('dc_site_code');
            $store_site_code = $this->input->post('store_site_code');
            
            //set session user data untuk pencarian, untuk paging pencarian
            $this->session->set_userdata('sess_name', $data['search_name']);
            $this->session->set_userdata('sess_dc_site_code', $dc_site_code);
            $this->session->set_userdata('sess_store_site_code', $store_site_code);
           
            
        } else {
            $data['search_name'] = $this->session->userdata('sess_name');
            $dc_site_code = $this->session->userdata('sess_dc_site_code');
            $store_site_code = $this->session->userdata('sess_store_site_code');
            $multiuser = $this->session->userdata('multiuser');
        }
        
        
        if($this->data->multiuser == 0){
        $this->db->select('*');
        $this->db->from('DC_STOCK_MASTER');
        $this->db->join('ART_ATTRIB', 'DC_STOCK_MASTER.ARTICLE_CODE = ART_ATTRIB.ART_CODE');
        $this->db->join('DELIVARABLE_MASTER', 'DC_STOCK_MASTER.ARTICLE_CODE = DELIVARABLE_MASTER.ARTICLE_CODE');
        $this->db->join('STORE_SALES_MASTER', 'DC_STOCK_MASTER.ARTICLE_CODE = STORE_SALES_MASTER.ARTICLE_CODE');
        $this->db->where('DC_STOCK_MASTER.DC_SITE_CODE',$dc_site_code);
        $this->db->where('STORE_SALES_MASTER.STORE_SITE_CODE',$store_site_code);
        $this->db->where('ART_ATTRIB.END_DATE','>= CURDATE() AND ART_ATTRIB.START_DATE <= CURDATE()');
        //$this->db->group_by('DC_STOCK_MASTER.ARTICLE_CODE');
        }else{
            
            $this->db->select('*');
            $this->db->from('DC_STOCK_MASTER');
            $this->db->join('ART_ATTRIB', 'DC_STOCK_MASTER.ARTICLE_CODE = ART_ATTRIB.ART_CODE');
            $this->db->join('DELIVARABLE_MASTER', 'DC_STOCK_MASTER.ARTICLE_CODE = DELIVARABLE_MASTER.ARTICLE_CODE');
            $this->db->join('STORE_SALES_MASTER', 'DC_STOCK_MASTER.ARTICLE_CODE = STORE_SALES_MASTER.ARTICLE_CODE');
            $this->db->where('ART_ATTRIB.END_DATE','>= CURDATE() AND ART_ATTRIB.START_DATE <= CURDATE()');
        }
        
        if($data['search_name'] != ''){
            $this->db->or_like('DC_STOCK_MASTER.ARTICLE_CODE', strtoupper($data['search_name']));
            //$this->db->or_like('DC_STOCK_MASTER.PLU', $data['search_name']);
            //$this->db->or_like('DC_STOCK_MASTER.ARTICLE_DESC', strtoupper($data['search_name']));
            
            //echo"a";
            
        }
        
        $this->db->group_by('DC_STOCK_MASTER.ARTICLE_CODE');
        
        //Pagination init
        $pagination['base_url'] 		= site_url('/store/search_prod/page/');
        $pagination['total_rows'] 		= $this->db->get()->num_rows();
        $pagination['full_tag_open'] 	        = "";
        $pagination['full_tag_close'] 	        = "";
        $pagination['cur_tag_open'] 	        = "<a style='background-color: #E3E3E3'>";
        $pagination['cur_tag_close'] 	        = "</a>";
        $pagination['num_tag_open'] 	        = "";
        $pagination['num_tag_close'] 	        = "";
        $pagination['per_page'] 		= 9;
        $pagination['uri_segment'] 		= 4;
        $pagination['num_links'] 		= 4;
    
        $this->pagination->initialize($pagination);
    
        $data['data'] = $this->produk_m->SearchResult($pagination['per_page'],$this->uri->segment(4,0),$data['search_name'],$dc_site_code,$store_site_code, $multiuser);
    
        $this->load->vars($data);
        
        
	$this->template->set_judul('Centralize Delivery & Inventory')
        ->set_js('jquery')
        ->set_css('bootstrap')
        ->set_css('base')
        ->set_css('bootstrap-responsive')
        ->set_css('font-awesome')
        ->set_css('mystyle')
       
        ->set_parsial('sidebar','sidebar_view',$this->data)
        ->set_parsial('topmenu','top_view',$this->data)
	->render('store',$data); 
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
    
    public function test()
    {
        $data = array();
        
        $data['result'] = $this->input->post('postVar1').'niel'; 
        
        echo json_encode($data);
    }
    
    public function transaksi() {
        $this->load->model('pesanan_m');
        

        $store_site_code = $this->data->store_site_code;
        
        $this->data->base_url = base_url().'/store/transaksi';
		
	//$this->data->total_rows = $this->db->count_all('order');
	$this->data->per_page = $this->config->item('hlm');
	$this->data->uri_segment = 4;
        $this->pagination->initialize($this->data);
	
        if($store_site_code != '')
        {
            
            if($this->data->multiuser == 1){
                $this->data->pesanan = $this->pesanan_m->get_all_transaksi();
            }else{
                $this->data->pesanan = $this->pesanan_m->get_transaksi($this->data->per_page,$this->uri->segment(4,0), $store_site_code);
            }
        
        }else{
            $this->session->set_flashdata('login','<div class="alert-danger"><center>Waktu Anda habis, silahkan login kembali.</center></div>');
            redirect('user/login');
        }
	
        $this->template->set_judul('Centralize Delivery & Inventory')
        
        ->set_css('bootstrap')
        ->set_css('base')
        ->set_css('bootstrap-responsive')
        ->set_css('font-awesome')
        ->set_css('prettify')
        ->set_css('mystyle')
        ->set_parsial('topmenu','top_view',$this->data)
        ->render('transaksi',$this->data); 
    }
    
    public function detail($id = 0) {
       $this->load->model('pesanan_m');
        
        if ($this->input->post('submit2')){
            $orderno = $this->input->post('orderno');
            
            
            $this->db->set('a.FLAG', '4');
            $this->db->set('b.FLAG', '4');
            
            $this->db->where('a.ORDER_NO_GTRON', $orderno);
            $this->db->where('b.ORDER_NO_GTRON', $orderno);
            $this->db->update('SUPPLIER_ORDER_HEADER as a, SUPPLIER_ORDER_DETAIL as b');
            
            redirect (site_url('store/transaksi'));
	}
        
        if ($this->input->post('submit')){
            $orderno = $this->input->post('orderno');
            $nostruk = $this->input->post('nomor');
            
            
            $this->db->set('a.FLAG', '1');
            $this->db->set('a.no_struk',$nostruk);
            $this->db->set('b.FLAG', '1');
            
            $this->db->where('a.ORDER_NO_GTRON', $orderno);
            $this->db->where('b.ORDER_NO_GTRON', $orderno);
            $this->db->update('SUPPLIER_ORDER_HEADER as a, SUPPLIER_ORDER_DETAIL as b');
            
            redirect (site_url('store/transaksi'));
	} else {
	    //CEK STATUS KONFIRMASI sudah / blom
	    //$this->data->cek_k = $this->konfirmasi_m->cek_k($id);
            
	    $this->data->detail = $this->pesanan_m->get_detail_trans(array('id_order'=>$id),true);
        }
        
        $this->template->set_judul('Centralize Delivery & Inventory')
        ->set_js('jquery')
        ->set_css('bootstrap')
        ->set_css('base')
        ->set_css('bootstrap-responsive')
        ->set_css('font-awesome')
        ->set_css('prettify')
        ->set_css('mystyle')
        ->set_parsial('topmenu','top_view',$this->data)
        ->render('detail_transaksi',$this->data); 
        
    }
}
?>
