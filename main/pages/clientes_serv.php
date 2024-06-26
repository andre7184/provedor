<?php 
include_once("../_conf.php");
if(!isset($_SESSION['id_userfc'])){
	header("Location: login.php?page=$page");
}
$id_cliente= isset($_REQUEST["id_cliente"]) ? $_REQUEST["id_cliente"] : false;
$nome= isset($_REQUEST["nome"]) ? $_REQUEST["nome"] : false;
if($id_cliente)
	$load_script="getServicos('sel_servicos','$id_cliente');"; //CARREGA SELECT SERVICOS
$scripts='
	<!-- DataTables CSS -->
	<link rel="stylesheet" href="../vendor/autocomplete/bootcomplete.css">
	<!-- DataTables JavaScript -->
	<script type="text/javascript" src="../vendor/autocomplete/bootcomplete.js"></script>
    <script src="../js/mask.js"></script>
	<script src="../js/cadastro.js"></script>
	<script src="../js/clientes_serv.js"></script>
class-none
    <script>
		$(function($){
			//
			'.$load_script.'
			//
			$("#id_mensalfc").change(function() {
				if($(this).val()!=\'\' && $(this).val()>0)
					$(\'#secret_atual\').show();
				else
					$(\'#secret_atual\').hide();
			});
			$("[name=\'id_cliente_mensalfc\']").change(function() {
				if($("#id_mensalfc").val()==\'\')
					getServicos(\'sel_servicos\',$(this).val()); //CARREGA SELECT SERVICOS
			});
			$(\'.mask-data\').mask(\'99/99/9999\', {placeholder: \'__/__/____\'});
			$(\'.mask-cep\').mask(\'00000-000\', {placeholder: \'_____-___\'});
			$(\'.mask-valor\').mask(\'##0,00\', {reverse: true});
			//	
		});
	</script>
';
?>

<div class="row">
                <div class="col-lg-12">
                    <br>
                </div>
                <!-- /.col-lg-12 -->	
</div>
<div class="row">
	<div class="col-lg-12">
		<div id="cadastro_mensal" class="panel panel-default">
 			<div class="panel-heading">
     			<font id="title_mensal">Cadastrar</font> serviço mensal <font id="id_mensal"></font>
         	</div>
    		<div class="panel-body">
   				<div class="row">
         			<div class="col-lg-6">
         				<div class="form-group">
         					<?php if(!$id_cliente){?>
							<div class="form-group input-group">
								<span class="input-group-addon">Cliente</span>
								<input class="form-control" id="name_cliente_add" type="text" name="chained">
							</div>
							<?php }else{?>
	         				<div class="form-group input-group">
								<span class="input-group-addon">Cliente</span>
	                            <p class="form-control form-control-static"><?php echo $nome;?><input name="nome_cliente" value="<?php echo $nome;?>" type="hidden"></p>
	                       	</div>
	                       	<?php }?>
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
								<input class="form-control mask-data" name="data_ativado_mensalfc" id="data_ativado_mensalfc" value="<?php echo date('d/m/Y')?>" type="text">
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
						<?php 
						if($id_cliente){
							echo '<input name="id_cliente_mensalfc" value="'.$id_cliente.'" type="hidden">';
						}
						?>
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