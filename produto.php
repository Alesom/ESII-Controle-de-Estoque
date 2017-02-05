<?php
	require ("connect.php");

	if(!isset($_SESSION['name']))
		header("Location:index.php");

	if(isset($_POST['cadprod'])){
		mysqli_autocommit($conexao, FALSE);
		$nome = $_POST['nome'];
		$qtdade = 0;
		$qtdademin = $_POST['qtdademin'];
		$codlocal = $_POST['codlocal'];
		$codgrupo = $_POST['codgrupo'];
		$data= date ("Y-m-d H:i");
		$medida = $_POST['unidade'];
		$sql = "SELECT MAX(cod)as cod FROM produto";
			$cons = mysqli_query($conexao ,$sql);
			$cod = mysqli_fetch_assoc($cons);
			$cod = $cod["cod"];
		$cod = substr($cod, 3, 4);
		if($cod == 0)
			$cod = "0001";
		else{
		$cod++;
		if($cod<1000){
			if($cod<100){
				if($cod<10){
					$cod = "000" . $cod;
				}else
					$cod = "00" . $cod;
			}else
				$cod = $cod = "0" . $cod;
		}else
			$cod = "" . $cod;
		}
		$cod = $codgrupo*100 . $cod;


		$sql = "INSERT INTO produto(`cod`,`nome`,`medida`) VALUES ('$cod','$nome', '$medida')";
		$sql1 = "INSERT INTO localizacao(`codp`,`codl`,`qtd`, `qtdmin`, `alarm`) VALUES ('$cod', '$codlocal','$qtdade', '$qtdademin',1)";

		try {
			$cons = mysqli_query($conexao , $sql);
			if(!$cons){
				throw new Exception("Dados inconsistentes.", 1);
			}

			$cons = mysqli_query($conexao , $sql1);
			if(!$cons){
				throw new Exception("Dados inconsistentes.", 1);
			}
			$a = mysqli_commit($conexao);
			if(!$a)
				throw new Exception("Não foi possivel efetivar o cadastro, problema com o banco. Consulte Administrador", 1);
			$_SESSION['msg'] = "O Produto ".$nome." foi cadastrado com sucesso.";
		}catch (Exception $e) {
			mysqli_rollback($conexao);
			$_SESSION['msg'] = $e->getMessage();
		}
		mysqli_autocommit($conexao, TRUE);
	}

	if(isset($_POST['cadg'])){
		$nome = $_POST['nome'];
		$busca = "SELECT * FROM grupo WHERE nome = '$nome'";
		$cons = mysqli_query($conexao ,$busca);
		while($res = mysqli_fetch_array($cons)){
			if($res['nome']== $nome){
				$_SESSION['msg']="O Grupo ".$nome." já existe.";
				break;
			}
		}
		if($res['nome']!= $nome){
			$sql = "INSERT INTO grupo(`nome`) VALUES ('$nome')";
			$cons = mysqli_query($conexao ,$sql);
			if(!$cons)
				$_SESSION['msg']="O Grupo ".$nome.' não pode ser cadastrado.<br/> <p style="color:red;">Erro: '.mysqli_error($conexao).'</p>';
			else
				$_SESSION['msg']="O Grupo ".$nome." foi cadastrado com sucesso.";

			$sql = "UPDATE grupo SET codg=codg  WHERE nome= '$nome'";
			$cons = mysqli_query($conexao ,$sql);
		}
	}

	if(isset($_POST['cadlocal'])){
		$nome = $_POST['nome'];

		$busca = "SELECT * FROM local WHERE nome = '$nome'";
		$cons = mysqli_query($conexao ,$busca);
		while($res = mysqli_fetch_array($cons)){
			if($res['nome']== $nome){
				$_SESSION['msg']="O Local ".$nome." já existe.";
				break;
			}
		}
		if($res['nome']!= $nome){
			$sql = "INSERT INTO local(`nome`) VALUES ('$nome')";
			$cons = mysqli_query($conexao ,$sql);
			if(!$cons)
				$_SESSION['msg']="O Local ".$nome.' não pode ser cadastrado.<br/> <p style="color:red;">Erro: '.mysqli_error($conexao).'</p>';
			else
				$_SESSION['msg']="O Local ".$nome." foi cadastrado com sucesso.";
		}
	}

	if(isset($_POST['cadforn'])){
		$razao = $_POST['razao'];
		$nome = $_POST['nomef'];
		$cnpj = $_POST['cnpj'];
		$logra = $_POST['logra'];
		$fone = $_POST['fone'];
		$busca = "SELECT * FROM fornecedor WHERE cnpj = '$cnpj'";
		$resultado = mysqli_query($conexao, $busca);
		$dados = mysqli_fetch_assoc($resultado);
		if($dados['cnpj']){
			$sql = "UPDATE fornecedor SET `razao_social` = '$razao' ,`nome_fantasia`= '$nome',`endereco` = '$logra',`telefone`='$fone' WHERE cnpj = '$cnpj'";
			$cons = mysqli_query($conexao ,$sql);
			if(!$cons)
				$_SESSION['msg']="O fornecedor ".$nome.' não pode ser atualizado.<br/> <p style="color:red;">Erro: '.mysqli_error($conexao).'</p>';
			else
				$_SESSION['msg']="O fornecedor ".$nome." foi atualizado com sucesso.";
		}else{

			$sql = "INSERT INTO fornecedor (`cnpj`,`razao_social`,`nome_fantasia`,`endereco`,`telefone`) VALUES ('$cnpj','$razao', '$nome', '$logra', '$fone')";
			$cons = mysqli_query($conexao ,$sql);
			if(!$cons)
				$_SESSION['msg']="O fornecedor ".$nome.' não pode ser cadastrado.<br/> <p style="color:red;">Erro: '.mysqli_error($conexao).'</p>';
			else
				$_SESSION['msg']="O fornecedor ".$nome." foi cadastrado com sucesso.";
		}
	}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Formulário Cadastro</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<script type="text/javascript">
			function opera(){
				if(<?php if(isset($_GET['cadp'])) echo '1';else echo '0';?>){
					document.getElementById('cadp').style.display='block';
					document.getElementById('cadg').style.display='none';
					document.getElementById('cadl').style.display='none';
					document.getElementById('cadf').style.display='none';
				}else if(<?php if(isset($_GET['cadg'])) echo '1';else echo '0';?>){
					document.getElementById('cadp').style.display='none';
					document.getElementById('cadg').style.display='block';
					document.getElementById('cadl').style.display='none';
					document.getElementById('cadf').style.display='none';
				}else if(<?php if(isset($_GET['cadl'])) echo '1';else echo '0';?>){//no caso de primeiro uso, permitir o admin se cadastrar sem problemas
					document.getElementById('cadp').style.display='none';
					document.getElementById('cadg').style.display='none';
					document.getElementById('cadl').style.display='block';
					document.getElementById('cadf').style.display='none';
				}else if(<?php if(isset($_GET['cadf'])) echo '1';else echo '0';?>){
					document.getElementById('cadf').style.display='block';
					document.getElementById('cadg').style.display='none';
					document.getElementById('cadl').style.display='none';
					document.getElementById('cadp').style.display='none';
				}
			}
			function showalarm() {
				document.getElementById("alarme").style.display="block;";
			}
			function formatar(mascara, documento){
              var i = documento.value.length;
              var saida = mascara.substring(0,1);
              var texto = mascara.substring(i)

              if (texto.substring(0,1) != saida){
                        documento.value += texto.substring(0,1);
              }
            }
		</script>
	</head>

	<body onload="opera();">

		<div class="container">

			<?php require_once ("menu-principal.php"); ?>

			<div id="cadp" class="col-sm-12">
				<h3><b>Cadastro de Produto</b></h3>
				<form action="produto.php?cadp=<?php echo $_GET['cadp']; ?>" method="post" class="form-horizontal">
					<div class="form-group row">
						<div class="col-xs-3">
							<input type="text" name="nome" class="form-control" required="required" placeholder="Nome do Produto">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-xs-3">
							<input type="number" min="0" name="qtdademin" class="form-control" required="required" placeholder="Quantidade Mínima">
						</div>
					</div>
					<div class="form-group">
						<div class="col-xs-3">
					    <label for="grupo">Grupo:</label>
					    <select class="form-control" id="grupo" name="codgrupo">
								<?php
									$busca = "SELECT * FROM grupo";
									$resultado = mysqli_query($conexao, $busca);
									while ($dados = mysqli_fetch_assoc($resultado))
										echo '<option value = "' . $dados['codg'] . '">' . $dados['nome'] . '</option>';
								?>
					    </select>
						</div>
				  </div>
					<div class="form-group">
						<div class="col-xs-3">
							<label for="local">Local:</label>
							<select class="form-control" id="local" name="codlocal">
					    	<?php
									$busca = "SELECT * FROM local";
									$resultado = mysqli_query($conexao, $busca);
									while ($dados = mysqli_fetch_array($resultado))
										echo '<option value = "' . $dados['codl'] . '">' . $dados['nome'] . '</option>';
								?>
							</select>
						</div>
				  </div>
					<div class="form-group">
						<div class="col-xs-3">
					    <label for="local">Unidade de Medida:</label>
					    <select class="form-control" id="unidade" name="unidade">
								<option>Litro</option>
								<option>Metro</option>
								<option>Metro Cúbico</option>
								<option>Quilograma</option>
								<option>Unidade</option>
					    </select>
						</div>
				  </div>
					<input type="submit" name="cadprod" value="Cadastrar" class="btn btn-primary">
				</form>
			</div>

			<div id="cadg" class="col-sm-12">
				<h3><b>Cadastro de Grupo</b></h3>
				<form action="produto.php?cadg=1" method="post" class="form-horizontal">
					<div class="form-group row">
						<div class="col-xs-3">
							<input type="text" name="nome" class="form-control" required="required" placeholder="Nome do Grupo">
						</div>
					</div>
					<input type="submit" name="cadg" value="Cadastrar" class="btn btn-primary">
				</form>
			</div>

			<div id="cadl" class="col-sm-12">
				<h3><b>Cadastro de Local</b></h3>
				<form action="produto.php?cadl=1" method="post" class="form-horizontal">
					<div class="form-group row">
						<div class="col-xs-3">
							<input type="text" name="nome" class="form-control" required="required" placeholder="Nome do Local">
						</div>
					</div>
					<input type="submit" name="cadlocal" value="Cadastrar" class="btn btn-primary">
				</form>
			</div>

			<div id="cadf" class="col-sm-12">
				<h3><b>Cadastro de Fornecedor</b></h3>
				<form action="produto.php?cadf=1" method="post" class="form-horizontal">
					<div class="form-group row">
						<div class="col-xs-3">
							<input type="text" name="razao" class="form-control" required="required" placeholder="Razão Social">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-xs-3">
							<input type="text" name="nomef" class="form-control" placeholder="Nome Fantasia">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-xs-3">
							<input type="text" name="cnpj" maxlength="18" class="form-control" placeholder="CNPJ"
								OnKeyPress="formatar('##.###.###/####-##', this)" required="required">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-xs-3">
							<input type="text" name="logra" class="form-control" placeholder="Endereço" required="required">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-xs-3">
							<input type="text" name="fone" class="form-control" placeholder="Telefone" maxlength="13"
								maxlength="13" OnKeyPress="formatar('## #####-####', this)">
						</div>
					</div>
					<input type="submit" name="cadforn" value="Cadastrar" class="btn btn-primary"><br/>
					<br/><span>*<i>Se CNPJ já estiver cadastrado o fornecedor será atualizado</i></span><br/>
				</form>
			</div>

			<?php
				if(isset($_SESSION['msg'])){
					$mensagem = substr($_SESSION['msg'], -8);
					if (strcmp($mensagem, "sucesso.") == 0) {
						echo '<div class="alert alert-success">' . $_SESSION['msg'] . '</div>';
					} else {
						echo '<div class="alert alert-danger">' . $_SESSION['msg'] . '</div>';
					}
					unset($_SESSION['msg']);
				}
			?>

		</div>

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="js/bootstrap.min.js"></script>

	</body>
</html>
