<?php
	include_once("../_conf.php");
	if(!isset($_SESSION['id_userfc'])){
		header("Location: login.php?page=$page");
	}
	$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : false;
	$tipo = isset($_REQUEST["tipo"]) ? $_REQUEST["tipo"] : false;
	switch($tipo) {
		case "pagamentos":
			$table='fcv_pagamentos';
		break;
		case "cobrancas":
			$table='fcv_cobrancas';
		break;
		case "bloqueios":
			$table='fc_bloqueios';
		break;
		case "dividas":
			$table='fcv_dividas';
		break;
	}
	$conect = new PDO_instruction();
	$conect->con_pdo();
	$resultCol = $conect->get_fields_pdo($table);
	$nomesCols='';
	foreach($resultCol as $col) {
		if($col!='id_provedor'){
			$colArray=explode("_", $col);
			$nomesCols.="<th>".ucfirst($colArray[0])."</th>";
		}else
			$nomesCols.="<th>Provedor</th>";
		//
		$colsDt.=',{"data":"'.$col.'"}';
	}
?>
<table id="table_list_dados" style="white-space: nowrap;" class="table table-striped table-bordered" cellspacing="0" width="100%">
	<thead>
   		<tr>
        	<th></th>
            	<?php 
                echo $nomesCols;
                ?>
          	</tr>
	</thead>
</table>
<script>
var table_list_dados='';
$(document).ready(function() {
	table_list_dados=$('#table_list_dados').DataTable({
        columns:[{
			className:'details-control',
			orderable:false,
			data:null,
			defaultContent:''
		}<?php echo $colsDt?>],
    	paging:false,
		searching: false,
		info:false,
		scrollX:true,
		//responsive:false,
		ajax: {
            url: "../_ajax.php",
            data: function ( d ) {
                d.cmd = "list";
				d.tipo = "<?php echo $tipo?>";
				d.id = "<?php echo $id?>";
				loading('Buscando dados de <?php echo $tipo?>','loading_list_<?php echo $tipo?>');
            }
        }
    });
	table_list_dados.on('xhr', function () {
		var json = table_list_dados.ajax.json();
		//$("#qtd_clientes").text(json.qtd);
		//setSelBusca();
		$("#loading_list_<?php echo $tipo?>").modal("hide");
	});
});
</script>