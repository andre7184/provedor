<?php
	include_once("../_conf.php");
	if(!isset($_SESSION['id_userfc'])){
		header("Location: login.php?page=$page");
	}
	$sit = isset($_REQUEST["busca_clientes_sit"]) ? $_REQUEST["busca_clientes_sit"] : 'all';
	$vc = isset($_REQUEST["busca_clientes_vc"]) ? $_REQUEST["busca_clientes_vc"] : 'all';
	$sel = isset($_REQUEST["busca_clientes_sel"]) ? $_REQUEST["busca_clientes_sel"] : '';
	$text = isset($_REQUEST["busca_clientes_text"]) ? $_REQUEST["busca_clientes_text"] : '';
	$conect = new PDO_instruction();
	$conect->con_pdo();
	$resultCol = $conect->get_fields_pdo('fca_clientes');
	$nomesCols='';
	foreach($resultCol as $col) {
		$coln=str_replace("_", " ", $col);
		$nomesCols.="<th>$coln</th>";
		$colsDt.=',{"data":"'.$col.'"}';
	}
	// 
	$scripts='
	<!-- DataTables CSS -->
    <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
    <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
	<!-- DataTables JavaScript -->
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
	<script src="../vendor/otherdropdown/jquery.otherdropdown.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
    <script>
		var table = \'\';
		$(document).ready(function() {
	        table = $("#table_amostra").DataTable({
		        columns:[{
		             className:\'details-control\',
		             orderable:false,
		             data:null,
		             defaultContent:\'\'
		            }'.$colsDt.'
		        ],
		        order: [[ 32, "desc" ]],
				paging:false,
				searching: false,
				info:false,
				scrollX:true,
				responsive:false,
				ajax: {
		            url: "../_ajax.php",
		            data: function ( d ) {
		                d.cmd = "list";
						d.tipo = "cliente";
						d.sit = $("#busca_clientes_sit").val();
						d.vc = $("#busca_clientes_vc").val();
						d.sel = $("#busca_clientes_sel").val();
						d.text = $("#busca_clientes_text").val();
						loading(\'Buscando dados Clientes\',\'loading_busca_cliente\');
		            }
		        },
				dom: \'<"toolbar">frtip<"footer">\'
		    });
		});
	</script>
	<script src="../js/clientes_list.js"></script>
	<script src="../js/cobrancas.js"></script>
	<script src="../js/cadastro.js"></script>
    <script src="../js/bloqueios.js"></script>
	<script src="../js/recibo.js"></script>
	<script src="../js/mask.js"></script>
	';
		?>
<input id="busca_clientes_sit" value="<?php echo $sit;?>" type="hidden">
<input id="busca_clientes_vc" value="<?php echo $vc;?>" type="hidden">
<input id="busca_clientes_sel" value="<?php echo $sel;?>" type="hidden">
<input id="busca_clientes_text" value="<?php echo $text;?>" type="hidden">
<input id="data_hoje" value="<?php echo date('d/m/Y')?>" type="hidden">
<input id="dados_retorno_pagamento" type="hidden">
<input id="tels_cliente_caixa" type="hidden">
<table id="table_amostra" style="white-space: nowrap;" class="table table-striped table-bordered" cellspacing="0" width="100%">
	<thead>
   		<tr>
        	<th></th>
            	<?php 
                echo $nomesCols;
                ?>
          	</tr>
	</thead>
</table>
