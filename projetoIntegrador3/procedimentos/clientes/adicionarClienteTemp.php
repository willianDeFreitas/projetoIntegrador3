<?php 
	session_start();

	require_once "../../classes/conexao.php";

	$c= new conectar();
	$conexao=$c->conexao();

    if(count($_SESSION['tabelaClienteTemp'])!=0) {
        unset($_SESSION['tabelaClienteTemp']);
    }

	$nomeCliente=$_POST['nomeBuscaCliente'];

	$buscaCliente="SELECT IDCLI, NOME, ENDERECO, EMAIL, TEL, CPF 
            FROM CLIENTE
            WHERE NOME LIKE '%".$nomeCliente."%' ";

	$result=mysqli_query($conexao,$buscaCliente);
    while ($dadosCliente=mysqli_fetch_row($result)):

        $cliente=$dadosCliente[0]."||".
                    $dadosCliente[1]."||".
                    $dadosCliente[2]."||".
                    $dadosCliente[3]."||".
                    $dadosCliente[4]."||".
                    $dadosCliente[5];

        $_SESSION['tabelaClienteTemp'][]=$cliente;

	endwhile;
 ?>