<?php
	session_start();
	if(!isset($_SESSION['name'])){
		header("Location:index.php");
	}
		?>
<!DOCTYPE html>
<html>
	<head>
		<title>Busca</title>
		<meta charset="UTF-8">

		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">

		<script type="text/javascript">

			function preencheBusca() {
				var codp = document.getElementById("IdCodP").value;
				var nomep = document.getElementById("IdNomeP").value;
				var codg = document.getElementById("IdCodG").value;
				var nomeg = document.getElementById("IdNomeG").value;
				var codl = document.getElementById("IdCodL").value;
				var nomel = document.getElementById("IdNomeL").value;
				var url = 'loads.php?codp=' + codp + '&nomep=' + nomep + '&codg=' + codg + '&nomeg=' + nomeg + 
							'&codl=' + codl + '&nomel=' + nomel;
				$.get(url, function(dataReturn) {
					$('#idpd').html(dataReturn);
				});
			};
		</script>
	</head>
	<body onload="preencheBusca()">
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
	<div class="">
		<div class="">
      		<form name="fsearch" action="" method="POST">
				<div class="">
  					<input id="IdCodP" type="search" name="codp" 
  						placeholder="Código do Produto" oninput="preencheBusca()"> <br/>
  					<input id="IdNomeP" type="search" name="nomep" 
  						placeholder="Nome do Produto" oninput="preencheBusca()"> <br/>
  					<input id="IdCodG" type="search" name="codg" 
  						placeholder="Código do Grupo" oninput="preencheBusca()"> <br/>
  					<input id="IdNomeG" type="search" name="nomeg" 
  						placeholder="Nome do Grupo" oninput="preencheBusca()"> <br/>
  					<input id="IdCodL" type="search" name="codl" 
  						placeholder="Código do Local" oninput="preencheBusca()"> <br/>
  					<input id="IdNomeL" type="search" name="nomel" 
  						placeholder="Nome do Local" oninput="preencheBusca()"> <br/>
  					<button type="submit" class="hide" disabled></button>
				</div>
			</form>
				<div>
					<a href="relatorioGeral.php"><button>Gerar Relatório geral de produtos</button></a>
  				</div>
  				<!--<select>
	  				<option><b>Ordenar por:</b></option>
	  				<option>Nome Produto A-Z</option>
	  				<option>Nome Produto Z-A</option>
	  				<option>Grupo A-Z</option>
	  				<option>Grupo Z-A</option>
	  				<option>Local A-Z</option>
	  				<option>Grupo Z-A</option>

  				</select>-->
  		</div>

			<div class="">
				<div class="">
					<table class="table">
						<thead>
							<tr>
								<td><center><b>Código</b></center></td>
								<td><center><b>Nome</b></center></td>
								<td><center><b>Quantidade</b></center></td>
								<td><center><b>Grupo</b></center></td>
								<td><center><b>Local</b></center></td>
							</tr>
						</thead>
				        <tbody id="idpd">
				        	
				        </tbody>
      				</table>
				</div>
			</div>

		</div>

		<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    	<script type="text/javascript" src="js/materialize.min.js"></script>

	</body>
</html>