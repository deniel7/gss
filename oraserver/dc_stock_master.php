<?php
$json=array();
$username="griyatron"; //Nama user sama dengan skema di oracle
$password="griyatron";
$database="172.16.9.40/XE"; //localhost bisa di isi dengan IP adress 

$koneksi=oci_connect($username,$password,$database);
$subclass = $_GET[subclass];

if($koneksi)
{
     $stid = oci_parse($koneksi, "select * from DC_STOCK_MASTER
WHERE SUBCLASS = '$subclass'
AND DC_SUPP_CODE = '13199'
");
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
