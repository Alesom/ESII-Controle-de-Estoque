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
			header("Location: index.php");
		}else{
			$_SESSION['newerror'] = "Usuário ou senha não conferem";
		}
	}else if(isset($_POST['logout']) || isset($_GET['logout'])){
		unset($_SESSION['name']);
		unset($_SESSION['senha']);
		unset($_SESSION['funcao']);
		unset($_SESSION['first']);
		header("Location: index.php");
	}else if(isset($_POST['newpeople'])){
		if(isset($_POST['newpass1']) && isset($_POST['newpass2'])){
			$pass1 = $_POST['newpass1'];
			$pass2 = $_POST['newpass2'];
			if(isset($_SESSION['first'])){
				$pass1 = md5($pass2);
				$nome  = $_POST['newname'];
				$funcao= $_POST['newfunction'];
				$codl  = $_POST['newplace'];
				$placename = $_POST['newplacen'];
				$sql = "INSERT INTO local VALUES ('$codl','$placename')";
				$cons = mysqli_query($conexao ,$sql);
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
	<!-- Bloco de script para login-->
	<script type="text/javascript">
			function check_login(){
				/*Se estiver logado não há necessidade de pedir login, mas oferecer opção de logout*/
				if(<?php if(isset($_SESSION['name'])) echo '1';else echo '0';?>){
					document.getElementById('lin').style.display='none';
					document.getElementById('fp').style.display='none';
					document.getElementById("cad_user").style.display="none";
				}else if(<?php if(!isset($_SESSION['first']))echo'1';else echo "0";?>){
					document.getElementById('lin').style.display='block';
					document.getElementById('fp').style.display='none';
					document.getElementById("cad_user").style.display="none";
				}else{//no caso de primeiro uso, permitir o admin se cadastrar sem problemas
					document.getElementById('lin').style.display='none';
					document.getElementById('fp').style.display='none';
					document.getElementById("cad_user").style.display="none";
				}
				if(<?php if(isset($_GET['fp']))echo'1'; else echo'0';?>){//esqueceu a senha: desenvolver metodo de recuperação
					document.getElementById('lin').style.display='none';
					document.getElementById('fp').style.display='block';
					document.getElementById("cad_user").style.display="none";
				}if(<?if(isset($_GET['cad_user']))echo'1'; else echo'0';?>){
					document.getElementById('lin').style.display='none';
					document.getElementById('fp').style.display='none';
					document.getElementById("cad_user").style.display="block";
				}
			}
			function cad_user() {
				document.getElementById("cad_user").style.display="block";
			}
	</script>

	</head>
	<body onload="check_login();"> <!-- A função também deverá definir em que #section da página está -->
		<? require_once ("menu-principal.php"); ?>

	<!-- section login BEGIN-->
		<section >

			<div id="lin" align="center" >
				<form action="index.php" method="POST" >
					<input type="text" name="user" <?php if(isset($usuario))echo'value="'.$usuario.'"'; else echo'placeholder="Login"';?> required /><br/>
					<input type="password" name="pass" <?php if(isset($_POST['pass']))echo'value="'.$_POST['pass'].'"'; else echo'placeholder="Senha"';?> required /><br/>
					<input type="submit" name="entrar" Value="Login"/>
				</form>
				<a href='index.php?fp=1'>Esqueci minha senha</a>
			</div>
			<div id='fp' align="center">
				<form action="index.php?fp=1" method="POST">
					<input type="text" name="email" placeholder="Usuário"/><br/>
					<input type="password" name="pass1" placeholder="Nova Senha"><br/>
					<input type="password" name="pass2" placeholder="Confirme Senha"><br/>

					<input type="submit" name="changepass" value="Trocar"><br/>
				</form>
			</div>

			<!-- a div seguinte é somente exibida no caso de o usuário logado ser um administrador -->
			<div align="center" style='<?php if(isset($_SESSION['first']))echo'display:block;';else echo'display:none;'; ?>'>
				<fieldset style="background-color:#009900;">
				<label>Cadastre um novo usuário</label>
				<form action="index.php" method="POST">
					<input type="text" name="newname" placeholder="Usuário"/><br/>
					<input type="password" name="newpass1" placeholder="Nova Senha"><br/>
					<input type="password" name="newpass2" placeholder="Confirme Senha"><br/>
					<input type="text" name="newplace" placeholder="Codigo do Local"><br/>
					<input type="text" name="newplacen" placeholder="Nome do Local"><br/>
					<input type="text" name="newfunction" placeholder="Função"><br/>
					<input type="submit" name="newpeople" value="Registrar"><br/>
				</form>
				</fieldset>
			</div>

			<!-- a div seguinte é somente exibida no caso de o usuário logado ser um administrador -->
			<div align="center" id="cad_user" style="display:none;">
				<label>Cadastre um novo usuário</label>
				<fieldset style="background-color:#009900;"><br/>
				<form action="index.php" method="POST">
					<input type="text" name="newname" placeholder="Usuário"/><br/>
					<input type="password" name="newpass1" placeholder="Nova Senha"><br/>
					<input type="password" name="newpass2" placeholder="Confirme Senha"><br/>
					Código do Local:<br/>
					<select name="codlocal">
					<?$busca= "SELECT * FROM local";
						$resultado = mysqli_query($conexao,$busca);
						while ($dados = mysqli_fetch_assoc($resultado))
							echo '<option value = "'.$dados['codl'].'">'.$dados['codl'].'</option>';
					?>
				</select><br/>
				Função:<br/>
					<select name="newfunction">
						<option value="Supervisor">Supervisor</option>
						<option value="Conferente">Conferente</option>
						<option value="Estagiário">Estagiário</option>
						<option value="Administrador">Administrador</option>
					</select>
					<br/>
					<!--<input type="text" name="newfunction" placeholder="Função"><br/>-->
					<input type="submit" name="newpeople" value="Registrar"><br/>
				</form>
				</fieldset>
			</div>

		</section>
		<div><fieldset>
			<?php
	//percorrer todos os produtos e verificar se hÃ¡ algum com qtd menor ou igual a qtdmin.
			if(isset($_SESSION['name'])){
				$sql = "SELECT * FROM produto WHERE qtd<=qtdmin AND alarm=1";
				$res = mysqli_query($conexao,$sql);
				echo'<h1> Alarmes:</h1>';
				$count=0;
				if($res)
				while ($resu = mysqli_fetch_assoc($res)){
					$count++;
					echo "<p>O produto <b>".$resu['nome']."</b> conta com <b>".$resu['qtd'].'</b> unidades, a quantidade mínima é de <b>'.$resu['qtdmin']."</b> unidades<br /></p>";
				}
				if($count!=0) $_SESSION['falta']=$count;
				else
					unset($_SESSION['falta']);
			}
			?>
		</fieldset>
		</div>
		<?php
			if(isset($_SESSION['newerror'])) {
				echo $_SESSION['newerror'];
				unset($_SESSION['newerror']);
			}
		?>
	</body>
</html>
