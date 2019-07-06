<?php 
	session_start();

	require_once "../../classes/conexao.php";

	$c= new conectar();
	$conexao=$c->conexao();

    if(count($_SESSION['tabelaFornecedorTemp'])!=0) {
        unset($_SESSION['tabelaFornecedorTemp']);
    }

	$nomeFornecedor=$_POST['nomeBuscaFornecedor'];

	$buscaFornecedor="SELECT IDFORN, NOME, ENDERECO, EMAIL, TEL, CNPJ 
            FROM FORNECEDOR
            WHERE NOME LIKE '%".$nomeFornecedor."%' ";

	$result=mysqli_query($conexao,$buscaFornecedor);
    while ($dadosFornecedor=mysqli_fetch_row($result)):

        $fornecedor=$dadosFornecedor[0]."||".
                    $dadosFornecedor[1]."||".
                    $dadosFornecedor[2]."||".
                    $dadosFornecedor[3]."||".
                    $dadosFornecedor[4]."||".
                    $dadosFornecedor[5];

        $_SESSION['tabelaFornecedorTemp'][]=$fornecedor;

	endwhile;
 ?>