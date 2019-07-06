<?php
	session_start();

    require_once "../../classes/conexao.php";
    require_once "../../classes/vendas.php";
    $c= new conectar();
    $obj= new vendas();

    $idVenda=$_POST['ind'];

    echo $obj->marcaVendaConferida($idVenda);
 ?>