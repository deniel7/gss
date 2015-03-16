<?php

mysql_connect('localhost','root','kudabesi');
mysql_select_db('griyatron');


	
	$sql = mysql_query("UPDATE SUPPLIER_ORDER_HEADER
SET STRUK_STATUS = 1
WHERE EXISTS (SELECT *
              FROM GTRON_POSTRA_TOTAL
              WHERE GTRON_POSTRA_TOTAL.TRANS_NO = SUPPLIER_ORDER_HEADER.no_struk
              AND SUPPLIER_ORDER_HEADER.tanggal_masuk > DATE_SUB( now( ) , INTERVAL 2
DAY))

");
	
	
	$sql2 = mysql_query("UPDATE SUPPLIER_ORDER_HEADER
SET STRUK_STATUS = 2
WHERE NOT EXISTS (SELECT *
              FROM GTRON_POSTRA_TOTAL
              WHERE GTRON_POSTRA_TOTAL.TRANS_NO = SUPPLIER_ORDER_HEADER.no_struk
              AND SUPPLIER_ORDER_HEADER.tanggal_masuk > DATE_SUB( now( ) , INTERVAL 2
DAY))

");


//$sql = mysql_query("UPDATE SUPPLIER_ORDER_HEADER
//SET STRUK_STATUS = 1
//WHERE EXISTS (SELECT *
//              FROM GTRON_POSTRA_TOTAL
//              WHERE GTRON_POSTRA_TOTAL.TRANS_NO = SUPPLIER_ORDER_HEADER.no_struk)
//
//");
//
//$sq = mysql_query("UPDATE SUPPLIER_ORDER_HEADER
//SET STRUK_STATUS = 2
//WHERE EXISTS (SELECT *
//              FROM GTRON_POSTRA_TOTAL
//              WHERE GTRON_POSTRA_TOTAL.TRANS_NO != SUPPLIER_ORDER_HEADER.no_struk)
//
//");

?>