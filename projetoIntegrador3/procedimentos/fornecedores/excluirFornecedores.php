<?php

require_once "../../classes/conexao.php";
require_once "../../classes/fornecedores.php";

$obj = new fornecedores();

$id = $_POST['idFornecedor'];
$dados = $id;
echo $obj->excluirFornecedor($dados);
    
?>