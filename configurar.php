<?php
	require ("connect.php"); // se não existe conexao conecta

	if(!isset($_SESSION['name'])){
		header("Location:index.php");
	}

	if(isset($_POST['configura'])){ // faz o update no banco de dados;
		mysqli_autocommit($conexao, FALSE);
		$codp = $_POST['codigo'];
		$nome = $_POST['nome'];
		$qtdmin = $_POST['qtdmin'];
		$codl = $_POST['codlocal'];
		$codg = $_POST['codgrupo'];
		$codpn = substr($codp, 3, 4);
		$codpn = $codg . $codpn;
		if(isset($_POST['alarme']))
			$alarme = '1';
		else
			$alarme = '0';

		$sql = "UPDATE produto SET cod='$codpn',nome='$nome' WHERE cod= '$codp'";


		$busca = "SELECT * FROM localizacao WHERE codp = '$codp' AND codl = '$codl'"; 
		$resultado = mysqli_query($conexao, $busca);
		$sql1 = "Insert";
		while($dados = mysqli_fetch_assoc($resultado))
			if($dados['codl'] == $codl){
				$sql1 = "Update";
				break;
			}
		if($sql1!="Update")
			$sql1 = "INSERT INTO localizacao(`codp`,`codl`,`qtd`, `qtdmin`, `alarm`) VALUES ('$codpn', '$codl',0, '$qtdmin',1)";
		else{
			$sql1 = " UPDATE localizacao SET qtdmin='$qtdmin',alarm='$alarme' WHERE codp= '$codp' AND codl = '$codl'";
		}
		try{
			$cons = mysqli_query($conexao ,$sql);
			$cons1 = mysqli_query($conexao ,$sql1);

			if(!$cons){
				$_SESSION['msg']=$nome.' não pode ser configurado.<br/><p style="color:red;">Erro: '.mysqli_error($conexao).'</p>';
			}else
				$_SESSION['msg']=$nome." configurado com sucesso.";

			if(!$cons1){
				$_SESSION['msg']=$nome.' não pode ser Inserido no local.<br/><p style="color:red;">Erro: '.mysqli_error($conexao).'</p>';
			}else
				$_SESSION['msg']=$nome." configurado com sucesso.";

			if(isset($_POST['cnpj']) && $_POST['cnpj']!="SELECIONE"){
				$cnpj = $_POST['cnpj'];
				$sql = "INSERT INTO fornecimento(cod, cnpj) VALUES('$codp','$cnpj')";
				$cons = mysqli_query($conexao ,$sql);
				if(!$cons){
				$_SESSION['msg']=$cnpj.' Não foi possivel cadastrar CNPJ como fornecedor.<br/><p style="color:red;">Erro: '.mysqli_error($conexao).'</p>';
				}else
					$_SESSION['msg']=$cnpj." fornecedor cadastrado com sucesso.";
			}
			$a = mysqli_commit($conexao);
			
			if(!$a){
				throw new Exception("Não foi possivel efetivar a configuração, problema com o banco. Consulte Administrador", 1);
				
			}
		}catch (Exception $e) {
			mysqli_rollback($conexao);
			$_SESSION['msg'] = $e->message(); 
		}
		mysqli_autocommit($conexao, TRUE);
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Formulário configuração</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	</head>
	<body>

		<div class="container">

			<?php require_once ("menu-principal.php"); ?>

			<div class="col-sm-12">
				<h3><b>Configurar Produto</b></h3>
				<form action="configurar.php?prod=<?php echo $_GET['prod']; ?>" method="post" class="form-horizontal">

					<?php
						if(isset($_GET['prod'])){
							mysqli_next_result($conexao);
				    		$produto = $_GET['prod'];
							$busca = "SELECT p.cod as codp, p.nome as nome, lz.qtdmin as qtdmin, l.codl as codl, lz.alarm as alarm FROM produto p JOIN localizacao lz on p.cod = lz.codp join local l on l.codl=lz.codl WHERE p.cod = '$produto'";
							$resultado = mysqli_query($conexao, $busca);
							$dados = mysqli_fetch_array($resultado);
							$codp = $dados['codp'];
							$nome = $dados['nome'];
							$qtdademin = $dados['qtdmin'];
							$local = $dados['codl'];
							$grupo = substr($produto,0,3);
							$alarme = $dados['alarm'];
						}
					?>

					<div class="form-group row">
				    <div class="col-xs-3">
							<label for="idCodigo">Código do Produto:</label>
							<input type="text" id="idCodigo" name="codigo" readonly="readonly"
							<?php echo 'value="' . $codp . '"'; ?> class="form-control">
						</div>
					</div>
					<div class="form-group row">
				    <div class="col-xs-3">
							<label for="idNome">Nome do Produto:</label>
							<input type="text" id="idNome" name="nome"
					    <?php echo 'value="' . $nome . '"'; ?> class="form-control" required="required">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-xs-3">
							<label for="idQtd">Quantidade Mínima:</label>
							<input id="idQtd" type="number" min="0" name="qtdmin"
							<?php  echo 'value="' . $qtdademin . '"'; ?> class="form-control" required="required"> 
						</div>
					</div>
					<div class="form-group row">
						<div class="col-xs-3">
					    <label for="grupo">Código do Grupo:</label>
					    <select class="form-control" id="grupo" name="codgrupo">
					      <option <?php echo 'value="' . $grupo . '"'; ?>> <?php echo $grupo; ?> </option>
								<?php
									$sql = "SELECT * FROM grupo";
									$res = mysqli_query($conexao, $sql);
									while ($resu = mysqli_fetch_assoc($res))
										echo '<option value = "' . $resu['codg'] . '">' . $resu['codg'] . '</option>';
								?>
					    </select>
						</div>
				  </div>
					<div class="form-group">
						<div class="col-xs-3">
					    <label for="local">Código do Local:</label>
					    <select class="form-control" id="local" name="codlocal">
					      <option>Selecione</option>
								<?php
									$sql = "SELECT * FROM local";
									$res = mysqli_query($conexao, $sql);
									while ($resu = mysqli_fetch_assoc($res))
										echo '<option value = "' . $resu['codl'] . '">' . $resu['codl'] . '</option>';
								?>
					    </select>
						</div>
				  </div>
						<div class="form-group">
						<div class="col-xs-3">
					    <label for="local">Adicionar Fornecedor do Produto:</label>
				  		<select name="cnpj">
				  			<option value="SELECIONE">Selecione</option>
					  		<?php 
					  			$busca = "SELECT * FROM fornecedor"; 
								$resultado = mysqli_query($conexao, $busca);
								while($dados = mysqli_fetch_array($resultado)){
								echo '<option value="' . $dados["cnpj"] . '"> '.$dados['razao_social'].': '.$dados['cnpj'].'</option>';
								}
								echo "</select>";
								if(!$dados){
									echo '<br /><a href="produto.php?cadf=1">Cadastrar Novo Fornecedor</a>';
								}

							?>
						
						</div>
				  </div>
							


					<div class="form-check">
					  <label class="form-check-label">
					    <input class="form-check-input" type="checkbox" value="TRUE" name="alarme"
							<?php if($alarme) echo 'checked'; ?>>
					    Receber alarme quando a quantidade for menor ou igual à quantidade mínima
					  </label>
					</div>
					<input type="submit" name="configura" value="Salvar" class="btn btn-primary">
		  	</form>
				<?php
					if(isset($_SESSION['msg'])){
						echo "<p>".$_SESSION['msg'];
						unset($_SESSION['msg']);
					}
				?>
			</div>
			<a href="buscas.php"><button><b>Nova Busca</b></button></a>
		</div>

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="js/bootstrap.min.js"></script>

	</body>
</html>
