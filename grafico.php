<html>	
	<head>	
	<title>Gráfico</title>	

	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	</head>

	<body onload="check_login();"> <!-- A função também deverá definir em que #section da página está -->	
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
		<a href="index.php?logout=1"><button>Logout</button></a>
	</div>
	<div align="center">
		<fieldset>
			<img src="imagem.php"/>
		</fieldset>
	</div>

	</body>
</html>

