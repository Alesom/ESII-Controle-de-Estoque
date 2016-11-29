<?php
	require ("connect.php");
	$nome = "Jardel";
	$sql = "SELECT cod FROM produto WHERE nome = '$nome'";
			$cons = mysqli_query($conexao ,$sql);
			$cod = mysqli_fetch_assoc($cons);
				echo $cod["cod"];
				$cod = $cod['cod'];
				echo $cod;
?>
<!--
<html>
	<head>
	<title>Gráfico</title>

	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	</head>

	<body onload="check_login();"> 
	<div id="top-bar" style='background-color:#009933;'>
		<img src="imagens/IdentidadeVisual.png" style="height:80px;"/>
		<a href="buscas.php"><button>Inserir Produtos</button></a>
		<a href="buscas.php"><button>Remover Produtos</button></a>
		<a href="produto.php?cadp=1"><button>Cadastrar Produtos</button></a>
		<a href="produto.php?cadg=1"><button>Cadastrar Grupo</button></a>
		<a href="produto.php?cadl=1"><button>Cadastrar Local</button></a>
		<a href="buscas.php"><button>Buscar por Produtos</button></a>
		<?php if(isset($_SESSION['funcao']) && $_SESSION['funcao']=='boss')echo '<a href="index.php?cad_user=1"><button onClick="cad_user();">Cadastrar Novo Usuário</button></a>';
			if(isset($_SESSION['falta']))echo '<a href="index.php"><button><img src="imagens/alarme.png" style="height:20px;"/></button></a>';
		?>
		<a href="relatorios.php"><button>Relatórios de Produtos</button></a>
		<a href="index.php?logout=1"><button>Logout</button></a>
	</div>


	<form method="GET" action="imagem.php">
		<input type="text" name="prod" value=<?echo $_GET['prod'];?>>
		<input type= "number" name ="ano" value="2016" />
		<input type = "radio" name = 'periodo' value = 'anual' checked /> anual<br/>
		<select name="mes">
			<option value="jan" > Janeiro</option>
			<option value="fev" > Fevereiro</option>
			<option value="mar" > Março</option>
			<option value="abr" > Abril</option>
			<option value="mai" > Maio</option>
			<option value="jun" > Junho</option>
			<option value="jul" > Julho</option>
			<option value="ago" > Agosto</option>
			<option value="set" > Setembro</option>
			<option value="out" > Outubro</option>
			<option value="nov" > Novembro</option>
			<option value="dez" > Dezembro</option>
		</select>
		<input type = "radio" name = 'periodo' value = 'mensal' /> mensal<br/>
		<input type= "text" name ="datai" placeholder="Data Inicial" />
		<input type= "text" name ="dataf" placeholder="Data Final" />
		<input type = "radio" name = 'periodo' value = 'interval' /> intervalo	<br/>

		<input type="submit" name="type" value="Pontos" />
		<input type="submit" name="type" value="Bolha" />
		<input type="submit" name="type" value="Pizza" />
		<input type="submit" name="type" value="Barra" />
	</form>

	</body>
</html>
