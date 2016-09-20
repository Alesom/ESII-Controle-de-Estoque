<?php
	require ("connect.php");
	
	if(!isset($_SESSION['name'])){
		header("Location:index.php");
	}	

	if(isset($_POST['confirma'])){
		$codp = $_POST['codigo'];
		$nome = $_POST['nome'];
		$qtdmin = $_POST['qtdmin'];
		$codl = $_POST['codlocal'];
		$codg = $_POST['codgrupo'];
		echo $codp.' x '. $codg.' x '. $codl.' x '. $qtdmin;
		if(isset($_POST['alarme']))
			$alarme = '1';
		else
			$alarme = '0';
		$sql = "UPDATE produto SET nome='$nome',qtdmin='$qtdmin',codg = '$codg', codl='$codl', alarm ='$alarme'  WHERE cod= '$codp'";
		$cons = mysqli_query($conexao ,$sql);
		if(!$cons){
		$_SESSION['msg']=$nome.' não pode ser configurado.<br/><p style="color:red;">Erro: '.mysqli_error($conexao).'</p>';
		}
		else
			$_SESSION['msg']=$nome." configurado com sucesso.";
	}
?>
<!DOCTYPE html>
<html>
<head> 
	<title>Formulário configuração</title> 
	<meta charset="utf-8" />
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
</head> 
<body>
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
	
	
	<div id="cadp" align="center">
	
		<label><b>Configurar Produto</b></label>
		<form action=<?echo '"configurar.php?prod='.$_GET['prod'].'"';?> method="post">	
			<?php if(isset($_GET['prod'])){					
					mysqli_next_result($conexao);
		    		$produto = $_GET['prod'];
					$busca= "SELECT * FROM produto WHERE cod = '$produto'";
					$resultado = mysqli_query($conexao,$busca);
					$dados = mysqli_fetch_array($resultado);
					$codp= $dados['cod'];
					$nome = $dados['nome'];
					$qtdademin= $dados['qtdmin'];
					$local = $dados['codl'];
					$grupo = $dados['codg'];
					$alarme = $dados['alarm'];
				}
			?>
		    Código do produto:<input type="text" name="codigo" readonly="readonly" <? echo 'value="'.$codp.'"';?> /><br/>
		    Nome do produto:<input type="text" name="nome" <? echo 'value="'.$nome.'"';?> /><br/>
			Quantidade minima:<input type="text" name="qtdmin" <? echo 'value="'.$qtdademin.'"';?> /><br/>
			Receber alarme quando a quantidade for menor ou igual a quantidade mínima:<input type="checkbox" name="alarme" value ='TRUE' <?if($alarme) echo'checked';?> /><br/>			

		    Código do Grupo:<select name="codgrupo">
				<option  <? echo 'value="'.$grupo.'"';?>> <? echo $grupo;?> </option>
				<?$sql= "SELECT * FROM grupo";
					$res = mysqli_query($conexao,$sql);
					while ($resu = mysqli_fetch_assoc($res))
						echo '<option value = "'.$resu['codg'].'">'.$resu['codg'].'</option>';
				?>
			</select><br/>
		  	Código do Local:<select name="codlocal">
				<option  <? echo 'value="'.$local.'"';?>> <? echo $local; ?></option>
				<?$sql= "SELECT * FROM local";
					$res = mysqli_query($conexao,$sql);
					while ($resu = mysqli_fetch_assoc($res))
						echo '<option value = "'.$resu['codl'].'">'.$resu['codl'].'</option>';
				?>
			</select><br/>
		 	<input type="submit" name="confirma" value="Confirmar"/><br/>
		</form> 
		<?if(isset($_SESSION['msg'])){echo $_SESSION['msg'];unset($_SESSION['msg']);}?>
	</div>
	<a href="buscas.php"><button><b>Nova Busca</b></button></a> 
</body>
</html>
