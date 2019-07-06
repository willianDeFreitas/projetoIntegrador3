<?php
    session_start();
    if(isset($_SESSION['usuario'])){
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Central de Vendas | Areia e Brita</title>
        <?php require_once "menu.php"; ?>
    </head>
    <body>
        <ul>Gestão de Produtos > <a href="vendas.php"> Central de Vendas</a></ul>
        <div class="container">
            <div class="row">
                <div class="col-sm-12" align="center">
                    <span class="btn btn-primary" id="vendaProdutosBtn">
                        Vender Produto
                    </span>
                    <span class="btn btn-primary" id="vendasFeitasBtn">
                        Vendas efetuadas
                    </span>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div id="vendaProdutos"></div>
                    <div id="vendasFeitas"></div>
                </div>
            </div>
        </div>
    </body>
    </html>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#vendaProdutosBtn').click(function(){
                esconderSessaoVenda();
                $('#vendaProdutos').load('vendas/vendasDeProdutos.php');
                $('#vendaProdutos').show();
            });
            $('#vendasFeitasBtn').click(function(){
                esconderSessaoVenda();
                $('#vendasFeitas').load('vendas/vendasRelatorios.php');
                $('#vendasFeitas').show();
            });
        });

        function esconderSessaoVenda(){
            $('#vendaProdutos').hide();
            $('#vendasFeitas').hide();
        }
    </script>
    <?php
}else{
    header("location:../index.php");
}
?>