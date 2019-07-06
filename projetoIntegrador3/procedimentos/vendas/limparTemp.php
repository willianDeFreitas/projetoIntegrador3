<?php
    session_start();

	require_once "../../classes/conexao.php";
	require_once "../../classes/vendas.php";

	$c= new conectar();
	$obj= new vendas();

	if(count($_SESSION['tabelaVendaTemp'])==0){
		echo "Não há lista de venda de produtos. Crie uma lista de venda, preenchendo o formulário.";

	}else{
		$result=$obj->deletaListaItensVenda();
		unset($_SESSION['tabelaVendaTemp']);
		echo $result;

	}
?>