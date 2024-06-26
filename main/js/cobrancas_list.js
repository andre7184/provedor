$(function($){
	$("div.toolbar").html(toolbarFind(table));
	getDadosTBF();
	table.on('xhr', function () {
   		var json = table.ajax.json();
		$("#qtd_cobrancas").text(json.qtd);
		setSelBusca();
		$("#loading_busca_cobrancas").modal("hide");
	});
   	// Add event listener for opening and closing details
   	$("#table_amostra").on("click", "td.details-control", function () {
      	var tr = $(this).closest("tr");
       	var row = table.row(tr);
       	if (row.child.isShown()) {
           	// This row is already open - close it
           	row.child.hide();
           	tr.removeClass("shown");
       	} else { 
           	// Open this row
           	row.child(format(row.data())).show();
           	tr.addClass("shown");
       	}
   	});
	$(".reload_busca_cobrancas").click(function() {
		table.ajax.reload();
	});
});
function format (obj) {
	var id_cliente=obj['id_cobrancasfc'];
	var nome=obj['nome_cliente_cobrancasfc'];
	var valor_pago=obj['pagamento_cobrancasfc'];
	return '<div class="btn-group" role="group">'+
	'<div class="btn-group" role="group">'+
	  	'<button class="btn btn-default dropdown-toggle btn-sm" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'+
	  		'<i class="fa fa-print"></i>Opções<span class="caret"></span>'+
	  	'</button>'+
	  	'<ul class="dropdown-menu">'+
	    '</ul>'+
	'</div>'+
	'</div>'; 
}
function toolbarFind() {
	return '<span class="badge" id="qtd_cobrancas"></span><b>Cobranças </b>'+
	'<div class="form-group input-group">'+
		'<input class="form-control input-sm" id="campo_busca_cobrancas_nome" onkeyup="$(\'#busca_cobrancas_nome\').val($(this).val());" type="text">'+
		'<span class="input-group-btn">'+
			'<button class="reload_busca_cobrancas btn btn-default btn-sm" type="button"><i class="fa fa-search"></i></button>'+
		'</span>'+
		'<span class="input-group-btn">'+
			'<button class="reload_busca_cobrancas btn btn-default btn-sm" onclick="$(\'#busca_cobrancas_nome\').val(\'\');" type="button"><i class="fa fa-times-circle-o"></i></button>'+
		'</span>'+
		'<span class="input-group-btn">'+
			'<button type="button" data-toggle="dropdown" class="btn btn-default btn-sm">Busca<span class="caret"></span></button>'+
		  	'<ul class="bts_busca dropdown-menu" id="local_busca_cobrancas">'+ 
    		'</ul>'+
    	'</span>'+
		'<span class="input-group-btn">'+
			'<button class="reload_busca_cobrancas btn btn-default btn-sm" type="button"><i class="fa fa-refresh"></i></button>'+
		'</span>'+
	'</div>';
}
function setSelBusca(){
	var urlArg=new Array();
	$(".bts_busca li").each(function() {
		var nome=$(this).attr("class");
		var valor=$(this).attr("v");
		if($("#"+nome).val()==valor){
			$(this).find("i").show();
			urlArg[nome]=valor;
		}else
			$(this).find("i").hide();
	});
	var busca_pagamentos_nome=$("#busca_cobrancas_nome").val();
	$("#campo_busca_cobrancas_nome").val(busca_pagamentos_nome);
	window.history.pushState(null,null,jQuery.query.set('busca_cobrancas_mes', urlArg['busca_cobrancas_mes']).set('busca_cobrancas_pg', urlArg['busca_cobrancas_pg']).set('busca_cobrancas_nome', busca_pagamentos_nome));
}
function getDadosTBF(){
	loading('Buscabdo Dados Toolbar','loading_dados_toolbar');
	$.post('../_ajax.php',{'cmd':'busca','tipo':'busca_cobrancas'},function(dados){
		var dados=JSON.parse(dados);
		$("#loading_dados_toolbar").modal("hide");
		$("#local_meses_cobrancas").html('');
		var li='<li class="dropdown-header">Tipo de Pagamento</li>'+
		'<li class="busca_cobrancas_pg" onclick="setBusca(this);" v="all"><a href="#"><i class="fa fa-check" style="display: none;"></i>Todos</a></li>'+
		'<li class="busca_cobrancas_pg" onclick="setBusca(this);" v="on"><a href="#"><i class="fa fa-check" style="display: none;"></i>Pago</a></li>'+
		'<li class="busca_cobrancas_pg" onclick="setBusca(this);" v="TOTAL"><a href="#"><i class="fa fa-check" style="display: none;"></i>Total</a></li>'+
		'<li class="busca_cobrancas_pg" onclick="setBusca(this);" v="MENOR"><a href="#"><i class="fa fa-check" style="display: none;"></i>Menor</a></li>'+
		'<li class="busca_cobrancas_pg" onclick="setBusca(this);" v="MAIOR"><a href="#"><i class="fa fa-check" style="display: none;"></i>Maior</a></li>'+
		'<li class="dropdown-header">Seleciona o Mês</li>'+
		'<li class="busca_cobrancas_mes" onclick="setBusca(this);" v="all"><a href="#"><i class="fa fa-check" style="display: none;"></i>Todos</a></li>';
		//
		$.each(dados['mes'], function (i, item) {
			li+='<li class="busca_cobrancas_mes" onclick="setBusca(this);" v="'+item.mesn+'"><a href="#"><i class="fa fa-check" style="display: none;"></i>'+item.mesc+'</a></li>';
		});
		$("#local_busca_cobrancas").append(li);
	});
}
function setBusca(obj){
	var nome=$(obj).attr("class");
	var valor=$(obj).attr("v");
	$("#"+nome).val(valor);
	table.ajax.reload();
}