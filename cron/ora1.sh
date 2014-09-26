#!/bin/bash


SQLOOP=$(cat <<EOF
SELECT \`order\`.kode_cabang, store_code
FROM \`order\`
JOIN cabang ON \`order\`.kode_cabang = cabang.kode_cabang
WHERE \`order\`.tanggal_masuk <= DATE_ADD(CURRENT_DATE(), INTERVAL -2 HOUR) AND \`order\`.tanggal_masuk >= DATE_ADD(CURRENT_DATE(), INTERVAL -24 HOUR) GROUP BY \`order\`.kode_cabang
EOF
)

DATE=$(date +%m%d%Y)
DATEGOLD=$(date +%d%m%y)
STATUS=0

while read -a row
do
#echo "..${row[0]}"
STATUS=1

SQLGOLD=$(cat <<EOF
SELECT CONCAT(\`order\`.order_no, '|', \`order\`.tanggal_masuk, '|', \`order\`.kode_cabang, '|', order_data.kuantitas, '|', produk.plu, '|', produk.nama_produk) AS '|'
FROM \`order\` JOIN user ON user.id_user = \`order\`.user_id
JOIN order_data ON \`order\`.id_order = order_data.order_id
JOIN produk ON order_data.produk_id = produk.id_produk
WHERE status_order = '4'
AND \`order\`.tanggal_masuk <= DATE_ADD(CURRENT_DATE(), INTERVAL -2 HOUR)
AND \`order\`.tanggal_masuk >= DATE_ADD(CURRENT_DATE(), INTERVAL -24 HOUR)
AND \`order\`.kode_cabang LIKE '%${row[0]}%' ORDER BY \`order\`.id_order ASC
EOF
)


SQLORACASH=$(cat <<EOF
SELECT CONCAT('11', cabang.store_code, ';', '"', UPPER(DATE_FORMAT(\`order\`.tanggal_masuk,'%d-%b-%Y')) ,'"', ';"cash sales";', SUM(\`order\`.total_biaya), ';1;""')
FROM \`order\` JOIN user ON user.id_user = \`order\`.user_id 
JOIN order_data ON \`order\`.id_order = order_data.order_id 
JOIN produk ON order_data.produk_id = produk.id_produk 
JOIN kategori ON produk.kategori_id = kategori.id_kategori
JOIN cabang ON \`order\`.kode_cabang = cabang.kode_cabang
WHERE status_order = '4' 
AND \`order\`.tanggal_masuk <= DATE_ADD(CURRENT_DATE(), INTERVAL -2 HOUR) 
AND \`order\`.tanggal_masuk >= DATE_ADD(CURRENT_DATE(), INTERVAL -24 HOUR) 
AND \`order\`.kode_cabang LIKE '%${row[0]}%' 
EOF
)

SQLORAVAT=$(cat <<EOF
SELECT CONCAT('11', cabang.store_code, ';', '"', UPPER(DATE_FORMAT(\`order\`.tanggal_masuk,'%d-%b-%Y')) ,'"', ';"vat sales";', SUM(\`order\`.total_biaya)*0.1, ';11;""')
FROM \`order\` JOIN user ON user.id_user = \`order\`.user_id 
JOIN order_data ON \`order\`.id_order = order_data.order_id 
JOIN produk ON order_data.produk_id = produk.id_produk 
JOIN kategori ON produk.kategori_id = kategori.id_kategori
JOIN cabang ON \`order\`.kode_cabang = cabang.kode_cabang
WHERE status_order = '4' 
AND \`order\`.tanggal_masuk <= DATE_ADD(CURRENT_DATE(), INTERVAL -2 HOUR) 
AND \`order\`.tanggal_masuk >= DATE_ADD(CURRENT_DATE(), INTERVAL -24 HOUR) 
AND order.kode_cabang LIKE '%${row[0]}%' 
EOF
)

SQLORAOUTRIGHT=$(cat <<EOF
SELECT CONCAT('11', cabang.store_code, ';', '"', UPPER(DATE_FORMAT(\`order\`.tanggal_masuk,'%d-%b-%Y')) ,'"', ';"outright sales";', SUM(\`order\`.total_biaya), ';1;""')
FROM \`order\` JOIN user ON user.id_user = \`order\`.user_id 
JOIN order_data ON \`order\`.id_order = order_data.order_id 
JOIN produk ON order_data.produk_id = produk.id_produk 
JOIN kategori ON produk.kategori_id = kategori.id_kategori
JOIN cabang ON order.kode_cabang = cabang.kode_cabang
WHERE status_order = '4' 
AND \`order\`.tanggal_masuk <= DATE_ADD(CURRENT_DATE(), INTERVAL -2 HOUR) 
AND \`order\`.tanggal_masuk >= DATE_ADD(CURRENT_DATE(), INTERVAL -24 HOUR) 
AND \`order\`.kode_cabang LIKE '%${row[0]}%'
GROUP BY id_kategori 
EOF
)

mysql ygecom -e "$SQLGOLD" >> "/srv/www/ygecom/www/export/SALES11${row[1]}$DATEGOLD.txt"
mysql ygecom --skip-column-names -e "$SQLORACASH" >> "/srv/www/ygecom/www/export/SALES_${row[1]}_$DATE.csv"
mysql ygecom --skip-column-names -e "$SQLORAVAT" >> "/srv/www/ygecom/www/export/SALES_${row[1]}_$DATE.csv"
mysql ygecom --skip-column-names -e "$SQLORAOUTRIGHT" >> "/srv/www/ygecom/www/export/SALES_${row[1]}_$DATE.csv"
done < <(echo "$SQLOOP" | mysql ygecom --skip-column-names)

if [ "$STATUS" -eq 1 ]
then
SQLUPDATE=$(cat <<EOF
INSERT INTO export_status (tanggal) VALUES (NOW());
EOF
)
mysql ygecom -e "$SQLUPDATE"
fi

