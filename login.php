<!-- Mudar:
	senha para md5 precisa ser maior que varchar(30)
	se codl(local) for NOT NULL, a primeira inserção de usuário o ADMIN que fará os primeiros cadastros inclusive de local, precisa de local.(local precisa ser cadastrado por ADMIN, ADMIN precisa de local para ser registrado)
	
 -->
<?php
	require("connect.php");
	$teste_sql= "SELECT * FROM usuario ";
	$teste_result = mysqli_query($conexao,$teste_sql);
	$teste_row_count=mysqli_num_rows($teste_result);
	if($teste_row_count==0){
		$_SESSION['first'] = "begin";
		$_SESSION['boss'] = "begin";
		echo"FIRST!!!";
	}
	if(isset($_POST['entrar'])){
		$usuario = $_POST["user"];
		$senha = md5($_POST["pass"]);   

		$sql = "SELECT * FROM usuario WHERE nome = '$usuario' AND senha ='$senha'";		
		$result = mysqli_query($conexao,$sql);
		if($result->num_rows == 1){	
			$_SESSION['name'] = $usuario;
			$_SESSION['password'] = $_POST['pass'];
			$result = mysqli_query($conexao,$sql,MYSQLI_USE_RESULT);
			$row = $result->fetch_assoc();
			if($row['funcao']=='boss'){
				$_SESSION['boss'] = "chefe_eh_chefe_neh_pai";
			}
			header("Location: login.php");
		}else{
			$_SESSION['Error'] = 1;
		}
	}else if(isset($_POST['logout'])){
		unset($_SESSION['name']);
		unset($_SESSION['senha']);
		unset($_SESSION['boss']);
		unset($_SESSION['first']);
		header("Location: login.php");
	}else if(isset($_POST['newpeople'])){
		if(isset($_POST['newpass1']) && isset($_POST['newpass2'])){
			$pass1 = $_POST['newpass1'];	
			$pass2 = $_POST['newpass2'];
			if(isset($_SESSION['first'])){
				$pass1 = md5($pass1);
				$nome  = $_POST['newname'];
				$funcao= $_POST['newfunction'];
				$codl  = $_POST['newplace'];
				$sql = "INSERT INTO usuario (nome,funcao,senha,codl) VALUES ('$nome','$funcao','$pass1','$codl')";
				$cons = mysqli_query($conexao ,$sql) or die ("MYSQL" .mysqli_error($conexao));	
				if(!$cons){
					die("Não foi possivel cadastrar usuário". mysqli_query($conexao,$sql,MYSQLI_USE_RESULT));
				}else{
					unset($_SESSION['first']);
					unset($_SESSION['boss']);
					$_SESSION['newerror']="Usuário Cadastrado.";	
					header("Location:login.php");
				}
			}else if($pass1==$pass2){
				$quem = $_SESSION['name'];
				$qpass = md5($_SESSION['password']);
				$sql = "SELECT * FROM usuario WHERE nome = '$quem' AND senha ='$qpass'";
				$result = mysqli_query($conexao,$sql,MYSQLI_USE_RESULT);
				$row = $result->fetch_assoc();
				if($row['funcao']=='boss'){
					$pass1 = md5($pass1);
					$nome  = $_POST['newname'];
					$funcao= $_POST['newfunction'];
					$codl  = $_POST['newplace'];
					mysqli_free_result($result);
					mysqli_next_result($conexao);
					$sql = "INSERT INTO usuario (nome,funcao,senha,codl) VALUES ('$nome','$funcao','$pass1','$codl')";
					$cons = mysqli_query($conexao ,$sql) or die ("MYSQL" .mysqli_error($conexao));	
					if(!$cons)
						die("Não foi possivel cadastrar usuário". mysqli_query($conexao,$sql,MYSQLI_USE_RESULT));					
					else
						$_SESSION['newerror']="Usuário Cadastrado.";	
				}else
					$_SESSION['newerror']="you have no power here";	
			}else
				$_SESSION['newerror']="As senhas não conferem.";
		}
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
			}else if(<?if(!isset($_SESSION['first']))echo'1';else echo "0";?>){
				document.getElementById('lin').style.display='block';
				document.getElementById('lout').style.display='none';			
				document.getElementById('fp').style.display='none';
			}else{//no caso de primeiro uso, permitir o admin se cadastrar sem problemas
				document.getElementById('lin').style.display='none';
				document.getElementById('lout').style.display='none';			
				document.getElementById('fp').style.display='none';
			}
			if(<?php if(isset($_GET['fp']))echo'1'; else echo'0';?>){//esqueceu a senha: desenvolver metodo de recuperação
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
				<input type="password" name="pass" <?php if(isset($_POST['pass']))echo'value="'.$_POST['pass'].'"'; else echo'placeholder="Senha"';?> required /><br/>
				<input type="submit" name="entrar" Value="Login"/>
				<?php if(isset($_SESSION['Error']))echo '<p> Usuário ou senha Incorretos</p>'; unset($_SESSION['Error']); unset($_SESSION['first']);?>
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

		<!-- a div seguinte é somente exibida no caso de o usuário logado ser um administrador -->
		<div align="center" style='<?php if(isset($_SESSION['boss']))echo'display:block;';else echo'display:none;'; ?>'>
			<p>I am the boss!!</p>
			<fieldset style="background-color:#009900;">
			<label>Cadestre um novo usuário</label>
			<form action="login.php" method="POST">
				<input type="text" name="newname" placeholder="Usuário"/><br/>
				<input type="password" name="newpass1" placeholder="Nova Senha"><br/>
				<input type="password" name="newpass2" placeholder="Confirme Senha"><br/>
				<input type="text" name="newplace" placeholder="Codigo do Local"><br/>
				<input type="text" name="newfunction" placeholder="Função"><br/>
				<input type="submit" name="newpeople" value="Registrar"><br/>
				<?php if(isset($_SESSION['newerror']) && $_SESSION['newerror']=="Usuário Cadastrado."){echo $_SESSION['newerror']; unset($_SESSION['newerror']);}
				else if(isset($_SESSION['newerror']))echo $_SESSION['newerror']; unset($_SESSION['newerror']);?>
			</form>
			</fieldset>
		</div> 
	</body>
</html>