<?php 
include_once("../_conf.php");
if(!isset($_SESSION['id_userfc'])){
	header("Location: login.php?page=$page");
}
$scripts='
	<!-- DataTables CSS -->
	<link rel="stylesheet" href="../vendor/autocomplete/bootcomplete.css">
	<!-- DataTables JavaScript -->
	<script type="text/javascript" src="../vendor/autocomplete/bootcomplete.js"></script>
    <script src="../js/clientes_busca.js"></script>
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
     			<div class="form-group input-group">
					<span class="input-group-addon">Buscar Clientes</span>
					<input class="form-control" id="name_cliente_add" type="text" name="chained">
				</div>
         	</div>
    		<div class="panel-body">
   				<div class="row">
         			<div class="col-lg-6">
         				<div class="form-group">
                   			<label>Dados Pessoais:</label>
	                        <div class="form-group input-group">
								<span class="input-group-addon">Nome</span>
	                            <p class="form-control form-control-static"><font id="nome_clientesfc"></font></p>
	                   		</div>
	                   		<label>Dados Pessoais:</label>
	                        <div class="form-group input-group">
								<span class="input-group-addon">Nome</span>
	                            <p class="form-control form-control-static"><font id="nome_clientesfc"></font></p>
	                   		</div>
						</div>
                  	</div>
                    <!-- /.col-lg-6 (nested) -->
                    <div class="col-lg-6">
                    	<div class="form-group" id="dados_ponto-acesso">
                    		<label>Dados Endereço:</label>
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
						<button onclick="salvaDados('cadastro_mensal');" type="submit" class="btn btn-outline btn-primary">Salvar</button>
						<a href="#" class="btn btn-outline btn-primary">Limpar</a>	
						</center>				
					</div>
                    <!-- /.col-lg-6 (nested) -->
               </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>