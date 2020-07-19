<?php
//session_start();
// Verificador de sessão 
require "php/verificar.php"; 

?>

<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
    <link rel="icon" href="icon.png">

    <title>Listar extintores - S.I.C.E.</title>
      
  </head>

  <body>

    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-danger">
      <a class="navbar-brand" href="conta_index.php"><img src="logo.png" width="170" height="50" alt=""></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="conta_perfil.php"><i class="fa fa-user" aria-hidden="true"></i> <?php echo $_SESSION['nome']; ?> <span class="sr-only"></span></a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Extintores</a>
            <div class="dropdown-menu" aria-labelledby="dropdown01">
              <a class="dropdown-item" href="cadastro_extintor.php">Adicionar</a>
              <a class="dropdown-item" href="listar_extintor.php">Listar todos</a>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Fichas de inspeção</a>
            <div class="dropdown-menu" aria-labelledby="dropdown01">
              <a class="dropdown-item" href="cadastro_ficha.php">Gerar</a>
              <a class="dropdown-item" href="listar_ficha.php">Listar todos</a>
            </div>
          </li>
        <li class="nav-item active">
            <a class="nav-link navbar-right" href="relatorio.php"> Relatório <span class="sr-only"></span></a>
          </li>
        <li class="nav-item active">
        <li class="nav-item active">
            <a class="nav-link navbar-right" href="php/destruir.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Sair <span class="sr-only"></span></a>
          </li>
        </ul>
        <form class="form-inline my-2 my-lg-0" method="post" action="procurar_inmetro.php">
          <input class="form-control mr-sm-2" type="text" placeholder="Selo INMETRO" aria-label="Search" name="selo_inmetro">
          <button class="btn btn-outline-secondary my-2 my-sm-0" style="color: white; border-color: white;" type="submit">Procurar</button>
        </form>
      </div>
    </nav>

    <main role="main">

      <!-- Main jumbotron for a primary marketing message or call to action -->
      <div class="jumbotron">
        <div class="container">
            <br><br><br>
          <h1 class="display-5">Procurar extintor</h1>
        </div>
      </div>

      <div class="container">
        
          
          <?php
          include ("php/conexao.php");
          $idUsuario = $_SESSION['idUsuario'];
          $selo_inmetro = $_POST['selo_inmetro'];
          $sql = "SELECT selo_inmetro, tipo_extintor, DATE_FORMAT(ult_recarga,'%d/%m/%Y'), DATE_FORMAT(vencimento,'%d/%m/%Y') FROM extintor WHERE selo_inmetro = '$selo_inmetro' AND idUsuario = '$idUsuario'";
          $result = mysqli_query($conexao, $sql);
          
          echo "<table class='table'>
                <thead class='thead-light'>
                <tr>
                    <th scope='col'>Selo INMETRO</th>
                    <th scope='col'>Tipo de Extintor</th>
                    <th scope='col'>Última recarga</th>
                    <th scope='col'>Vencimento</th>
                    <th scope='col'></th>
                </tr>
                </thead>";
          
          while($item=mysqli_fetch_array($result)) {   
              
              $selo_inmetro = $item['selo_inmetro'];
              $tipo_extintor = $item['tipo_extintor'];
              $ult_recarga = $item["DATE_FORMAT(ult_recarga,'%d/%m/%Y')"];
              $vencimento = $item["DATE_FORMAT(vencimento,'%d/%m/%Y')"];
              
              if (($tipo_extintor) == "agua") {
                  $tipo_extintor = "Água";
              } elseif (($tipo_extintor) == "co2") {
                  $tipo_extintor = "Dióxido de Carbono (CO2)";
              } elseif (($tipo_extintor) == "pqs") {
                  $tipo_extintor = "Pó Químico Seco (PQS)";
              }
              
         echo"<tbody>
              <tr>
                <form method='post' action='ver_extintor.php'>
                <th scope='row'>$selo_inmetro</th>
                <td>$tipo_extintor</td>
                <td>$ult_recarga</td>
                <td>$vencimento</td>
                <input type='hidden' name='selo_inmetro' value='$selo_inmetro'>
                <td><button type='submit' class='btn btn-secondary btn-sm' name='operacao' value='listar'>Detalhes</button>
                    <button type='submit' class='btn btn-danger btn-sm' name='operacao' value='excluir'>Excluir</button></td>
                </form>
              </tr>
             </tbody>";
          }
          echo "</table>";
          ?>
        <br><hr>

      </div> <!-- /container -->

    </main>

    <footer class="container">
      <p>&copy; S.I.C.E. 2017-2018</p>
    </footer>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="../../../../assets/js/vendor/popper.min.js"></script>
    <script src="../../../../dist/js/bootstrap.min.js"></script>
  </body>
</html>
