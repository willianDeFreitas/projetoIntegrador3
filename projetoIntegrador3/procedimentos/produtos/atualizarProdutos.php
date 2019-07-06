<?php

require_once "../../classes/conexao.php";
require_once "../../classes/produtos.php";

$obj = new produtos();

    //tratativa caso o usuário insira vírgula no lugar de ponto
    $qtd = $_POST['quantidadeU'];
    $procuraVirgula = strpos($qtd, ",");
    if ($procuraVirgula === false) {
        $quantidadeU = $qtd;
    } else {
        $quantidadeU = str_replace(",", ".", $qtd);
    }

    //tratativa caso o usuário insira vírgula no lugar de ponto
    $preco = $_POST['precoU'];
    $procuraVirgula = strpos($preco, ",");
    if ($procuraVirgula === false) {
        $precoU = $preco;
    } else {
        $precoU = str_replace(",", ".", $preco);
    }

    $dados = array(
        $_POST['idProdutoU'],
        $_POST['categoriaSelectU'],
        $_POST['nomeU'],
        $_POST['unidadeU'],
        $quantidadeU,
        $precoU
    );

    echo $obj->atualizarProdutos($dados);
?>