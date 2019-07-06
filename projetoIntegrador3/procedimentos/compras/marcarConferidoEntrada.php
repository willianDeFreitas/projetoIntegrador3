<?php
	session_start();

    require_once "../../classes/conexao.php";
    require_once "../../classes/compras.php";

    $c= new conectar();
    $obj= new compras();

    $idCompra=$_POST['ind'];

    echo $obj->marcaCompraConferida($idCompra);
 ?>