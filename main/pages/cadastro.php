<?php
include("../_conf.php");
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>MK FÁCIL - CADASTRO</title>  

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <div id="wrapper">
        <!-- Navigation -->
        <?php 
        if(isset($_SESSION['id_userfc']) && $_SESSION['id_userfc']>0){
        ?>
        <nav class="navbar navbar-default">
          <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="#"><b>Novo Cadastro <?php echo '(<font class="small" color="blue"><b>'.$_SESSION['grupo_userfc'].' => '.$_SESSION['login_userfc'].'</b></font>)';?></b></a>
            </div>
        
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">MENU<i class="fa fa-navicon fa-fw"></i><span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="#"><i class="fa fa-home fa-fw"></i>Página Inicial</a></li>
                  	<li><a href="#"><i class="fa fa-users fa-fw"></i>Listar Clientes</a></li>
                  	<li><a href="caixa.php"><i class="fa fa-money fa-fw"></i>Caixa</a></li>
                    <li><a href="recebimentos.php"><i class="fa fa-dollar fa-fw"></i>Recebimentos</a></li>
                    <li><a href="inadimplentes.php"><i class="fa fa-tags fa-fw"></i>Dívidas</a></li>
                    <li><a href="#"><i class="fa fa-cogs fa-fw"></i>Configurações</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="../logar.php?logout=true&page=caixa.php"><i class="fa fa-close fa-fw"></i>Logout</a></li>
                  </ul>
                </li> 
              </ul>
            </div><!-- /.navbar-collapse -->
          </div><!-- /.container-fluid -->
        </nav>
        <?php 
        }
        ?>
	    <div id="page-wrapper">
        	<div class="panel-body">
					<?php 
					if(isset($_SESSION['id_userfc']) && $_SESSION['id_userfc']>0){
					?>
						<div class="row">
                        	<div class="col-lg-12">
                        		<div id="cadastro_cliente" class="panel panel-default">
                         			<div class="panel-heading">
                             			Cadastrar dados
                                 	</div>
                            		<div class="panel-body">
                           				<div class="row">
                                 			<div class="col-lg-6">
                                 				<div class="form-group">
                                 					<label>Dados Pessoais:</label>
                        							<?php 
                        							if($_SESSION['grupo_userfc']=='admin'){
                        								if(isset($_SESSION['grupos'])){
                        									?>
                        									<div class="form-group input-group">
                        										<span class="input-group-addon">Grupo parceria:</span>
                        										<select class="form-control" name="grupo_parceria" id="grupo_parceria">
                        										<option value="">Seleciona Grupo parceria</option>
                        									<?php 
                        									foreach ($_SESSION['grupos'] as $grupo) {
                        										?>
                        		 								<option value="<?php echo $grupo;?>"><?php echo $grupo;?></option>
                                                		<?php }?>
                        										</select>
                        	                   				</div>								
                        							<?php 
                        							}}?>
                                                	<div class="form-group input-group">
                        								<span class="input-group-addon">Cadastro:</span>
                        								<select class="form-control" name="pessoa_juridica_clientesfc" id="pessoa_juridica_clientesfc">
                        									<option value="">Pessoa Física</option>
                        									<option value="on">Empresa</option>
                        								</select>
                                           			</div>
                        							<div class="form-group input-group">
                        								<span class="input-group-addon">Nome:</span>
                        								<input class="form-control" onkeyup="$(this).val($(this).val().toUpperCase());" name="nome_clientesfc" id="nome_clientesfc" type="text">
                        							</div>
                        							<div class="form-group input-group" id="div_rs" style="display: none;">
                        								<span class="input-group-addon">Razão Social:</span>
                        								<input class="form-control" onkeyup="$(this).val($(this).val().toUpperCase());" name="razao_social_clientesfc" id="razao_social_clientesfc" type="text">
                        							</div>
                        							<div class="form-group input-group">
                        								<span class="input-group-addon" id="imp_rg-ie">Rg</span>
                        								<input class="form-control" name="rg_ie_clientesfc" id="rg_ie_clientesfc" type="text">
                        							</div>
                        							<div class="form-group input-group">
                        								<span class="input-group-addon" id="imp_cpf-cnpj">Cpf</span>
                        								<input class="form-control" name="cpf_cnpj_clientesfc" id="cpf_cnpj_clientesfc" type="text">
                        							</div>
                        							<div class="form-group input-group" id="div_resposavel" style="display: none;">
                        								<span class="input-group-addon">Responsável</span>
                        								<input class="form-control" onkeyup="$(this).val($(this).val().toUpperCase());" name="responsavel_clientesfc" id="responsavel_clientesfc" type="text">
                        							</div>
                        							<div class="form-group input-group" id="div_nascimento">
                        								<span class="input-group-addon">Data Nasc</span>
                        								<input class="form-control mask-data" name="data_nascimento_clientesfc" id="data_nascimento_clientesfc" type="text" data-provide="datepicker" data-date-autoclose="true" data-date-clear-btn="true" data-date-format="dd/mm/yyyy" data-date-language="pt-BR" data-date-today-highlight="true" data-date-orientation="top">
                        							</div>
                        							<div class="form-group input-group">
                        								<span class="input-group-addon">E-mail</span>
                        								<input class="form-control" onkeyup="$(this).val($(this).val().toLowerCase());" name="email_clientesfc" id="email_clientesfc"  type="text">
                        							</div>
                        							<label>Telefones:</label>
                        							<div class="form-group input-group">
                        								<span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                                                    	<input class="form-control mask-phone" name="tel1_clientesfc" id="tel1_clientesfc" class="phone_with_ddd" type="text">
                                                        <span class="input-group-addon"><i class="fa fa-info"></i></span>
                                                        <input class="form-control" name="nome1_clientesfc" id="nome1_clientesfc" type="text">
                                                    </div>
                        							<div class="form-group input-group">
                        								<span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                                                    	<input class="form-control mask-phone" name="tel2_clientesfc" id="tel2_clientesfc" class="phone_with_ddd" type="text">
                                                        <span class="input-group-addon"><i class="fa fa-info"></i></span>
                                                        <input class="form-control" name="nome2_clientesfc" id="nome1_clientesfc" type="text">
                                                    </div>
                        							<div class="form-group input-group">
                        								<span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                                                    	<input class="form-control mask-phone" name="tel3_clientesfc" id="tel3_clientesfc" class="phone_with_ddd" type="text">
                                                        <span class="input-group-addon"><i class="fa fa-info"></i></span>
                                                        <input class="form-control" name="nome3_clientesfc" id="nome3_clientesfc" type="text">
                                                    </div>
                        							<div class="form-group input-group">
                        								<span class="input-group-addon">Obs</span>
                        								<textarea class="form-control" cols="30" rows="2" name="obs_clientesfc" id="obs_clientesfc"></textarea>
                        							</div>
                        						</div>
                                          	</div>
                                            <!-- /.col-lg-6 (nested) -->
                                            <div class="col-lg-6">
                                            	<div class="form-group">
                                            		<label>Endereço:</label>
                        							<div class="form-group input-group">
                        								<span class="input-group-addon">Cep</span>
                        								<input class="form-control mask-cep" name="cep1_clientesfc" id="cep1_clientesfc" type="text">
                        								<span class="input-group-btn">
                        	                            	<button onclick="getEnd($('#cep1_clientesfc').val(),{logradouro:'end1_clientesfc',numero:'num1_clientesfc',bairro:'bar1_clientesfc',cidade:'cid1_clientesfc',uf:'uf1_clientesfc'});" class="btn btn-default" type="button"><i class="fa fa-refresh"></i>
                        	                                </button>
                        	                            </span>
                                                    	<span class="input-group-btn">
                        	                            	<button onclick="getCep({cep:'cep1_clientesfc',logradouro:'end1_clientesfc',numero:'num1_clientesfc',bairro:'bar1_clientesfc',cidade:'cid1_clientesfc',uf:'uf1_clientesfc'});" class="btn btn-default" type="button"><i class="fa fa-search"></i>
                        	                                </button>
                        	                            </span>
                                                    </div>
                        							<div class="form-group input-group">
                        								<span class="input-group-addon">End</span>
                                                    	<input class="form-control" onkeyup="$(this).val($(this).val().toUpperCase());" name="end1_clientesfc" id="end1_clientesfc" type="text">
                                                    </div>
                                                    <div class="form-group input-group">    
                                                        <span class="input-group-addon">Número</span>
                                                        <input class="form-control" name="num1_clientesfc" id="num1_clientesfc" type="text">
                                                    </div>
                                                    <div class="form-group input-group">    
                                                        <span class="input-group-addon">Complemento</span>
                                                        <input class="form-control" name="comp1_clientesfc" id="comp1_clientesfc" type="text">
                                                    </div>
                                                    <div class="form-group input-group">    
                                                        <span class="input-group-addon">Bairro</span>
                                                        <input class="form-control" onkeyup="$(this).val($(this).val().toUpperCase());" name="bar1_clientesfc" id="bar1_clientesfc" type="text">
                                                    </div>
                                                    <div class="form-group input-group">    
                                                        <span class="input-group-addon">Estado</span>
                                                        <select class="form-control" onchange="getCidades(this.value,'cid1_clientesfc');" name="uf1_clientesfc" id="uf1_clientesfc">
                        								</select>
                                                    </div>
                                                    <div class="form-group input-group">    
                                                        <span class="input-group-addon">Cidade</span>
                                                        <select class="form-control" name="cid1_clientesfc" id="cid1_clientesfc">
                        									<option value="">Selecione o estado antes</option>
                        								</select>
                                                    </div>
                        							<div class="form-group input-group">
                        								<span class="input-group-addon">Lat</span>
                        								<input class="form-control" name="lat1_clientesfc" id="lat1_clientesfc" type="text">
                        								<span class="input-group-addon">Lon</span>
                        								<input class="form-control" name="long1_clientesfc" id="long1_clientesfc" type="text">
                        								<span class="input-group-btn">
                        	                            	<button onclick="getMap();" class="btn btn-default" type="button"><i class="fa fa-search"></i>
                        	                                </button>
                        	                            </span>
                        							</div>
                        							<div class="form-group input-group">
                        								<span class="input-group-addon">Vencimento:</span>
                        								<select class="form-control" name="venc_clientesfc" id="venc_clientesfc">
                        									<option value="">Dia</option>
                        									<option value="5">05</option>
                        									<option value="6">06</option>
                        									<option value="7">07</option>
                        									<option value="8">08</option>
                        									<option value="9">09</option>
                        									<option value="10">10</option>
                        									<option value="11">11</option>
                        									<option value="12">12</option>
                        									<option value="13">13</option>
                        									<option value="14">14</option>
                        									<option value="15">15</option>
                        									<option value="16">16</option>
                        									<option value="17">17</option>
                        									<option value="18">18</option>
                        									<option value="19">19</option>
                        									<option value="20">20</option>
                        									<option value="21">21</option>
                        									<option value="22">22</option>
                        									<option value="23">23</option>
                        									<option value="24">24</option>
                        									<option value="25">25</option>
                        									<option value="26">26</option>
                        									<option value="27">27</option>
                        									<option value="28">28</option>
                        								</select>
                        							</div>
                        							<div class="form-group input-group">
                                                    	<span class="input-group-addon">Gerar Boletos Mensais</span>
                                                    	<select class="form-control" name="bol_clientesfc" id="bol_clientesfc">
                        									<option value="">Não</option>
                        									<option value="on">Sim</option>
                        								</select>
                                                	</div>
                                                	<div class="form-group input-group">
                                                    	<span class="input-group-addon">Enviar Sms</span>
                                                    	<select class="form-control" name="sendsms_clientesfc" id="sendsms_clientesfc">
                        									<option value="">Não</option>
                        									<option value="on">Sim</option>
                        								</select>
                                                	</div>
                                                	<div class="form-group input-group">
                                                    	<span class="input-group-addon">Enviar Emails</span>
                                                    	<select class="form-control" name="sendemail_clientesfc" id="sendemail_clientesfc">
                        									<option value="">Não</option>
                        									<option value="on">Sim</option>
                        								</select>
                                                	</div>
                        							<div class="form-group input-group">
                                                    	<span class="input-group-addon">Desativar Encargos</span>
                                                    	<select class="form-control" name="desativar_juros_clientesfc" id="desativar_juros_clientesfc">
                        									<option value="">Não</option>
                        									<option value="on">Sim</option>
                        								</select>
                                                	</div>
                        							<div class="form-group input-group">
                                                    	<span class="input-group-addon">Desativar Bloqueio</span>
                                                    	<select class="form-control" name="destivar_bloqueio_clientesfc" id="destivar_bloqueio_clientesfc">
                        									<option value="">Não</option>
                        									<option value="on">Sim</option>
                        								</select>
                                                	</div>
                                                </div>
                        						<input data-fix=true name="cmd" value="save" type="hidden">
                        						<input data-fix=true name="cache" value="false" type="hidden">
                        						<input data-fix=true id="tipo" name="tipo" value="cliente" type="hidden">
                        						<input name="sit_clientesfc" id="sit_clientesfc" value="inativo" type="hidden">
                        						<input name="id_clientesfc" id="id_clientesfc" type="hidden">
                        						<center>
                        						<button onclick="salvaDados('cadastro_cliente','dados_ajax');" type="submit" class="btn btn-outline btn-primary">Salvar</button>
                        						<a href="#" class="btn btn-outline btn-primary">Limpar</a>	
                        						</center>				
                        					</div>
                                            <!-- /.col-lg-6 (nested) -->
                                       </div>
                                    <!-- /.row (nested) -->
                                	</div>
                                <!-- /.panel-body -->
                            	</div>
                            	<div id="cadastro_mensal" class="panel panel-default" style="display: none;">
                         			<div class="panel-heading">
                             			Cadastrar serviço mensal
                                 	</div>
                            		<div class="panel-body">
                           				<div class="row">
                                 			<div class="col-lg-6">
                                 				<div class="form-group">
                        	         				<div class="form-group input-group">
                        								<span class="input-group-addon">Cliente</span>
                        	                            <p class="form-control form-control-static"><font id="nome_cliente_text"></font><input name="nome_cliente" id="nome_cliente" type="hidden"></p>
                        	                       	</div>
                        	                        <div class="form-group input-group">
                        								<span class="input-group-addon">Serviço</span>
                        								<select class="form-control" onchange="getServMensal(this.value);" name="sel_servicos" id="sel_servicos">
                        								</select>
                        	                   		</div>
                                           			<label>Dados do Serviço Mensal:</label>
                        							<div class="form-group input-group">
                        								<span class="input-group-addon">Acesso Grátis</span>
                        								<select class="form-control" name="gratis_sevmensalfc" id="gratis_sevmensalfc">
                        									<option value="">Não</option>
                        									<option value="on">Sim</option>
                        								</select>
                        							</div>
                        							<div class="form-group input-group">
                        								<span class="input-group-addon">Data Inicio</span>
                        								<input class="form-control mask-data" name="data_ativado_mensalfc" id="data_ativado_mensalfc" type="text">
                        							</div>
                        							<div class="form-group input-group">
                        								<span class="input-group-addon">Valor Mensal R$</span>
                        								<input class="form-control mask-valor" name="valor_sevmensalfc" id="valor_sevmensalfc" type="text">
                        							</div>
                        							<div class="form-group input-group">
                        								<span class="input-group-addon">Valor Desconto R$</span>
                        								<input class="form-control mask-valor" name="valor_desconto_mensalfc" id="valor_desconto_mensalfc" type="text">
                        							</div>
                        							<div class="form-group input-group">
                        								<span class="input-group-addon">Valor Acréscimo R$</span>
                        								<input class="form-control mask-valor" name="valor_acrescimo_mensalfc" id="valor_acrescimo_mensalfc" type="text">
                        							</div>
                        							<div class="form-group input-group">
                        								<span class="input-group-addon">Descrição</span>
                        								<input class="form-control" onkeyup="$(this).val($(this).val().toUpperCase());" name="descricao_mensalfc" id="descricao_mensalfc" type="text">
                        							</div>
                        							<div class="form-group input-group">
                        								<span class="input-group-addon">Situação</span>
                        								<select class="form-control" name="sit_mensalfc" id="sit_mensalfc">
                        									<option value="ativo">Ativo</option>
                        									<option value="desativado">Desativado</option>
                        								</select>
                        							</div>
                        							<div class="form-group input-group">
                        								<span class="input-group-addon">Ponto de Acesso</span>
                        								<select class="form-control" onchange="alteraDadosPonto(this.value);" name="ponto_sevmensalfc" id="ponto_sevmensalfc">
                        									<option value="on">Sim</option>
                        									<option value="">Não</option>
                        								</select>
                        							</div>
                        						</div>
                                          	</div>
                                            <!-- /.col-lg-6 (nested) -->
                                            <div class="col-lg-6">
                                            	<div class="form-group" id="dados_ponto-acesso">
                                            		<label>Dados do Ponto de Acesso:</label>
                        							<div class="form-group input-group">
                        								<span class="input-group-addon">Tipo de Conexão</span>
                        								<select class="form-control" name="tipo_auth_sevmensalfc" id="tipo_auth_sevmensalfc">
                        									<option value="pppoe" selected>PPPOE</option>
                        									<option value="bindings">IPBINDINGS</option>
                        								</select>
                        							</div>
                        							<p class="help-block" id="secret_atual" style="display: none">Secret Atual: <b><font name="nome_secret"></font></b></p>
                        							<div class="form-group input-group">
                        								<span class="input-group-addon">User mk</span>
                        								<input class="form-control" id="name_secret_add" type="text" name="chained">
                        							</div>	
                        							<div class="form-group input-group">
                        								<span class="input-group-addon">Mesmo endereço</span>
                        								<select class="form-control" onchange="getEndServMensal(this.value);" name="end_cob_sevmensalfc" id="end_cob_sevmensalfc">
                        										<option value="">Não</option>
                        										<option value="on">Sim</option>
                        								</select>
                        							</div>
                        							<div class="form-group input-group">
                        								<span class="input-group-addon">Cep</span>
                        								<input class="form-control mask-cep" name="cep_sevmensalfc" id="cep_sevmensalfc" type="text">
                                                    </div>
                        							<div class="form-group input-group">
                        								<span class="input-group-addon">End</span>
                        								<textarea cols="40" rows="2" onkeyup="$(this).val($(this).val().toUpperCase());" class="form-control" name="end_sevmensalfc" id="end_sevmensalfc"></textarea>
                                                    </div>
                                                    <div class="form-group input-group">
                        								<span class="input-group-addon">Complemento</span>
                        								<input class="form-control" onkeyup="$(this).val($(this).val().toUpperCase());" name="comp_sevmensalfc" id="comp_sevmensalfc" type="text">
                                                    </div>
                                                    <div class="form-group input-group">
                        								<span class="input-group-addon">Lat</span>
                        								<input class="form-control" name="lat_sevmensalfc" id="lat_sevmensalfc" type="text">
                        								<span class="input-group-addon">Lon</span>
                        								<input class="form-control" name="lon_sevmensalfc" id="lon_sevmensalfc" type="text">
                        								<span class="input-group-btn">
                        	                            	<button onclick="getMap();" class="btn btn-default" type="button"><i class="fa fa-search"></i>
                        	                                </button>
                        	                            </span>
                        							</div>
                        							<div class="form-group input-group">
                        								<span class="input-group-addon">Instalação em Comodato</span>
                        								<select class="form-control" name="comodato_sevmensalfc" id="comodato_sevmensalfc">
                        										<option value="">Não</option>
                        										<option value="on">Sim</option>
                        								</select>
                        							</div>
                                                    <div class="form-group input-group">
                        								<span class="input-group-addon">Equipamentos</span>
                        								<textarea cols="40" rows="2" onkeyup="$(this).val($(this).val().toUpperCase());" class="form-control" name="equipamentos_sevmensalfc" id="equipamentos_sevmensalfc"></textarea>
                                                    </div>
                        							<div class="form-group input-group">
                        								<span class="input-group-addon">Cobrar Instalação</span>
                        								<select class="form-control" name="cobranca_instalacao">
                        										<option value="">Não</option>
                        										<option value="on">Sim</option>
                        								</select>
                        							</div>
                                                </div>
                        						<input data-fix=true name="cmd" value="save" type="hidden">
                        						<input data-fix=true name="cache" value="false" type="hidden">
                        						<input data-fix=true id="tipo" name="tipo" value="mensal" type="hidden">
                        						<input name="id_mensalfc" id="id_mensalfc" type="hidden">
                        						<input name="id_cliente_mensalfc" id="id_cliente_mensalfc" value="'.$id_cliente.'" type="hidden">';
                        						<center>
                        						<button onclick="salvaDados('cadastro_mensal','dados_ajax');" type="submit" class="btn btn-outline btn-primary">Salvar</button>
                        						<a href="#" class="btn btn-outline btn-primary">Limpar</a>	
                        						</center>				
                        					</div>
                                            <!-- /.col-lg-6 (nested) -->
                                       	</div>
                                    <!-- /.row (nested) -->
                             		</div>
                                <!-- /.panel-body -->
                               	</div>
                           	<input id="dados_ajax" value="" type="hidden">
                       	<!-- /.panel -->
                    	</div>
                  	<!-- /.col-lg-12 -->
                   	</div>
					<?php
					}else{
							if($_SESSION['process_result'] && isset($_SESSION['process_result'])){
					?>
                        <div class="alert alert-danger">
                           	ERROR:<?php echo $_SESSION['process_result'];?>
                        </div>
                        <?php
							}
						?>
						
                    	<form action="../logar.php" method="post">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Login" name="login" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <input name="page" type="hidden" value="caixa.php">
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="submit" name="login-submit" id="login-submit" class="btn btn-lg btn-success btn-block"  value="Login">
                            </fieldset>
                      	</form>
                    <?php 
					}
                    ?>  	
        	</div>
    	</div>
    </div>
    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
<?php 
   if(isset($_SESSION['id_userfc']) && $_SESSION['id_userfc']>0){
?>
	<script src="../vendor/dialog/bootstrap-dialog.min.js"></script>
  <link rel="stylesheet" href="../vendor/autocomplete/bootcomplete.css">
  <script type="text/javascript" src="../vendor/autocomplete/bootcomplete.js"></script>	<!-- Bootstrap datepicker JS and CSS -->
	<script src="../vendor/datepicker/js/bootstrap-datepicker.js"></script>
	<script src="../vendor/datepicker/js/locales/bootstrap-datepicker.pt-BR.js"></script>
	<link rel="stylesheet" href="../vendor/datepicker/css/datepicker.css"></link>
	<script src="../js/cadastro.js"></script>
	<script src="../js/mask.js"></script>
	<script type="text/javascript">
		var dataHoje='<?php echo date('d/m/Y')?>'; 
		$(function($){
			getUfs('uf1_clientesfc'); //CARREGA SELECT CIDADES
			//
			$("#cpf_cnpj_clientesfc").mask('999.999.999-99');
			$(".mask-data").mask('99/99/9999', {placeholder: '__/__/____'});
			$(".mask-cep").mask('00000-000', {placeholder: '_____-___'});
			$(".mask-phone").mask('(00) 00000-0000', {placeholder: '(__)_____-____'});
			//	
			$("#pessoa_juridica_clientesfc").change(function(){
				var valor=$(this).val();
			   	if (valor=='on'){
			       	$("#div_rs").show();
			   		$("#div_resposavel").show();
			   		$("#div_nascimento").hide();
					$("#imp_rg-ie").html("Ie");
					$("#imp_cpf-cnpj").html("Cnpj");
					$("#cpf_cnpj_clientesfc").val("");
					$("#cpf_cnpj_clientesfc").mask('99.999.999/9999-99');
				}else{
				   	$("#div_rs").hide();
				   	$("#div_resposavel").hide();
					$("#div_nascimento").show();
					$("#imp_rg-ie").html("Rg");
					$("#imp_cpf-cnpj").html("Cpf");
					$("#cpf_cnpj_clientesfc").val("");
					$("#cpf_cnpj_clientesfc").mask('999.999.999-99');
				}
			});
			$('#name_secret_add').bootcomplete({
			    url:'../_ajax.php',
			    minLength : 1,
			    method:'post',
			    idField:true,
			    idFieldName:'id_user_sevmensalfc',
			    dataParams:{
			    	'cmd':'busca',
			    	'tipo':'secrets'
			    },
			    formParams: {
			        'secret' : $('#tipo_auth_sevmensalfc')
			    }
			});
		});
		$('#dados_ajax').on('change', function() { 
			var dados=JSON.parse($(this).val()); 
			//alert(dados.new); 
			if(dados.dados_pessoais){
				$("#cadastro_cliente").hide();
				BootstrapDialog.alert('Cadastro dos dados pessoais efetuado com sucesso!!!');
				$("#cadastro_mensal").show();
				$("#nome_cliente_text").html(dados.nome);
				$("#nome_cliente").val(dados.nome);
				$("#data_ativado_mensalfc").val(dataHoje);
				$("#id_cliente_mensalfc").val(dados.id);
				getServicos('sel_servicos',dados.id); //CARREGA SELECT SERVICOS
			}
		});
		function getServicos(obj,id){
			$("#"+obj).children().remove();
			$("#"+obj).append($(document.createElement('option')).attr("value","").text("Carregando..."));	
			$.ajax({url: '../_ajax.php',data:'cmd=select&tipo=servicos&id_cliente='+id,dataType: "json"}).then( function (retorno) {
				if(retorno!='')
					$("#"+obj).children().remove();
				//
				$.each(retorno, function(key, value){
					var dados=value.split("|");
					if(retorno.length==2 && dados[0]=='new')
						$("#"+obj).append($(document.createElement('option')).attr("value",dados[0]).text(dados[1]).attr('selected', true));
					else if(retorno.length==3 && dados[0]>0)
						$("#"+obj).append($(document.createElement('option')).attr("value",dados[0]).text(dados[1]).attr('selected', true));
					else if(retorno.length>3 && dados[0]=='sel')
						$("#"+obj).append($(document.createElement('option')).attr("value",dados[0]).text(dados[1]).attr('selected', true));
					else
						$("#"+obj).append($(document.createElement('option')).attr("value",dados[0]).text(dados[1]));
				});	
				$("#"+obj).change();
				$("#"+obj).selectmenu('refresh', true);
			});		
		}
		function getEndServMensal(vl){
			var id=$("[name='id_cliente_mensalfc']").val();
			if(vl=='on' && id>0){
				BootstrapDialog.show({
					title: 'Localizando Endereço do cliente id:'+id+'...',
					id: 'loading_endcliente',
					message: '<div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"><span>Carregando<span class="dotdotdot"></span></span></div></div>'
				});
			    $.ajax({url: '../_ajax.php',data:'cmd=busca&tipo=endcliente&id='+id,dataType: "json"}).then( function (retorno) {
			    	$("#loading_endcliente").modal("hide");
					if(retorno!=''){
						$.each(retorno, function(key, value){
							$("[name='"+key+"']").val(value);
							if($("[name='"+key+"']").attr("type")=='hidden')
								$("[name='"+key+"']").change();
							//
						});
					}
				});
			}else{
				
			}
		}
		function alteraDadosPonto(vl){
			if(vl!='on'){
				$('#dados_ponto-acesso').find('*').prop('disabled',true);
			}else{
				$('#dados_ponto-acesso').find('*').prop('disabled',false);
			}
		}
		function getMask(tipo){
			if(tipo=='data')
				$(".mask-data").mask('99/99/9999', {placeholder: '__/__/____'});
			if(tipo=='valor')
				$(".mask-valor").mask('####0,00', {placeholder: '0,00',reverse: true});
		}
		
	</script>
	<style type="text/css">
    	.panel-body {
        	margin: 10px;
          	padding: 10px;
          	background-color: white;
        }
		.loading {    
		    background-color: #ffffff;
		    background-image: url("http://loadinggif.com/images/image-selection/3.gif");
		    background-size: 25px 25px;
		    background-position:right center;
		    background-repeat: no-repeat;
	 	}
	 	.clearable{
		  background: #fff url(http://bijudesigner.com/blog/wp-content/uploads/2015/06/download.gif) no-repeat right -10px center;
		  padding: 3px 18px 3px 4px; /* Use the same right padding (18) in jQ! */
		  transition: background 0.4s;
		}
		.clearable.x  { background-position: right 5px center; }
		.clearable.onX{ cursor: pointer; }
		td.details-control {
            background: url('http://www.datatables.net/examples/resources/details_open.png') no-repeat center center;
            cursor: pointer;
        }
        tr.shown td.details-control {
            background: url('http://www.datatables.net/examples/resources/details_close.png') no-repeat center center;
        }
        .datepicker table tr td{
           width:auto !important;
           height: auto !important;
           font-size: 11px !important;
        }
        .datepicker table tr td{
           width:auto !important;
           height: auto !important;
           font-size: 11px !important;
        }
	</style>
<?php 
   }
?> 
</body>
</html>
