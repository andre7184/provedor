<?php 
include_once("../_conf.php");
if(!isset($_SESSION['id_userfc'])){
	header("Location: login.php?page=$page");
}
$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : false;
if($id)
	$load_script="alteraDB('".$id."');";
$scripts='
	<!-- DataTables CSS -->
	<!-- DataTables JavaScript -->
    <script src="../js/mask.js"></script>
	<script src="../js/clientes_edit.js"></script>
	<script src="../js/cadastro.js"></script>
class-none
    <script>
		$(function($){
			'.$load_script.'
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
		<div id="cadastro_cliente" class="panel panel-default">
 			<div class="panel-heading">
     			<font id="title_cliente">Cadastrar</font> dados <font id="id_cliente"></font>
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
								<input class="form-control mask-data" name="data_nascimento_clientesfc" id="data_nascimento_clientesfc" type="text">
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
                    <input id="dados_ajax" value="" type="hidden">
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>