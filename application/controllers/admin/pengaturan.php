<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pengaturan extends MY_Controller {
    private $judul = 'Pengaturan';
    
    private $edit_rules = array (
                        array(
                                 'field'   => 'biaya', 
                                 'label'   => 'Biaya', 
                                 'rules'   => 'alpha_numeric|required|max_length[9]|min_length[5]'
                              )
                         );
    
    public function __construct() {
        parent::__construct();
        parent::set_judul($this->judul);
        parent::default_meta();
        $this->load->model('option_m');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<p class="msg warning">', '</p>');
        $this->data->metadata = $this->template->get_metadata();
        $this->data->judul = $this->template->get_judul();
        
        $this->data->username = $this->session->userdata('username');
        $this->data->cabang = $this->session->userdata('kode_cabang');
    }
    
    public function index(){
        //$old_data = $this->option_m->get_by(array('nama_opsi'=>'store_option'));
        //
        //$isi_data = unserialize($old_data->value_opsi);
        //
        //$this->data->nama_situs = $isi_data['nama_situs'];
        //$this->data->slogan = $isi_data['slogan'];
        //$this->data->sambutan = $isi_data['sambutan'];
        //$this->data->biaya = $isi_data['biaya'];
        //
        //$data = array(  'nama_situs'=>$this->input->post('nama_situs'),
        //                'slogan'    =>$this->input->post('slogan'),
        //                'sambutan'  =>$this->input->post('sambutan'),
        //                'biaya'  =>$this->input->post('biaya')
        //                );
        //$insert_data = array('value_opsi'=>serialize($data));
        //if(isset($_POST['submit'])){
        //    $this->option_m->update_by(array('nama_opsi'=>'store_option'),$insert_data);
        //    redirect (site_url('admin/pengaturan'));
        //}                   
        //
        //parent::_view('pengaturan/form',$this->data);
        
        $id = 1;
        
        $data = $this->option_m->get($id);
        
        if(isset($_POST['submit'])){
            //$this->option_m->update_by(array('biaya'=>$biaya));
            //redirect (site_url('admin/pengaturan'));
            //echo "submit";
            
            
            $this->form_validation->set_rules($this->edit_rules);
            if(!$this->form_validation->run()) {
                
                $biaya = $this->input->post('biaya');
                $this->option_m->ubah($id,$biaya);
                $this->data->sukses = 'Proses input data berhasil';
                //redirect (site_url('admin/pengaturan'));
                
            }else{
                $this->data->error = 'Proses pengubahan data gagal.';
            }
            
            
        }
        
        if($data){
            $this->data->biaya = $data->biaya;
            
        }else{
            $this->data->biaya = set_value('biaya');
        }
        
        parent::_view('pengaturan/form',$this->data);
    }

}