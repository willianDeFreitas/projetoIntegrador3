<?php

require_once "../../classes/conexao.php";
require_once "../../classes/fornecedores.php";

$obj = new fornecedores();

echo json_encode($obj->obterDadosFornecedores($_POST['idFornecedor']));

?>