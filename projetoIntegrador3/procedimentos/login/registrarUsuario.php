<?php
    require_once "../../classes/conexao.php";
    require_once "../../classes/usuarios.php";

    $obj = new usuarios();

    $senha = sha1($_POST['senha']);
    $nivelAcesso = $_POST['setor'];

    if ($nivelAcesso != null){
        $idAcesso = $nivelAcesso;
    }else{
        $idAcesso = 1;
    };

    $dadosCadastrais = array(
        $_POST['nome'],
        $_POST['email'],
        $idAcesso,
        $senha
    );

    echo $obj->gravaUsuario($dadosCadastrais);
?>