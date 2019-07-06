<?php

require_once "../../classes/conexao.php";
require_once "../../classes/produtos.php";

$obj = new produtos();

    //tratativa caso o usuário insira vírgula no lugar de ponto
    $qtd = $_POST['qtdConf'];
    $procuraVirgula = strpos($qtd, ",");
    if ($procuraVirgula === false) {
        $quantidadeU = $qtd;
    } else {
        $quantidadeU = str_replace(",", ".", $qtd);
    }


    $dados = array(
        $_POST['idProdutoConf'],
        $_POST['tipoMov'],
        $_POST['comprovanteU'],
        $quantidadeU
    );

    echo $obj->conferirProdutos($dados);
?>