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

		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

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

		<div class="container">

			<?php require_once ("menu-principal.php"); ?>

			<div class="col-sm-12">
				<form name="fsearch" action="" method="POST">
					<div class="form-group row">
				    <div class="col-xs-3">
							<input id="IdCodP" type="search" name="codp" class="form-control"
							placeholder="Código do Produto" oninput="preencheBusca()">
						</div>
					</div>
					<div class="form-group row">
				    <div class="col-xs-3">
			    		<input id="IdNomeP" type="search" name="nomep" class="form-control"
			      		placeholder="Nome do Produto" oninput="preencheBusca()">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-xs-3">
							<input id="IdCodG" type="search" name="codg" class="form-control"
								placeholder="Código do Grupo" oninput="preencheBusca()">
						</div>
					</div>
					<div class="form-group row">
				    <div class="col-xs-3">
							<input id="IdNomeG" type="search" name="nomeg" class="form-control"
								placeholder="Nome do Grupo" oninput="preencheBusca()">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-xs-3">
							<input id="IdCodL" type="search" name="codl" class="form-control"
								placeholder="Código do Local" oninput="preencheBusca()">
						</div>
					</div>
					<div class="form-group row">
				    <div class="col-xs-3">
							<input id="IdNomeL" type="search" name="nomel" class="form-control"
								placeholder="Nome do Local" oninput="preencheBusca()">
						</div>
					</div>
					<button type="submit" class="hide" disabled></button>
		  	</form>
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
				<tbody id="idpd"></tbody>
	    </table>
		</div>

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

	</body>
</html>
