<?php
	require("connect.php");

	if(isset($_POST['entrar'])){
		$usuario = $_POST["user"];
		/*não há necessidade usar criptografia md5 para senha:
			pois a senha será criada pelo administrador e mantida por ele
			-é possível criar formulário para redefinição de senha [via confirmação via e-mail], podendo ai utilizar md5 na criptografia.      (codigo de envio de e-mail disponivel na web)
		$senha = md5($_POST["pass"]);   //*/
		$senha = $_POST["pass"];

		$sql = "SELECT * FROM usuario WHERE nome = '$usuario' AND senha ='$senha'";
		$result = mysqli_query($conexao,$sql);
		$rowcount=mysqli_num_rows($result);
		if($rowcount == 1){	
			$_SESSION['name'] = $usuario;
			$_SESSION['password'] = $senha;
			header("Location: index.php");//definir para onde direcionar após login.
		}else{
			$_SESSION['Error'] = 1;
		}
	}else if(isset($_POST['logout'])){
		unset($_SESSION['name']);
		unset($_SESSION['senha']);
		header("Location: login.php");
	}else if(isset($_GET['fp'])){
		if(isset($_POST['changepass'])){
			$email = $_POST['email'];
			$pass1 = $_POST['pass1'];
			$pass2 = $_POST['pass2'];
			if($pass1 == $pass2){
				$sql = "UPDATE usuario SET senha = '$pass1' WHERE nome = '$email'";
				$result = mysqli_query($conexao,$sql);
				if($result == TRUE){
					$_SESSION['changed'] = 1;
				}		
			}else{
				$_SESSION['changeerr'] = 1;
			}
		}

	}
?>

<html>	
	<head>
	<style type="text/css" src="css/style.css"></style>
	<script type="text/javascript">
		function check_login(){
			/*Se estiver logado não há necessidade de pedir login, mas oferecer opção de logout*/
			if(<?php if(isset($_SESSION['name'])) echo '1';else echo '0';?>){
				document.getElementById('lin').style.display='none';
				document.getElementById('lout').style.display='block';
				document.getElementById('fp').style.display='none';
			}else{
				document.getElementById('lin').style.display='block';
				document.getElementById('lout').style.display='none';			
				document.getElementById('fp').style.display='none';
			}
			if(<?php if(isset($_GET['fp']))echo'1'; else echo'0';?>){
				document.getElementById('lin').style.display='none';
				document.getElementById('lout').style.display='none';			
				document.getElementById('fp').style.display='block';
			}
		}
	</script>
	<title>Login</title>	
	</head>

	<body onload="check_login();">	
		<div id="lin" align="center" >			
			<form action="login.php" method="POST" >
				<input type="text" name="user" <?php if(isset($usuario))echo'value="'.$usuario.'"'; else echo'placeholder="Login"';?> required /><br/>
				<input type="password" name="pass" <?php if(isset($senha))echo'value="'.$senha.'"'; else echo'placeholder="Senha"';?> required /><br/>
				<input type="submit" name="entrar" Value="Login"/>
				<?php if(isset($_SESSION['Error']))echo '<p> Usuário ou senha Incorretos</p>'; unset($_SESSION['Error']);?>
			</form>
			<a href='login.php?fp=1'>Esqueci minha senha</a>
		</div>
		<div id="lout" align="center" >	
			<form action="login.php" method="POST">
			<input type="submit" name="logout" Value="logout"/>
			</form>
		</div>
		<div id='fp' align="center">
			<form action="login.php?fp=1" method="POST">
				<input type="text" name="email" placeholder="Usuário"/><br/>
				<input type="password" name="pass1" placeholder="Nova Senha"><br/>
				<input type="password" name="pass2" placeholder="Confirme Senha"><br/>

				<input type="submit" name="changepass" value="Trocar"><br/>
				<?php if(isset($_SESSION['changed'])){echo '<p> Senha Alterada</p>'; unset($_SESSION['changed']);}
				else if(isset($_SESSION['changeerr']))echo'As senhas não equivalem'; unset($_SESSION['changederr']);?>
			</form>
		</div>
	</body>
</html>




