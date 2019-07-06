<?php
//inicia sessão para poder ser utilizada por um usuário logado
session_start();
//se existe uma sessão iniciada para o usuário X entra no if
if(isset($_SESSION['usuario'])){
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Início - Estoque de Produtos | Areia e Brita</title>
        <!-- insere o menu nessa página-->
        <?php require_once "menu.php"; ?>
    </head>
    <body>
        <ul><a href="inicio.php">Início</a> > Estoque de Produtos</ul>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h1 hidden>Estoque de Produtos</h1>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div id="estoqueProdutos"></div>
                </div>
            </div>
        </div>
    </body>
    </html>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#estoqueProdutos').load('produtos/estoque.php');
            $('#estoqueProdutos').show();
        });
    </script>
    <?php
}else{
    header("location:../index.php");
}
?>