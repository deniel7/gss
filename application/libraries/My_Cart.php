<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Cart extends CI_Cart {

    var $product_name_rules = '[:print:]';
    
    $this->ci->cart->product_name_rules = '^.';

}