<?php 
	require_once("validar.php");
?>
<!DOCTYPE html> 
<html>
	<head>
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <title>CONTROLE FACIL</title>
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.4/jquery.mobile-1.4.4.min.css" />
		<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.4.4/jquery.mobile-1.4.4.min.js"></script>
    </head>
     
    <body>
        <div data-role="page" id="home" style="background-color:#ADD8E6">
    		<div data-role="header" style="overflow:hidden;" data-position="fixed">
				<?php 
				$error = $error ? $error : false;
				if($authSession && !$error){
				?>
				<h1>GERA USUARIO AUTOMATICO</h1>
				<?php 
				}else{
					echo "<h2><font color=red>$error</font></h2>";
				}
				?>
			</div><!-- /header -->
		<?php 
		if(!$authSession){
			echo $form_login;
		}else{
			$salvar = isset($_REQUEST["salvar"]) ? $_REQUEST["salvar"] : false;
			if($salvar){

			}else{
				$gerar = isset($_REQUEST["gerar"]) ? $_REQUEST["gerar"] : false;
				if($gerar){
					$quser=1;
					$cod_provedor_usuario="66665770";
					while($quser!=0){
						$user=gerarUser('user');		//verifica se codigo trasacao ja existe
						$quser = mysql_num_rows(mysql_query("SELECT id_secretpp FROM mk_secretpp WHERE name_secretpp='".$user."' AND codigo_provedor='$cod_provedor_usuario'"));
					}
			?>
				<center>
					<form id="form1" name="form1" method="post" action="add_user_pppoe.php">
						<table border="0">
						<tr>
						<td><span class="Style6">USER:</span></td>
						<td><span class="Style6">
						<label>
						<?php echo $user;?><input name="id_user" value="<?php echo $id_user;?>" type="hidden" id="id_user" />
						</label>
						</span></td>
						</tr>
						<tr>
						<td>&nbsp;</td>
						<td><span class="Style6">
						<label>
						<input name="salvar" value=true type="hidden" id="salvar" />
						<input type="submit" name="Submit" value="SALVAR USER" />
						</label>
						</span></td>
						</tr>
						</table>
					</form>
				</center>
			<?php 
			}else{
			?>
				<center>
					<form id="form1" name="form1" method="post" action="add_user_pppoe.php">
						<table border="0">
						<tr>
						<td><span class="Style6">USER:</span></td>
						<td><span class="Style6">
						<label>
						GERA USUARIO AUTOMATICO
						</label>
						</span></td>
						</tr>
						<tr>
						<td>&nbsp;</td>
						<td><span class="Style6">
						<label>
						<input name="gerar" value=true type="hidden" id="gerar" />
						<input type="submit" name="Submit" value="GERAR USER" />
						</label>
						</span></td>
						</tr>
						</table>
					</form>
				</center>
				<?php
				}
			}
		}
?>
		</div>
	</body>
</html>