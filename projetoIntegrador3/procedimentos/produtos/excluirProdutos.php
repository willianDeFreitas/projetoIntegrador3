<?php

require_once "../../classes/conexao.php";
require_once "../../classes/produtos.php";

$obj = new produtos();

$dados = $_POST['idProduto'];

echo $obj->excluirProduto($dados);
    
?>