<?php require_once "dependencias.php" ?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
<nav class="navbar fixed-top navbar-expand-md navbar-dark bg-dark">
    <a class="navbar-brand" href="inicio.php">
        <img class="rounded" src="../img/logo3.jpeg" alt="Logo do Sistema, o formato de uma casa com chaminé, escrito com os seguintes dizeres dentro da casa: Opções areia e brita" width="90px" height="90px">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#conteudoNavbarSuportado" aria-controls="conteudoNavbarSuportado" aria-expanded="false" aria-label="Alterna navegação">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="conteudoNavbarSuportado">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="inicio.php">
                    <span class="fa fa-home fa-fw"></span> Início
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="fas fa-warehouse"></span>
                    Gestão de Produtos
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <?php if($_SESSION['nivelAcesso'] == "99"): ?>
                    <a class="dropdown-item" href="categorias.php">
                        <span class="fas fa-sitemap"></span>
                        Categorias
                    </a>
                    <?php endif; ?>
                    <?php if($_SESSION['nivelAcesso'] == "99" || $_SESSION['nivelAcesso'] == "2"): ?>
                    <a class="dropdown-item" href="compras.php">
                        <span class="fas fa-dollar-sign"></span>
                        Central de Compras
                    </a>
                    <a class="dropdown-item" href="vendas.php">
                        <span class="fas fa-dollar-sign"></span>
                        Central de Vendas
                    </a>
                    <?php endif; ?>
                    <?php if($_SESSION['nivelAcesso'] == "99" || $_SESSION['nivelAcesso'] == "3"): ?>
                        <a class="dropdown-item" href="conferenciaEntrada.php">
                            <span class="fas fa-search"></span>
                            Conferência de Entrada
                        </a>
                        <a class="dropdown-item" href="conferenciaSaida.php">
                            <span class="fas fa-search"></span>
                            Conferência de Saída
                        </a>
                    <?php endif; ?>
                    <a class="dropdown-item" href="produtos.php">
                        <span class="fas fa-boxes"></span>
                        Produtos
                    </a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="fa fa-book fa-fw"></span>
                    Gestão de Pessoas
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="clientes.php">
                        <span class="fas fa-clipboard-list"></span>
                        Clientes
                    </a>
                    <a class="dropdown-item" href="fornecedores.php">
                        <span class="fas fa-clipboard-list"></span>
                        Fornecedores
                    </a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="fa fa-cog"></span>
                    Bem vindx, <?php echo $_SESSION['nomeUsuario']; ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <?php if($_SESSION['nivelAcesso'] == "99"): ?>
                        <a class="dropdown-item" href="usuarios.php">
                            <span class="fas fa-users"></span>
                            Gestão de Usuários
                        </a>
                    <?php endif; ?>
                    <a class="dropdown-item" href="../procedimentos/sair.php">
                        <i class='fas fa-power-off fa-fw' style='color:red'></i>
                        Sair
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>
</body>
</html>