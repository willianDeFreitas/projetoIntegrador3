<?php
    require_once "../../classes/conexao.php";
    require_once "../../classes/produtos.php";

    $obj = new produtos();

    echo json_encode($obj->obterDados($_POST['idproduto']));
?>