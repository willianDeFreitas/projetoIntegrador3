<?php
    session_start();
    require_once "../../classes/conexao.php";
    require_once "../../classes/fornecedores.php";

    $idusuario = $_SESSION['idUsu'];
    $nome = $_POST['nome'];
    $endereco = $_POST['endereco'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $cnpj = $_POST['cnpj'];

    $obj = new fornecedores();

    $dados = array(
        $idusuario,
        $nome,
        $endereco,
        $email,
        $telefone,
        $cnpj
    );

    echo $obj->adicionarFornecedor($dados);
?>