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
		$data= date ("Y-m-d H:i");
		//echo $data;
		$sql = "INSERT INTO produto VALUES ('$cod','$nome','$qtdade','$codgrupo','$codlocal','$qtdademin','1')";
		$cons = mysqli_query($conexao ,$sql);
		if(!$cons){
		$_SESSION['msg']='O produto'.$nome.' não pode ser cadastrado.<br/> <p style="color:red;">Erro: '.mysqli_error($conexao).'</p>';
		}
		else{
			$sql = "INSERT INTO insercao VALUES ('$cod','$qtdade','$data')";
			$cons = mysqli_query($conexao ,$sql);
				if(!$cons){
					echo "putaquepariu". mysqli_error($conexao);
				}
			$_SESSION['msg']="O produto ".$nome." foi cadastrado com sucesso.";
		}
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
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
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
	<? require_once ("menu-principal.php"); ?>

	<div id="cadp" align="left">

		<label>Cadastro de Produto</label>
		<form action=<?php echo '"produto.php?cadp='.$_GET['cadp'].'"';?> method="post">
		    <input type="text" name="codigo" placeholder="Código do Produto" /><br/>
		 	<input type="text" name="nome" placeholder="Nome do Produto" /><br/>
			<input type="text" name="qtdade" placeholder="Quantidade" /><br/>
			<input type="text" name="qtdademin" placeholder="Quantidade Mínima" /> <br/>
			Código do Grupo:<select name="codgrupo">
				<option>Selecione:</option>
				<?php $busca= "SELECT * FROM grupo";
					$resultado = mysqli_query($conexao,$busca);
					while ($dados = mysqli_fetch_assoc($resultado))
						echo '<option value = "'.$dados['codg'].'">'.$dados['codg'].'</option>';
				?>
			</select><br/>
			<!--<input type="text" name="codgrupo" placeholder="Código do grupo" /><br/>-->
			Código do Local:<select name="codlocal">
				<option>Selecione:</option>
				<?php $busca= "SELECT * FROM local";
					$resultado = mysqli_query($conexao,$busca);
					while ($dados = mysqli_fetch_assoc($resultado))
						echo '<option value = "'.$dados['codl'].'">'.$dados['codl'].'</option>';
				?>
			</select><br/>

			<!--<input type="text" name="codlocal" placeholder="Código do local" /><br/>--><br/>
		 	<input  class="btn btn-lg btn-default" type="submit" name="cadprod" value="Cadastrar"/><br/>
		</form>
		<?php if(isset($_SESSION['msg'])){echo $_SESSION['msg'];unset($_SESSION['msg']);}?>
	</div>

	<div id="cadg" align="left">

		<label>Cadastro de Grupos</label>
		<form action="produto.php?cadg=1" method="post">
			<input type="text" name="codigo" placeholder="Código do Grupo" /><br/>
		 	<input type="text" name="nome" placeholder="Nome do Grupo" /><br/>
		 	<input class="btn btn-lg btn-default" type="submit" name="cadg" value="Cadastrar"/><br/>
		</form>
		<?php if(isset($_SESSION['msg'])){echo $_SESSION['msg'];unset($_SESSION['msg']);}?>
	</div>
	<div id="cadl" align="left">

		<label>Cadastro de Local</label>
		<form action="produto.php?cadl=1" method="post">
			<input type="text" name="codigo" placeholder="Código do local" /><br/>
		 	<input type="text" name="nome" placeholder="Nome do local" /><br/>
		 	<input class="btn btn-lg btn-default" type="submit" name="cadlocal" value="Cadastrar" /><br/>
		</form>
		<?php if(isset($_SESSION['msg'])){echo $_SESSION['msg'];unset($_SESSION['msg']);}?>
	</div>
</body>
</html>
