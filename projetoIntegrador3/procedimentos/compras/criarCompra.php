<?php 
	session_start();

	require_once "../../classes/conexao.php";
	require_once "../../classes/compras.php";

	$c= new conectar();
	$obj= new compras();

	if(count($_SESSION['tabelaCompraTemp'])==0){
		echo 0;
	}else{
		$result=$obj->criarCompra();
		unset($_SESSION['tabelaCompraTemp']);
		echo $result;
	}
 ?>