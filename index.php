<?php
	require ("connect.php");
?>
<html>	
	<head>	
	<title>Login</title>	
	<!-- Bloco de script para login-->
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
			function cad_user() {
				document.getElementById("cad_user").style.display="block";
			}
	</script>
	</head>

	<body onload="check_login();"> <!-- A função também deverá definir em que #section da página está -->	
	<div style="position:right;"><img src="people.jpeg"/><a href="index.php?logout=1"><button>Logout</button></a></div>
	<div id="top-bar" style='background-color:#009933;'>
		<a href="buscas.php"><button>Inserir Produtos</button></a>
		<a href="buscas.php"><button>Remover Produtos</button></a>
		<a href="produto.php?cadp=1"><button>Cadastrar Produtos</button></a>
		<a href="produto.php?cadg=1"><button>Cadastrar Grupo</button></a>
		<a href="produto.php?cadl=1"><button>Cadastrar Local</button></a>
		<a href="buscas.php"><button>Buscar por Produtos</button></a>
		<?php if(isset($_SESSION['funcao']) && $_SESSION['funcao']=='boss')echo '<button onClick="cad_user();">Cadastrar Novo Usuário</button>'; ?>
	</div>

	<!-- section login BEGIN-->
		<section >
			<?php
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
						//$resultado = mysqli_query($conexao,$sql);
						
						//$row = $result->fetch_assoc();
						$_SESSION['funcao'] = $row['funcao'];
						header("Location: index.php");
					}else{
						$_SESSION['Error'] = "Usuário ou senha não conferem";
					}
				}else if(isset($_POST['logout'])){
					unset($_SESSION['name']);
					unset($_SESSION['senha']);
					unset($_SESSION['first']);
					header("Location: index.php");
				}else if(isset($_POST['newpeople'])){
					if(isset($_POST['newpass1']) && isset($_POST['newpass2'])){
						$pass1 = $_POST['newpass1'];	
						$pass2 = $_POST['newpass2'];
						if(isset($_SESSION['first'])){
							$pass1 = md5($pass2);
							$nome  = $_POST['newname'];
							//$funcao= $_POST['newfunction'];
							$funcao= "boss";
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
								if($row['funcao']=='boss'){
									$pass1 = md5($pass2);
									$nome  = $_POST['newname'];
									$funcao= $_POST['newfunction'];
									$codl  = $_POST['newplace'];
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
							}echo $_SESSION['newerror']="Você precisa fazer login";	
						}else
							$_SESSION['newerror']="As senhas não conferem.";
					}
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
								$_SESSION['changed'] = 1;				}		
						}else{
							$_SESSION['changed'] = "As senhas não conferem";
						}
					}
				}

			?>
			<div id="lin" align="center" >			
				<form action="index.php" method="POST" >
					<input type="text" name="user" <?php if(isset($usuario))echo'value="'.$usuario.'"'; else echo'placeholder="Login"';?> required /><br/>
					<input type="password" name="pass" <?php if(isset($_POST['pass']))echo'value="'.$_POST['pass'].'"'; else echo'placeholder="Senha"';?> required /><br/>
					<input type="submit" name="entrar" Value="Login"/>
					<?php if(isset($_SESSION['Error']))echo '<p>'.$_SESSION['Error'].'</p>'; unset($_SESSION['Error']);?>
				</form>
				<a href='index.php?fp=1'>Esqueci minha senha</a>
			</div>
			<div id="lout" align="center" >	
				<form action="index.php" method="POST">
				<input type="submit" name="logout" Value="logout"/>
				</form>
			</div>
			<div id='fp' align="center">
				<form action="index.php?fp=1" method="POST">
					<input type="text" name="email" placeholder="Usuário"/><br/>
					<input type="password" name="pass1" placeholder="Nova Senha"><br/>
					<input type="password" name="pass2" placeholder="Confirme Senha"><br/>

					<input type="submit" name="changepass" value="Trocar"><br/>
					<?php if(isset($_SESSION['changed'])){echo $_SESSION['changed'];}
					else if(isset($_SESSION['changed']))echo$_SESSION['changed']; unset($_SESSION['changed']);?>
				</form>
			</div>

			<!-- a div seguinte é somente exibida no caso de o usuário logado ser um administrador -->
			<div align="center" style='<?php if(isset($_SESSION['first']))echo'display:block;';else echo'display:none;'; ?>'>
				<p>I am the boss!!</p>
				<fieldset style="background-color:#009900;">
				<label>Cadestre um novo usuário</label>
				<form action="index.php" method="POST">
					<input type="text" name="newname" placeholder="Usuário"/><br/>
					<input type="password" name="newpass1" placeholder="Nova Senha"><br/>
					<input type="password" name="newpass2" placeholder="Confirme Senha"><br/>
					<input type="text" name="newplace" placeholder="Codigo do Local"><br/>
					<input type="text" name="newplacen" placeholder="Nome do Local"><br/>
					<input type="text" name="newfunction" placeholder="Função"><br/>
					<input type="submit" name="newpeople" value="Registrar"><br/>
					<?php if(isset($_SESSION['newerror']) && $_SESSION['newerror']=="Usuário Cadastrado."){echo $_SESSION['newerror']; unset($_SESSION['newerror']);}
					else if(isset($_SESSION['newerror']))echo $_SESSION['newerror']; unset($_SESSION['newerror']);?>
				</form>
				</fieldset>
			</div> 

			<!-- a div seguinte é somente exibida no caso de o usuário logado ser um administrador -->
			<div align="center" id="cad_user" style="display:none;">
				<p>I am the boss!!</p>
				<fieldset style="background-color:#009900;">
				<label>Cadestre um novo usuário</label>
				<form action="index.php" method="POST">
					<input type="text" name="newname" placeholder="Usuário"/><br/>
					<input type="password" name="newpass1" placeholder="Nova Senha"><br/>
					<input type="password" name="newpass2" placeholder="Confirme Senha"><br/>
					Código do Local:<select name="codlocal">
					<option>Selecione:</option>
					<?$busca= "SELECT * FROM local";
						$resultado = mysqli_query($conexao,$busca);
						while ($dados = mysqli_fetch_assoc($resultado))
							echo '<option value = "'.$dados['codl'].'">'.$dados['codl'].'</option>';
					?>
				</select><br/>
				
					<input type="text" name="newfunction" placeholder="Função"><br/>
					<input type="submit" name="newpeople" value="Registrar"><br/>
					<?php if(isset($_SESSION['newerror']) && $_SESSION['newerror']=="Usuário Cadastrado."){echo $_SESSION['newerror']; unset($_SESSION['newerror']);}
					else if(isset($_SESSION['newerror']))echo $_SESSION['newerror']; unset($_SESSION['newerror']);?>
				</form>
				</fieldset>
			</div>

		</section>

	<!-- /section login END-->

	<!-- section cadastro BEGIN-->
		<section <?php if(isset($_GET['cadastro']))echo'onload="show_cadastro();"';?>>
			
		</section>
	<!-- /section cadastro END-->
	<!-- section busca BEGIN-->
		<section <?php if(isset($_GET['busca']))echo'onload="show_cadastro();"';?>>
			
		</section>
	<!-- /section busca END-->


	</body>
</html>
