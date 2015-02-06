<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Import extends MY_Controller {
    private $judul = 'Import Produk';
    
    public function __construct() {
        parent::__construct();
        parent::set_judul($this->judul);
        parent::onecol_meta();
        //$this->load->model('option_m');
        $this->load->model('import_m');
        $this->load->helper('file');
        
        $this->data->metadata = $this->template->get_metadata();
        $this->data->judul = $this->template->get_judul();
        
        $this->data->username = $this->session->userdata('username');
        $this->data->cabang = $this->session->userdata('kode_cabang');
    }
    
    public function index(){
        
        parent::_view_onecol('import/form',$this->data);
    }
    
    public function import_p(){
        
        parent::_view_onecol('import/form2',$this->data);
    }
    
    public function finish(){
        
        parent::_view('import/finish',$this->data);
    }
    
    function import_sku()
	{
		//$ci =& get_instance();
                $config['upload_path'] = './temp_upload/';
		$config['allowed_types'] = 'xls';
                $config['file_name'] = 'sku.xls';
                $config['overwrite'] = 'TRUE';
		
		$this->load->library('upload', $config);
                
		if ( ! $this->upload->do_upload())
		{
			$this->data->error = '<div class="msg error">'.$this->upload->display_errors().'</div>';
			
                        //$this->data->error = '<div class="error">Username telah digunakan</div>';
		}
		else
		{
			$this->data->error = '<div class="msg done">Berhasil melakukan Import data SKU terbaru</div>';
			$upload_data = $this->upload->data();

			$this->load->library('excel_reader');
			$this->excel_reader->setOutputEncoding('CP1251');

			$file =  $upload_data['full_path'];
			$this->excel_reader->read($file);
			error_reporting(E_ALL ^ E_NOTICE);

			// Sheet 1
			$data = $this->excel_reader->sheets[0] ;
                        $dataexcel = Array();
			for ($i = 1; $i <= $data['numRows']; $i++) {

                            if($data['cells'][$i][1] == '') break;
                            $dataexcel[$i-1]['entry_number'] = $data['cells'][$i][1];
			    $dataexcel[$i-1]['PLU'] = $data['cells'][$i][2];

			}
                        
			//cek data
			$check= $this->import_m->search_chapter($dataexcel);
			//echo $check;
			if (count($check) > 0)
			{
			    
			    $this->load->model('import_m');
			    //$this->import_m->hapus();
			    $this->import_m->update_sku($dataexcel);
			    //delete_files($upload_data['file_path']);
                            //$this->import_m->updates($dataexcel);
			    //$this->import_m->generates();
			    //$data['user'] = $this->import_m->getuser();
			    //echo "atas";
			
			}else{
			    
			    //delete_files($upload_data['file_path']);
			    $this->load->model('import_m');
			    //$this->import_m->hapus();
			    $this->import_m->tambahsku($dataexcel);
			    //$data['user'] = $this->import_m->getuser();
			    //echo "bawah";
			}
		}
		
                parent::_view_onecol('import/form',$this->data);
                
                //redirect(site_url('admin/import'));
        }
        
        
    function import_produk()
    {
		//$ci =& get_instance();
                $config['upload_path'] = './temp_upload/';
		$config['allowed_types'] = 'xls';
                $config['file_name'] = 'produk.xls';
                $config['overwrite'] = 'TRUE';
		
		$this->load->library('upload', $config);
                
		if ( ! $this->upload->do_upload())
		{
			$this->data->error = '<div class="msg error">'.$this->upload->display_errors().'</div>';
			//parent::_view('import/form',$this->data);
		}
		else
		{
			$this->data->sukses = '<div class="msg done">Berhasil melakukan Import data Produk terbaru</div>';
			$upload_data = $this->upload->data();

			$this->load->library('excel_reader');
			$this->excel_reader->setOutputEncoding('CP1251');

			$file =  $upload_data['full_path'];
			$this->excel_reader->read($file);
			error_reporting(E_ALL ^ E_NOTICE);

			// Sheet 1
			$data = $this->excel_reader->sheets[0] ;
                        $dataexcel = Array();
			for ($i = 1; $i <= $data['numRows']; $i++) {

                            if($data['cells'][$i][1] == '') break;
                            $dataexcel[$i-1]['plu'] = $data['cells'][$i][1];
			    $dataexcel[$i-1]['plu_descriptor'] = $data['cells'][$i][2];
                            $dataexcel[$i-1]['kategori_id'] = $data['cells'][$i][3];
                            $dataexcel[$i-1]['harga_jual'] = $data['cells'][$i][4];
			}
                        
			//cek data
			$check= $this->import_m->search_produk_imp($dataexcel);
			//echo $check;
			if (count($check) > 0)
			{
			    
			    $this->load->model('import_m');
			    
			    $this->import_m->update_produk($dataexcel);
			    
                            //echo "update";
                            //delete_files($upload_data['file_path']);
                            
			
			}else{
			    
			    //delete_files($upload_data['file_path']);
			    $this->load->model('import_m');
			    //$this->import_m->kosong();
			    $this->import_m->tambah_produk($dataexcel);
			    
                            //echo "tambah";
			}
		}
		parent::_view_onecol('import/finish',$this->data);
                //redirect(site_url('admin/import/finish'));
    }
    
    public function finish_process(){
        
        $this->data->username = $this->session->userdata('username');
        $username = $this->data->username;
        
        $this->load->model('import_m');
	$this->import_m->generates();
        $this->import_m->log_import($username);
        
        redirect(site_url('admin/produk'));
    }
    
}