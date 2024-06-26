var torre={};
var ids_cord={};
function getAddress(obj){		
	var id_ul=obj.attr("id");
	if(!$(obj).is("ul")){
		id_ul=id_ul+'_ul';
		$(obj).after('<ul id="'+id_ul+'" data-role="listview" data-inset="true"></ul>');
		$("#"+id_ul).listview();
	}
  	$("#"+id_ul).html("");
  	var value=$(obj).val().trim();
  	if(value && value.length > 2 )
    	getGeocode(value,id_ul);
    //
}
function getGeocode(address,id) {
	if(id)
		$("#"+id).html("<li><font color='green'><h3>Carregando...</h3></font></li>").listview('refresh').trigger("updatelayout");
	//
	var html="";
	$.ajax({
  		url: "https://maps.google.com/maps/api/geocode/json?address="+replaceAll(address," ","+")+"&sensor=true&key=AIzaSyA6IqOjPlJ-uvoe_3Wome-S5qi0hEDRQ20",
  		dataType: "json",
  		crossDomain: !0
	}).then( function (r) {
		//alert(print_r(r.results))
		if(r.results.length!=0 && r.results[0].formatted_address && r.results[0].formatted_address!=''){
			//var output = [];
			if(!id && (r.results[0].geometry.location.lat!='' && r.results[0].geometry.location.lng!='')){
				$('#lat').val(r.results[0].geometry.location.lat);
				$('#lng').val(r.results[0].geometry.location.lng);
			}else{
				$.each( r.results, function( key, val ) {
					//alert(val.geometry.location.lat+' - '+val.geometry.location.lng);
					var lat=val.geometry.location.lat;
					var lng=val.geometry.location.lng;
					if(lat!='' && lng!=''){
						html+='<li><a href="#" onclick=\"getAddressInput(\''+removeAcento(val.formatted_address)+'\',\''+id+'\');getMap(false,\''+lat+'|'+lng+'\');\">'+(key+1)+' - '+removeAcento(val.formatted_address)+'</a></li>';
					}
				});
			}
		}else{
			html='<li>Nada Encontrado</li>';
		}
		if(!id)
			loadScriptMaps();
		else
			$("#"+id).html(html).listview("refresh").trigger("updatelayout");
		//
	});
}
function getMap(ids,latlng,address,tor) {
	if(latlng && latlng!=''){
		var latlngArray=latlng.split("|");
		var latlng={};
		latlng.lat=latlngArray[0];
		latlng.lon=latlngArray[1];
	}
	if(ids)
		ids_cord=ids;
	//
	if(tor)
		torre=tor;
	//
	if(latlng && (latlng.lat!='' && latlng.lon!='')){
		$('#lat').val(latlng.lat);
		$('#lng').val(latlng.lon);
		loadScriptMaps();
	}else if(address){
		$("#address-mapa").val(address);
		getGeocode(address);
	}else{
		loadScriptMaps();
	}
}
//
function loadScriptMaps() {
	//getLoading('Carregando MAPA, aguarde...');
	if (!$("#inscript_googleMaps").length ){
		var script = document.createElement('script');
		script.id = 'inscript_googleMaps';
		script.type = 'text/javascript';
		script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp' +
		'&libraries=geometry&sensor=true&signed_in=true&key=AIzaSyA6IqOjPlJ-uvoe_3Wome-S5qi0hEDRQ20&callback=initialize';
		document.body.appendChild(script);
	}else{
		initialize();
	}
}
function initialize() {
	$('#contentMaps').height(getRealContentHeight());
	// This is the minimum zoom level that we'll allow
	var lat=$('#lat').val();
	var lng=$('#lng').val();
	if(!lat || lat=='' && !lng || lng==''){
		lat='-20.3853783';
	   	lng='-54.5601593';
	}
	var minZoomLevel = 16;
	//
	if((torre.lat && torre.lat!='') && (torre.lon && torre.lon!=''))
		var point1 = new google.maps.LatLng(torre.lat,torre.lon);
	else
		var point1 = false;
	//
	var point2 = new google.maps.LatLng(lat,lng);
	//
	var map = new google.maps.Map(document.getElementById('map_canvas'), {
		zoom: minZoomLevel,
	   	center: point2,
	   	mapTypeId: google.maps.MapTypeId.SATELLITE
	});
	if(point1){
		var route = [point1,point2];
		var polyline = new google.maps.Polyline({
			path: route,
		    strokeColor: "#ff0000",
		    strokeOpacity: 0.6,
		    geodesic: true,
		    strokeWeight: 5
		});	
		polyline.setMap(map);
		update(polyline);
		var marker1 = new google.maps.Marker({
			position: point1,
			map: map,
		  	draggable:false,
		  	title:"TORRE "+torre.nome,
		  	icon: pinSymbol("blue"),
		});
	}
	//var lengthInMeters = google.maps.geometry.spherical.computeLength(polyline.getPath());
	
	///$('#distancia').html('Distancia da Torre:'+lengthInMeters);
	// Place a draggable marker on the map
	var marker2 = new google.maps.Marker({
		position: point2,
		map: map,
	  	draggable:true,
	  	title:"Local"
	});
	google.maps.event.addListener(marker2, 'dragend', function (event) {
	  	$('#lat').val(this.getPosition().lat());
	  	$('#lng').val(this.getPosition().lng());
	  	point2 = new google.maps.LatLng($('#lat').val(),$('#lng').val());
	  	if(point1){
	  		route = [point1,point2];
	  		polyline.setPath(route);
	  		update(polyline);
	  	}
	});
	google.maps.event.addListener(map, 'tilesloaded', function() {
		$.mobile.loading("hide");
	});
}
function update(polyline) { 
	  var heading = arredondar(google.maps.geometry.spherical.computeLength(polyline.getPath()),2);
	  $('#distancia').html('Distancia da Torre <b>'+torre.nome+'</b>:'+heading+' mts');
}

function getRealContentHeight() {
	var header = $.mobile.activePage.find("div[data-role='header']:visible");
	var footer = $.mobile.activePage.find("div[data-role='footer']:visible");
	var content = $.mobile.activePage.find("div[data-role='content']:visible:visible");
	var viewport_height = $(window).height();
	var content_height = viewport_height - header.outerHeight() - footer.outerHeight();
	if((content.outerHeight() - header.outerHeight() - footer.outerHeight()) <= viewport_height) {
		content_height -= (content.outerHeight() - content.height());
	} 
	return content_height;
}
function getAddressInput(address,id) {
	var idarray=id.split("_");
	var idam=idarray[0];
	$("#"+idam).val(address);
	$("#"+id+" li").remove();
	$("#"+id).listview("refresh");
}
function getCords() {
	var lat=$("#lat").val();
	var lng=$("#lng").val();
	if(ids_cord && ids_cord.lat!='' && ids_cord.lon!='' && lat!='' && lng!=''){
		$("#"+ids_cord.lat).val(lat);
		$("#"+ids_cord.lon).val(lng);
	}
	$("#lat").val('');
	$("#lng").val('');
	$("#address-mapa").val('');
}
function openMapa(tipo){
	var address=''; 
	var torre={};
	var ids={};
	var latlng=false;
	if(tipo=='ponto'){
		var lat='';var lon='';
		if($('#end_add').val()=='0')
			address=$('#outro_end_add').val();
		else if($('#end_add').val()=='1'){
			address=$("#end_add").find('option[value=1]').html();
			lat=$("#lat1_clientesfc").val();lon=$("#long1_clientesfc").val();
		}else if($('#end_add').val()=='2'){
			address=$("#end_add").find('option[value=2]').html();
			lat=$("#lat2_clientesfc").val();lon=$("#long2_clientesfc").val();
		}//
		if(lat=='' && $("#lat_add").val()!='')
			lat=$("#lat_add").val();
		if(lon=='' && $("#lon_add").val()!='')
			lon=$("#lon_add").val();
		//
		if(lat!='' && lon!='')
			latlng=lat+'|'+lon;
		//
		ids.lat='lat_add';ids.lon='lon_add';
		var torreArr=$("#torre_add").val().split("|");
		torre.nome=torreArr[3];torre.lat=torreArr[1];torre.lon=torreArr[2];
	}else if(tipo=='1'){
		if($("#end1_clientesfc").val()!='')
			address=$("#end1_clientesfc").val()+', '+$("#num1_clientesfc").val()+', '+$("#bar1_clientesfc").val()+', '+$("#cid1_clientesfc").val()+'-'+$("#uf1_clientesfc").val();
		//
		if($("#lat1_clientesfc").val()!='' && $("#long1_clientesfc").val()!='')
			latlng=$("#lat1_clientesfc").val()+'|'+$("#long1_clientesfc").val();
		//
		ids.lat='lat1_clientesfc';ids.lon='long1_clientesfc';
		torre=false;
	}else if(tipo=='2'){
		if($("#end2_clientesfc").val()!='')
			address=$("#end2_clientesfc").val()+', '+$("#num2_clientesfc").val()+', '+$("#bar2_clientesfc").val()+', '+$("#cid2_clientesfc").val()+'-'+$("#uf2_clientesfc").val();
		//
		if($("#lat2_clientesfc").val()!='' && $("#long2_clientesfc").val()!='')
			latlng=$("#lat2_clientesfc").val()+'|'+$("#long2_clientesfc").val();
		//
		ids.lat='lat2_clientesfc';ids.lon='long2_clientesfc';
		torre=false;
	}else{
		ids=false;
		address=false;
		torre=false;
	}
	//alert(ids.lat+'-'+ids.lng);
	if((latlng && latlng!='') || address=='')
		address=false;
	//
	$('<div>').simpledialog2({
		mode: 'blank',
		themeDialog: 'a',
		headerText: 'Mapa',
		headerClose: true,
		fullScreen: true,
		fullScreenForce: true,
		callbackClose:getCords,
		zindex:'10000',
		blankContent : 
			'<div style="padding: 5px;height:100%;overflow:scroll;" id="contentMaps">'+
				'<div class="ui-grid-b">'+
					'<center>'+ 
			    		'<div class="ui-block-a"><input id="lat-torre" type="hidden"><input placeholder="Latitude" id="lat" type="text" style="width:100px"></div>'+
						'<div class="ui-block-b"><input id="lng-torre" type="hidden"><input placeholder="Longitude" id="lng" type="text" style="width:100px"></div>'+
						'<div class="ui-block-c"><a href="#" onclick="getMap();" class="ui-shadow ui-btn ui-corner-all ui-btn-icon-left ui-icon-search ui-btn-min ui-min">RELOAD</a></div>'+
		    		'</center>'+
		    	'</div><!-- /grid-b -->'+
		    	'<div class="ui-grid-solo">'+
		    		'<div class="ui-block-a">'+
		    			'<input id="address-mapa" onkeyup="getAddress($(this));" type="text" placeholder="Address...">'+
		    		'</div>'+
		    	'</div>'+
		    	'<div id="map_canvas" style="height:400px;"></div>'+
		    	'<center>'+
		    		'<font size=2 id="distancia"></font><br>'+
		    		'<a rel="close" data-role="button" href="#">Fechar</a>'+
		    	'</center>'+
		    '</div>'
	  })
	  getMap(ids,latlng,address,torre);
}
function arredondar(valor,casas){
	var novo = Math.round(valor*Math.pow(10,casas))/Math.pow(10,casas);
	return(novo);
}
function pinSymbol(color) {
    return {
        path: 'M 0,0 C -2,-20 -10,-22 -10,-30 A 10,10 0 1,1 10,-30 C 10,-22 2,-20 0,0 z M -2,-30 a 2,2 0 1,1 4,0 2,2 0 1,1 -4,0',
        fillColor: color,
        fillOpacity: 1,
        strokeColor: '#000',
        strokeWeight: 2,
        scale: 1,
   };
}