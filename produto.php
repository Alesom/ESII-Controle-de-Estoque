<?php
	require ("connect.php");
	
	if(!isset($_SESSION['name'])){
		header("Location:index.php");
	}
	if(isset($_POST['cadprod'])){
		$cod = $_POST['codigo'];
		$nome = $_POST['nome'];
		$qtdade = $_POST['qtdade'];
		$qtdademin = $_POST['qtdademin'];
		$codlocal = $_POST['codlocal'];
		$codgrupo = $_POST['codgrupo'];
		$sql = "INSERT INTO produto VALUES ('$cod','$nome','$qtdade','$codgrupo','$codlocal','$qtdademin','1')";
		$cons = mysqli_query($conexao ,$sql);
		if(!$cons){
		$_SESSION['msg']='O produto'.$nome.' não pode ser cadastrado.<br/> <p style="color:red;">Erro: '.mysqli_error($conexao).'</p>';
		}
		else
			$_SESSION['msg']="O produto ".$nome." foi cadastrado com sucesso.";
	}
	
	if(isset($_POST['cadg'])){
		$cod = $_POST['codigo'];
		$nome = $_POST['nome'];
		$sql = "INSERT INTO grupo VALUES ('$cod','$nome')";
		$cons = mysqli_query($conexao ,$sql);
		if(!$cons){
			$_SESSION['msg']="O Grupo ".$nome.' não pode ser cadastrado.<br/> <p style="color:red;">Erro: '.mysqli_error($conexao).'</p>';
		}
		else
			$_SESSION['msg']="O Grupo ".$nome." foi cadastrado com sucesso.";

	}
	if(isset($_POST['cadlocal'])){
		$cod = $_POST['codigo'];
		$nome = $_POST['nome'];
		$sql = "INSERT INTO local VALUES ('$cod','$nome')";
		$cons = mysqli_query($conexao ,$sql);
		if(!$cons){
			$_SESSION['msg']="O Local ".$nome.' não pode ser cadastrado.<br/> <p style="color:red;">Erro: '.mysqli_error($conexao).'</p>';
		}
		else
			$_SESSION['msg']="O Local ".$nome." foi cadastrado com sucesso.";
	}
?>
<!DOCTYPE html>
<html>
<head> 
	<title>Formulário Cadastro</title> 
	<meta charset="utf-8" />
	<script type="text/javascript">
	function opera(){
			if(<?php if(isset($_GET['cadp'])) echo '1';else echo '0';?>){
				document.getElementById('cadp').style.display='block';
				document.getElementById('cadg').style.display='none';
				document.getElementById('cadl').style.display='none';
			}else if(<?php if(isset($_GET['cadg'])) echo '1';else echo '0';?>){
				document.getElementById('cadp').style.display='none';
				document.getElementById('cadg').style.display='block';
				document.getElementById('cadl').style.display='none';
			}else if(<?php if(isset($_GET['cadl'])) echo '1';else echo '0';?>){//no caso de primeiro uso, permitir o admin se cadastrar sem problemas
				document.getElementById('cadp').style.display='none';
				document.getElementById('cadg').style.display='none';
				document.getElementById('cadl').style.display='block';
			}
		}
			function showalarm() {
				document.getElementById("alarme").style.display="block;";
			}
			
	</script>
</head> 
<body onload="opera();">
	<div id="top-bar" style='background-color:#009933;'>
		<a href="index.php"><button>Início</button></a>
		<a href="buscas.php"><button>Inserir Produtos</button></a>
		<a href="buscas.php"><button>Remover Produtos</button></a>
		<a href="produto.php?cadp=1"><button>Cadastrar Produtos</button></a>
		<a href="produto.php?cadg=1"><button>Cadastrar Grupo</button></a>
		<a href="produto.php?cadl=1"><button>Cadastrar Local</button></a>
		<a href="buscas.php"><button>Buscar por Produtos</button></a>
		<?php if(isset($_SESSION['funcao']) && $_SESSION['funcao']=='boss')echo '<a href="index.php?cad_user=1"><button onClick="cad_user();">Cadastrar Novo Usuário</button></a>'; ?>
		
		<a href="index.php?logout=1"><button>Logout</button></a>
	</div>
	
	<div id="cadp" align="center">
	
		<label>Cadastro de Produto</label>
		<form action=<?echo '"produto.php?cadp='.$_GET['cadp'].'"';?> method="post">	
		    <input type="text" name="codigo" placeholder="Código do Produto" /><br/>
		 	<input type="text" name="nome" placeholder="Nome do Produto" /><br/>
			<input type="text" name="qtdade" placeholder="Quantidade" /><br/>
			<input type="text" name="qtdademin" placeholder="Quantidade Mínima" /> <br/>			
			Código do Grupo:<select name="codgrupo">
				<option>Selecione:</option>
				<?$busca= "SELECT * FROM grupo";
					$resultado = mysqli_query($conexao,$busca);
					while ($dados = mysqli_fetch_assoc($resultado))
						echo '<option value = "'.$dados['codg'].'">'.$dados['codg'].'</option>';
				?>
			</select><br/>
			<!--<input type="text" name="codgrupo" placeholder="Código do grupo" /><br/>-->
			Código do Local:<select name="codlocal">
				<option>Selecione:</option>
				<?$busca= "SELECT * FROM local";
					$resultado = mysqli_query($conexao,$busca);
					while ($dados = mysqli_fetch_assoc($resultado))
						echo '<option value = "'.$dados['codl'].'">'.$dados['codl'].'</option>';
				?>
			</select><br/>
			
			<!--<input type="text" name="codlocal" placeholder="Código do local" /><br/>--><br/>
		 	<input type="submit" name="cadprod" value="Cadastrar"/><br/>
		</form> 
		<?if(isset($_SESSION['msg'])){echo $_SESSION['msg'];unset($_SESSION['msg']);}?>
	</div>

	<div id="cadg" align="center">
		
		<label>Cadastro de Grupos</label>
		<form action="produto.php?cadg=1" method="post">
			<input type="text" name="codigo" placeholder="Código do Grupo" /><br/>
		 	<input type="text" name="nome" placeholder="Nome do Grupo" /><br/>
		 	<input type="submit" name="cadg" value="Cadastrar"/><br/>
		</form> 
		<?if(isset($_SESSION['msg'])){echo $_SESSION['msg'];unset($_SESSION['msg']);}?>
	</div>
	<div id="cadl" align="center">
		
		<label>Cadastro de Local</label>
		<form action="produto.php?cadl=1" method="post">
			<input type="text" name="codigo" placeholder="Código do local" /><br/>
		 	<input type="text" name="nome" placeholder="Nome do local" /><br/>
		 	<input type="submit" name="cadlocal" value="Cadastrar" /><br/>
		</form> 
		<?if(isset($_SESSION['msg'])){echo $_SESSION['msg'];unset($_SESSION['msg']);}?>
	</div>
</body>
</html>



