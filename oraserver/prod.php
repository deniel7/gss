<?php
$json=array();
$username="griyatron"; //Nama user sama dengan skema di oracle
$password="griyatron";
$database="172.16.9.40/XE"; //localhost bisa di isi dengan IP adress 

$koneksi=oci_connect($username,$password,$database);
$kat = $_GET[kat];;

if($koneksi)
{
     $stid = oci_parse($koneksi, "SELECT * from PRODUK JOIN KATEGORI  
ON PRODUK.KATEGORI_ID = KATEGORI.ID_KATEGORI 
JOIN FOTO_PRODUK  
ON PRODUK.ID_PRODUK = FOTO_PRODUK.PRODUK_ID 
WHERE FOTO_PRODUK.DEFAULTS = 1 
AND PRODUK.STATUS_PRODUK = 1 
AND KATEGORI.URL = '$kat'");
     oci_execute($stid);


     while ($row = oci_fetch_array($stid)) {
            
               // $json['ROYEN']=$row;
                $json[]=$row;

     }
    
$json_format = json_encode($json); 
    echo json_encode($json); 
     
}
else
{
  $err=oci_error();
  echo "Gagal tersambung ke ORACLE". $err['text'];
}


?>
