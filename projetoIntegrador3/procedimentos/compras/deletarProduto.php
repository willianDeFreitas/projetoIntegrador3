<?php
	session_start();
	$index=$_POST['ind'];

	/*com index do produto que está sendo deletado removemos o produto do array com todos os produtos já adicionados*/
	unset($_SESSION['tabelaCompraTemp'][$index]);
	$dados=array_values($_SESSION['tabelaCompraTemp']);

	unset($_SESSION['tabelaCompraTemp']);
	/*cria novo array sem a o produto que foi excluido*/
	$_SESSION['tabelaCompraTemp']=$dados;
 ?>