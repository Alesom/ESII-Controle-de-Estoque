<? php
	require("connect.php");
	session_start();
	//
	/*
	if(isset($_session['logado'])){	
		$session_destroy['logado'];
		//só mostrar botão de logout
		
	}else*/ if(isset($_POST['Nome'])){		
			//conecta ao banco
			
			$sql = "SELECT nome FROM usuario where senha='$_POST['Senha'] ";
			$result = mysqli_query($conn, $sql);
			if($result){
				$_session['logado']=$result;
				
				header("Location:index.php");				
			}else{
			    echo"vacilaum morre cedo";
				
				}
			
			
				// faz consulta com login e senha
				
	}		

?>
<html>	
	<head>
	<title> Acesso</title>
	
	
	</head>
	<body onLoad="check_login();">	
		<div id="lin" align="center" >			
			<form action="login.php" method="POST" > 
				<input type="text" name="Nome" placeholder="Login" required /><br/>
				<input type="password" name="Senha" placeholder="Senha" required /><br/>
				<input type="submit" name="Entrar" Value="Login"/>
			</form>
		</div>
		<div id="lout" align="center" >	
			<input type="button" name="logout" Value="logout"/>
		</div>
	</body>
</html>

