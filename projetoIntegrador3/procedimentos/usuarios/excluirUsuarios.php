<?php
    require_once "../../classes/conexao.php";
    require_once "../../classes/usuarios.php";

    $obj = new usuarios();

    $id = $_POST['idUsuario'];
    $dados = $id;

    echo $obj->excluirUsuario($dados);
?>