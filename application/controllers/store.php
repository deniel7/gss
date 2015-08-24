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
        $this->data->subkat = $this->kategori_m->subkat();
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
        
        $this->data->nosearch = TRUE;
        
        
        $this->template->set_judul('Centralize Delivery & Inventory')
        ->set_js('jquery')
        ->set_js('modernizr.custom.86080')
        ->set_css('bootstrap')
        ->set_css('base')
        ->set_css('bootstrap-responsive')
        ->set_css('font-awesome')
        ->set_css('mystyle')
        ->set_css('demo')
        ->set_css('style1')
        
        ->set_parsial('slidebanner','slide_banner',$this->data)
        ->set_parsial('topmenu','top_view',$this->data)
        ->render('front',$data);   
    }
    
    public function home(){        
        
        $this->session->unset_userdata('spv_pass');
        
        
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
        
        $names = $this->input->post('ARTICLE_DESC');
        $name = preg_replace('/[^A-Za-z0-9\-]/', ' ', $names);
        
        $data = array ( 'id'=>$this->input->post('ARTICLE_CODE'),
                        'name'=>$name,
                        'qty'=>$this->input->post('qty'),
                        'price'=>$price,
                        'PLU'=>$plu,
                        'stock_cost' =>$this->input->post('STOCK_COST'),
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
                                'penerima'        =>  $this->input->post('penerima'),
                                'ORDER_NO_GTRON'  =>  $order_no_gtron
                                );
            
            $total = $this->input->post('total');
            $cpv = $this->input->post('cpv');
            $biaya = $this->input->post('biaya');
            $biaya_nego = $this->input->post('biaya_nego');
            $tanggal = $this->input->post('tgl');
            
            if($tanggal != 0){
                $tgl = $this->input->post('tgl');    
            }else{
                $tgl_besok = $this->input->post('tgl_besok');
                $tgl = date('Y-m-d', strtotime($tgl_besok));
                
                
            } 
            
            $catatan = $this->input->post('catatan');

            
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
                                'ORDER_NO_GOLD'   =>  $order_no_gtron,
                                'SITE_CODE'       =>  $this->data->store_site_code,
                                'DC_CODE'         =>  $this->data->dc_site_code,
                                'ORDER_DELIVERY_DATE' => $tgl,
                                'catatan' => $catatan,
                                'COST_PRICE_VALUE' => $cpv
                                
                                );
                                
            
            if($order['total_biaya'] == NULL){
                $this->session->set_flashdata('pesan', '<div class="error">List Pesanan Anda kosong </div><br/><div class="sukses">Silahkan memilih kembali produk yang akan dibeli.</div>');
                
                redirect(site_url('store/order'));
            
            
            
            
            }else{
                
                $insert['user_id'] = $this->session->userdata('user_id');
                //echo $tgl; 
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
        ->set_js('jquery-1.8.3.min')
        ->set_js('bootstrap.min')
        ->set_js('bootstrap-datetimepicker.min')
        ->set_js('bootstrap-datetimepicker.uk')
        ->set_css('bootstrap')
        ->set_css('bootstrap-datetimepicker.min')
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
        
        $catatan = $this->input->post('catatan');
        
        $data = array (
                        'ORDER_NO_GTRON' =>$ordernumb,
                        'nama_depan'=>$this->input->post('nama_depan'),
                        'nama_belakang'=>$this->input->post('nama_belakang'),
                        'alamat'=>$this->input->post('alamat'),
                        'kode_pos'=>$this->input->post('kodepos'),
                        'phone'=>$this->input->post('phone'),
                        'penerima' =>$this->input->post('penerima')
                        
                        );
        
        $this->pesanan_m->update_user_booking($data, $ordernumb, $catatan);
        
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
        
        $data['search_name'] =''; 
        
	
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
        
        
        if ($this->config->item('enable_sphinx_search') == '0')
        {
                $search = $this->input->post('search');
                
                $this->db->select('*');
                    $this->db->from('DC_STOCK_MASTER');
                    $this->db->join('ART_ATTRIB', 'DC_STOCK_MASTER.ARTICLE_CODE = ART_ATTRIB.ART_CODE');
                    $this->db->join('DELIVARABLE_MASTER', 'DC_STOCK_MASTER.ARTICLE_CODE = DELIVARABLE_MASTER.ARTICLE_CODE');
                    $this->db->join('STORE_SALES_MASTER', 'DC_STOCK_MASTER.ARTICLE_CODE = STORE_SALES_MASTER.ARTICLE_CODE');
                    $this->db->where('DC_STOCK_MASTER.DC_SITE_CODE',$dc_site_code);
                    $this->db->where('STORE_SALES_MASTER.STORE_SITE_CODE',$store_site_code);
                    $this->db->where('CURDATE() BETWEEN ART_ATTRIB.START_DATE AND ART_ATTRIB.END_DATE');
                    
                    $this->db->where('STORE_SALES_MASTER.PLU', $data['search_name']);
                    //$this->db->or_where('DC_STOCK_MASTER.ARTICLE_CODE', strtoupper($data['search_name']));
                    $this->db->group_by('DC_STOCK_MASTER.ARTICLE_CODE');
                
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
                        $this->db->join('ART_ATTRIB', 'DC_STOCK_MASTER.ARTICLE_CODE = ART_ATTRIB.ART_CODE');
                        $this->db->join('DELIVARABLE_MASTER', 'DC_STOCK_MASTER.ARTICLE_CODE = DELIVARABLE_MASTER.ARTICLE_CODE');
                        $this->db->join('STORE_SALES_MASTER', 'DC_STOCK_MASTER.ARTICLE_CODE = STORE_SALES_MASTER.ARTICLE_CODE');
                        $this->db->where('DC_STOCK_MASTER.DC_SITE_CODE',$dc_site_code);
                        $this->db->where('STORE_SALES_MASTER.STORE_SITE_CODE',$store_site_code);
                        $this->db->where('CURDATE() BETWEEN ART_ATTRIB.START_DATE AND ART_ATTRIB.END_DATE');
                        $this->db->where_in('DC_STOCK_MASTER.ARTICLE_CODE', $foundId);
                    
                }	
        }
    
        //Pagination init
        $pagination['base_url'] 		= site_url('/store/search/page/');
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
    
        if ($this->config->item('enable_sphinx_search') == '0')
        {
                $data['data'] = $this->produk_m->SearchResult_front($pagination['per_page'],$this->uri->segment(4,0),$data['search_name'],$dc_site_code,$store_site_code);
                
        }
        else
        {
                $data['data'] = $this->produk_m->SearchResult_front($pagination['per_page'],$this->uri->segment(4,0),$data['search_name'],$dc_site_code,$store_site_code, $foundId);
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
            $this->db->where('STORE_SALES_MASTER.SV', strtoupper($data['search_name']));
            //$this->db->or_like('DC_STOCK_MASTER.PLU', $data['search_name']);
            //$this->db->or_like('DC_STOCK_MASTER.ARTICLE_DESC', strtoupper($data['search_name']));
           
        }
        
        $this->db->group_by('DC_STOCK_MASTER.ARTICLE_CODE');
        //echo $this->db->last_query();
        //Pagination init
        $pagination['base_url'] 		= site_url('/store/search_prod/page/');
        $pagination['total_rows'] 		= $this->db->get()->num_rows();
        $pagination['full_tag_open'] 	        = "";
        $pagination['full_tag_close'] 	        = "";
        $pagination['cur_tag_open'] 	        = "<a style='background-color: #E3E3E3'>";
        $pagination['cur_tag_close'] 	        = "</a>";
        $pagination['num_tag_open'] 	        = "";
        $pagination['num_tag_close'] 	        = "";
        $pagination['per_page'] 		= 3;
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
    
    
    
    public function test()
    {
        $data = array();
        
        $data['result'] = $this->input->post('postVar1').'niel'; 
        
        echo json_encode($data);
    }
    
    public function transaksi() {
        $this->session->unset_userdata('spv_pass');
        
        $this->load->model('pesanan_m');
        

        $store_site_code = $this->data->store_site_code;
        
        $this->data->base_url = base_url().'/store/transaksi';
	
	
        if($store_site_code != '')
        {
            
            if($this->data->multiuser == 1){
                $this->data->pesanan = $this->pesanan_m->get_all_transaksi();
            }else{
                $this->data->pesanan = $this->pesanan_m->get_transaksi($store_site_code);
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
        
        $waktu_confirm = date('Y-m-d H:i:s'); 
        
        if ($this->input->post('submit2')){
            $orderno = $this->input->post('orderno');
            $password = $this->input->post('password');
            
            if($password == 'spv12345'){
                
                $this->db->set('a.FLAG', '10');
                $this->db->set('b.FLAG', '10');
                
                $this->db->where('a.ORDER_NO_GTRON', $orderno);
                $this->db->where('b.ORDER_NO_GTRON', $orderno);
                $this->db->update('SUPPLIER_ORDER_HEADER as a, SUPPLIER_ORDER_DETAIL as b');
            
                $this->data->error_pass = '<div class="alert-success" style="text-align:center">Proses Cancel Order Berhasil</div>';
            }else{
                $this->data->error_pass = '<div class="alert-error" style="text-align:center">Anda Salah menginput Password</div>';
            }
            //redirect (site_url('store/transaksi'));
            
	} 
        
        if ($this->input->post('submit')){
            $orderno = $this->input->post('orderno');
            $nostruk = $this->input->post('nomor');
            $total_biaya_inputs = $this->input->post('total_biaya_input');
            //$password = $this->input->post('password');
            $total_biaya_input = str_replace(".","",$total_biaya_inputs);
                                             
            //if($password == 'spv12345'){
                
                $this->db->set('a.FLAG', '1');
                $this->db->set('a.no_struk',$nostruk);
                $this->db->set('a.TOTAL_BIAYA_INPUT', $total_biaya_input);
                $this->db->set('a.waktu_confirm', $waktu_confirm);
                $this->db->set('b.FLAG', '1');
               
                $this->db->where('a.ORDER_NO_GTRON', $orderno);
                $this->db->where('b.ORDER_NO_GTRON', $orderno);
                $this->db->update('SUPPLIER_ORDER_HEADER as a, SUPPLIER_ORDER_DETAIL as b');
                
                $this->data->error_pass = '<div class="alert-success" style="text-align:center">Proses Submit Pesanan Berhasil</div>';
            
            //}else{
            //    $this->data->error_pass = '<div class="alert-error" style="text-align:center">Anda Salah menginput Password</div>';
            //}
            
	
        $this->data->detail = $this->pesanan_m->get_detail_trans(array('id_order'=>$id),true);
         
        } else {
	    //CEK STATUS KONFIRMASI sudah / blom
	    //$this->data->cek_k = $this->konfirmasi_m->cek_k($id);
            
	    $this->data->detail = $this->pesanan_m->get_detail_trans(array('id_order'=>$id),true);
        }
        
        
        
        if ($this->input->post('submit_conf')){
            
            $id = $this->input->post('id_order');
            $password = $this->input->post('password');
            
            if($password == 'spv12345'){
                 
                $spv_pass = array(
                   //'username'  => 'johndoe',
                   //'email'     => 'johndoe@some-site.com',
                   'spv_pass' => TRUE
                );

                $this->session->set_userdata($spv_pass);
                 
                 redirect (site_url('store/cancel_confirm/'.$id));
            }else{
                $this->data->error_pass = '<div class="alert-error" style="text-align:center">Anda Salah menginput Password SPV</div>';
                
               
            } 
        } 
        
        
        $this->template->set_judul('Centralize Delivery & Inventory')
        ->set_js('jquery')
        ->set_js('jquery.min')
        ->set_js('jquery.countdown.min')
        ->set_js('jquery.plugin.min')
        ->set_css('bootstrap')
        ->set_css('base')
        ->set_css('bootstrap-responsive')
        ->set_css('font-awesome')
        ->set_css('prettify')
        ->set_css('mystyle')
        ->set_parsial('topmenu','top_view',$this->data)
        ->render('detail_transaksi',$this->data); 
        
    }
    
    public function cancel_confirm($id = 0, $order = array()){
        $this->load->model('pesanan_m');
        $this->load->model('kategori_m');
        $this->load->model('order_m');
        
        
        if($this->data->store_site_code == '')
        {
            $this->session->set_flashdata('login','<div class="alert-danger"><center>Waktu Anda habis, silahkan login kembali.</center></div>');
            redirect('user/login');
        
        }else{
        
        
            if ($this->session->userdata('spv_pass') == FALSE)
            {
              //$this->error = (array('status'=>'Status belum aktif'));
              $this->data->error_pass = '<div class="alert-error" style="text-align:center">Anda Salah menginput Password SPV</div>';
              redirect (site_url('store/transaksi/'));
               
            }
            
            //UPDATE JUMLAH ITEM BOOKING
            if ($this->input->post('update') && $this->data->store_site_code != ''){
                $id_order_detail =  $this->input->post('id_order_detail');
                $kuantitas =  $this->input->post('v');
                $total_item = $this->input->post('total_item');
                $orderno = $this->input->post('orderno');
                $total_cpv = $this->input->post('total_cpv');
                
                $order = array(     'id_order_detail'         =>  $id_order_detail,
                                    'kuantitas'            =>  $kuantitas,
                                    
                                    );
                
                //var_dump($order);
                $this->order_m->update_booking($order, $total_item, $orderno, $total_cpv);
                
                
            }
            
            if ($this->input->post('save') && $this->data->store_site_code != ''){
                $id_order_detail =  $this->input->post('id_order_detail');
                $kuantitas =  $this->input->post('v');
                $total_item = $this->input->post('total_item');
                $orderno = $this->input->post('orderno');
                $total_cpv = $this->input->post('total_cpv');
                
                $order = array(     'id_order_detail'         =>  $id_order_detail,
                                    'kuantitas'            =>  $kuantitas,
                                    
                                    );
                
                //var_dump($order);
                $this->order_m->update_booking($order, $total_item, $orderno, $total_cpv);
                redirect (site_url('store/transaksi/'));
                
            }
            
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
        ->render('cancel_confirm',$this->data); 
    }
    
    public function ex_cancel_confirm(){
        
        if ($this->data->store_site_code != ''){
            
            $art_code = $this->uri->segment(3);
            $orderno_gtron = $this->uri->segment(4);
            $id_order = $this->uri->segment(5);
            
            $this->db->set('cancel', '1');
            $this->db->where('ORDER_NO_GTRON', $orderno_gtron);
            $this->db->where('ARTICLE_CODE', $art_code);
            $this->db->update('SUPPLIER_ORDER_DETAIL');
        
        redirect (site_url('store/cancel_confirm/'.$id_order));
        }
    }
    
    public function ex_all_cancel_confirm(){
        
        if ($this->data->store_site_code != ''){
        
        $orderno = $this->input->post('orderno');
        
        $this->db->set('a.FLAG', '11');
        $this->db->set('b.FLAG', '11');
        
        $this->db->where('a.ORDER_NO_GTRON', $orderno);
        $this->db->where('b.ORDER_NO_GTRON', $orderno);
        $this->db->update('SUPPLIER_ORDER_HEADER as a, SUPPLIER_ORDER_DETAIL as b');
        
        
        //redirect (site_url('store/transaksi'));
        
        
        
        }
        $this->data->error_pass = '<div class="alert-danger" style="text-align:center">Berhasil melakukan Cancel Transaction, Harap melakukan proses Retur Manual.</div>';
        
        $this->template->set_judul('Centralize Delivery & Inventory')
        ->set_js('jquery')
        ->set_js('jquery.min')
        ->set_js('jquery.countdown.min')
        ->set_js('jquery.plugin.min')
        ->set_css('bootstrap')
        ->set_css('base')
        ->set_css('bootstrap-responsive')
        ->set_css('font-awesome')
        ->set_css('prettify')
        ->set_css('mystyle')
        ->set_parsial('topmenu','top_view',$this->data)
        ->render('detail_transaksi',$this->data); 
    }
    
    
    
    public function pending_transaksi() {
        $this->session->unset_userdata('spv_pass');
        
        $this->load->model('pesanan_m');
        

        $store_site_code = $this->data->store_site_code;
        
        $this->data->base_url = base_url().'/store/pending_transaksi';
		
	
        if($store_site_code != '')
        {
            
            if($this->data->multiuser == 1){
                $this->data->pesanan = $this->pesanan_m->get_pending_transaksi();
            }else{
                $this->data->pesanan = $this->pesanan_m->get_pending_transaksi_cbg($store_site_code);
            
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
        ->render('pending_transaksi',$this->data); 
    }
    
    public function pending_detail($id = 0) {
       
       $this->load->model('pesanan_m');
       $struk_update_time = date('Y-m-d h:i:s');
       $password = $this->input->post('password');
        
        $store_site_code = $this->data->store_site_code;
        
	
        if($store_site_code != '')
        {
            
            //if ($this->session->userdata('spv_pass') == FALSE)
            //{
            //  //$this->error = (array('status'=>'Status belum aktif'));
            //  $this->data->error_pass = '<div class="alert-error" style="text-align:center">Anda Salah menginput Password SPV</div>';
            //  redirect (site_url('store/transaksi/'));
            //   
            //}
            
            if ($this->input->post('submit2')){
                if($password == 'spv12345'){
                
                $orderno = $this->input->post('orderno');
                
                $spv_pass = array(
                       'spv_pass' => TRUE
                    );
                $this->session->set_userdata($spv_pass);
                
                
                $this->db->set('a.FLAG', '4');
                $this->db->set('b.FLAG', '4');
                $this->db->set('a.updated_by', $this->data->user_desc);
                $this->db->set('a.struk_update_time', $struk_update_time);
                $this->db->set('a.STRUK_STATUS', 3);
                
                $this->db->where('a.ORDER_NO_GTRON', $orderno);
                $this->db->where('b.ORDER_NO_GTRON', $orderno);
                $this->db->update('SUPPLIER_ORDER_HEADER as a, SUPPLIER_ORDER_DETAIL as b');
                
                $this->data->error_pass = '<div class="alert-success" style="text-align:center">Proses Cancel Pesanan Berhasil</div>';
                
                
                //redirect (site_url('store/pending_transaksi'));
                
                }else{
                    $this->data->error_pass = '<div class="alert-error" style="text-align:center">Anda Salah menginput Password SPV</div>';
                    
                   
                } 
                
            }
        
        
            if ($this->input->post('submit')){
                
                if($password == 'spv12345'){
                
                    $orderno = $this->input->post('orderno');
                    $nostruk = $this->input->post('nomor');
                    $total_biaya_inputs = $this->input->post('total_biaya_input');
                    
                    $total_biaya_input = str_replace(".","",$total_biaya_inputs);
                    
                    $spv_pass = array(
                       'spv_pass' => TRUE
                    );
                    $this->session->set_userdata($spv_pass);
                    
                    $this->db->set('a.FLAG', '5');
                    $this->db->set('a.no_struk',$nostruk);
                    $this->db->set('a.TOTAL_BIAYA_INPUT', $total_biaya_input);
                    $this->db->set('b.FLAG', '5');
                    $this->db->set('a.updated_by', $this->data->user_desc);
                    $this->db->set('a.struk_update_time', $struk_update_time);
                    $this->db->set('a.STRUK_STATUS', 1);
                     
                    $this->db->where('a.ORDER_NO_GTRON', $orderno);
                    $this->db->where('b.ORDER_NO_GTRON', $orderno);
                    $this->db->update('SUPPLIER_ORDER_HEADER as a, SUPPLIER_ORDER_DETAIL as b');
                    
                    $this->data->error_pass = '<div class="alert-success" style="text-align:center">Proses Submit Pesanan Berhasil</div>';
                
                    
                    
                    //redirect (site_url('store/pending_transaksi'));
                
                }else{
                    $this->data->error_pass = '<div class="alert-error" style="text-align:center">Anda Salah menginput Password SPV</div>';
                    
                   
                }
                
                $this->data->detail = $this->pesanan_m->get_detail_trans(array('id_order'=>$id),true);
                
            } else {
                
                $this->data->detail = $this->pesanan_m->get_detail_trans(array('id_order'=>$id),true);
            }
        
        
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
        ->set_css('prettify')
        ->set_css('mystyle')
        ->set_parsial('topmenu','top_view',$this->data)
        ->render('pending_detail',$this->data); 
        
    }
    
}
?>
