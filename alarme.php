<!doctype html>
<html lang="pt-br" dir="ltr">
    <head>
        <title>JSON Ajax com jQuery</title>
    </head>
	<body> 
	<div id="teste"></div>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {

			    $.ajax({
			        url : "teste.php",
			        dataType : "json",
			        success : function(data){
			            var html = "";
			            for($i=0; $i < data.length; $i++){
			                html += 	"O produto <b>"+data[$i].nome +"</b> conta apenas com <b>"+ data[$i].valor;
			                html += "</b> unidades, a quantidade mínima é de <b>"+data[$i].minimo
			                html += "</b> unidades<br />";
			            }
			            $('#teste').html(html);
			        }
			    });
			});
		</script>
	</body>
</html>