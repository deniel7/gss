<?php


$username="deniel";
$password="kudabesi";
$dbname="griyatron";
$dbhost="172.16.9.40";


$query="UPDATE SUPPLIER_ORDER_HEADER
SET STRUK_STATUS = 1
WHERE EXISTS (SELECT *
              FROM GTRON_POSTRA_TOTAL
              WHERE GTRON_POSTRA_TOTAL.TRANS_NO = SUPPLIER_ORDER_HEADER.no_struk
            )
AND SUPPLIER_ORDER_HEADER.tanggal_masuk > DATE_SUB( now( ) , INTERVAL 2
DAY)	    
";

$query2="UPDATE SUPPLIER_ORDER_HEADER
SET STRUK_STATUS = 2
WHERE NOT EXISTS (SELECT *
              FROM GTRON_POSTRA_TOTAL
              WHERE GTRON_POSTRA_TOTAL.TRANS_NO = SUPPLIER_ORDER_HEADER.no_struk
              )
AND SUPPLIER_ORDER_HEADER.tanggal_masuk > DATE_SUB( now( ) , INTERVAL 2
DAY)
";

mysql_connect($dbhost,$username,$password);
@mysql_select_db($dbname) or die(strftime('%c')." Unable to select database");
mysql_query($query);
mysql_query($query2);
mysql_close();

?>