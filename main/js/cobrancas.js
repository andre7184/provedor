function openCobranca(md5,mes,data,valor,id_cliente,nome,email,tels,grupo){
	//alert(mes+','+data+','+valor+','+id_cliente+','+nome+','+email+','+tels+','+grupo);
	BootstrapDialog.show({
		title: 'Cobrança de R$ '+decimalFormat(valor*1)+' - '+nome,
		id: 'dialog_cobrancas',
		message: '<div class="btn-group btn-group-justified" role="group">'+
		'<div class="btn-group" role="group">'+
			'<a class="btn btn-default" href="#" onclick="openPagamento(\''+mes+'\',\''+data+'\',\''+valor+'\',\''+id_cliente+'\',\''+nome+'\',\''+email+'\',\''+tels+'\',\''+grupo+'\');$(\'#dialog_cobrancas\').modal(\'hide\');">Receber Cobrança</a>'+
		'</div>'+
		'<div class="btn-group" role="group">'+
			'<a class="btn btn-default" href="#" onclick="getBoletos(\''+md5+'\',\''+data+'\',\''+valor+'\',\''+id_cliente+'\',\''+nome+'\',\''+grupo+'\');$(\'#dialog_cobrancas\').modal(\'hide\');">Gerar Boleto</a>'+
		'</div>'+
		'</div>'
	});
}
function openPagamento(mes,data,valor,id_cliente,nome,email,tels,grupo){
	var dataHoje=$("#data_hoje").val();
	$("#tels_cliente_caixa").val(tels);
	BootstrapDialog.show({
		title: 'Receber de '+nome+' ('+id_cliente+')',
	    message: '<div id="cadastro_pagamento"><div class="col-lg-12"><div class="form-group">'+
		'<div class="form-group input-group">'+
			'<span class="input-group-addon">Valor Débito R$</span>'+
			'<p class="form-control form-control-static" id="valor_debito">'+decimalFormat(valor*1)+'</p>'+
		'</div>'+
		'<div class="form-group input-group">'+
			'<span class="input-group-addon">Desconto R$</span>'+
			'<input class="form-control mask-valor" onkeyup="$(\'#bt_salvar\').prop(\'disabled\', true);" onfocus="getMask(\'valor\');" name="valor_desconto_caixafc" id="valor_desconto_caixafc" type="text">'+
			'<span class="input-group-btn">'+
		    	'<button class="btn btn-default" onclick="Calcula(\'desconto\');$(\'#bt_salvar\').prop(\'disabled\', false);" type="button"><i class="glyphicon glyphicon-ok-circle"></i></button>'+
		    '</span>'+
		'</div>'+
		'<div class="form-group input-group">'+
			'<span class="input-group-addon">Valor Débito R$</span>'+
			'<p class="form-control form-control-static" id="new_valor_debito">'+decimalFormat(valor*1)+'</p>'+
		'</div>'+
		'<div class="form-group input-group">'+
			'<span class="input-group-addon">Recebido R$</span>'+
			'<input class="form-control mask-valor" onkeyup="$(\'#bt_salvar\').prop(\'disabled\', true);" onfocus="getMask(\'valor\');" value="'+decimalFormat(valor*1)+'" name="valor_caixafc" id="valor_caixafc" type="text">'+
			'<span class="input-group-btn">'+
		    	'<button class="btn btn-default" onclick="Calcula();$(\'#bt_salvar\').prop(\'disabled\', false);" type="button"><i class="glyphicon glyphicon-ok-circle"></i></button>'+
		    '</span>'+
		'</div>'+
		'<div class="form-group input-group" id="div_vr" style="display: none;">'+
			'<span class="input-group-addon"><font id="tipo_vr"></font> R$</span>'+
			'<p class="form-control form-control-static" id="new_valor_debito_atz">'+decimalFormat(valor*1)+'</p>'+
		'</div>'+
		'<div class="form-group input-group" id="div_dd" style="display: none;">'+
			'<span class="input-group-addon">Data Pag Débito</span>'+
			'<input type="text" class="form-control mask-data" name="data_debito_caixafc" id="data_debito_caixafc" value="'+dataHoje+'" data-provide="datepicker" data-date-autoclose="true" data-date-clear-btn="true" data-date-format="dd/mm/yyyy" data-date-language="pt-BR" data-date-today-highlight="true">'+		
		'</div>'+
		'<div class="form-group input-group">'+
			'<span class="input-group-addon">Tipo Pagamento</span>'+
			'<select class="form-control" name="especie_caixafc" id="especie_caixafc">'+
				'<option value="dinheiro">Dinheiro</option>'+
				'<option value="cheque">Cheque</option>'+
				'<option value="cartao_credito">Cartão Crédito</option>'+
				'<option value="cartao_debito">Cartão Débito</option>'+
				'<option value="deposito">Depósito</option>'+
				'<option value="outros">Outros</option>'+
			'</select>'+
		'</div>'+
		'<div class="form-group input-group">'+
			'<span class="input-group-addon">Data Crédito</span>'+
			'<input type="text" class="form-control mask-data" name="data_credito_caixafc" id="data_credito_caixafc" value="'+dataHoje+'" data-provide="datepicker" data-date-autoclose="true" data-date-clear-btn="true" data-date-format="dd/mm/yyyy" data-date-language="pt-BR" data-date-today-highlight="true" data-date-orientation="top">'+		
		'</div>'+
		'<div class="form-group input-group">'+
			'<span class="input-group-addon">Obs</span>'+
			'<textarea cols="40" rows="2" onkeyup="$(this).val($(this).val().toUpperCase());" class="form-control" name="obs_caixafc" id="obs_caixafc"></textarea>'+
	    '</div>'+
		'<input data-fix=true name="cmd" value="save" type="hidden">'+
		'<input data-fix=true name="cache" value="false" type="hidden">'+
		'<input data-fix=true id="tipo" name="tipo" value="caixa" type="hidden">'+
		'<input data-fix=true id="origem_caixafc" name="origem_caixafc" value="local" type="hidden">'+
		'<input data-fix=true id="tipo_caixafc" name="tipo_caixafc" value="in" type="hidden">'+
		'<input data-fix=true id="data_pagamento_caixafc" name="data_pagamento_caixafc" value="'+dataHoje+'" type="hidden">'+
	    '<input id="data_caixafc" name="data_caixafc" value="'+data+'" type="hidden">'+
	    '<input id="mes_caixafc" name="mes_caixafc" value="'+mes+'" type="hidden">'+
	    '<input id="nome_cliente_caixa" name="nome_cliente_caixa" value="'+nome+'" type="hidden">'+
	    '<input id="email_cliente_caixa" name="email_cliente_caixa" value="'+email+'" type="hidden">'+
	    '<input id="grupo_parceria" name="grupo_parceria" value="'+grupo+'" type="hidden">'+
	    '<input id="id_cliente_caixafc" name="id_cliente_caixafc" value="'+id_cliente+'" type="hidden">'+
	    '</div></div></div>',
	    cssClass: 'login-dialog',
	    buttons: [{
	    	label: 'Salvar',
	    	id:'bt_salvar',
	        cssClass: 'btn-primary',
	        action: function(dialog){
	        	dialog.close();
	        	salvaDados('cadastro_pagamento','dados_retorno_pagamento');
	        }
	    },{
	        label: 'Fechar',
	        cssClass: 'btn-primary',
	        action: function(dialog){
	        	dialog.close();
	        }
	    }]
	}); 
}
function getBoletos(md5,data,valor,id_cliente,nome,email,tels,grupo){
	BootstrapDialog.show({
		title: 'Gerar Boleto para '+id_cliente+':'+nome,
	    message: '<div id="cadastro_boleto"><div class="col-lg-12"><div class="form-group">'+
		'<div class="form-group input-group">'+
			'<span class="input-group-addon">Valor Boleto R$</span>'+
			'<p class="form-control form-control-static">'+decimalFormat(valor*1)+'</p>'+
		'</div>'+
		'<div class="form-group input-group">'+
			'<span class="input-group-addon">Data Vencimento</span>'+
			'<input type="text" class="form-control mask-data" name="data_vencimento" id="data_vencimento" value="'+data+'" data-provide="datepicker" data-date-autoclose="true" data-date-clear-btn="true" data-date-format="dd/mm/yyyy" data-date-language="pt-BR" data-date-today-highlight="true">'+		
		'</div>'+
		'<input data-fix=true name="cmd" value="gerar" type="hidden">'+
		'<input data-fix=true name="cache" value="false" type="hidden">'+
		'<input id="id_cobranca" name="id_cobranca" value="'+md5+'" type="hidden">'+
	    '<input id="valor" name="valor" value="'+valor+'" type="hidden">'+
	    '</div></div></div>',
	    cssClass: 'login-dialog',
	    buttons: [{
	    	label: 'Salvar',
	    	id:'bt_salvar',
	        cssClass: 'btn-primary',
	        action: function(dialog){
	        	dialog.close();
	        	salvaDados('cadastro_boleto','dados_retorno_boleto','boleto_facil.php');
	        }
	    },{
	        label: 'Fechar',
	        cssClass: 'btn-primary',
	        action: function(dialog){
	        	dialog.close();
	        }
	    }]
	}); 
}
function openBoleto(dadosj){
	var dados=JSON.parse(dadosj);
	if(!dados.error){
		var tels=dados.telefones.split("|");
		tels = $.grep(tels,function(n){ return n == 0 || n });
		var sel='<option value="">Selecione/Digite</option><option value="new">Digitar...</option>';
		$.each(tels, function (i) {
			if(tels[i]!='')
				sel+='<option value="'+tels[i]+'">'+tels[i]+'</option>';
		});
		BootstrapDialog.show({
			title: 'Boleto de R$ '+dados.valor+' para '+dados.nome,
			id: 'dialog_boleto',
			message: '<div class="form-group input-group">'+
				'<span class="input-group-addon">Linha Digitável</span>'+
				'<p class="form-control form-control-static">'+dados.linha_digitavel+'</p>'+
			'</div>'+
			'<div class="btn-group btn-group-justified" role="group">'+
			'<div class="btn-group" role="group">'+
				'<a class="btn btn-default" href="'+dados.url+'" target="_blank">PDF</a>'+
			'</div>'+
			'<div class="btn-group" role="group">'+
				'<a class="btn btn-default" href="#" onclick="$(\'#local_sms_send\').hide();$(\'#local_email_send\').show();">EMAIL</a>'+
			'</div>'+
			'<div class="btn-group" role="group">'+
				'<a class="btn btn-default" href="#" onclick="$(\'#local_email_send\').hide();$(\'#local_sms_send\').show();">SMS</a>'+
			'</div>'+
			'</div>'+
			'<div class="form-group input-group" id="local_email_send" style="display: none;">'+
				'<span class="input-group-addon">Email</span>'+
				'<input class="form-control" value="'+dados.email+'" id="email_send" type="text">'+
				'<span class="input-group-btn">'+
            		'<button onclick="sendBoleto(\'email\',$(\'#email_send\').val(),\''+dados.id+'\');$(\'#dialog_boleto\').modal(\'hide\');" class="btn btn-default" type="button"><i class="fa fa-search"></i>ENVIAR</button>'+
			    '</span>'+
			'</div>'+
			'<div class="form-group input-group" id="local_sms_send" style="display: none;">'+
				'<span class="input-group-addon">Tels</span>'+
				'<select class="form-control" onchange="onNewTel($(this));" id="sms_send">'+
				sel+
				'</select>'+
				'<span class="input-group-btn">'+
	        		'<button onclick="sendBoleto(\'sms\',$(\'#sms_send\').val(),\''+dados.id+'\');$(\'#dialog_boleto\').modal(\'hide\');" class="btn btn-default" type="button"><i class="fa fa-search"></i>ENVIAR</button>'+
			    '</span>'+
			'</div>'
		});
	}else{ 
		BootstrapDialog.alert(dados.msg);
	}
}
function sendBoleto(tipo,email_tel,id){
	loading('Enviando boleto ('+tipo+') para '+email_tel,'loading_envio_boleto');
	$.post('../_ajax.php',{'cmd':'boleto','tipo':tipo,'email_tel':email_tel,'id_boletosfc':id},function(dadosj){
		var dados=JSON.parse(dadosj);
		$("#loading_envio_boleto").modal("hide");
		BootstrapDialog.alert(dados.msg);
	});
}
function Calcula(tipo) {
	if(tipo=='desconto'){
		var debito=parseFloat($("#valor_debito").text().replace(',', '.'));
		var desconto=$("#valor_desconto_caixafc").val();
		if(desconto=='')
			desconto=0;
		else
			desconto=parseFloat(desconto.replace(',', '.'));
		//
		if(desconto>0)
			debito=debito-desconto;
		//
		$("#new_valor_debito").text(decimalFormat(debito));
		$("#valor_caixafc").val(decimalFormat(debito));
		var recebido=debito;
	}else{
		var debito=parseFloat($("#new_valor_debito").text().replace(',', '.'));
		var recebido=$("#valor_caixafc").val();
		if(recebido=='')
			recebido=0;
		else
			recebido=parseFloat(recebido.replace(',', '.'));
		//
	}
	$("#div_dd").hide();
	if(recebido>debito){
		$("#div_vr").show();
		var restante=recebido-debito;
		$("#tipo_vr").text('Crédito');
	}else if(recebido<debito){
		$("#div_vr").show();
		$("#div_dd").show();
		var restante=debito-recebido;
		$("#tipo_vr").text('Débito');
	}else{
		$("#div_vr").hide();
		var restante=0;
	}
	$("#new_valor_debito_atz").text(decimalFormat(restante));
}
function decimalFormat(number){
	formatedNumber = number.toFixed(2);
	formatedNumber=formatedNumber.replace(".",",");
	return(formatedNumber);
}