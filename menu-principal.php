<div id="top-bar" style='background-color:#009933; padding: 1% 5% 1% 3%;'>
  <img src="imagens/IdentidadeVisual.png" style="height:80px; padding-right: 3%;"/>
  <a href="buscas.php"><button class="btn btn-lg btn-default">Movimentar Produtos</button></a>

  <select class="btn btn-lg btn-default" name="cadastro" onchange="location = this.value;">
    <option value="" selected>Cadastros</option>
    <option value="produto.php?cadp=1">Cadastrar Produto</option>
    <option value="produto.php?cadg=1">Cadastrar Grupo</option>
    <option value="produto.php?cadl=1">Cadastrar Local</option>
  </select>

  <a href="buscas.php"><button class="btn btn-lg btn-default">Buscar por Produtos</button></a>
  <a href="relatorios.php"><button class="btn btn-lg btn-default">Relatórios de Produtos</button></a>
  <a href="index.php?logout=1"><button class="btn btn-lg btn-default">Logout</button></a>
  <?php if(isset($_SESSION['funcao']) && $_SESSION['funcao']=='boss')echo '<a href="index.php?cad_user=1"><button class="btn btn-lg btn-default" onClick="cad_user();">Cadastrar Novo Usuário</button></a>';
    if(isset($_SESSION['falta']))echo '<a href="index.php"><button><img src="imagens/alarme.png" style="height:20px;"/></button></a>';
  ?>
</div>
