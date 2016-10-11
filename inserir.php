<?php
	require ("connect.php");

	if(!isset($_SESSION['name'])){
		header("Location:index.php");
	}
	//desativar o autocommit para quando o php try, as alterações não corretas não vão diretamente para o banco.
	mysqli_autocommit($conexao, FALSE);

	if(isset($_POST['insertprod'])){
		$codp = $_POST['codigo'];
		$nome = $_POST['nome'];
		$qtdade = $_POST['qtdade'];
		$data = $_POST['data'];
		$sql = "INSERT INTO insercao VALUES ('$codp','$qtdade','$data')";

		$busca= "SELECT qtd FROM produto WHERE cod = '$codp'";
		$resultado = mysqli_query($conexao,$busca);
		$dados = mysqli_fetch_array($resultado);
		$new_qtd = $dados["qtd"] + $qtdade;
		$sql1 = "UPDATE produto SET qtd = '$new_qtd' WHERE cod = '$codp'";
		if($qtdade<0){
			$_SESSION['msg']='Favor inserir uma quantidade positiva';
		}else{
			try {
				$cons = mysqli_query($conexao ,$sql);
			    $cons1 = mysqli_query($conexao ,$sql1);
			    if(!$cons || !$cons1){
			    	throw new Exception("na inserção", 1);
			    }
			    if(!$cons)
					$_SESSION['msg']='O produto'.$nome.' não pode ser inserido.<br/><p style="color:red;">Erro: '.mysqli_error($conexao).'</p>';
				else
					$_SESSION['msg']=$qtdade." unidades de ".$nome." foram inseridas com sucesso.";


			    $a = mysqli_commit($conexao);
			    if(!$a)	throw new Exception("Não foi possivel efetivar a inserção, problema com o banco. Consulte Administrador", 1);
			} catch (Exception $e) {
			    echo 'Ocorreu um erro: ',  $e->getMessage(), "\n";
			}
		}
	}
	mysqli_autocommit($conexao, TRUE);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Formulário Inserção</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
</head>
<body>
	<?php require_once ("menu-principal.php"); ?>

	<div id="cadp" align="center">

		<label><b>Inserir unidades de Produto</b></label>
		<form action=<?php echo '"inserir.php?prod='.$_GET['prod'].'"';?> method="post">

		    Código do produto:<input type="text" name="codigo" readonly="readonly" <?php if(isset($_GET['prod']))echo 'value="'.$_GET['prod'].'"';else echo'placeholder="Código do Produto"'?> /><br/>
		    Nome do produto:<input type="text" name="nome" readonly="readonly"
		    	<?php if(isset($_GET['prod'])){
		    		$produto = $_GET['prod'];
					$busca= "SELECT nome FROM produto WHERE cod = '$produto'";
					$resultado = mysqli_query($conexao,$busca);
					$dados = mysqli_fetch_array($resultado);
					echo '	value="'.$dados["nome"].'"';

		    	}?> /><br/>
			Quantidade:<input type="text" name="qtdade" placeholder="00" /><br/>
			Data: <input type="date" name="data" value=<?php echo'"'.date('Y-m-d H:i').'"';?>/><br/>
		 	<input type="submit" name="insertprod" value="Inserir"/><br/>
		</form>
		<?php if(isset($_SESSION['msg'])){echo $_SESSION['msg'];unset($_SESSION['msg']);}?>
	</div>
	<a href="buscas.php"><button><b>Nova Busca</b></button></a>
</body>
</html>
