<?php
	require ("connect.php");
	$teste_sql= "SELECT * FROM usuario ";
	$teste_result = mysqli_query($conexao,$teste_sql);
	$teste_row_count=mysqli_num_rows($teste_result);

	if($teste_row_count==0){
		$_SESSION['first'] = "begin";
	}

	if(isset($_POST['entrar'])){
		$usuario = $_POST["user"];
		$senha = md5($_POST["pass"]);

		$sql = "SELECT * FROM usuario WHERE nome = '$usuario' AND senha ='$senha'";
		$result = mysqli_query($conexao,$sql);
		$row = mysqli_fetch_array($result);
		if(mysqli_num_rows($result) == 1){

			$_SESSION['name'] = $usuario;
			$_SESSION['password'] = $_POST['pass'];
			$_SESSION['funcao'] = $row['funcao'];
			$_SESSION['local'] = $row['codl'];
			header("Location: index.php");
		}else{
			$_SESSION['newerror'] = "Usuário ou senha não conferem";
		}
	}else if(isset($_POST['logout']) || isset($_GET['logout'])){

		unset($_SESSION['name']);
		unset($_SESSION['senha']);
		unset($_SESSION['funcao']);
		unset($_SESSION['first']);
		unset($_SESSION['falta']);
		header("Location: index.php");

	}else if(isset($_POST['newpeople'])){
		if(isset($_POST['newpass1']) && isset($_POST['newpass2'])){
			$pass1 = $_POST['newpass1'];
			$pass2 = $_POST['newpass2'];
			if(isset($_SESSION['first'])){
				$pass1 = md5($pass2);
				$nome  = $_POST['newname'];
				$funcao= $_POST['newfunction'];
				$placename = $_POST['newplacen'];
				$sql = "INSERT INTO local(nome) VALUES ('$placename')";
				$cons = mysqli_query($conexao ,$sql);
				$sql = "SELECT * FROM local WHERE nome ='$placename'";
				$cons = mysqli_query($conexao ,$sql);
				$codl = mysqli_fetch_assoc($cons);
				$codl = $codl['codl'];
				$sql = "INSERT INTO usuario (nome,funcao,senha,codl) VALUES ('$nome','$funcao','$pass1','$codl')";
				$cons = mysqli_query($conexao ,$sql);
				if(!$cons){
					$_SESSION['newerror']="Não foi possivel cadastrar usuário. Erro: ".mysqli_error($conexao);
				}else{
					unset($_SESSION['first']);
					$_SESSION['newerror']="Usuário Cadastrado.";
					header("Location:index.php");
				}
			}else if($pass1==$pass2){
				if(isset($_SESSION['name'])){
					$quem = $_SESSION['name'];
					$qpass = md5($_SESSION['password']);
					$sql = "SELECT * FROM usuario WHERE nome = '$quem' AND senha ='$qpass'";
					$result = mysqli_query($conexao,$sql,MYSQLI_USE_RESULT);
					$row = $result->fetch_assoc();
					if($row['funcao']=='Administrador'){
						$pass1 = md5($pass2);
						$nome  = $_POST['newname'];
						$funcao= $_POST['newfunction'];
						$codl  = $_POST['codlocal'];
						mysqli_free_result($result);
						mysqli_next_result($conexao);
						$sql = "INSERT INTO usuario (nome,funcao,senha,codl) VALUES ('$nome','$funcao','$pass1','$codl')";
						$cons = mysqli_query($conexao ,$sql);
						if(!$cons)
							$_SESSION['newerror']="Não foi possivel cadastrar usuário. Erro: ".mysqli_error($conexao);
						else
							$_SESSION['newerror']="Usuário Cadastrado.";
					}else
						$_SESSION['newerror']="you have no power here";
				}
			}else
				$_SESSION['newerror']="As senhas não conferem.";
		}else $_SESSION['newrror']="As senhas não conferem";
	}else if(isset($_GET['fp'])){
		if(isset($_POST['changepass'])){
			$email = $_POST['email'];
			$pass1 = $_POST['pass1'];
			$pass2 = $_POST['pass2'];
			if($pass1 == $pass2){
				$pass1= md5($pass2);
				$sql = "UPDATE usuario SET senha = '$pass1' WHERE nome = '$email'";
				$result = mysqli_query($conexao,$sql);

				if($result){
					$_SESSION['newerror'] = "Senha Alterada";
				}
			}else{
				$_SESSION['newerror'] = "As senhas não conferem";
			}
		}
	}
?>
<html>
	<head>
		<title>Index</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<!-- Bloco de script para login-->
		<script type="text/javascript">
			function check_login(){
				/*Se estiver logado não há necessidade de pedir login, mas oferecer opção de logout*/
				if(<?php if(isset($_SESSION['name'])) echo '1';else echo '0';?>){
					document.getElementById('lin').style.display='none';
					document.getElementById('fp').style.display='none';
					document.getElementById("cad_user").style.display='none';
					document.getElementById("alarmes").style.display='block';
				}else if(<?php if(!isset($_SESSION['first']))echo'1';else echo "0";?>){
					document.getElementById('lin').style.display='block';
					document.getElementById('fp').style.display='none';
					document.getElementById("cad_user").style.display="none";
					document.getElementById("alarmes").style.display='none';
				}else{//no caso de primeiro uso, permitir o admin se cadastrar sem problemas
					document.getElementById('lin').style.display='none';
					document.getElementById('fp').style.display='none';
					document.getElementById("cad_user").style.display="none";
					document.getElementById("alarmes").style.display='none';
				}
				if(<?php if(isset($_GET['fp']))echo'1'; else echo'0';?>){//esqueceu a senha: desenvolver metodo de recuperação
					document.getElementById('lin').style.display='none';
					document.getElementById('fp').style.display='block';
					document.getElementById("cad_user").style.display="none";
					document.getElementById("alarmes").style.display='none';
				}if(<?if(isset($_GET['cad_user']))echo'1'; else echo'0';?>){
					document.getElementById('lin').style.display='none';
					document.getElementById('fp').style.display='none';
					document.getElementById("cad_user").style.display="block";
					document.getElementById("alarmes").style.display='none';
				}
			}
			function cad_user() {
				document.getElementById("cad_user").style.display="block";
			}
		</script>

	</head>
	<body onload="check_login();"> <!-- A função também deverá definir em que #section da página está -->

		<div class="container">

			<!-- section login BEGIN-->
			<section>

				<?php require_once ("menu-principal.php"); ?>

				<div id="lin" class="col-sm-12" align="center">
					<form action="index.php" method="post" class="form-horizontal">
						<div class="form-group row">
							<div class="col-xs-2 col-xs-offset-5">
								<input type="text" name="user" class="form-control" required="required"
								<?php
									if(isset($usuario))
										echo 'value="' . $usuario . '"';
									else
										echo 'placeholder="Login"'; ?>>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-xs-2 col-xs-offset-5">
								<input type="password" name="pass" class="form-control" required="required"
								<?php
									if(isset($_POST['pass']))
										echo 'value="' . $_POST['pass'] . '"';
									else
										echo 'placeholder="Senha"'; ?>>
							</div>
						</div>
						<input type="submit" name="entrar" value="Login" class="btn btn-primary">
					</form>
					<a href='index.php?fp=1'>Esqueci Minha Senha</a>
				</div>

				<div id="fp" class="col-sm-12" align="center">
					<form action="index.php?fp=1" method="post" class="form-horizontal">
						<div class="form-group row">
							<div class="col-xs-2 col-xs-offset-5">
								<input type="text" name="email" class="form-control" required="required" placeholder="Usuário">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-xs-2 col-xs-offset-5">
								<input type="password" name="pass1" class="form-control" required="required" placeholder="Nova Senha">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-xs-2 col-xs-offset-5">
								<input type="password" name="pass2" class="form-control" required="required" placeholder="Confirme Senha">
							</div>
						</div>
						<input type="submit" name="changepass" value="Salvar" class="btn btn-primary">
					</form>
				</div>

				<!-- a div seguinte é somente exibida no caso de o usuário logado ser um administrador -->
				<div class="col-sm-12" align="center" id="cad_user_f" style='
				<?php
					if(isset($_SESSION['first']))
						echo 'display:block;';
					else echo 'display:none;'; ?>'>
					<h3><b>Cadastrar Novo Usuário</b></h3>
					<form action="index.php" method="post" class="form-horizontal">
						<div class="form-group row">
							<div class="col-xs-2 col-xs-offset-5">
								<input type="text" name="newname" class="form-control" required="required" placeholder="Usuário">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-xs-2 col-xs-offset-5">
								<input type="password" name="newpass1" class="form-control" required="required" placeholder="Nova Senha">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-xs-2 col-xs-offset-5">
								<input type="password" name="newpass2" class="form-control" required="required" placeholder="Confirme Senha">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-xs-2 col-xs-offset-5">
								<input type="text" name="newplacen" class="form-control" required="required" placeholder="Nome do Local">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-xs-2 col-xs-offset-5">
								<input type="text" name="newfunction" class="form-control" required="required" value="Administrador" readonly>
							</div>
						</div>
						<input type="submit" name="newpeople" value="Salvar" class="btn btn-primary">
					</form>
				</div>

				<!-- a div seguinte é somente exibida no caso de o usuário logado ser um administrador -->
				<div class="col-sm-12" align="center" id="cad_user" style="display:none;">
					<h3><b>Cadastrar Novo Usuário</b></h3>
					<form action="index.php" method="post" class="form-horizontal">
						<div class="form-group row">
							<div class="col-xs-2 col-xs-offset-5">
								<input type="text" name="newname" class="form-control" required="required" placeholder="Usuário">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-xs-2 col-xs-offset-5">
								<input type="password" name="newpass1" class="form-control" required="required" placeholder="Nova Senha">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-xs-2 col-xs-offset-5">
								<input type="password" name="newpass2" class="form-control" required="required" placeholder="Confirme Senha">
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-2 col-xs-offset-5">
						    <label for="local">Local:</label>
						    <select class="form-control" id="local" name="codlocal">
									<?php
										$busca = "SELECT * FROM local";
										$resultado = mysqli_query($conexao, $busca);
										while ($dados = mysqli_fetch_assoc($resultado))
											echo '<option value = "' . $dados['nome'] . '">' . $dados['nome'] . '</option>';
									?>
						    </select>
							</div>
					  </div>
						<div class="form-group">
							<div class="col-xs-2 col-xs-offset-5">
						    <label for="func">Função:</label>
						    <select class="form-control" id="func" name="newfunction">
						    	<option value="Administrador">Administrador</option>
								<option value="Servidor">Servidor</option>
								<option value="Estagiário">Estagiário</option>
						    </select>
							</div>
					  </div>
						<input type="submit" name="newpeople" value="Salvar" class="btn btn-primary">
					</form>
				</div>
			</section>

			<div id="alarmes">
				<?php
				//percorrer todos os produtos e verificar se hÃ¡ algum com qtd menor ou igual a qtdmin.
					if(isset($_SESSION['name'])){
						$sql = "SELECT * FROM localizacao JOIN produto ON codp = cod WHERE qtd<=qtdmin AND alarm=1";
						$res = mysqli_query($conexao, $sql);
						$count=0;
						echo '<div align="center"><h1>Alarmes</h1></div>';
						if($res) {
							while ($resu = mysqli_fetch_assoc($res)){
								$count++;
								echo '<span class="label label-danger">Atenção</span>';
								echo '<div class="alert alert-danger">
												O produto <b>' . $resu['nome'] . '</b> conta com <b>' . $resu['qtd'] .
												'</b> unidades, a quantidade mínima é de <b>' . $resu['qtdmin'] . '</b> unidades.
											</div>';
							}
						}
						if($count!=0) $_SESSION['falta'] = $count;
						else unset($_SESSION['falta']);
					}
				?>
			</div>
			<?php
				if(isset($_SESSION['newerror'])) {
					echo $_SESSION['newerror'];
					unset($_SESSION['newerror']);
				}
			?>
		</div>

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="js/bootstrap.min.js"></script>

	</body>
</html>
