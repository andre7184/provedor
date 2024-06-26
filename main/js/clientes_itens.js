var form='<label>Gerar (1) Item:</label>'+
'<div class="form-group input-group">'+
	'<span class="input-group-addon">Descrição</span>'+
	'<input class="form-control" onkeyup="$(this).val($(this).val().toUpperCase());" name="descricao_itensfc[]" type="text">'+
'</div>'+
'<div class="form-group input-group">'+
	'<span class="input-group-addon">Data (vencimento)</span>'+
	'<input class="form-control mask-data" name="data_itensfc[]" value="'+dataHoje+'" type="text">'+
'</div>'+
'<div class="form-group input-group">'+
	'<span class="input-group-addon">Valor R$</span>'+
	'<input class="form-control mask-valor" onkeyup="$(\'#bt_salvar\').prop(\'disabled\', true);" id="valor_itensfc" name="valor_itensfc[]" type="text" />'+
	'<span class="input-group-btn">'+
		'<button class="btn btn-default" onclick="$(\'#valor_total_itensfc\').val($(\'#valor_itensfc\').val());$(\'#bt_salvar\').prop(\'disabled\', false);" type="button"><i class="glyphicon glyphicon-ok-circle"></i></button>'+
	'</span>'+
'</div>'+
'<input name="qtd_itensfc[]" id="qtd_itensfc" value="1" type="hidden">'+
'<input name="valor_total_itensfc[]" id="valor_total_itensfc" type="hidden">';
var formParcelado='<label>Gerar Itens em Parcelas:</label>'+
'<div class="form-group input-group">'+
	'<span class="input-group-addon">R$</span>'+
	'<input class="form-control mask-valor" id="valor_total" type="text">'+
	'<span class="input-group-addon">In R$</span>'+
	'<input class="form-control mask-valor" id="valor_entrada" type="text">'+
	'<span class="input-group-btn">'+
    	'<button class="btn btn-default" onclick="Calcula();" type="button"><i class="glyphicon glyphicon-ok-circle"></i></button>'+
    '</span>'+
'</div>'+
'<ul class="list-group" id="local_parcelas">'+
'</ul>';
$(function($){
	$("#dados_itens").append(form);
	getMask();
	//
	$("#parcelar_item").change(function() {
		if($(this).val()>0){
			if($("#valor_entrada").length>0){
				Calcula();
			}else{
				$("#dados_itens").html('');
				$("#dados_itens").append(formParcelado);
				getMask();
			}
		}else{
			$("#dados_itens").html('');
			$("#dados_itens").append(form);
			getMask();
		}
	});
	$('#name_cliente_add').bootcomplete({
	    url:'../_ajax.php',
	    minLength : 3,
	    method:'post',
	    idField:true,
	    idFieldName:'id_cliente_itensfc',
	    dataParams:{
	    	'cmd':'busca',
	    	'tipo':'clientes'
	    }
	});
	$('#dados_ajax').on('change', function() {
		var dados=JSON.parse($(this).val());
		if(dados.new)
			$(location).attr('href','http://mkfacil.cf/main/pages/index.php?page=clientes_list.php&busca_clientes_sel=Id&busca_clientes_text='+dados.id);
	});
});
function getMask(){
	$(".mask-data").mask('99/99/9999', {placeholder: '__/__/____'});
	$(".mask-valor").mask('####0,00', {placeholder: '0,00',reverse: true});
}
function Calcula() {
	var qtd=$("#parcelar_item").val();
	if(qtd>0){
		$("#local_parcelas").html('');
		var valor_total='0,00';
		var valor_entrada='0,00';
		if($("#valor_total").val()!='')
			valor_total=$("#valor_total").val();
		//
		if($("#valor_entrada").val()!='')
			valor_entrada=$("#valor_entrada").val();
		//
		var valor_restante=parseInt(valor_total)*1-parseInt(valor_entrada)*1;
		valor_entrada=parseInt(valor_entrada)*1;
		if(valor_entrada>0){
			//
			$("#local_parcelas").append('<div class="form-group input-group">'+
			'<span class="input-group-addon">P(0) Data</span>'+
			'<input class="form-control mask-data" name="data_itensfc[]" value="'+dataHoje+'" type="text">'+
			'<span class="input-group-addon">R$</span>'+
			'<p class="form-control form-control-static">'+decimalFormat(valor_entrada)+'</p>'+
			'</div>'+
			'<input name="valor_itensfc[]" value="'+decimalFormat(valor_entrada)+'" type="hidden">'+
			'<input name="qtd_itensfc[]" value="1" type="hidden">'+
			'<input name="valor_total_itensfc[]" value="'+decimalFormat(valor_entrada)+'" type="hidden">'+
			'<input name="descricao_itensfc[]" value="PARCELA 0/'+qtd+'" type="hidden">');
		}
		if(valor_restante>0){
			var valor_parcela=valor_restante/qtd*1;
			for(i=1;i<=qtd;i++){
				var dataVc=dataFormatada(dataHoje,i);
				$("#local_parcelas").append('<div class="form-group input-group">'+
				'<span class="input-group-addon">P('+i+') Data</span>'+
				'<input class="form-control mask-data" name="data_itensfc[]" value="'+dataVc+'" type="text">'+
				'<span class="input-group-addon">R$</span>'+
				'<p class="form-control form-control-static">'+decimalFormat(valor_parcela)+'</p>'+
				'</div>'+
				'<input name="valor_itensfc[]" value="'+decimalFormat(valor_parcela)+'" type="hidden">'+
				'<input name="qtd_itensfc[]" value="1" type="hidden">'+
				'<input name="valor_total_itensfc[]" value="'+decimalFormat(valor_parcela)+'" type="hidden">'+
				'<input name="descricao_itensfc[]" value="PARCELA '+i+'/'+qtd+'" type="hidden">');			
			}
		}
			
	}
}
function dataFormatada(dataHoje,m=0) {
	var dataArray=dataHoje.split('/')
	var data=new Date(dataArray[2], dataArray[1], dataArray[0])
        dia = data.getDate(),
        mes = data.getMonth() + m,
        ano = data.getFullYear(),
        hora = data.getHours(),
        minutos = data.getMinutes(),
        segundos = data.getSeconds();
	if(dia<10)
		dia='0'+dia;
	if(mes<10)
		mes='0'+mes;
    return [dia, mes, ano].join('/');
}
function decimalFormat(number){
	formatedNumber = number.toFixed(2);
	formatedNumber=formatedNumber.replace(".",",");
	return(formatedNumber);
}