<?php
    session_start();
    $iduser = $_SESSION['idUsu'];
    require_once "../../classes/conexao.php";
    require_once "../../classes/produtos.php";

    $obj = new produtos();

    $dados = array();

    $dados[0]=$_POST['categoriaSelect'];
    $dados[1]=$iduser;
    $dados[2]=$_POST['nome'];

    //tratativa caso o usuário insira vírgula no lugar de ponto
    $qtd=$_POST['quantidade'];
    $procuraVirgula = strpos($qtd, ",");
    if ($procuraVirgula === false) {
        $dados[3] = $qtd;
    } else {
        $dados[3] = str_replace(",", ".", $qtd);
    }

    $dados[4]=$_POST['unidade'];

    //tratativa caso o usuário insira vírgula no lugar de ponto
    $preco = $_POST['preco'];
    $procuraVirgula = strpos($preco, ",");
    if ($procuraVirgula === false) {
        $dados[5] = $preco;
    } else {
        $dados[5] = str_replace(",", ".", $preco);
    }

    echo $obj->inserirProduto($dados);
?>