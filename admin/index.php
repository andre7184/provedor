<?php 
$getLoading = <<<END
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
END;
require_once("_validar.php");
	if(!$authSession){
		?>
		<!DOCTYPE html>
		<html>
		<head>
			<title>MKFÁCIL - LOGIN</title>
			<meta name="viewport" content="initial-scale=1, maximum-scale=1" />
			<link rel="stylesheet" href="_js/jquery/jquery-mobile-1.4.5.min.css" />
			<link rel="stylesheet" href="_js/jquery/jquery-ui.min.css" />
			<link rel="stylesheet"  href="_js/jquery/icon-pack-custom.css" />
			<script type="text/javascript" src="_js/jquery/jquery-1.11.3.min.js"></script>
			<script type="text/javascript" src="_js/jquery/jquery-mobile-1.4.5.min.js"></script>
			<script type="text/javascript" src="_js/jquery/jquery-ui.min.js"></script>
			<script type="text/javascript">
				<?php echo $getLoading;?>
			    $(document).ready(function(){
			        $("#btnEntrar").click(function(){
			        	getLoading('Autenticando...');
			            var envio = $.post("_logar.php", {login:$("#login").val(),senha:$("#senha").val()})
			            envio.done(function(data) {
			                $("#resultado").html(data);
			                $.mobile.loading("hide");
			            })
			            envio.fail(function() { alert("Erro na requisição");$.mobile.loading("hide"); })
			        });
			    });
			</script>
		</head>
		<body>
			<div data-role="page">
				<div data-role="header" style="overflow:hidden;" data-position="fixed">
					<div data-role="navbar"><center><h3><font color=red id="resultado">MKFÁCIL - LOGIN</font></h3></center></div>
				</div>
					<center> 
					    <table border="0">
						    <tr>
							    <td><span class="Style6">Login:</span></td>
							    <td>
							    	<span class="Style6">
								    	<label>
									    	<input name="login" type="text" id="login" />
								    	</label>
								    </span>
								</td>
							</tr>
							<tr>
								<td><span class="Style6">Senha:</span></td>
								<td>
									<span class="Style6">
									    <label>
										    <input name="senha" type="password" id="senha" />
									    </label>
									</span>
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>
									<span class="Style6">
									    <label>
									    	<input type="button" id="btnEntrar" value="Entrar" class="button" />
										</label>
								    </span>
								</td>
							</tr>
						</table>
					</center>
				</div>
			</body>
		</html>
<?php 
	}else{
?>
		<!DOCTYPE html> 
		<html>
			<head>
				<title>MKFÁCIL - Controle de Mikrotiks</title>
				<meta name="viewport" content="initial-scale=1, maximum-scale=1" />
				<link rel="stylesheet" href="_js/jquery/jquery-mobile-1.4.5.min.css" />
				<link rel="stylesheet" href="_js/jquery/jquery-ui.min.css" />
				<link rel="stylesheet" href="_js/sd.min.css" />
				<link rel="stylesheet"  href="_js/jquery/icon-pack-custom.css" />
				<style type="text/css">
					.ui-simpledialog-screen-modal{
					    opacity: 0.4;
					}
					.ui-simpledialog-container {
					    border: 1px solid rgb(221, 221, 221) !important;
					}
					.ui-grid-a > div {
					    padding: 2px;
					}
				</style>
				<script type="text/javascript" src="_js/jquery/jquery-1.11.3.min.js"></script>
				<script type="text/javascript" src="_js/jquery/jquery-mobile-1.4.5.min.js"></script>
				<script type="text/javascript" src="_js/jquery/jquery-ui.min.js"></script>
				<script type="text/javascript" src="_js/mask.js"></script>
				<script type="text/javascript" src="_js/sd.min.js"></script>
				<script type="text/javascript">
					var ipage='';
				 	var itipo=''; 
				 	var iobj='';
				 	var iargs=''; 
				 	var iordem='';
					var scripts=[];
					Array.prototype.duplicates = function (){
					    return this.filter(function(x,y,k){
					        return y !== k.lastIndexOf(x) ;
					    }) ;
					}
					jQuery.cachedScript = function( url, options ) {
					 
					  // Allow user to set any option except for dataType, cache, and url
					  options = $.extend( options || {}, {
					    dataType: "script",
					    cache: true,
					    url: url
					  });
					 
					  // Use $.ajax() since it is more flexible than $.getScript
					  // Return the jqXHR object so we can chain callbacks
					  return jQuery.ajax( options );
					};
					//
					<?php echo $getLoading;?>
					//
					function loadPage(page,args){
						var urlargs='';
						if(args){
							iargs=args;
							var argArray=args.split('|');
							for(i=0;i<argArray.length;i++){
								urlargs+='&'+argArray[i];
							}
						}
						getLoading('Carregando página...');
						$('#content').load('_remote.php?cmd=pages&page='+page+''+urlargs+' #page', function( response, status, xhr ) {
							if ( response.indexOf('JSON') > -1 ) {
								var obj = jQuery.parseJSON(response);
								if(!obj.auth)
									location.reload();
								//
							}
						    $(this).trigger('create');
						    $.mobile.loading("hide");
						    var myscripts=$("#myscripts").val().split(",");
						    var runs='';
						    if($("#myruns").length)
						    	runs=$("#myruns").val();
					    	//
						    loadScript(myscripts,runs);
						});
					} 
					
					function loadScript(myscripts,run){
						//alert(myscripts+'-'+page+'-'+run)
						var myscripts2=[];
						//alert(scripts+'-'+myscripts+'-'+myscripts2);
					    scripts=scripts.concat(myscripts).concat(myscripts2);
					    scripts=$.unique(scripts);
						var notscripts=[];
						var inscripts=[];
						//
					    for(i=0;i<scripts.length;i++){
						    if(scripts[i]!=''){
								if ( $("#inscript_"+scripts[i]).length )
							    	inscripts.push(scripts[i]);
						    	else
									notscripts.push(scripts[i]);
								//
						    }			
					    }
					    if(notscripts.length)
					    	downScript(notscripts,run);
					    else
					    	if(run)
								eval(run);
						//
					}
					function downScript(scripts,run){
						if(scripts!=''){
						    getLoading('Baixando scripts...');
						    $.get("_remote.php?cmd=scripts&nome="+scripts).done(function( data ) {
								if ( data.indexOf('JSON') > -1 ) {
									var obj = jQuery.parseJSON(data);
									if(!obj.auth)
										location.reload();
									//
								}else{
									var alldados=data.split("|,|");
									for(i=0;i<alldados.length;i++){
							    		var dados=alldados[i].split(">|");
							    		//alert(dados[1]+'='+$("script [id='inscript_"+dados[1]+"']").length)
							    		if(!$("#inscript_"+dados[1]).length){
									    	$("head").append($("<script />", {
										    	id:'inscript_'+dados[1],
									    		html: dados[0] 
									    	}));
										}
									}
								}
								$.mobile.loading("hide");
								if(run){
									var allRun=run.split(";");
									for(i=0;i<allRun.length;i++){
										eval(allRun[i]);
									}
								}
									//
							});
						}
					}
				</script>
			</head>
			<body>
				<div data-role="page" id="page1">
					<div data-role="header" style="overflow: hidden;">
						<nav data-role="navbar">
			                <ul>
			                	<li><a href="#" onclick="loadPage('home');" data-icon="home" >Home/Contas</a></li>
			                    <li><a href="#" onclick="loadPage('produtos');" data-icon="calendar" >Servicos/Produtos</a></li>
			                    <li><a href="#" onclick="loadPage('caixa');" data-icon="shop" >Vendas/Caixa</a></li>
			                    <li><a href="#" onclick="loadPage('mk');" data-icon="info" >Mk/logs</a></li>
			                    <li><a href="#" onclick="location.href='index.php?logout=true'" data-icon="power" >Logout</a></li>
			                </ul>
						</nav>
						<!-- /navbar -->
					</div>
					<!-- /header -->
					<div role="main" class="ui-content" id="content">
						<center>
							<h2>Página incicial</h2>
						</center>
					</div>
				</div>
			</body>
		</html>
<?php 
	}
?>
