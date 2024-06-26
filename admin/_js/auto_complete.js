		 	var interval = 0;
		  	function AutoCompleteText(obj){		
		  		var idul=false;
		  		if(obj.attr("data-id-ul") && obj.attr("data-id-ul")!='' && $("#"+obj.attr("data-id-ul")).is("ul")){
		  			idul=obj.attr("data-id-ul");
		  			if(obj.attr("data-name-input"))
		  				obj.attr("name",obj.attr("data-name-input"));
		  			//
		  		}else{
		  			idul=getPassword('ul_',6);
		  			$(obj).after('<ul id="'+idul+'" data-role="listview" data-inset="true"></ul>');
		  			$("#"+idul).listview();
		  			obj.attr("data-id-ul",idul);
		  			if(obj.attr("data-name-input"))
		  				obj.attr("name",obj.attr("data-name-input"));
		  			//
		  		}
		  			var value = obj.val();
		  	        var html = "";
		  	      	$("#"+idul).html("");
		  	      	var dataUrl = obj.attr("data-url").replace("{val}", value);
		  	      	var dataData='';
		  	      	var q = dataUrl.indexOf("?");
		  			if(q>0){
		  				dataData=dataUrl.substr(q+1);
		  				dataUrl=dataUrl.substr(0,q);
		  			}
		  	      	var titulo='';
		  	      	var newitem='';
		  	      	var match='';
		  	      	var idclick='';
		  	    	var loadclick='';
		  	  		var color='red';
		  	  		var dataDelay=100;
		  	  		var dataSpeed='';
		  	  		var useCache='';
		  	  		var useTimeout='';
		  	  		var loading='';
		  	  		var minlen='';
		  			if(obj.attr("data-titulo")){
		  				titulo=obj.attr("data-titulo");
		  			}
		  			if(obj.attr("data-newitem")){
		  				newitem=obj.attr("data-newitem");
		  			}
		  			if(obj.attr("data-no-match")){
		  				match=obj.attr("data-no-match");
		  			}
		  			if(obj.attr("data-id-click")){
		  				idclick=obj.attr("data-id-click");
		  			}
		  			if(obj.attr("data-load-click")){
		  				loadclick=obj.attr("data-load-click");
		  			}
		  			if(obj.attr("data-color")){
		  				color=obj.attr("data-color");
		  			}
		  			if(obj.attr("data-loading")){
		  				loading=obj.attr("data-loading");
		  			}
			  		if(obj.attr("data-speed")) try{
						dataSpeed=parseInt(obj.attr("data-speed"));
					}catch(x){
						dataSpeed=200;
					}
		  	      	if (obj.attr("data-delay")) try {
		  	      		dataDelay = parseInt(obj.attr("data-delay"))
		  	      	} catch (x) {
		  	      		dataDelay=1000;
		  	      	}
		  	      	if (obj.attr("data-cache")) try {
		  	      		useCache = parseBool(obj.attr("data-cache"))
		  	      	} catch (x) {
		  	      		useCache = !0;
		  	      	}
		  	      	if (obj.attr("data-timeout")) try {
		  	      		useTimeout = parseInt(obj.attr("data-timeout"))
		  	      	} catch (x) {
		  	        	useTimeout = 0;
		  	      	}
		  	      	if (obj.attr("data-minlen")) try {
		  	      		minlen = parseInt(obj.attr("data-minlen"))
		  	      	} catch (x) {
		  	      		minlen = 2;
		  	      	} 
		  	      	clearInterval(interval);
		  	      	interval = window.setTimeout(function(){
			  	      	var val=obj.val().trim();
	  	        		if (val.length >= minlen) {
	  	        			var callData=dataData;
	  	        			//$("#"+idul).html("<li><div class='ui-loader'><span class='ui-icon ui-icon-loading'></span></div></li>");
	  	        			//$("#"+idul).listview("refresh");
	  	        			var loading = loading || $.mobile.loader.prototype.options.text;
				  	        getLoading(loading);
				  	    	$.ajax({
				  	    		url: dataUrl,
				  	            data: callData,
				  	            cache: useCache,
				  	            dataType: "json",
				  	            crossDomain: !0,
				  	            timeout: useTimeout
				  	      	}).then( function ( response ) {
				  	      		if(!response.auth) 
				  	      			location.reload();
				  	      		//
				  	      		if(response.qtd==0){
				  	      			if(newitem)
				  	      				html +="<li><a href=\"#"+newitem+"\"><font size='2'>Cadastrar Novo</font></a></li>";
				  	      			else if(match!='')
				  	      				html +="<li>"+match+" com '<font color=\""+color+"\">"+response.query+"</font>'</li>";
				  	      		}
				  	      		if(response.qtd!=0){
					  	      		if(titulo!='')
					  	      			html += "<li><center><b>"+titulo+"</b></center></li>";
					  	      		//
					  	      		$.each(response.suggestion, function ( i, dados ) {
					  	         		var resultado = dados.name.replace(/\"/g,"\\\"");
					  	              	if (loadclick != ''){
					  	              		loadclick += "('"+dados.id+"','"+idul+"')";
					  	              	}
					  	              	var reg = RegExp("("+response.query+")",'gi'); 
					  	              	//alert(reg);
					  	              	var textname = dados.name.replace(reg,"<font color='"+color+"'>$1</font>");
					  	              	//alert(textname);
					  	              	html += "<li><a onclick=\"ocac('"+dados.id+"','"+resultado+"','"+idclick+"','"+idul+"');"+loadclick+";\" href=\"#\">"+textname+"</a></li>";
					  	            });
				  	      			if(newitem)
				  	      				html +="<li><a href=\"#"+newitem+"\"><font size='2'>Cadastrar Novo</font></a></li>";
				  	      		}
				  	      		$("#"+idul).html(html);
				  	      		$("#"+idul).listview("refresh");
				  	      		$("#"+idul).trigger("updatelayout");
				  	          	$.mobile.loading("hide")
				  	          	
				  	      	});
	  	        		}
	  	    		}, dataDelay);
		  	      	
	  		}
		  	//
			function ocac(id,value,idclick,idul){
				if(idclick && idclick!='')
					if($("#"+idclick).is("input"))
						$("#"+idclick).val(id);
					else
						$("#"+idclick).html(id);
				//
				$('input[data-id-ul="'+idul+'"]').val(value);
				$("#"+idul+" li").remove();
				$("#"+idul).listview("refresh");
				$("#"+idul).remove();
			}