<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Picking_list extends MY_Controller {
    private $judul = 'Print Picking List';
    private $rules = array (
                        array(
                                 'field'   => 'kode', 
                                 'label'   => 'Kode', 
                                 'rules'   => 'utf8'
                              ),
                        
                         );
    
    public function __construct() {
        parent::__construct();
        parent::set_judul($this->judul);
        parent::default_meta();
        $this->load->model('produk_m');
        $this->load->model('kategori_m');
        $this->load->model('pesanan_m');
        
        $this->template->set_js('jcrop')->set_css('jcrop');
        $this->data->metadata = $this->template->get_metadata();
        $this->data->judul = $this->template->get_judul();
    }
    
    public function index(){
        //$this->data->produk = $this->produk_m->get_all();
        
        //parent::_view('produk/list',$this->data);
    
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<p class="msg warning">', '</p>');
        
        foreach($this->kategori_m->kategori as $key => $val) {
            $this->data->list_kategori[$val['id_kategori']] = $val['nama_kategori'];
        }
        
        $this->form_validation->set_rules($this->rules);
        
        if($this->form_validation->run()) {
            $data =  array (    'nama_produk'   =>  $this->input->post('nama_produk'),
                                'url_produk'    =>  underscore($this->input->post('nama_produk')),
                                'kode_produk'   =>  $this->input->post('kode'),
                                'kategori_id'   =>  $this->input->post('kategori'),
                                'harga_jual'    =>  $this->input->post('harga'),
                                'stok'          =>  $this->input->post('stok'),
                                'deskripsi_produk'=>  $this->input->post('deskripsi')
                            );
            if ($this->produk_m->insert($data)) {
                $this->data->sukses = 'Data Berhasil di tambahkan';
            }
        }
        
        $this->data->nama_produk = set_value('nama_produk');
        $this->data->kode = set_value('kode');
        $this->data->deskripsi = set_value('deskripsi');
        $this->data->harga = set_value('harga');
        $this->data->stok = set_value('stok');
        $this->data->kategori = $this->input->post('kategori');
                
        //parent::_modal('produk/form',$this->data);
        parent::_view('picking_list/form',$this->data);
    }
    
    
    public function prints(){
        $order_no =  $this->input->post('order_no');
        
        //CEK STATUS ORDER = COnfirmed
		$this->db->select('*');
		$this->db->from('order');
                $this->db->join('user','user.id_user=order.user_id');
                $this->db->join('user_data','user_data.user_id=user.id_user');
                $this->db->join('order_data','order.id_order = order_data.order_id');
                $this->db->join('produk','produk.id_produk = order_data.produk_id');
                $this->db->where('status_order','2');
                $this->db->where('order_no',$order_no);
                $q = $this->db->get();
                
                   
        if($q->result_array() == NULL){
                    
            parent::_view('picking_list/gagal',$this->data);
                
        }else{
        
        
                //CEK Sudah pernah di PRINT belum
                $this->db->select('status_print');
                $this->db->from('order');
                $this->db->where('order_no',$order_no);
                $this->db->where('status_print','0');
                $data_p = $this->db->get();
        
        if($data_p->result_array() != NULL){
                
                //$this->pesanan_m->update_by(array('order_no'=>$order_no),array('status_print'=>'PRINTED'));
                
		$this->db->select('*');
		$this->db->from('order');
                $this->db->join('user','user.id_user=order.user_id');
                $this->db->join('user_data','user_data.user_id=user.id_user');
                $this->db->join('order_data','order.id_order = order_data.order_id');
                $this->db->join('produk','produk.id_produk = order_data.produk_id');
                $this->db->where('status_order','2');
                $this->db->where('order_no',$order_no);
                $q = $this->db->get(); 	
		
		
                $this->load->view('picking_list/print',$q);
		//parent::_view('picking_list/print',$this->data);
		
                
                
        }else{
            //Eksekusi status sudah di print 2x
            $this->pesanan_m->update_by(array('order_no'=>$order_no),array('status_print'=>'COPIED'));
                
                $this->db->select('*');
                $this->db->from('order');
                $s = $this->db->get();
                $data_table2=array();
                foreach ($s->result_array() as $row2) {
                                $data_table2[]=$row2;
                }
        
        
                error_reporting(0);  //suppress some error message
		$parameters=array(
			'paper'=>'letter',   //paper size
			'orientation'=>'portrait',  //portrait or lanscape
			'type'=>'none',   //paper type: none|color|colour|image
			'options'=>array(0.6, 0.9, 0.8) //I specified the paper as color paper, so, here's the paper color (RGB)
                        
                );
		$this->load->library('pdf', $parameters);  //load ezPdf library with above parameters
		$this->pdf->selectFont(APPPATH.'/third_party/pdf-php/fonts/Helvetica.afm');  //choose font, watch out for the dont location!
		$this->pdf->ezImage(base_url().'images/logo.jpg', 0, '130', 'left', 'none');  //insert image
                //$this->pdf->ezText('Yogya E-Commerce',20);  //insert text with size
                $this->pdf->addText(50,32,8,'Tanggal Print : '.date('m/d/Y - H:i:s'));
                $this->pdf->ezStartPageNumbers(720,32,8,'','',1);
                
                
		//get data from database (note: this should be on 'models' but mehhh..), we'll try creating table using ezPdf
//		$this->db->select('status');
//		$this->db->from('konfirmasi');
//                $this->db->where('order_no',$order_no);
//                $status = $this->db->get();
                
                //this data will be presented as table in PDF
		$data_table=array();
		
                foreach ($q->result_array() as $row) {
			$data_table[]=$row;
		}
               
                
                $column_header=array(
			'nama_produk'=>'Nama Produk',
			'kuantitas'=>'Jumlah',
                        'subtotal'=>'subtotal',
			''=>'Keterangan'
		);
		$this->pdf->addText(400,730,25,$row2['status_print'],0);
                $this->pdf->ezSetDy(-40,'makeSpace');
                $this->pdf->ezText('<u>Data Picking Listas</u>',15)."\n\n";
                
                
                $this->pdf->ezSetDy(-10,'makeSpace');
                $this->pdf->addText(30,650,10,'Nomor Order :',0);
                $this->pdf->addText(150,650,10,$row['order_no']);
                
                $this->pdf->ezSetDy(-10,'makeSpace');
                
                $this->pdf->addText(30,630,10,'Nama User :',0);
                $this->pdf->addText(150,630,10,$row['username'],0);
                
                //$this->pdf->ezSetDy(-10,'makeSpace');
                $this->pdf->addText(30,610,10,'Tanggal Pemesanan :',0);
                $this->pdf->addText(150,610,10,date("d/m/Y - H:i",strtotime($row['tanggal_masuk'])),0);
                
                $this->pdf->ezSetDy(-80,'makeSpace');
                //$this->pdf->ezTable($data_table, $column_header); //generate table
                $this->pdf->ezTable($data_table,$column_header,
                array('xPos'=>130,'xOrientation'=>'left','width'=>100
                ,'cols'=>array(
                'num'=>array('justification'=>'left')
                ,'name'=>array('width'=>10))
                ));
                
                   
		$this->pdf->ezSetY(480);  //set vertical position
		
		
                
                $this->pdf->ezStream(array('Content-Disposition'=>'just_random_filename.pdf'));  //force user to download the file as 'just_random_filename.pdf'

                $this->template->set_judul('Yogya E-Commerce')
                ->set_css('style')
                ->set_parsial('sidebar','sidebar_view',$this->data)
                ->set_parsial('topmenu','top_view',$this->data)
                ->render('admin/picking_list/print',$this->data); 
        
        }
    }
}
    
    public function gagal(){
        parent::_view('admin/picking_list/gagal');
        
    }
}