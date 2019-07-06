<?php
session_start();
if(isset($_SESSION['usuario'])){
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Conferência de Saída | Areia e Brita</title>
        <?php require_once "menu.php"; ?>
    </head>
    <body>
    <ul>Gestão de Produtos > <a href="conferenciaSaida.php"> Conferências de Saída</a></ul>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div id="conferenciaSaida"></div>
            </div>
        </div>
    </div>
    </body>
    </html>
    <script type="text/javascript">
            $('#conferenciaSaida').load('vendas/conferenciaDeSaida.php');
            $('#conferenciaSaida').show();
    </script>
    <script type="text/javascript">
        function marcarConferido(idVenda){
            alertify.confirm("Areia e Brita",'Deseja conferir esta venda?', function(){
                $.ajax({
                    type:"POST",
                    data:"ind=" + idVenda,
                    url:"../procedimentos/vendas/marcarConferidoSaida.php",
                    success:function(r){
                        if(r==1){
                            $('#conferenciaSaida').load('vendas/conferenciaDeSaida.php');
                            alertify.success("Conferência iniciada com sucesso, comece a baixa no estoque!");
                        }else{
                            alertify.error("Conferência não pode ser iniciada! Verifique a venda com comercial.");
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