<!DOCTYPE html>
<html>
	<head>
		<title>CV - LOGIN</title>
		<meta name="viewport" content="initial-scale=1, maximum-scale=1" />
		<link rel="stylesheet" href="_js/jquery/jquery-mobile-1.4.5.min.css" />
		<link rel="stylesheet" href="_js/jquery/jquery-ui.min.css" />
		<link rel="stylesheet"  href="_js/jquery/icon-pack-custom.css" />
		<script type="text/javascript" src="_js/jquery/jquery-1.11.3.min.js"></script>
		<script type="text/javascript" src="_js/jquery/jquery-mobile-1.4.5.min.js"></script>
		<script type="text/javascript" src="_js/jquery/jquery-ui.min.js"></script>
	</head>
	<body>
		<div data-role="page" id="login">
			<div data-role="header" style="overflow:hidden;" data-position="fixed">				
				<div data-role="navbar"><center><h2><font color=red><?php echo $_REQUEST["error"];?></font></h2></center></div>
				</div>
				<center>
			    <form id="form1" name="form1" method="post" action="logar.php">
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
								    <td><span class="Style6">
								    <label>
								    <input name="senha" type="password" id="senha" />
								    </label>
								    </span></td>
								    </tr>
								    <tr>
								    <td>&nbsp;</td>
								    <td><span class="Style6">
								    <label>
								    <input type="submit" name="Submit" value="OK" />
								    </label>
						    </span></td>
					    </tr>
				    </table>
			    </form>
			</center>
		</div>
	</body>
</html>