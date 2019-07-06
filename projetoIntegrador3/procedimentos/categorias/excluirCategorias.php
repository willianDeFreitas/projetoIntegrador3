<?php

    require_once "../../classes/conexao.php";
    require_once "../../classes/categorias.php";

    $id = $_POST['idcategoria'];

    $obj = new categorias();
    $dados = $id;
    echo $obj->excluirCategoria($dados);
    
?>