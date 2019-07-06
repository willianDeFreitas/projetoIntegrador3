<?php
    session_start();

	require_once "../../classes/conexao.php";
	require_once "../../classes/compras.php";

	$c= new conectar();
	$obj= new compras();

	if(count($_SESSION['tabelaCompraTemp'])==0){
		echo "Não há lista de compra de produtos. Crie uma lista de compra, preenchendo o formulário.";

	}else{
		$result=$obj->deletaListaItensCompra();
		unset($_SESSION['tabelaCompraTemp']);
		echo $result;

	}
?>