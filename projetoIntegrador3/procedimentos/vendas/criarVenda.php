<?php 
	session_start();
	require_once "../../classes/conexao.php";
	require_once "../../classes/vendas.php";
	$c= new conectar();
	$obj= new vendas();

	if(count($_SESSION['tabelaVendaTemp'])==0){
		echo 0;
	}else{
		$result=$obj->criarVenda();
		unset($_SESSION['tabelaVendaTemp']);
		echo $result;
	}
 ?>