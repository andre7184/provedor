	//FUNCAO LOADING
	function getSelect(n) {
		if(n){
			//alert(n instanceof Object);
			if(n instanceof Object)
				var sel=n;
			else
				var sel='select[name="'+n+'"][data-role="auto"][data-url]';
		}else
			var sel='select[data-role="auto"][data-url]';
		//
		$(sel).each(function() {
			var inp=$(this);
			var dataUrl=inp.attr("data-url");
			$.ajax({url: dataUrl,
	            success: function(output) {
	               inp.html(output);
	           },
	         error: function (xhr, ajaxOptions, thrownError) {
	           alert(xhr.status + " "+ thrownError);
	         }});
		});
	}
	//FUNCAO LOADING
	function getLoading(m) {
		$.mobile.loading("hide");
		$.mobile.loading("show",{
  		    text: m,
  		    textVisible: true,
  		    theme: $.mobile.loader.prototype.options.theme,
  		    textonly: false,
  		    html: ''
  		});
	}
	//FUNCAO BUSCA ENDERE«O
	function getEnd(cep,valEnd) {
		if($.trim(cep) != ""){
			getLoading('Buscando EndereÁo, aguarde...');
			$.getScript("remote.php?cmd=busca&tipo=end&formato=javascript&cep="+cep, function(){
		  		if(resultadoCEP["resultado"]){
		  			$("#"+valEnd.logradouro).val(unescape(resultadoCEP["tipo_logradouro"]).toUpperCase()+' '+unescape(resultadoCEP["logradouro"]).toUpperCase());
		  			$("#"+valEnd.bairro).val(unescape(resultadoCEP["bairro"]).toUpperCase());
		  			$("#"+valEnd.cidade).val(unescape(resultadoCEP["cidade"]).toUpperCase()); 
		  			$("#"+valEnd.uf).val(unescape(resultadoCEP["uf"]).toUpperCase());
		  			$.mobile.loading("hide");
		  			//showPopup({title: "Sucesso!", message: "Cep "+cep+" correto, End:"+resultadoCEP['tipo_logradouro']+" "+resultadoCEP['logradouro']+"!", buttonText: "I know!", width: "500px"});
				}else{
					//showPopup({title: "Error", message: 'Cep n„o encontrado!', buttonText: "I know!", width: "500px"});
					//$("#popupDialog").popup("open");
					$.mobile.loading("hide");
					alert('Nenhum endereÁo encontrado!');
				}
			});			
		}else{
			$("#"+valEnd.cep).focus();
			alert('Preencha corretamento o cep!');
		}	
	}
	//FUNCAO BUSCA CEP
	function getCep(valEnd) {
		var log=$("#"+valEnd.logradouro).val();
		var end=log;
		if(end!=''){
			if($("#"+valEnd.numero).val()!='')
				end+='+'+$("#"+valEnd.numero).val();
			//
			if($("#"+valEnd.bairro).val()!='')
				end+='+'+$("#"+valEnd.bairro).val();
			//
			if($("#"+valEnd.cidade).val()!='')
				end+='+'+$("#"+valEnd.cidade).val();
			//
			if($("#"+valEnd.uf).val()!='')
				end+='+'+$("#"+valEnd.uf).val();
		}
		if(end != ""){
			getLoading('Buscando Cep, aguarde...');
			$.getJSON( "remote.php?cmd=busca&tipo=cep&end="+end, function( r ) {
				$.mobile.loading("hide");
				if(r.results.length!=0){
					var cepL={};
					var cepS={};
					var output = [];
					$.each( r.results, function( key1, val1 ) {
						//alert(val1.formatted_address)
						$.each( val1.address_components, function( key, val ) {
							//alert(val+' - '+val.types[0])
							cepL[val.types[0]]=val.long_name;
							cepS[val.types[0]]=val.short_name;
						});
						if(cepL.postal_code && cepL.postal_code!='')
							output.push('<li><a onclick="$(\'#'+valEnd.cep+'\').val(\''+cepL.postal_code+'\');$(\'#bt_PageListView\').click();">'+cepL.postal_code+' - '+val1.formatted_address+'</a></li>');
						//
					});
					if(output.length>0){
						$.mobile.changePage("#PageListView");
						$("#titulo_PageListView").html("Cep(s) Localizados");
						$("#list_PageListView").empty().append(output.join('')).listview('refresh');
						$("#list_PageListView").listview('refresh');
					}else{
						alert('Nenhum cep encontrado!');
					}
				}else{
					alert('Nenhum cep encontrado!');
				}
			});
		}else{
			$("#"+valEnd.logradouro).focus();
			alert('Preencha corretamento o endereÁo!');
		}	
	}
	//REMOVE ACENTOS
	function removeAcento(strToReplace) {
		str_acento= "·‡„‚‰ÈËÍÎÌÏÓÔÛÚıÙˆ˙˘˚¸Á¡¿√¬ƒ…» ÀÕÃŒœ”“’÷‘⁄Ÿ€‹«";
		str_sem_acento = "aaaaaeeeeiiiiooooouuuucAAAAAEEEEIIIIOOOOOUUUUC";
		var nova="";
		for (var i = 0; i < strToReplace.length; i++) {
			if (str_acento.indexOf(strToReplace.charAt(i)) != -1) {
				nova+=str_sem_acento.substr(str_acento.search(strToReplace.substr(i,1)),1);
			} else {
				nova+=strToReplace.substr(i,1);
			}
		 }
		 return nova;
	 } 
	 // IMPRIME FORMATO REAL
	function brMoney(v) {
		 v = Ext.num(v, 0);
		 v = (Math.round((v - 0) * 100)) / 100;
		 v = (v == Math.floor(v)) ? v + ".00" : ((v * 10 == Math.floor(v * 10)) ? v + "0" : v);
		 v = String(v);
	
		 var ps = v.split('.');
		 var whole = ps[0];
		 var sub = ps[1] ? ','+ ps[1] : ',00';
		 var r = /(\d+)(\d{3})/;
	
		 while (r.test(whole)) {
			 whole = whole.replace(r, '$1' + '.' + '$2');
		 }
	
		 v = whole + sub;
	
		 if (v.charAt(0) == '-') {
			 return '-R$' + v.substr(1);
		 }
	
		 return "R$ " + v;
	 }
	// INT FORMAT
	function intFormat(texto){
		texto=texto.replace(",",".");
		return texto*1;
	}
	// DECIMAL FORMAT
	function decimalFormat(number){
		formatedNumber = number.toFixed(2);
		formatedNumber=formatedNumber.replace(".",",");
		return(formatedNumber);
	}
	//
	function arredondar(valor,casas){
		var novo = Math.round(valor*Math.pow(10,casas))/Math.pow(10,casas);
		return(novo);
	}
	// PEGAR VARIAVEL GET
	function getUrlVars(){
		alert('ok');
	    var vars = [], hash;
	    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
	    for(var i = 0; i < hashes.length; i++)
	    {
	        hash = hashes[i].split('=');
			hash[1] = unescape(hash[1]);
			vars.push(hash[0]);
	        vars[hash[0]] = hash[1];
	    }
	 
	    return vars;
	}
	// VERIFICAR 
	function timeOut(){
		//alert(timeLoadFunction+'>'+timeLimit)
		if(timeLoadFunction>timeLimit){
			clearInterval(nomeIntervalo);
			Ext.MessageBox.hide();
			Ext.Msg.alert('Error!', 'Timeout do download do arquivo!<br><center>Tente novamente!</center>');
			
		}
		timeLoadFunction++;
	}
	function rce(text) { 
		text = text.replace(new RegExp('[-_.,/?!:;]','gi'), '');
		return text;
	}
	// SUBSTITUIR ACENTOS
	/*function removeAcento(text) { 
		if(!text){
			var text='';
		}
		text = text.replace(new RegExp('[¡¿¬√]','gi'), 'A'); 
		text = text.replace(new RegExp('[…» ]','gi'), 'E'); 
		text = text.replace(new RegExp('[ÕÃŒ]','gi'), 'I'); 
		text = text.replace(new RegExp('[”“‘’]','gi'), 'O'); 
		text = text.replace(new RegExp('[⁄Ÿ€]','gi'), 'U'); 
		text = text.replace(new RegExp('[«]','gi'), 'C'); 
		text = text.toLowerCase(); 
		return text; 
	}*/
	// BUSCA NO ARRAY
	function findArray(arr,text) { 
		for (var i=0;i<arr.length;i++) { 
			if(arr[i]==text){
				return true;	
			} 
		} 
		return false; 
	}
	// REMOVE ELEMENTOS DUPLICADOS NO ARRAY
	function find_duplicates(arr) { 
		var len = arr.length, 
		out = [], 
		counts = {}; 
		for (var i=0;i<len;i++) { 
			var item = arr[i]; 
			var count = counts[item]; 
			counts[item] = counts[item] >= 1 ? counts[item] + 1 : 1; 
		} 
		for (var item in counts) { 
			if(counts[item] > 1) 
				out.push(item); 
		} 
		return out; 
	}
	// PRINT_R PARA JAVASCRIPT
	function print_r(theObj){
		var dw="";
		if(theObj.constructor == Array || theObj.constructor == Object){
			for(var p in theObj){
		     	if(theObj[p].constructor == Array || theObj[p].constructor == Object){
					dw+="["+p+"] => "+typeof(theObj)+"";
		            	dw+="";
		            	dw+=print_r(theObj[p]);
		            	dw+="";
		         	} else {
		            	dw+="["+p+"] => "+theObj[p]+"";
		         }
		      }
		      dw+="";
		}
		return dw;
	}
	// GERA CODIGO ALEATORIO
	function getPassword(iniciais,qtd) {
		if(!iniciais)
			var iniciais=""
		var rc = iniciais;
		var numberChars = "0123456789";
		var count = qtd-rc.length;
		for (var idx = 1; idx <= count; ++idx) {
			rc = rc + numberChars.charAt(Math.floor(Math.random() * (numberChars.length - 0)) + 0);
		}
		return rc;
	}
	//var x;
	function getX(element){
		var x;
		$(document).ready(function() {
			x=$('#'+element).offset().left;
		});
		return x;
	}
	function getY(element){
		var y;
		$(document).ready(function() {
			y=$('#'+element).offset().top;
		});
		return y;
	}
	//
	function isArray(obj) {
	 	if (obj.constructor.toString().indexOf("Array") == -1)
	  		return false;
	 	else
	  		return true;
	}
	//
	function moeda(valor, casas){
		var separdor_decimal=',';
		var separador_milhar='.';
		var valor_total = parseInt(valor * (Math.pow(10,casas)));
		var inteiros =  parseInt(parseInt(valor * (Math.pow(10,casas))) / parseFloat(Math.pow(10,casas)));
		var centavos = parseInt(parseInt(valor * (Math.pow(10,casas))) % parseFloat(Math.pow(10,casas)));
		if(centavos%10 == 0 && centavos+"".length<2 ){
			centavos = centavos+"0";
		}else if(centavos<10){
			centavos = "0"+centavos;
		}
		var milhares = parseInt(inteiros/1000);
		inteiros = inteiros % 1000;
		var retorno = "";
		if(milhares>0){
			retorno = milhares+""+separador_milhar+""+retorno
			if(inteiros == 0){
				inteiros = "000";
			} else if(inteiros < 10){
				inteiros = "00"+inteiros;
			} else if(inteiros < 100){
				inteiros = "0"+inteiros;
			}
		}
		retorno += inteiros+""+separdor_decimal+""+centavos;
		return retorno;
	}
	// ABRE POPUP
	function novaJanela(URL,nome){
   		window.open(URL,nome/*,"width=800, 
                                   height=600,
                                   directories=no,
                                   location=no,
                                   menubar=no,
                                   scrollbars=no,
                                   status=no,
                                   toolbar=no,
                                   resizable=no"*/)
	}
	//// ABRE JANELA DO MAPA
	function setWinMapa(nome_item,tipo_logradouro,logradouro,numero,cidade,uf,latitude,longitude){
		var valEnd = {
			tipo_logradouro:tipo_logradouro,
			logradouro:logradouro,
			numero:numero,
			cidade:cidade,
			uf:uf,
			latitude:latitude,
			longitude:longitude
		};
		getMap('Local',nome_item,valEnd,true);	
	}
	// lista macs
	function setListaMac(id,codigo,nome){
		// FILTRO GRID
		var nomeModel='model_'+Math.round(Math.random()*1000);
		Ext.define(nomeModel, {
		     extend: 'Ext.data.Model',
		     fields: ['mac','tipo','sit','ip','equipamentos']
		})
		var storeMacs = new Ext.data.JsonStore({
		    	model: nomeModel,
		     proxy: {
		          type: 'rest',
		          url: 'gerenciador/configurar_pontos.php',
		          extraParams:{cmd:'load',tipo:'grid',id_pontos:id},
		          reader: {
		               type: 'json',
		               root: 'data'
		          }
		     }
		});
		var columnsMacs = [Ext.create('Ext.grid.RowNumberer')
		,{
			header: 'Mac', 
			width: 120, 
			dataIndex: 'mac'
		},{
			header: 'Tipo', 
			width: 70, 
			dataIndex: 'tipo'
	
		},{
			header: 'Sit', 
			width: 40, 
			dataIndex: 'sit'	
		},{
			header: 'Ip Fixo', 
			width: 100, 
			dataIndex: 'ip'
	
		},{
			header: 'Equipamentos', 
			width: 200, 
			dataIndex: 'equipamentos'
		}]
		// INICIO DADOS PARA BUSCA GRID
	    	var storeCampoBuscaMacs = new Ext.data.Store({
			fields:['text'],
			data:[]					    	
		})
	    	storeMacs.on('load', function() {
			buscaGrid('Macs');
			listaBusca('Macs');
		})
		inicializaBusca('Macs');
		//FIM DADOS PARA BUSCA GRID
		var gridMacs = Ext.create('Ext.grid.Panel', {
		     id:'gridMacs',
		     width: 400,
		     //frame: true,
		     loadMask: true,
		     store: storeMacs,
		     //iconCls: 'icon-user',
		     columns: columnsMacs,
			selType: 'rowmodel',
			dockedItems: [{
				xtype: 'toolbar',
				items: addCampoBusca('Macs',columnsMacs,storeCampoBuscaMacs,storeMacs)
			}]     
		});
		showWinSimple('Lista de Macs <font color=green>(Cliente '+nome+')</font>',gridMacs,'',200); 
		storeMacs.load();
	}
	// verifica se objeto existe
	function isObjeto(o){
		return(typeof(o.length)=="undefined")?true:false;
	}
	//
	function replaceAll(string, token, newtoken) {
		while (string.indexOf(token) != -1) {
	 		string = string.replace(token, newtoken);
		}
		return string;
	}
	// TEXTO COL COMPLETO
	function formataColuna(value){
		return '<p style="white-space:normal">' + value + '</p>';
	}
	//ORDENAR DATAS
	var dateRE = /^(\d{2})[\/\- ](\d{2})[\/\- ](\d{4})/;
	function dmyOrdA(a, b){
		a = a.replace(dateRE,"$3$2$1");
		b = b.replace(dateRE,"$3$2$1");
		if (a>b) return 1;
		if (a<b) return -1;
		return 0; 
	}
	function dmyOrdD(a, b){
		a = a.replace(dateRE,"$3$2$1");
		b = b.replace(dateRE,"$3$2$1");
		if (a>b) return -1;
		if (a <b) return 1;
		return 0; 
	}
	function ymdOrdA(a, b){
		a = a.replace(dateRE,"$1$2$3");
		b = b.replace(dateRE,"$1$2$3");
		if (a>b) return 1;
		if (a <b) return -1;
		return 0; 
	}
	function ymdOrdD(a, b){
		a = a.replace(dateRE,"$1$2$3");
		b = b.replace(dateRE,"$1$2$3");
		if (a>b) return -1;
		if (a <b) return 1;
		return 0; 
	}
	//VALIDA CPF
	function validarCPF(cpf) {
	    cpf = cpf.replace(/[^\d]+/g,'');
	 
	    if(cpf == '') return false;
	 
	    // Elimina CPFs invalidos conhecidos
	    if (cpf.length != 11 ||
	        cpf == "00000000000" ||
	        cpf == "11111111111" ||
	        cpf == "22222222222" ||
	        cpf == "33333333333" ||
	        cpf == "44444444444" ||
	        cpf == "55555555555" ||
	        cpf == "66666666666" ||
	        cpf == "77777777777" ||
	        cpf == "88888888888" ||
	        cpf == "99999999999")
	        return false;
	     
	    // Valida 1o digito
	    add = 0;
	    for (i=0; i < 9; i ++)
	        add += parseInt(cpf.charAt(i)) * (10 - i);
	    rev = 11 - (add % 11);
	    if (rev == 10 || rev == 11)
	        rev = 0;
	    if (rev != parseInt(cpf.charAt(9)))
	        return false;
	     
	    // Valida 2o digito
	    add = 0;
	    for (i = 0; i < 10; i ++)
	        add += parseInt(cpf.charAt(i)) * (11 - i);
	    rev = 11 - (add % 11);
	    if (rev == 10 || rev == 11)
	        rev = 0;
	    if (rev != parseInt(cpf.charAt(10)))
	        return false;
	         
	    return true;
	}
	//VALIDA CNPJ
	function validarCNPJ(cnpj){
	    cnpj = cnpj.replace(/[^\d]+/g,'');
	 	//
	    if(cnpj == '') return false;
	    //
	    if (cnpj.length != 14)
	        return false;
	 	//
	    // Elimina CNPJs invalidos conhecidos
	    if (cnpj == "00000000000000" ||
	        cnpj == "11111111111111" ||
	        cnpj == "22222222222222" ||
	        cnpj == "33333333333333" ||
	        cnpj == "44444444444444" ||
	        cnpj == "55555555555555" ||
	        cnpj == "66666666666666" ||
	        cnpj == "77777777777777" ||
	        cnpj == "88888888888888" ||
	        cnpj == "99999999999999")
	        return false;
	    //     
	    // Valida DVs
	    tamanho = cnpj.length - 2
	    numeros = cnpj.substring(0,tamanho);
	    digitos = cnpj.substring(tamanho);
	    soma = 0;
	    pos = tamanho - 7;
	    for (i = tamanho; i >= 1; i--) {
	      	soma += numeros.charAt(tamanho - i) * pos--;
	      	if (pos < 2)
	            pos = 9;
	    }
	    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
	    if (resultado != digitos.charAt(0))
	        return false;
	    //
	    tamanho = tamanho + 1;
	    numeros = cnpj.substring(0,tamanho);
	    soma = 0;
	    pos = tamanho - 7;
		for (i = tamanho; i >= 1; i--) {
	    	soma += numeros.charAt(tamanho - i) * pos--;
	     	if (pos < 2)
	            pos = 9;
	    }
	    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
	    if (resultado != digitos.charAt(1))
	          return false;
		//        
	    return true;
	}
	//
	function SomarData(txtData,DiasAdd) {
        // Tratamento das Variaveis.
        // var txtData = "01/01/2007"; //poder ser qualquer outra
        // var DiasAdd = 10 // Aqui vem quantos dias vocÍ quer adicionar a data
        var d = new Date();
        // Aqui eu "mudo" a configuraÁ„o de datas.
        // Crio um obj Date e pego o campo txtData e 
        // "recorto" ela com o split("/") e depois dou um
        // reverse() para deixar ela em padr„o americanos YYYY/MM/DD
       	// e logo em seguida eu coloco as barras "/" com o join("/")
       	// depois, em milisegundos, eu multiplico um dia (86400000 milisegundos)
        // pelo n˙mero de dias que quero somar a txtData.
        d.setTime(Date.parse(txtData.split("/").reverse().join("/"))+(86400000*(DiasAdd)))
        // Crio a var da DataFinal            
        var DataFinal;
        // Aqui comparo o dia no objeto d.getDate() e vejo se È menor que dia 10.            
        if(d.getDate() < 10){
            // Se o dia for menor que 10 eu coloca o zero no inicio
            // e depois transformo em string com o toString()
            // para o zero ser reconhecido como uma string e n„o
            // como um n˙mero.
            DataFinal = "0"+d.getDate().toString();
        }else{    
            // Aqui a mesma coisa, porÈm se a data for maior do que 10
            // n„o tenho necessidade de colocar um zero na frente.
            DataFinal = d.getDate().toString();    
        }
        
        // Aqui, j· com a soma do mÍs, vejo se È menor do que 10
        // se for coloco o zero ou n„o.
        if((d.getMonth()+1) < 10){
            DataFinal += "/0"+(d.getMonth()+1).toString()+"/"+d.getFullYear().toString();
        }else{
            DataFinal += "/"+((d.getMonth()+1).toString())+"/"+d.getFullYear().toString();
        }
        return DataFinal;
	}
	//
	function clear_form_elements(id) {
		$("#"+id+" input, #"+id+" select").each(function() {
			if(this.type=='checkbox' || this.type=='radio')
				 this.checked = false;
			else
				if(!$(this).attr("data-fix"))
					$(this).val('');
			//
			if($(this).attr("data-role")=='slider')
				$(this).slider("refresh");
			else if($(this).is('select'))
				$(this).selectmenu('refresh', true);
			//
        });
    }
