<?php
/*
Licença: MIT
Alunos: Alesom, André, Eduardo, Jardel, João Barp, Jovani e Kétly
Disciplina: Engenharia de Software II

Arquivo retirar:
é responsável pela parte de remoção de unidades de um produto
*/
	require ("connect.php");

	if(!isset($_SESSION['name'])){
		header("Location:index.php");
	}
	mysqli_autocommit($conexao,False);

	if(isset($_POST['retirarprod'])){
		$codp = $_POST['codigo'];
		$nome = $_POST['nome'];
		$qtdade = $_POST['qtdade'];
		$data = $_POST['data'];
		$destino = $_POST['destino'];
		$chamado = $_POST['chamado'];
		$origem = $_POST['codl'];
		if(isset($_POST['trans']) && isset($_POST['transferencia'])){
			$trans = $_POST['trans'];//codl
			$valor = $_POST['valor'];

			$insercao = "INSERT IGNORE INTO localizacao(`codp`,`codl`,`qtd`, `qtdmin`, `alarm`)
									VALUES ('" . $codp . "', " . $trans . ", 0, 0, 1);";
			$insere = mysqli_query($conexao,$insercao);

			$insercao2 = "INSERT IGNORE INTO localizacao(`codp`,`codl`,`qtd`, `qtdmin`, `alarm`)
									VALUES ('" . $codp . "', " . $origem . ", 0, 0, 1);";
			$insere2 = mysqli_query($conexao,$insercao);

			$busca = "SELECT * FROM localizacao WHERE codp = '$codp' AND codl = '$trans'";
			$busca1= "SELECT * FROM localizacao WHERE codp = '$codp' AND codl ='$origem'";

			$resultado = mysqli_query($conexao,$busca);
			$resultado1 = mysqli_query($conexao,$busca1);

			$dados = mysqli_fetch_array($resultado);
			$dados1 = mysqli_fetch_array($resultado1);

			if ($dados1['qtd'] < $qtdade) {
				$_SESSION['msg']="Preste atenção na quantidade disponível. Você está retirando mais produtos do que há.";
			} else {

				$qtdade1 = $dados['qtd'] + $qtdade;
				$qtdade2 = $dados1['qtd'] - $qtdade;

				$sql  = "UPDATE localizacao SET qtd = '$qtdade1' WHERE codp ='$codp' AND codl = '$trans'";
				$sql1 = "UPDATE localizacao SET qtd = '$qtdade2' WHERE codp ='$codp' AND codl = '$origem'";

				$resultado = mysqli_query($conexao,$sql);
				$resultado1 = mysqli_query($conexao,$sql1);

				$log1 = "INSERT INTO remocao(data,qtd,codp,destino,chamado,local) VALUES ('$data', '$qtdade' ,'$codp','Transferência','$chamado', $origem)";
				$log2 = "INSERT INTO insercao(codp,qtd,data,vlr,tipo,local) VALUES ('$codp','$qtdade','$data', '$valor', 'Transferência', $trans)";

				$l1 = mysqli_query($conexao,$log1);
				$l2 = mysqli_query($conexao,$log2);

				try {
					$a = mysqli_commit($conexao);
					if(!$a)
						throw new Exception("Não commitado no banco, tente novamente", 1);
					else {
	    			$_SESSION['msg']='Transferido com sucesso.';
	    		}
				} catch (Exception $e) {
					$_SESSION['msg'] = $e->getMessage();
						mysqli_rollback($conexao);
				}
			}

		}else{
			$busca = "SELECT * FROM localizacao WHERE codp = '$codp' AND codl = '$origem'";
			$resultado = mysqli_query($conexao,$busca);
			$dados = mysqli_fetch_array($resultado);
			$qtdade1 = $dados['qtd'] - $qtdade;

			if ($qtdade1 >= 0) {
				try{
					$sql = "INSERT INTO remocao(data,qtd,codp,destino,chamado,local) VALUES ('$data', '$qtdade' ,'$codp','$destino','$chamado', $origem)";

					$cons = mysqli_query($conexao, $sql);

					$sql1 = "UPDATE localizacao SET qtd = '$qtdade1' WHERE codp ='$codp' AND codl = '$origem'";
					$cons1 = mysqli_query($conexao, $sql1);

					if(!$cons){
						$_SESSION['msg']='Erro ao remover as unidades do produto solicitado';
						throw new Exception($_SESSION['msg'], 1);
					}
					else
						$_SESSION['msg']="As ". $qtdade." unidades de ".$nome." foram retiradas com sucesso.";

					$a = mysqli_commit($conexao);
					if(!$a)
						throw new Exception("Não commitado no banco, tente novamente", 1);

					$a = mysqli_commit($conexao);
					if(!$a)
						throw new Exception("Não commitado no banco, tente novamente", 1);

				}catch(Exception $e ){
					$_SESSION['msg'] = $e->getMessage();
					mysqli_rollback($conexao);
				}
			}else

					$_SESSION['msg']="Preste atenção na quantidade disponível. Você está retirando mais produtos do que há.";
		}
	}
	mysqli_autocommit($conexao,True);
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Formulário Remoção</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

		<script type="text/javascript">
			function ativatransferencia(){
				if(document.getElementById("idtransferencia").checked){
					document.getElementById("trans").style.display= "block";
					document.getElementById("valor_trans").style.display= "block";
				}else {
					document.getElementById("trans").style.display= "none";
					document.getElementById("valor_trans").style.display= "none";
				}
			}
		</script>
	</head>
	<body>

		<div class="container">

			<?php require_once ("menu-principal.php"); ?>

			<div class="col-sm-12">
				<h3><b>Lançamento de Saída</b></h3>
				<form action="retirar.php?prod=<?php echo $_GET['prod']; ?>" method="post" class="form-horizontal">
					<div class="form-group row">
						<div class="col-xs-3">
							<label for="idCodigo">Código do Produto:</label>
							<input type="text" id="idCodigo" name="codigo" readonly="readonly"
							<?php
								if(isset($_GET['prod']))
									echo 'value="' . $_GET['prod'] . '"';
							?> class="form-control">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-xs-3">
							<label for="idNome">Nome do Produto:</label>
							<input type="text" id="idNome" name="nome" readonly="readonly"
							<?php
								if(isset($_GET['prod'])){
									$produto = $_GET['prod'];
									$busca = "SELECT nome FROM produto WHERE cod = '$produto'";
									$resultado = mysqli_query($conexao, $busca);
									$dados = mysqli_fetch_array($resultado);
									echo '	value="' . $dados["nome"] . '"';
								}
							?> class="form-control">
						</div>
					</div>

					<div class="form-group row">
						<div class="col-xs-3">
							<input id="idQtd" type="number" min="1" name="qtdade" class="form-control" required="required" placeholder="Quantidade">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-xs-3">
							<input id="idDestino" type="text" name="destino" class="form-control" required="required" placeholder="Motivo">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-xs-3">
							<input id="idChamado" type="text" name="chamado" class="form-control" placeholder="Chamado" >
						</div>
					</div>
					<div class="form-group row">
				    <div class="col-xs-3">
							<label>Origem</label>
								<?php
									$local = $_SESSION['local'];
									$busca = "SELECT * FROM local";
									$resultado = mysqli_query($conexao, $busca);

									if($_SESSION['funcao']=="Administrador"){
										echo'<select class="form-control" name="codl">';
										while($dados = mysqli_fetch_array($resultado)){
											echo '<option value="'.$dados['codl'].'">'.$dados['nome'].'</option>';
										}
									}else{
										$dados = mysqli_fetch_assoc($resultado);
										echo'<select class="form-control" name="codl">';
										echo '<option value="'.$dados['codl'].'">'.$dados['nome'].'</option>';
									}
									echo'</select>';
								?>
						</div>
					</div>

					<div class="form-group row">
						<div class="col-xs-3">
							<label for="idData">Data:</label>
							<input type="date" id="idData" name="data" value=
								<?php
									echo '"' . date('Y-m-d H:i') . '"';
								?> class="form-control" required="required">
						</div>
					</div>

					<div class="form-group row">
						<div class="col-xs-3">
							<label class="checkbox-inline">
						  	<input type="checkbox" id="idtransferencia" name ="transferencia" value="t" onchange="ativatransferencia();"> Transferência
							</label>
						</div>
					</div>

					<div class="form-group row" id="trans" style="display:none;">
						<div class="col-xs-3">
							<label for="destino">Destino:</label>
							<select class="form-control" id="destino" name="trans">
					    	<?php
									$busca = "SELECT * FROM local";
									$resultado = mysqli_query($conexao, $busca);
									while ($dados = mysqli_fetch_array($resultado))
										echo '<option value = "' . $dados['codl'] . '">' . $dados['nome'] . '</option>';
								?>
							</select>
						</div>
				  </div>
					<div class="form-group row" id="valor_trans" style="display:none;">
						<div class="col-xs-3">
							<input type="number" min="0" name="valor" class="form-control" placeholder="Valor">
						</div>
					</div>

					<input type="submit" name="retirarprod" value="Retirar" class="btn btn-primary">
					<br/><br/>
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
