<?php
	session_start();
	if(!isset($_SESSION['name'])){
		header("Location:index.php");
	}
		?>
<!DOCTYPE html>
<html>
	<head>
		<title>Relatório</title>
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
				var anoi = document.getElementById("IdAnoi").value;
				var mesi = document.getElementById("IdMesi").value;
				var diai = document.getElementById("IdDiai").value;
				var anof = document.getElementById("IdAnof").value;
				var mesf = document.getElementById("IdMesf").value;
				var diaf = document.getElementById("IdDiaf").value;
				if(document.getElementById("checkboxSaida").checked) var saida='1';
				else var saida='0';
				if(document.getElementById("checkboxEntrada").checked) var entrada='1';
				else var entrada='0';
				if(document.getElementById("radioAno").checked){
					document.getElementById("IdDiaI").value = anof +"-01-01";
					document.getElementById("IdDiaF").value = anof +"-12-31";
					}
				if(document.getElementById("radioMes").checked){
				 	document.getElementById("IdDiaI").value = anof + "-" + mesf + "-01";
					document.getElementById("IdDiaF").value = anof + "-" + mesf + "-31";
				}
				if(document.getElementById("radioIntervalo").checked){
				 	document.getElementById("IdDiaI").value = anoi + "-" + mesi + "-" +diai;
					document.getElementById("IdDiaF").value = anof + "-" + mesf +  "-" +diaf;
				}
				ano = anof;
				var diaI = document.getElementById("IdDiaI").value;
				var diaF = document.getElementById("IdDiaF").value;
				var url = 'consultRelatorio.php?codp=' + codp + '&nomep=' + nomep + '&codg=' + codg + '&nomeg=' + nomeg +
							'&codl=' + codl + '&nomel=' + nomel +'&saida=' + saida + '&entrada=' + entrada + '&diai=' +diaI + '&diaf=' + diaF;
				$.get(url, function(dataReturn) {
					$('#idpd').html(dataReturn);
				});

			};


			function GeraPDF() {
				var id = document.getElementById("idpd").innerHTML;
    			var url = "http://localhost/ESII-Controle-de-Estoque/testepdf.php?id="+id;
    			window.location.href=url;
			}

		</script>
	</head>
	<body onload="preencheBusca()">

	<?php require_once ("menu-principal.php"); ?>

<!--
	<div id="top-bar" style='background-color:#009933;'>
		<img src="imagens/IdentidadeVisual.png" style="height:80px;"/>
		<a href="buscas.php"><button>Inserir Produtos</button></a>
		<a href="buscas.php"><button>Remover Produtos</button></a>
		<a href="produto.php?cadp=1"><button>Cadastrar Produtos</button></a>
		<a href="produto.php?cadg=1"><button>Cadastrar Grupo</button></a>
		<a href="produto.php?cadl=1"><button>Cadastrar Local</button></a>
		<a href="buscas.php"><button>Buscar por Produtos</button></a>
		<?php if(isset($_SESSION['funcao']) && $_SESSION['funcao']=='Administrador')echo '<a href="index.php?cad_user=1"><button onClick="cad_user();">Cadastrar Novo Usuário</button></a>';
			if(isset($_SESSION['falta']))echo '<a href="index.php"><button><img src="imagens/alarme.png" style="height:20px;"/></button></a>';
		?>
		<a href="relatorios.php"><button>Relatórios de Produtos</button></a>
		<a href="index.php?logout=1"><button>Logout</button></a>
	</div>
-->

	<div class="">
			<div class="">
	      		<form name="fsearch" action="joao.php" method="get">
    				<div class="">
      					<input id="IdCodP" type="search" name="codp"
      						placeholder="Código do Produto" oninput="preencheBusca()">
      						<input type="number" id="IdAnoi" name="Ano" value="2016" oninput="preencheBusca()">Ano
						<br/>
      					<input id="IdNomeP" type="search" name="nomep"
      						placeholder="Nome do Produto" oninput="preencheBusca()">
      						<select id="IdMesi" name="Mesi">
								<option value="01" > Janeiro</option>
								<option value="02" > Fevereiro</option>
								<option value="03" > Março</option>
								<option value="04" > Abril</option>
								<option value="05" > Maio</option>
								<option value="06" > Junho</option>
								<option value="07" > Julho</option>
								<option value="08" > Agosto</option>
								<option value="09" > Setembro</option>
								<option value="10" > Outubro</option>
								<option value="11" > Novembro</option>
								<option value="12" > Dezembro</option>
							</select>Mês
							<br/>
      					<input id="IdCodG" type="search" name="codg"
      						placeholder="Código do Grupo" oninput="preencheBusca()">
      						<input type="number" id="IdDiai" name="DiaI" value="01" onchange="preencheBusca()" />Dia
      						 	<br/>
      					<input id="IdNomeG" type="search" name="nomeg"
      						placeholder="Nome do Grupo" oninput="preencheBusca()">
      						<input type="number" id="IdAnof" name="Ano"onchange="preencheBusca()" value=2017>Ano
      						<br/>
      					<input id="IdCodL" type="search" name="codl"
      						placeholder="Código do Local" oninput="preencheBusca()">
      						<select id="IdMesf" name="Mesf" onchange="preencheBusca()">
								<option value="01" > Janeiro</option>
								<option value="02" > Fevereiro</option>
								<option value="03" > Março</option>
								<option value="04" > Abril</option>
								<option value="05" > Maio</option>
								<option value="06" > Junho</option>
								<option value="07" > Julho</option>
								<option value="08" > Agosto</option>
								<option value="09" > Setembro</option>
								<option value="10" > Outubro</option>
								<option value="11" > Novembro</option>
								<option value="12" > Dezembro</option>

							</select>Mês

      						<br/>
      					<input id="IdNomeL" type="search" name="nomel"
      						placeholder="Nome do Local" oninput="preencheBusca()">

      						<input type="number" id="IdDiaf" onchange="preencheBusca()" name="DiaI" value="01" />Dia <br/>
  						 	<input type="date" id="IdDiaI" name="diai" readonly>Data Inicial
  						 	<input type="date" id="IdDiaF" name="diaf" readonly>Data Final
  						 	<br/>
  						<br/>

      					<label class="checkbox-inline">
      					<input id="radioIntervalo" type="radio" name="radioData"
  						 		onchange="preencheBusca()"> Relatório Intervalo<br/>
  						</label>
  						<label class="checkbox-inline">
  						<input id="radioAno" type="radio" name="radioData"
      						 	onchange="preencheBusca()"> Relatório Anual<br/>
      					</label>
      					<label class="checkbox-inline">
      					<input id="radioMes" type="radio" name="radioData"
      						 	onchange="preencheBusca()"> Relatório Mensal<br/>
      					</label>
      					<label class="checkbox-inline">
  							<input type="checkbox" id="checkboxSaida" name = "checkboxsaida" onchange="preencheBusca()"> Saída
						</label>
						<label class="checkbox-inline">
  							<input type="checkbox" id="checkboxEntrada" name = "checkboxentrada"
  								onchange="preencheBusca()"> Entrada
						</label>

      					<button type="button" class="botton" onclick="GeraPDF()"> Gerar Relatório</button>
      					<button type="submit" class="botton" > Gerar Gráfico</button>
    				</div>
  				</form>
	  		</div>
	  		<div>

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
								<td><center><b>Data de Entrada</b></center></td>
								<td><center><b>Data de Saída</b></center></td>
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
