<?php
    session_start();
    if(isset($_SESSION['usuario'])){
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Central de Compras | Areia e Brita</title>
        <?php require_once "menu.php"; ?>
    </head>
    <body>
        <ul>Gestão de Produtos > <a href="compras.php"> Central de Compras</a></ul>
        <div class="container">
            <div class="row">
                <div class="col-sm-12" align="center">
                    <span class="btn btn-primary" id="compraProdutosBtn">
                        Comprar Produto
                    </span>
                    <span class="btn btn-primary" id="comprasFeitasBtn">
                        Compras efetuadas
                    </span>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div id="compraProdutos"></div>
                    <div id="compraFeitas"></div>
                </div>
            </div>
        </div>
    </body>
    </html>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#compraProdutosBtn').click(function(){
                esconderSessaoCompra();
                $('#compraProdutos').load('compras/comprasDeProdutos.php');
                $('#compraProdutos').show();
            });
            $('#comprasFeitasBtn').click(function(){
                esconderSessaoCompra();
                $('#compraFeitas').load('compras/comprasRelatorios.php');
                $('#compraFeitas').show();
            });
        });

        function esconderSessaoCompra(){
            $('#compraProdutos').hide();
            $('#compraFeitas').hide();
        }
    </script>
    <?php
}else{
    header("location:../index.php");
}
?>