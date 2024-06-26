$(document).ready(function() {
	table.on('xhr', function () {
		var json = table.ajax.json();
		$("#qtd_clientes").text(json.qtd);
		setSelBusca();
		$("#loading_busca_cliente").modal("hide");
	});
	$("div.toolbar").html(toolbarFind(table));
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
	$(".bts_busca li").click(function() {
		var nome=$(this).attr("class");
		var valor=$(this).attr("v");
		$("#"+nome).val(valor);
		if(valor=='limpar')
			$("#busca_clientes_text").val('');
		table.ajax.reload();
	});
	$("#reload_busca_clientes").click(function() {
		table.ajax.reload();
	}); 
	$('#dados_retorno_pagamento').on('change', function() {
		openRecibo($(this).val());
		table.ajax.reload();
	});
});
function format (obj) {
	var id=obj['Id'];
	var nome=obj['Nome'];
	var email=obj['Email'];
	var tels=obj['Tel1']+'|'+obj['Tel2']+'|'+obj['Tel3']
	var sit=obj['Sit'];
	var grupo=obj['Grupo'];
	var cob_total=obj['Divida'];
	var id_bloqueio=0;
	if(obj['Bloqueio']!=null){
		var bloqueiosArray=obj['Bloqueio'].split(";");
		var ultimo_bloqueio=bloqueiosArray[0].split("|");
		id_bloqueio=ultimo_bloqueio[0];
	}
	if(parseInt(cob_total)*1>0){
		var dividas_data=obj['Datas_dividas'].split(";");
		var meses_data=obj['Meses_dividas'].split(";")
		var md5_data=obj['Md5_dividas'].split(";")
		var dividas_valor=obj['Valores_dividas'].split(";");
		var cob='<li><a href="#" onclick="openCobranca(\'\',\'\',\''+dividas_data[(dividas_data.length-1)]+'\',\''+cob_total+'\',\''+id+'\',\''+nome+'\',\''+email+'\',\''+tels+'\',\''+grupo+'\');"><i class="fa fa-credit-card"></i>Vc:'+dividas_data[(dividas_data.length-1)]+' Total R$ '+decimalFormat(parseInt(cob_total)*1)+'</a></li>';
		$.each(dividas_data, function (i) {
			cob+='<li><a href="#" onclick="openCobranca(\''+md5_data[i]+'\',\''+meses_data[i]+'\',\''+dividas_data[i]+'\',\''+dividas_valor[i]+'\',\''+id+'\',\''+nome+'\',\''+email+'\',\''+tels+'\',\''+grupo+'\');"><i class="fa fa-credit-card"></i>Vc:'+dividas_data[i]+' R$ '+decimalFormat(parseInt(dividas_valor[i])*1)+'</a></li>';
		});
	}else{
		var cob='<li><a href="#" onclick="openCobranca(\'\',\'\',\''+$("#data_hoje").val()+'\',\'0,00\',\''+id+'\',\''+nome+'\',\''+email+'\',\''+tels+'\',\''+grupo+'\');"><i class="fa fa-credit-card"></i> Cobrança Avulsa</a></li>';
	}
	var acao='';
	if(sit=='ativo')
		acao='<li><a href="#" onclick="AlteraSit(\'Bloquear ['+nome+']\',\'bl\',\''+id+'\',\''+grupo+'\');"><i class="fa fa-lock"></i>Bloquear</a></li>';
	else if(sit=='bloqueado')
		acao='<li><a href="#" onclick="AlteraSit(\'Desbloquear ['+nome+']\',\'at\',\''+id_bloqueio+'\',\''+grupo+'\');"><i class="fa fa-unlock"></i>Desbloquear</a></li>'+
		'<li><a href="#" onclick="AlteraSit(\''+nome+'\',\'ca\',\''+id+'\',\''+grupo+'\');"><i class="fa fa-times"></i>Cancelar</a></li>';
	else
		acao='<li><i class="fa fa-info-circle"></i>Para Ativar Cadastre um serviço!</li>';
	//
	return '<div class="btn-group" role="group">'+
	'<div class="btn-group" role="group">'+
	  	'<button class="btn btn-default dropdown-toggle btn-sm" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'+
	  		'<i class="fa fa-gears"></i> <span class="caret"></span>'+
	  	'</button>'+
	  	'<ul class="dropdown-menu">'+
	  	'<li><a href="index.php?page=clientes_edit.php&id='+id+'&nome='+nome+'"><i class="glyphicon glyphicon-edit"></i> Alterar Dados Pessoais</a></li>'+
	    '<li><a href="index.php?page=clientes_serv.php&id_cliente='+id+'&nome='+nome+'"><i class="fa fa-calendar"></i> Cadastrar/Alterar Serviços</a></li>'+
	    '<li><a href="index.php?page=clientes_itens.php&id_cliente='+id+'&nome='+nome+'"><i class="fa fa-money"></i> Cadastrar Débitos/Créditos</a></li>'+
	    acao+
	    '</ul>'+
	'</div>'+
	'<div class="btn-group" role="group">'+
	  	'<button class="btn btn-default dropdown-toggle btn-sm" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'+
	  		'<i class="fa fa-list-ul"></i> <span class="caret"></span>'+
	  	'</button>'+
	  	'<ul class="dropdown-menu">'+ 
		    '<li><a href="#" onclick="openList(\'Cobranças\',\'clientes_list_dados.php?id='+id+'&tipo=cobrancas\',\''+nome+'\');"><i class="fa fa-tags"></i> Listar Cobranças</a></li>'+
		    '<li><a href="#" onclick="openList(\'Dividas\',\'clientes_list_dados.php?id='+id+'&tipo=dividas\',\''+nome+'\');"><i class="fa fa-money"></i> Listar Débitos</a></li>'+
		    '<li><a href="#" onclick="openList(\'Bloqueios\',\'clientes_list_dados.php?id='+id+'&tipo=bloqueios\',\''+nome+'\');"><i class="fa fa-lock"></i> Listar Bloqueios</a></li>'+
		    '<li><a href="#" onclick="openList(\'Pagamentos\',\'clientes_list_dados.php?id='+id+'&tipo=pagamentos\',\''+nome+'\');"><i class="fa fa-credit-card"></i> Listar Pagamentos</a></li>'+
	    '</ul>'+
	'</div>'+
	'<div class="btn-group" role="group">'+
	  	'<button class="btn btn-default dropdown-toggle btn-sm" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'+
			'<i class="fa fa-credit-card"></i> Cobranças <span class="caret"></span>'+
		'</button>'+
		'<ul class="dropdown-menu">'+
			cob+
		'</ul>'+
	'</div>'+	
	'</div>'; 
}
function toolbarFind() {
	return '<span class="badge" id="qtd_clientes"></span><b>Clientes </b>'+
	'<div class="form-group input-group">'+
		'<span class="input-group-btn">'+
			'<button id="reload_busca_clientes" class="btn btn-default btn-sm" type="button"><i class="fa fa-refresh"></i>'+
			'</button>'+
		'</span>'+
		'<span class="input-group-btn">'+
			'<button type="button" data-toggle="dropdown" class="btn btn-default btn-sm">Sit<span class="caret"></span></button>'+
		  	'<ul class="bts_busca dropdown-menu">'+
	  			'<li class="busca_clientes_sit" v="all"><a href="#"><i class="fa fa-check" style="display: none;"></i>Todas</a></li>'+
		  		'<li class="busca_clientes_sit" v="ativo"><a href="#"><i class="fa fa-check" style="display: none;"></i>Ativo</a></li>'+
		  		'<li class="busca_clientes_sit" v="bloqueado"><a href="#"><i class="fa fa-check" style="display: none;"></i>Bloqueado</a></li>'+
		  		'<li class="busca_clientes_sit" v="inativo"><a href="#"><i class="fa fa-check" style="display: none;"></i>Inativo</a></li>'+
	  			'<li class="dropdown-header">Listar Vencidos</li>'+
	  			'<li class="busca_clientes_vc" v="all"><a href="#"><i class="fa fa-check" style="display: none;"></i>Todas</a></li>'+
		  		'<li class="busca_clientes_vc" v="on"><a href="#"><i class="fa fa-check" style="display: none;"></i>Sim</a></li>'+
		  		'<li class="busca_clientes_vc" v="off"><a href="#"><i class="fa fa-check" style="display: none;"></i>Não</a></li>'+
		  	'</ul>'+
		'</span>'+
		'<input class="form-control input-sm" id="campo_busca_clientes_text" onkeyup="$(\'#busca_clientes_text\').val($(this).val());" type="text">'+
		'<span class="input-group-btn">'+
			'<button type="button" data-toggle="dropdown" class="btn btn-default btn-sm">Buscar<span class="caret"></span></button>'+
		  	'<ul class="bts_busca dropdown-menu dropdown-menu-right">'+ 
		  		'<li class="busca_clientes_sel" v="limpar"><a href="#" class="btn btn-default btn-sm"><i class="fa fa-check" style="display: none;"></i>LIMPAR</a></li>'+
		  		'<li class="busca_clientes_sel" v="Id"><a href="#" class="btn btn-default btn-sm"><i class="fa fa-check" style="display: none;"></i>Id</a></li>'+
		  		'<li class="busca_clientes_sel" v="Nome"><a href="#" class="btn btn-default btn-sm"><i class="fa fa-check" style="display: none;"></i>Nome</a></li>'+
    			'<li class="busca_clientes_sel" v="Doc"><a href="#" class="btn btn-default btn-sm"><i class="fa fa-check" style="display: none;"></i>Doc</a></li>'+
    			'<li class="busca_clientes_sel" v="Tel"><a href="#" class="btn btn-default btn-sm"><i class="fa fa-check" style="display: none;"></i>Tel</a></li>'+
    			'<li class="busca_clientes_sel" v="Email"><a href="#" class="btn btn-default btn-sm"><i class="fa fa-check" style="display: none;"></i>Email</a></li>'+
    			'<li class="busca_clientes_sel" v="Grupo"><a href="#" class="btn btn-default btn-sm"><i class="fa fa-check" style="display: none;"></i>Grupo</a></li>'+
    			'<li class="busca_clientes_sel" v="Bairro"><a href="#" class="btn btn-default btn-sm"><i class="fa fa-check" style="display: none;"></i>Bairro</a></li>'+
    			'<li class="busca_clientes_sel" v="Rua"><a href="#" class="btn btn-default btn-sm"><i class="fa fa-check" style="display: none;"></i>Rua</a></li>'+
    			'<li class="busca_clientes_sel" v="Comp"><a href="#" class="btn btn-default btn-sm"><i class="fa fa-check" style="display: none;"></i>Comp</a></li>'+
    			'<li class="busca_clientes_sel" v="Secrets"><a href="#" class="btn btn-default btn-sm"><i class="fa fa-check" style="display: none;"></i>Secrets</a></li>'+
    			'<li class="busca_clientes_sel" v="Mk"><a href="#" class="btn btn-default btn-sm"><i class="fa fa-check" style="display: none;"></i>Mk</a></li>'+
    			'<li class="busca_clientes_sel" v="Profile"><a href="#" class="btn btn-default btn-sm"><i class="fa fa-check" style="display: none;"></i>Profile</a></li>'+
    		'</ul>'+
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
	var busca_clientes_text=$("#busca_clientes_text").val();
	$("#campo_busca_clientes_text").val(busca_clientes_text);
	window.history.pushState(null,null,jQuery.query.set('busca_clientes_sit', urlArg['busca_clientes_sit']).set('busca_clientes_vc', urlArg['busca_clientes_vc']).set('busca_clientes_sel', urlArg['busca_clientes_sel']).set('busca_clientes_text', busca_clientes_text));
}
function openList(title,url,nome){
    BootstrapDialog.show({
        title: title+' de '+nome,
        message: $('<div></div>').load(url),
        buttons: [{
            label: 'Fechar',
            cssClass: 'btn-primary',
            action: function(dialog){
                dialog.close();
            }
        }]
    });
	
}
function getMask(tipo){
	if(tipo=='data')
		$(".mask-data").mask('99/99/9999', {placeholder: '__/__/____'});
	if(tipo=='valor')
		$(".mask-valor").mask('####0,00', {placeholder: '0,00',reverse: true});
}
function decimalFormat(number){
	formatedNumber = number.toFixed(2);
	formatedNumber=formatedNumber.replace(".",",");
	return(formatedNumber);
}