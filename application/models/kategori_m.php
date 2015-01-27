<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kategori_m extends MY_Model {
    private $prefix = array();
    private $tabel_produk = 'produk';
    
    public $kategori = array();
    public $kategori_menu = '';
    public $kategori_menu_list = '';
    
    public function __construct(){
        parent::__construct();
        parent::set_table('MS_MASTER c','MS_CHILD');
        //$this->db->join('MS_MASTER c1', 'c1.MS_PARENT = c.MS_CHILD', 'left')
        //->join('MS_MASTER c2', 'c2.MS_PARENT = c1.MS_CHILD', 'left')
        //->join('DC_STOCK_MASTER', 'c2.MS_CHILD = DC_STOCK_MASTER.SUBCLASS', 'left');
        //$this->db->join('DC_STOCK_MASTER', 'DC_STOCK_MASTER.SUBCLASS = MS_MASTER.MS_CHILD');

        self::get_kategori_menu();
        
        $this->kategori_menu_list = ''.$this->kategori_menu.'';
    }
    
    public function hapus($id = 0) {
        if($data = parent::get($id)) {
            if(parent::update_by(array('parent'=>$id),array('parent' => $data->parent))) {
                $this->update_produk($id,$data->parent);
                parent::delete($id);
                return true;
            }
            return false;
        }
        return false;
    }
    
    private function update_produk($old = 0,$new = 0) {
        $this->db->where(array('kategori_id'=>$old));
        $this->db->update('produk',array('kategori_id'=>$new));
    }
    
    private function get_kategori($find_child = FALSE,$parent_id = '0') {
        if($find_child == FALSE){
            $older = parent::get_many_by(array('parent'=>'0'));
            foreach ($older as $parent) {
                $this->kategori[] = array ( 'id_kategori'   =>$parent->id_kategori, 
                                    'kode_kategori' =>$parent->kode_kategori, 
                                    'nama_kategori' =>$parent->nama_kategori,
                                    'deskripsi'     =>$parent->deskripsi,
                                    'parent'        =>$parent->parent,
                                    'status'        =>$parent->status,
                                    'ori_name'      =>$parent->nama_kategori
                                    );
                $this->get_kategori(TRUE,$parent->id_kategori);
                array_shift($this->prefix);
            }
        }else{
            array_push($this->prefix,'-- ');
            if(parent::get_many_by(array('parent'=>$parent_id))) {
                $child = parent::get_many_by(array('parent'=>$parent_id));
                
                foreach ($child as $item) {
                    $this->kategori[] = array ( 'id_kategori'   =>$item->id_kategori, 
                                        'kode_kategori' =>$item->kode_kategori, 
                                        'nama_kategori' =>implode('',$this->prefix).$item->nama_kategori,
                                        'deskripsi'     =>$item->deskripsi,
                                        'parent'        =>$item->parent,
                                        'status'        =>$item->status,
                                        'ori_name'      =>$item->nama_kategori
                                        );
                    $this->get_kategori(TRUE,$item->id_kategori);
                    array_shift($this->prefix);
                }
            }
        }
    }
    
    
    function list_cab($kode_cabang,$nama_cabang){
        $data = array();
        $array_keys_values = $this->db->query("select * from cabang");
        foreach($array_keys_values ->result() as $row){
            $data[$row->kode_cabang] = $row->nama_cabang;
        }
        return $data;
    }
    
    private function get_kategori_menu($find_child = FALSE,$parent_id = 'L6') {
        if($find_child == FALSE){
            $older = parent::get_many_by(array('c.MS_PARENT'=>'L6'));
            
            //$older = $this->db->where('c2.MS_PARENT IS NOT NULL', null);
            
            //echo $this->db->last_query();
            foreach ($older as $parent) {
                $this->kategori_menu .= '<li>'.anchor(site_url('/produk/'.$parent->MS_CHILD), $parent->MS_CHILD_DESC.'<span>v</span>','id="'.$parent->MS_CHILD.'"');
                $this->get_kategori_menu(TRUE,$parent->MS_CHILD);
                $this->kategori_menu .= '</li>';
            }
        }else{
            
            if(parent::get_many_by(array('MS_PARENT'=>$parent_id))) {
                $this->kategori_menu .= '<ul>';
                $child = parent::get_many_by(array('MS_PARENT'=>$parent_id));
                // echo $this->db->last_query();
                foreach ($child as $item) {
                    $this->kategori_menu .= '<li>'.anchor(site_url('/store/kategori/'.$item->MS_CHILD), $item->MS_CHILD_DESC.'<span>v</span>','id="'.$item->MS_CHILD.'"');
                    
                    $this->kategori_menu .= '<li>'.$this->get_kategori_menu(TRUE,$item->MS_CHILD);
                    $this->kategori_menu .= '</li>';
                    
                    $this->kategori_menu .= '</li>';
                }
                $this->kategori_menu .= '</ul>';
            }
            
        }
       
    }
    
    
    //public function get_data($induk=0)
    //{
    //    $data = array();
    //    $this->db->from('multileveldata');
    //    $this->db->where('induk',$induk);
    //    $result = $this->db->get();
    //    echo $this->db->last_query();    
    //    foreach($result->result() as $row)
    //    {
    //    $data[] = array(
    //    'id' =>$row->id,
    //    'nama' =>$row->nama,
    //    
    //    // recursive
    //    'child' =>$this->get_data($row->id)
    //    );
    //    
    //    }
    //    return $data;    
    //}
}