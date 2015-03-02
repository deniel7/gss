<?php
$json=array();
$username="griyatron"; //Nama user sama dengan skema di oracle
$password="griyatron";
$database="172.16.9.40/XE"; //localhost bisa di isi dengan IP adress 

$koneksi=oci_connect($username,$password,$database);
$article_code = $_GET[article_code];

if($koneksi)
{
     $stid = oci_parse($koneksi, "select * from DC_STOCK_MASTER
WHERE ARTICLE_CODE = '$article_code'
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
