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
				var valor = document.getElementById("search").value;
				var url = 'load.php?valor=' + valor;
				$.get(url, function(dataReturn) {
					$('#idpd').html(dataReturn);
				});
			};
		</script>
	</head>
	<body>

		<br><br>

		<div class="">
		
			<div class="">
	      		<form name="fsearch" action="" method="POST">
    				<div class="">
      					<input id="search" type="search" name="textsd" oninput="preencheBusca()" required>
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