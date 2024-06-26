<?php
	include_once("../_conf.php");
	if(!isset($_SESSION['id_userfc'])){
		header("Location: login.php?page=$page");
	}
	$mes = isset($_REQUEST["busca_cobrancas_mes"]) ? $_REQUEST["busca_cobrancas_mes"] : 'all';
	$pg = isset($_REQUEST["busca_cobrancas_pg"]) ? $_REQUEST["busca_cobrancas_pg"] : 'all';
	$nome = isset($_REQUEST["busca_cobrancas_nome"]) ? $_REQUEST["busca_cobrancas_nome"] : '';
	$conect = new PDO_instruction();
	$conect->con_pdo();
	$resultCol = $conect->get_fields_pdo('fcv_cobrancas');
	$nomesCols='';
	foreach($resultCol as $col) {
		if($col!='id_provedor'){
			if($col=='valor_encargos_cobrancasfc')
				$colArray[0]='valor encargos';
			else if($col=='valor_atual_cobrancasfc')
				$colArray[0]='valor restante';
			else
				$colArray=explode("_", $col);
			//
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
		        order: [[ 4, "desc" ]],
				paging:false,
				searching: false,
				info:false,
				scrollX:true, 
				responsive:false,
				ajax: {
		            url: "../_ajax.php",
		            data: function ( d ) {
		                d.cmd = "list";
						d.tipo = "cobrancas";
						d.nome = $("#busca_cobrancas_nome").val();
						d.mes = $("#busca_cobrancas_mes").val();
						d.pg = $("#busca_cobrancas_pg").val();
						loading(\'Buscando dados Cobranças\',\'loading_busca_cobrancas\');
		            }
		        },
				dom: \'<"toolbar">frtip\'
		    });
		});
	</script>
	<script src="../js/cobrancas_list.js"></script>
	';
		?>
<input id="busca_cobrancas_nome" value="<?php echo $nome;?>" type="hidden">
<input id="busca_cobrancas_mes" value="<?php echo $mes;?>" type="hidden">
<input id="busca_cobrancas_pg" value="<?php echo $pg;?>" type="hidden">
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
