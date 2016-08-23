<?php

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
				var url = 'load.php?codp=' + codp + '&nomep=' + nomep + '&codg=' + codg + '&nomeg=' + nomeg + 
							'&codl=' + codl + '&nomel=' + nomel;
				$.get(url, function(dataReturn) {
					$('#idpd').html(dataReturn);
				});
			};
		</script>
	</head>
	<body onload="preencheBusca()">

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
	  		</div>

			<div class="">
				<div class="" id="idpd">

				</div>
			</div>

		</div>

		<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    	<script type="text/javascript" src="js/materialize.min.js"></script>

	</body>
</html>