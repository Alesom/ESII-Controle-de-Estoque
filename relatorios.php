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

		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

		<script type="text/javascript">

			function preencheBusca(mode) {
				var codp = document.getElementById("IdCodP").value;
				var nomep = document.getElementById("IdNomeP").value;
				var codg = document.getElementById("IdCodG").value;
				var nomeg = document.getElementById("IdNomeG").value;
				var codl = document.getElementById("IdCodL").value;
				var nomel = document.getElementById("IdNomeL").value;

				if(document.getElementById("idSaidas").checked) var saida='1';
				else var saida='0';

				if(document.getElementById("idEntradas").checked) var entrada='1';
				else var entrada='0';

				if($('#IdRelInt').is(':checked')) {
					var dataini = document.getElementById("idDataI").value;
					var datafim = document.getElementById("idDataF").value;
				} else if($('#IdRelMensal').is(':checked')) {
					var mes = document.getElementById("idMes").value;
					var ano = document.getElementById("idAno").value;
					var dataini = ano + '-' + mes + '-01';
					var datafim = ano + '-' + mes + '-31';
				} else if($('#IdRelAnual').is(':checked')) {
					var ano = document.getElementById("idAno").value;
					var dataini = ano + '-01' + '-01';
					var datafim = ano + '-12' + '-31';
				} else {
					var dataini = '1900-01-01';
					var datafim = '3000-12-31';
				}

				if (mode) {
					var url = 'graficos.php?codp=' + codp + '&nomep=' + nomep + '&codg=' + codg + '&nomeg=' + nomeg +'&codl=' + codl + '&nomel=' + nomel +'&saida=' + saida + '&entrada=' + entrada + '&diai=' + dataini + '&diaf=' + datafim;
					window.open(url);
				} else {
					var url = 'consultRelatorio.php?codp=' + codp + '&nomep=' + nomep + '&codg=' + codg + '&nomeg=' + nomeg +
								'&codl=' + codl + '&nomel=' + nomel +'&saida=' + saida + '&entrada=' + entrada + '&diai=' + dataini + '&diaf=' + datafim;
					$.get(url, function(dataReturn) {
						$('#idpd').html(dataReturn);
					});
				}
			};

			function GeraPDF() {
				var id = document.getElementById("idpd").innerHTML;
    		var url = "testepdf.php?id="+id;
    		window.open(url);
			}

			function showFormInt() {
				document.getElementById('intervaloI').style.display='block';
				document.getElementById('intervaloF').style.display='block';
				document.getElementById('anual').style.display='none';
				document.getElementById('mensal').style.display='none';
			}
			function showFormAnual() {
				document.getElementById('intervaloI').style.display='none';
				document.getElementById('intervaloF').style.display='none';
				document.getElementById('anual').style.display='block';
				document.getElementById('mensal').style.display='none';
			}
			function showFormMensal() {
				document.getElementById('intervaloI').style.display='none';
				document.getElementById('intervaloF').style.display='none';
				document.getElementById('anual').style.display='block';
				document.getElementById('mensal').style.display='block';
			}

		</script>
	</head>
	<body onload="preencheBusca(0)">

		<div class="container">

			<?php require_once ("menu-principal.php"); ?>

			<div class="col-md-12" align="center">
				<form name="options" action="" method="get" class="form-horizontal">
					<div class="form-group row">
				    <div class="col-xs-4 col-xs-offset-4">
							<input id="IdCodP" type="search" name="codp" class="form-control"
							placeholder="Código do Produto" oninput="preencheBusca(0)">
						</div>
					</div>
					<div class="form-group row">
				    <div class="col-xs-4 col-xs-offset-4">
			    		<input id="IdNomeP" type="search" name="nomep" class="form-control"
			      		placeholder="Nome do Produto" oninput="preencheBusca(0)">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-xs-4 col-xs-offset-4">
							<input id="IdCodG" type="search" name="codg" class="form-control"
								placeholder="Código do Grupo" oninput="preencheBusca(0)">
						</div>
					</div>
					<div class="form-group row">
				    <div class="col-xs-4 col-xs-offset-4">
							<input id="IdNomeG" type="search" name="nomeg" class="form-control"
								placeholder="Nome do Grupo" oninput="preencheBusca(0)">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-xs-4 col-xs-offset-4">
							<input id="IdCodL" type="search" name="codl" class="form-control"
								placeholder="Código do Local" oninput="preencheBusca(0)">
						</div>
					</div>
					<div class="form-group row">
				    <div class="col-xs-4 col-xs-offset-4">
							<input id="IdNomeL" type="search" name="nomel" class="form-control"
								placeholder="Nome do Local" oninput="preencheBusca(0)">
						</div>
					</div>

					<h4>Movimentação:</h4>
					<label class="checkbox-inline">
					  <input type="checkbox" id="idEntradas" value="e" checked="checked" onclick="preencheBusca(0)"> Entradas
					</label>
					<label class="checkbox-inline">
					  <input type="checkbox" id="idSaidas" value="s" checked="checked" onclick="preencheBusca(0)"> Saídas
					</label>

					<br/><br/>
				  <label class="radio-inline">
				    <input type="radio" name="op_rel" id="IdRelInt" value="intervalo" onclick="showFormInt()">
				    Relatório por Intervalo
				  </label>
					<label class="radio-inline">
				    <input type="radio" name="op_rel" id="IdRelMensal" value="mensal" onclick="showFormMensal()">
				    Relatório Mensal
				  </label>
					<label class="radio-inline">
				    <input type="radio" name="op_rel" id="IdRelAnual" value="anual" onclick="showFormAnual()">
				    Relatório Anual
				  </label>

					<br/><br/>
					<div class="form-group row col-xs-12" id="intervaloF" style="display:none;">
				    <div class="col-xs-6 col-xs-offset-3 form-inline">
							<label for="idData">Data Inicial:</label>
							<input type="date" id="idDataI" name="datai" value=
								<?php
									echo '"' . date('Y-m-d H:i') . '"';
								?> class="form-control" required="required">
						</div>
						<br/>
					</div>
					<div class="form-group row col-xs-12" id="intervaloI" style="display:none;">
						<div class="col-xs-6 col-xs-offset-3 form-inline">
							<label for="idData">Data Final:</label>
							<input type="date" id="idDataF" name="dataf" value=
								<?php
									echo '"' . date('Y-m-d H:i') . '"';
								?> class="form-control" required="required" oninput="preencheBusca(0)">
						</div>
					</div>
					<div class="form-group row" id="mensal" style="display:none;">
						<div class="col-xs-4 col-xs-offset-4 form-inline">
					    <label for="idMes">Mês:</label>
					    <select class="form-control" id="idMes" name="seleciona_mes">
								<option value="01" >Janeiro</option>
								<option value="02" >Fevereiro</option>
								<option value="03" >Março</option>
								<option value="04" >Abril</option>
								<option value="05" >Maio</option>
								<option value="06" >Junho</option>
								<option value="07" >Julho</option>
								<option value="08" >Agosto</option>
								<option value="09" >Setembro</option>
								<option value="10" >Outubro</option>
								<option value="11" >Novembro</option>
								<option value="12" >Dezembro</option>
					    </select>
						</div>
				  </div>
					<div class="form-group row" id="anual" style="display:none;">
						<div class="col-xs-4 col-xs-offset-4 form-inline">
							<label for="idAno">Ano:</label>
							<input id="idAno" type="number" min="1900" max="3000" name="seleciona_ano" class="form-control" required="required" oninput="preencheBusca(0)">
						</div>
					</div>

					<br/>
					<button class="btn btn-primary" type="button" onclick="GeraPDF()">Gerar Relatório</button>
					<button class="btn btn-primary" type="button" onclick="preencheBusca(1)">Gerar Gráfico</button>
					<br/><br/>

				</form>
			</div>

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
				<tbody id="idpd"></tbody>
	    </table>
		</div>

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="js/bootstrap.min.js"></script>

	</body>
</html>
