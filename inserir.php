<?php
	require_once 'inserts/functions.php';
	require_once 'inserts/logindb.php';
	$banco = conectadb($dbHostname, $dbUsername, $dbPassword);

	
	mysqli_autocommit($banco, FALSE);

	selectdb($banco, $dbDatabase);	
	if(isset($_POST['insertprod'])){
		$codp = $_POST['codigo'];
		$nome = $_POST['nome'];
		$qtdade = $_POST['qtdade'];
		$data = $_POST['data'];
		$sql = "INSERT INTO insercao VALUES ('$codp','$qtdade','$data')";

		$busca= "SELECT qtd FROM produto WHERE cod = '$codp'";
		$resultado = mysqli_query($banco,$busca);
		$dados = mysqli_fetch_array($resultado);
		$new_qtd = $dados["qtd"] + $qtdade;
		$sql1 = "UPDATE produto SET qtd = '$new_qtd' WHERE cod = '$codp'";


		try {
			$cons = mysqli_query($banco ,$sql);
		    $cons1 = mysqli_query($banco ,$sql1);
		    if(!$cons || !$cons1){
		    	throw new Exception("FOdeu a porra toda", 1);    	
		    }
		    if(!$cons)
				$_SESSION['msg']='O produto'.$nome.' não pode ser inserido.<br/><p style="color:red;">Erro: '.mysqli_error($banco).'</p>';
			else
				$_SESSION['msg']=$qtdade." unidades de ".$nome." foram inseridas com sucesso.";


		    $a = mysqli_commit($banco);
		    if(!$a)	throw new Exception("Não foi possivel efetivar a inserção, problema com o banco. Consulte Administrador", 1);
		} catch (Exception $e) {
		    echo 'Ocorreu um erro: ',  $e->getMessage(), "\n";
		}		
	}
?>
<!DOCTYPE html>
<html>
<head> 
	<title>Formulário Inserção</title> 
	<meta charset="utf-8" />
</head> 
<body>
	<div style="position:right;"><img src="people.jpeg"/><a href="index.php?logout=1"><button>Logout</button></a></div>
	<div id="top-bar" style='background-color:#009933;'>
		<a href="buscas.php"><button>Inserir Produtos</button></a>
		<a href="buscas.php"><button>Remover Produtos</button></a>
		<a href="produto.php?cadp=1"><button>Cadastrar Produtos</button></a>
		<a href="produto.php?cadg=1"><button>Cadastrar Grupo</button></a>
		<a href="produto.php?cadl=1"><button>Cadastrar Local</button></a>
		<a href="buscas.php"><button>Buscar por Produtos</button></a>
	</div>
	<div id="cadp" align="center">
	
		<label><b>Inserir unidades de Produto</b></label>
		<form action=<?echo '"inserir.php?prod='.$_GET['prod'].'"';?> method="post">	

		    Código do produto:<input type="text" name="codigo" readonly="readonly" <?if(isset($_GET['prod']))echo 'value="'.$_GET['prod'].'"';else echo'placeholder="Código do Produto"'?> /><br/>
		    Nome do produto:<input type="text" name="nome" readonly="readonly"
		    	<?php if(isset($_GET['prod'])){
		    		$produto = $_GET['prod'];
					$busca= "SELECT nome FROM produto WHERE cod = '$produto'";
					$resultado = mysqli_query($banco,$busca);
					$dados = mysqli_fetch_array($resultado);
					echo '	value="'.$dados["nome"].'"';

		    	}?> /><br/>
			Quantidade:<input type="text" name="qtdade" placeholder="00" /><br/>
			Data: <input type="Datetime" name="data" /><br/>
		 	<input type="submit" name="insertprod" value="Inserir"/><br/>
		</form> 
		<?if(isset($_SESSION['msg'])){echo $_SESSION['msg'];unset($_SESSION['msg']);}?>
	</div>
	<a href="buscas.php"><button><b>Nova Busca</b></button></a> 
</body>
</html>



