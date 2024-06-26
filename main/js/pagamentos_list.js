$(function($){
	$("div.toolbar").html(toolbarFind(table));
	getDadosTBF();
	table.on('xhr', function () {
   		var json = table.ajax.json();
		$("#qtd_pagamentos").text(json.qtd);
		var totalUser='';
		$.each( json.total_user, function( i, value ){
			totalUser+='<b>'+i+':</b> R$'+value+' '
		})
		$("div.footer").html('<b>T:</b> R$'+json.total+' '+totalUser);
		setSelBusca();
		$("#loading_busca_pagamentos").modal("hide");
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
	$(".reload_busca_pagamentos").click(function() {
		table.ajax.reload();
	});
});
function format (obj) {
	var id_cliente=obj['id_pagamentosfc'];
	var nome=obj['nome_pagamentosfc'];
	var valor_pago=obj['saldo_pagamentosfc'];
	var li_recibo='';
	var li_remove='';
	if(obj['itens_pagamentosfc']>1){
		var datasArray=obj['datas_pagamentosfc'].split(",");
		var valorArray=obj['valores_pagamentosfc'].split(",");
		var descontoArray=obj['descontos_pagamentosfc'].split(",");
		var idsArray=obj['ids_pagamentosfc'].split(",");
		$.each( datasArray, function( i, value ){
			li_recibo+='<li><a href="#" onclick="actionPagamento(\''+idsArray[i]+'\',\'recibo\',\''+nome+'\',\''+valorArray[i]+'\',\''+obj['email_pagamentosfc']+'\',\''+obj['tels_pagamentosfc']+'\');"><i class="fa fa-print"></i> Pag R$ '+valorArray[i]+' em '+value+'</a></li>';
			li_remove+='<li><a href="#" onclick="actionPagamento(\''+idsArray[i]+'\',\'remove\',\''+nome+'\',\''+valorArray[i]+'\',\''+obj['email_pagamentosfc']+'\',\''+obj['tels_pagamentosfc']+'\');"><i class="fa fa-times-circle"></i> Pag R$ '+valorArray[i]+' em '+value+'</a></li>';
		});
	}else{
		li_recibo+='<li><a href="#" onclick="actionPagamento(\''+obj['ids_pagamentosfc']+'\',\'recibo\',\''+nome+'\',\''+obj['valores_pagamentosfc']+'\',\''+obj['email_pagamentosfc']+'\',\''+obj['tels_pagamentosfc']+'\');"><i class="fa fa-print"></i> Pag R$ '+obj['valores_pagamentosfc']+' em '+obj['datas_pagamentosfc']+'</a></li>';
		li_remove+='<li><a href="#" onclick="actionPagamento(\''+obj['ids_pagamentosfc']+'\',\'remove\',\''+nome+'\',\''+obj['valores_pagamentosfc']+'\',\''+obj['email_pagamentosfc']+'\',\''+obj['tels_pagamentosfc']+'\');"><i class="fa fa-times-circle"></i> Pag R$ '+obj['valores_pagamentosfc']+' em '+obj['datas_pagamentosfc']+'</a></li>';
	}

	return '<div class="btn-group" role="group">'+
	'<div class="btn-group" role="group">'+
	  	'<button class="btn btn-default dropdown-toggle btn-sm" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'+
	  		'<i class="fa fa-print"></i>Recibo<span class="caret"></span>'+
	  	'</button>'+
	  	'<ul class="dropdown-menu">'+
	  	li_recibo+
	    '</ul>'+
	'</div>'+
	'<div class="btn-group" role="group">'+
	  	'<button class="btn btn-default dropdown-toggle btn-sm" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'+
	  		'<i class="fa fa-times"></i>Remover<span class="caret"></span>'+
	  	'</button>'+
	  	'<ul class="dropdown-menu">'+
	  	li_remove+
	  	'</ul>'+
	'</div>'+	
	'</div>'; 
}
function toolbarFind() {
	return '<span class="badge" id="qtd_pagamentos"></span><b>Pagamentos de </b>'+
	'<div class="form-group input-group">'+
		'<input class="form-control input-sm" id="campo_busca_pagamentos_nome" onkeyup="$(\'#busca_pagamentos_nome\').val($(this).val());" type="text">'+
		'<span class="input-group-btn">'+
			'<button class="reload_busca_pagamentos btn btn-default btn-sm" type="button"><i class="fa fa-search"></i></button>'+
		'</span>'+
		'<span class="input-group-btn">'+
			'<button class="reload_busca_pagamentos btn btn-default btn-sm" onclick="$(\'#busca_pagamentos_nome\').val(\'\');" type="button"><i class="fa fa-times-circle-o"></i></button>'+
		'</span>'+
		'<span class="input-group-btn">'+
			'<button type="button" data-toggle="dropdown" class="btn btn-default btn-sm">Busca<span class="caret"></span></button>'+
		  	'<ul class="bts_busca dropdown-menu" id="local_meses_pagamentos">'+ 
    		'</ul>'+
    	'</span>'+
		'<span class="input-group-btn">'+
			'<button class="reload_busca_pagamentos btn btn-default btn-sm" type="button"><i class="fa fa-refresh"></i></button>'+
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
	var busca_pagamentos_nome=$("#busca_pagamentos_nome").val();
	$("#campo_busca_pagamentos_nome").val(busca_pagamentos_nome);
	window.history.pushState(null,null,jQuery.query.set('busca_pagamentos_mes', urlArg['busca_pagamentos_mes']).set('busca_pagamentos_nome', busca_pagamentos_nome));
}
function getDadosTBF(){
	loading('Buscabdo Dados Toolbar','loading_dados_toolbar');
	$.post('../_ajax.php',{'cmd':'busca','tipo':'busca_pagamento'},function(dados){
		var dados=JSON.parse(dados);
		$("#loading_dados_toolbar").modal("hide");
		$("#local_meses_pagamentos").html('');
		var li='<li class="dropdown-header">Seleciona o Mês</li>'+
		'<li class="busca_pagamentos_mes" onclick="setBusca(this);" v="all"><a href="#"><i class="fa fa-check" style="display: none;"></i>Todos</a></li>';
		//
		$.each(dados['mes'], function (i, item) {
			li+='<li class="busca_pagamentos_mes" onclick="setBusca(this);" v="'+item.mesn+'"><a href="#"><i class="fa fa-check" style="display: none;"></i>'+item.mesc+'</a></li>';
		});
		li+='<li class="dropdown-header">Seleciona o Usuário</li>'+
		'<li class="busca_pagamentos_user" onclick="setBusca(this);" v="all"><a href="#"><i class="fa fa-check" style="display: none;"></i>Todos</a></li>';
		$.each(dados['user'], function (i, item) {
			li+='<li class="busca_pagamentos_user" onclick="setBusca(this);" v="'+item.user_pagamentosfc+'"><a href="#"><i class="fa fa-check" style="display: none;"></i>'+item.user_pagamentosfc+'</a></li>';
		});
		$("#local_meses_pagamentos").append(li);
	});
}
function setBusca(obj){
	var nome=$(obj).attr("class");
	var valor=$(obj).attr("v");
	$("#"+nome).val(valor);
	table.ajax.reload();
}
function actionPagamento(id,tipo,nome,valor,email,tels){
	if(tipo=='remove'){
        BootstrapDialog.confirm({
            title: 'WARNING',
            message: 'Deseja realmente remover o pagamento:'+id+' do Cliente '+nome+'?',
            type: BootstrapDialog.TYPE_WARNING, // <-- Default value is BootstrapDialog.TYPE_PRIMARY
            closable: true, // <-- Default value is false
            draggable: true, // <-- Default value is false
            btnCancelLabel: 'Não', // <-- Default value is 'Cancel',
            btnOKLabel: 'Sim', // <-- Default value is 'OK',
            btnOKClass: 'btn-warning', // <-- If you didn't specify it, dialog type will be used,
            callback: function(result) {
                // result will be true if button was click, while it will be false if users close the dialog directly.
                if(result) {
                	loading('Removendo pagamento :'+id,'loading_remove_pagamento');
            		$.post('../_ajax.php',{'cmd':'alterar','tipo':'remover_pagamento','id':id},function(dados){
            			dados=JSON.parse(dados);
            			$("#loading_remove_pagamento").modal("hide");
            			BootstrapDialog.alert(dados.result);
            			table.ajax.reload();
            		});
                }
            }
        });		
	}else if(tipo=='recibo'){
		openRecibo('{"error":false,"id":"'+id+'","tels":"'+tels+'","send":{"nome_cliente_caixa":"'+nome+'","valor_caixafc":"'+valor+'","email_cliente_caixa":"'+email+'"}}');		
	}
}