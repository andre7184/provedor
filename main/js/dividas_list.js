$(function($){
	$("div.toolbar").html(toolbarFind(table));
	getDadosTBF();
	table.on('xhr', function () {
   		var json = table.ajax.json();
		$("#qtd_dividas").text(json.qtd);
		var totalGrupo='';
		if(json.total_grupo.length>1){
			$.each(json.total_grupo, function( i, value ){
				totalGrupo+='<b>'+i+':</b> R$'+value+' '
			})
		}
		$("div.footer").html('<b>T:</b> R$'+json.total+' '+totalGrupo);
		setSelBusca();
		$("#loading_busca_dividas").modal("hide");
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
	$(".reload_busca_dividas").click(function() {
		table.ajax.reload();
	});
});
function format (obj) {
	var id_cliente=obj['id_dividasfc'];
	var nome=obj['cliente_dividasfc'];
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
	return '<span class="badge" id="qtd_dividas"></span><b>Dívidas </b>'+
	'<div class="form-group input-group">'+
		'<input class="form-control input-sm" id="campo_busca_dividas_nome" onkeyup="$(\'#busca_dividas_nome\').val($(this).val());" type="text">'+
		'<span class="input-group-btn">'+
			'<button class="reload_busca_dividas btn btn-default btn-sm" type="button"><i class="fa fa-search"></i></button>'+
		'</span>'+
		'<span class="input-group-btn">'+
			'<button class="reload_busca_dividas btn btn-default btn-sm" onclick="$(\'#busca_dividas_nome\').val(\'\');" type="button"><i class="fa fa-times-circle-o"></i></button>'+
		'</span>'+
		'<span class="input-group-btn">'+
			'<button type="button" data-toggle="dropdown" class="btn btn-default btn-sm">Busca<span class="caret"></span></button>'+
		  	'<ul class="bts_busca dropdown-menu" id="local_busca_dividas">'+ 
    		'</ul>'+
    	'</span>'+
		'<span class="input-group-btn">'+
			'<button class="reload_busca_dividas btn btn-default btn-sm" type="button"><i class="fa fa-refresh"></i></button>'+
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
	var busca_dividas_nome=$("#busca_dividas_nome").val();
	$("#campo_busca_dividas_nome").val(busca_dividas_nome);
	window.history.pushState(null,null,jQuery.query.set('busca_dividas_mes', urlArg['busca_dividas_mes']).set('busca_dividas_nome', busca_dividas_nome));
}
function getDadosTBF(){
	loading('Buscabdo Dados Toolbar','loading_dados_toolbar');
	$.post('../_ajax.php',{'cmd':'busca','tipo':'busca_dividas'},function(dados){
		var dados=JSON.parse(dados);
		$("#loading_dados_toolbar").modal("hide");
		$("#local_busca_dividas").html('');
		var li='<li class="dropdown-header">Seleciona o Mês</li>'+
		'<li class="busca_cobrancas_mes" onclick="setBusca(this);" v="all"><a href="#"><i class="fa fa-check" style="display: none;"></i>Todos</a></li>';
		//
		$.each(dados['mes'], function (i, item) {
			li+='<li class="busca_dividas_mes" onclick="setBusca(this);" v="'+item.mesn+'"><a href="#"><i class="fa fa-check" style="display: none;"></i>'+item.mesc+'</a></li>';
		});
		$("#local_busca_dividas").append(li);
	});
}
function setBusca(obj){
	var nome=$(obj).attr("class");
	var valor=$(obj).attr("v");
	$("#"+nome).val(valor);
	table.ajax.reload();
}