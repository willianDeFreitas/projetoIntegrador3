<?php
    require_once "../../classes/conexao.php";
    require_once "../../classes/compras.php";

    $obj = new compras();

    echo json_encode($obj->obterDadosProduto($_POST['idproduto']));
?>