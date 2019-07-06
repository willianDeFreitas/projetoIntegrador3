<?php
session_start();
if(isset($_SESSION['usuario'])){
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Conferência de Entrada | Areia e Brita</title>
        <?php require_once "menu.php"; ?>
    </head>
    <body>
    <ul>Gestão de Produtos > <a href="conferenciaEntrada.php"> Conferências de Entrada</a></ul>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div id="conferenciaEntrada"></div>
            </div>
        </div>
    </div>
    </body>
    </html>
    <script type="text/javascript">
            $('#conferenciaEntrada').load('compras/conferenciaDeEntrada.php');
            $('#conferenciaEntrada').show();
    </script>
    <script type="text/javascript">
        function marcarConferido(idCompra){
            alertify.confirm("Areia e Brita",'Deseja conferir esta compra?', function(){
                $.ajax({
                    type:"POST",
                    data:"ind=" + idCompra,
                    url:"../procedimentos/compras/marcarConferidoEntrada.php",
                    success:function(r){
                        if(r==1){
                            $('#conferenciaEntrada').load('compras/conferenciaDeEntrada.php');
                            alertify.success("Conferência iniciada com sucesso, comece a entrada no estoque!");
                        }else{
                            alertify.error("Conferência não pode ser iniciada! Verifique a compra com comercial.");
                        }
                    }
                });
            }, function(){
                alertify.error('Cancelado.')
            });
        }
    </script>

    <?php
}else{
    header("location:../index.php");
}
?>