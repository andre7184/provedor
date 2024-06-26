<?php 
	$vel='4.2kbps';
	$tipo = eregi_replace('[.\0-9\-]','',$vel);
	$valor = preg_replace("/[^0-9]/","", $vel);
	echo "($tipo) - ($valor)";
?>