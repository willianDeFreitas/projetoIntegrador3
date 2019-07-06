<?php
    session_start();
    require_once "../../classes/conexao.php";
    require_once "../../classes/clientes.php";

    $idusuario = $_SESSION['idUsu'];
    $nome = $_POST['nome'];
    $endereco = $_POST['endereco'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $cpf = $_POST['cpf'];

    $obj = new clientes();

    $dados = array(
        $idusuario,
        $nome,
        $endereco,
        $email,
        $telefone,
        $cpf
    );

    echo $obj->adicionarCliente($dados);
?>