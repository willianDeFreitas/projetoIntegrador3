<?php
    require_once "../../classes/conexao.php";
    require_once "../../classes/usuarios.php";

    $obj = new usuarios();

    $testaSenha = $_POST['senhaU'];

    if($testaSenha != ""){
        $senha = sha1($_POST['senhaU']);
    }else{
        $senha = " ";
    }


    $dados = array(
        $_POST['idUsuarioU'],
        $_POST['nomeU'],
        $_POST['emailU'],
        $senha,
        $_POST['setorU']
    );

    echo $obj->atualizarUsuario($dados);
?>