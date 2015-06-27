<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sales_Report extends MY_Controller {
    private $judul = 'Daftar Produk';
    
    public function __construct() {
        parent::__construct();
        parent::set_judul($this->judul);
        parent::default_meta();
        $this->data->judul = $this->template->get_judul();
        $this->data->metadata = $this->template->get_metadata();
	
	$this->data->username = $this->session->userdata('username');
        $this->data->nik = $this->session->userdata('user_id');
	$this->data->dc_site_code = $this->session->userdata('dc_site_code');
	$this->load->helper(array('form', 'url'));
	
	$this->load->model('produk_m');
    }
    
    public function index(){
        
        parent::_view('sales_report/list',$this->data);
    }
    
    public function get_produk_json(){
        $res = $this->produk_m->get_master_produk();
        //$res = $this->article_model->get_list_article_by_po($get["po"]);
        $i = 0;
        $hasil = "{\"data\" : [";
	
        foreach ($res->result() as $row) {
            if($row->IMG1)
	    {
		$gbr = "<div class= 'btn btn-success'><i class='fa fa-check-square-o fa-fw'>.</i></div>";
	    }else{
		$gbr = "<div class= 'btn btn-danger'><i class='fa fa-times-circle-o fa-fw'>,</i></div>";
	    }
	    
	    $hasil .= "[\"" . $row->ARTICLE_CODE . "\",\"" . str_replace('"',"",$row->ARTICLE_DESC) . "\",\"" . str_replace('"','',$row->CLASS_DESC) . "\",\"".str_replace('"',"",$row->ATTRIB_DESC). "\",\"".$gbr. "\"]";
            //$hasil .= "[\"" . $row->PLU . "\",\"" . $row->ART_CODE . "\",\"" . $row->L_DESC . "\",\"".$row->ART_ATTR."\",\"" . $row->SUBCLASS . "\",\"" . $row->SV . "\",\"<input type='checkbox' id='check-art-" . $row->PLU . "' /><input type='hidden' id='art-desc-" . $row->PLU . "' value='" . $row->L_DESC . "' />\" ]";

            if ($i < $res->num_rows() - 1) {
                $hasil .=",";
            }
            $i++;
        }
        $hasil .= "]}";
        echo $hasil;
    }
    
}
