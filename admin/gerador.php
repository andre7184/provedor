<?php 
//importa funçoes
include_once( "../../classes/funcoes_novas.php");
//IMPORTA SITE SEGURO
	// get command 
	$conn = new mysqli( "localhost" , "provedor_admin" , "amb8484" , "provedor_facil" );
	if ( !$conn->connect_error ){
        if ( ( $res = $conn->query( "SHOW FIELDS FROM `fc_clientes`;" ) ) ){
            $id = 0;
    
            printf( "<form action='%s' method='POST'>" , $_SERVER[ "SCRIPT_NAME" ] );
            while ( ( $row = $res->fetch_row() ) ){
                $name = $row[ 0 ];
                $type = empty( $row[ 3 ] ) ? "text" : "hidden";
                $size = 20;
                $mtc  = array();
    
                if ( preg_match( "/((d+))/" , $row[ 1 ] , $mtc ) ){
                    $size = (float) $mtc[ 1 ];
                }
    
                if ( $type == "text" ){
                    printf( "<label for='campo%d'><span>%s:</span>" , $id , ucwords( $name ) );
                    printf( "<input id='campo%d' type='%s' name='%s' size='%d' />" , $id++ , $type , $name , $size );
                    printf( "</label>" );
                } else {
                    printf( "<input id='campo%d' type='%s' name='%s' size='%d' />" , $id++ , $type , $name , $size );
                }
            }
    
            printf( "<input type='submit' value='Enviar' /></form>" );
    
            $res->free_result();
        }
    }
?>