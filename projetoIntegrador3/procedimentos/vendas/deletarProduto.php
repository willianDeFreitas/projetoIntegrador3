<?php 

	session_start();
	$index=$_POST['ind'];

	/*com index do produto que está sendo deletado removemos o produto do array com todos os produtos já adicionados*/
	unset($_SESSION['tabelaVendaTemp'][$index]);
	$dados=array_values($_SESSION['tabelaVendaTemp']);

	unset($_SESSION['tabelaVendaTemp']);
	/*cria novo array sem a o produto que foi excluido*/
	$_SESSION['tabelaVendaTemp']=$dados;

 ?>