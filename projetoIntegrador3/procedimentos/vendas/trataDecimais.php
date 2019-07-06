<?php
    session_start();

	require_once "../../classes/conexao.php";
	require_once "../../classes/trataDecimais.php";

	$trataDecimais= new TrataDecimais();

	$trataDecimais->convertePontoVirgula();

?>