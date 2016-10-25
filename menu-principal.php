<nav class="navbar navbar-default navbar-static-top" role="navigation">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">
        <img src="imagens/logo.png" alt="Imagem do logo institucional da UFFS.">
      </a>
      <p class="navbar-text"><b>SGE - UFFS</b></p>
    </div>
    <div class="collapse navbar-collapse" id="menuprincipal">
      <ul class="nav navbar-nav">
        <?php
          if(isset($_SESSION['name'])) {
            echo '
            <li> <a href="buscas.php"><b>Movimentar Produtos</b></a> </li>
            <li class="dropdown">
              <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button"
              aria-haspopup="true" aria-expanded="false"><b>Cadastrar</b>
              <span class="caret"></span></a>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                <li><a href="produto.php?cadp=1">Cadastrar Produto</a></li>
                <li><a href="produto.php?cadg=1">Cadastrar Grupo</a></li>
                <li><a href="produto.php?cadl=1">Cadastrar Local</a></li>
              </ul>
            </li>
            <li> <a href="relatorios.php"><b>Relatórios</b></a> </li>';
            if($_SESSION['funcao']=='boss') {
              echo '<li> <a href="index.php?cad_user=1" onclick="cad_user();"><b>Cadastrar Novo Usuário</b></a> </li>';
            }
            echo '<li> <a href="index.php?logout=1"><b>Logout</b></a> </li>';
          } else {
            echo '<li> <a href="index.php"><b>Login</b></a> </li>';
          }
        ?>
      </ul>
      <?php
        if(isset($_SESSION['falta'])) {
          echo '<a href="index.php">' .
                '<span class="glyphicon glyphicon-warning-sign red big-icon" aria-hidden="true"></span>' .
                '</a> ';
        }
      ?>
    </div>
  </div>
</nav>
