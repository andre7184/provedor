<?php 
require_once( "../../classes/conf.php");
conecta_mysql();	//concecta no banco myslq
//
header( 'Cache-Control: no-cache' );
header( 'Content-type: application/xml; charset="utf-8"', true );
//
$id_uf = isset($_REQUEST["id_uf"]) ? $_REQUEST["id_uf"] : false;
//
$cidades = array();
if($id_uf){
	$where="cod_uf_cidades='".mysql_real_escape_string($id_uf)."'";
}else {
	$uf_cidades = mysql_real_escape_string( $_GET['uf_cidades'] );
	$where="uf_cidades='$uf_cidades'";
}
$sql = "SELECT id_cidades, nome_cidades
FROM sis_cidades
WHERE $where
ORDER BY nome_cidades";
$res = mysql_query( $sql );
while ( $row = mysql_fetch_assoc( $res ) ) {
$cidades[] = array(
		'id_cidades'	=> $row['id_cidades'],
		'nome_cidades'			=> $row['nome_cidades'],
);
}

echo( json_encode( $cidades ) );
?>