<?php
	include_once("../_conf.php");
	if(!isset($_SESSION['id_userfc'])){
		header("Location: login.php?page=$page");
	}
	$mes = isset($_REQUEST["busca_recebiveis_mes"]) ? $_REQUEST["busca_recebiveis_mes"] : 'all';
	$user = isset($_REQUEST["busca_recebiveis_user"]) ? $_REQUEST["busca_recebiveis_user"] : 'all';
	$nome = isset($_REQUEST["busca_recebiveis_nome"]) ? $_REQUEST["busca_recebiveis_nome"] : '';
	$conect = new PDO_instruction();
	$conect->con_pdo();
	$resultCol = $conect->get_fields_pdo('fcv_recebiveis');
	$nomesCols='';
	foreach($resultCol as $col) {
		if($col!='id_provedor'){
			$colArray=explode("_recebiveisfc", $col);
			$nomesCols.="<th>".ucfirst($colArray[0])."</th>";
		}else
			$nomesCols.="<th>Provedor</th>";
		//
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
	<script src="../vendor/datatables-plugins/date-eu.js"></script>
    <script>
		var table=\'\';
		$(function($){
	        table = $("#table_amostra").DataTable({
		        columns:[{
		             className:\'details-control\',
		             orderable:false,
		             data:null,
		             defaultContent:\'\'
		            }'.$colsDt.'
		        ],
		        order: [[ 17, "desc" ]],
				paging:false,
				searching: false,
				info:false,
				scrollX:true,
				responsive:false,
				ajax: {
		            url: "../_ajax.php",
		            data: function ( d ) {
		                d.cmd = "list";
						d.tipo = "recebiveis";
						d.nome = $("#busca_recebiveis_nome").val();
						d.mes = $("#busca_recebiveis_mes").val();
						d.user = $("#busca_recebiveis_user").val();
						loading(\'Buscando dados Recebiveis\',\'loading_busca_recebiveis\');
		            }
		        },
				dom: \'<"toolbar">frtip<"footer">\'
		    });
		});
	</script>
	<script src="../js/recebiveis_list.js"></script>
	<script src="../js/recibo.js"></script>
	<script src="../vendor/otherdropdown/jquery.otherdropdown.min.js"></script>
	';
		?>
<input id="busca_recebiveis_nome" value="<?php echo $nome;?>" type="hidden">
<input id="busca_recebiveis_mes" value="<?php echo $mes;?>" type="hidden">
<input id="busca_recebiveis_user" value="<?php echo $user;?>" type="hidden">
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
