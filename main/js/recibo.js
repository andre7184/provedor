function openRecibo(dadosj){
	var dados=JSON.parse(dadosj);
	if(dados.tels!='')
		$("#tels_cliente_caixa").val(dados.tels);
	//
	if(!dados.error){
		var tels=$("#tels_cliente_caixa").val().split("|");
		tels = $.grep(tels,function(n){ return n == 0 || n });
		var sel='<option value="">Selecione/Digite</option><option value="new">Digitar...</option>';
		$.each(tels, function (i) {
			if(tels[i]!='')
				sel+='<option value="'+tels[i]+'">'+tels[i]+'</option>';
		});
		BootstrapDialog.show({
			title: 'Gerar recibo de R$ '+dados.send.valor_caixafc+' para '+dados.send.nome_cliente_caixa,
			id: 'dialog_recibo',
			message: '<div class="btn-group btn-group-justified" role="group">'+
			'<div class="btn-group" role="group">'+
				'<a class="btn btn-default" href="../_ajax.php?cmd=recibo&tipo=html&id_caixafc='+dados.id+'" target="_blank">HTML</a>'+
			'</div>'+
			'<div class="btn-group" role="group">'+
				'<a class="btn btn-default" href="../_ajax.php?cmd=recibo&tipo=pdf&id_caixafc='+dados.id+'" target="_blank">PDF</a>'+
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
				'<input class="form-control" value="'+dados.send.email_cliente_caixa+'" id="email_send" type="text">'+
            	'<span class="input-group-btn">'+
			    	'<button onclick="sendRecibo(\'email\',$(\'#email_send\').val(),\''+dados.id+'\');$(\'#dialog_recibo\').modal(\'hide\');" class="btn btn-default" type="button"><i class="fa fa-search"></i>'+
			        '</button>'+
			    '</span>'+
			'</div>'+
			'<div class="form-group input-group" id="local_sms_send" style="display: none;">'+
				'<span class="input-group-addon">Tels</span>'+
				'<select class="form-control" onchange="onNewTel($(this));" id="sms_send">'+
				sel+
				'</select>'+
	        	'<span class="input-group-btn">'+
			    	'<button onclick="sendRecibo(\'sms\',$(\'#sms_send\').val(),\''+dados.id+'\');$(\'#dialog_recibo\').modal(\'hide\');" class="btn btn-default" type="button"><i class="fa fa-search"></i>'+
			        '</button>'+
			    '</span>'+
			'</div>'
		});
	}else{ 
		BootstrapDialog.alert(dados.msg);
	}
}
function onNewTel(obj){
	if(obj.val()=='new'){
		var textInput=$('<input type="text" class="otherdropdown" placeholder="digite o telefone" />');
		obj.hide().after(textInput);
		textInput.focus();
		textInput.blur( function(ev) {
			var value = this.value;
			this.value = '';
			this.remove();
			obj.show();

			// If something was typed, create a new option with that value
			var searchedOption = obj.children('[value="' + value + '"]');

			// If value doesn't exist, added it.
			if ( searchedOption.length < 1 ) {
				var option = $('<option value="' + value + '">' + value + '</option>');
				obj.append(option);
			}
			// Focus the value
			obj.val( value );
		});
	}
}
function sendRecibo(tipo,email_tel,id){
	loading('Enviando recibo ('+tipo+') para '+email_tel,'loading_envio_recibo');
	$.post('../_ajax.php',{'cmd':'recibo','tipo':tipo,'email_tel':email_tel,'id_caixafc':id},function(dadosj){
		var dados=JSON.parse(dadosj);
		$("#loading_envio_recibo").modal("hide");
		BootstrapDialog.alert(dados.msg);
	});
}