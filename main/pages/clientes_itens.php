<?php 
include_once("../_conf.php");
if(!isset($_SESSION['id_userfc'])){
	header("Location: login.php?page=$page");
}
$id_cliente= isset($_REQUEST["id_cliente"]) ? $_REQUEST["id_cliente"] : false;
$nome= isset($_REQUEST["nome"]) ? $_REQUEST["nome"] : false;
//
//CARREGA SELECT SERVICOS
$scripts='
    <script>
		var dataHoje=\''.date('d/m/Y').'\';
	</script>
	<!-- DataTables CSS -->
	<link rel="stylesheet" href="../vendor/autocomplete/bootcomplete.css">
	<!-- DataTables JavaScript -->
	<script type="text/javascript" src="../vendor/autocomplete/bootcomplete.js"></script>
    <script src="../js/mask.js"></script>
	<script src="../js/cadastro.js"></script>
	<script src="../js/clientes_itens.js"></script>
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
		<div id="cadastro_itens" class="panel panel-default">
 			<div class="panel-heading">
     			<font id="title_mensal">Cadastrar</font> crédito/débito <font id="id_itens"></font>
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
	                            <p class="form-control form-control-static"><?php echo $nome;?></p>
	                       	</div>
	                       	<?php }?>
                  			<label>Dados do Débito:</label>
                   			<div class="form-group input-group">
								<span class="input-group-addon">Tipo</span>
								<select class="form-control" name="tipo_itensfc" id="tipo_itensfc">
									<option value="+">Débito</option>
									<option value="-">Crédito</option>
								</select>
	                   		</div>
							<div class="form-group input-group">
								<span class="input-group-addon">Nome</span>
								<input class="form-control" onkeyup="$(this).val($(this).val().toUpperCase());" name="nome_itensfc" id="nome_itensfc" type="text">
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon">Data (Origem)</span>
								<input class="form-control mask-data" name="data_origem_itensfc" value="<?php echo date('d/m/Y');?>" type="text">
							</div>
	                   		<div class="form-group input-group">
								<span class="input-group-addon">Parcelar</span>
								<select class="form-control" id="parcelar_item">
									<option value="0">Não</option>
									<option value="1">1 parcela</option>
									<option value="2">2 parcela</option>
									<option value="3">3 parcela</option>
									<option value="4">4 parcela</option>
									<option value="5">5 parcela</option>
									<option value="6">6 parcela</option>
								</select>
	                   		</div>
						</div>
                  	</div>
                    <!-- /.col-lg-6 (nested) -->
                    <div class="col-lg-6">
                    	<div class="form-group" id="dados_itens">
                        </div>
						<input data-fix=true name="cmd" value="save" type="hidden">
						<input data-fix=true name="cache" value="false" type="hidden">
						<input data-fix=true id="tipo" name="tipo" value="itens" type="hidden">
						<?php 
						if($id_cliente){
							echo '<input name="id_cliente_itensfc" value="'.$id_cliente.'" type="hidden">';
						}
						?>
						<center>
						<button id="bt_salvar" onclick="salvaDados('cadastro_itens','dados_ajax');" disabled="true" type="submit" class="btn btn-outline btn-primary">Salvar</button>
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