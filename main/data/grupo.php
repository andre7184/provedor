<?php
$text = $_REQUEST["g"];
$img = imagecreate( 100, 50 );
$background = imagecolorallocate( $img, 200, 200, 200 );
$text_colour = imagecolorallocate( $img, 0, 0, 0 );
imagestring( $img, 4, 20, 15, $text,
$text_colour );
imagesetthickness ( $img, 5 );

header( "Content-type: image/png" );
imagepng( $img );


imagecolordeallocate( $text_color );
imagecolordeallocate( $background );
imagedestroy( $img );
?>
