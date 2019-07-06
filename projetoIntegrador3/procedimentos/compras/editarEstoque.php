<?php
    require_once "../../classes/conexao.php";

	$c= new conectar();
	$conexao=$c->conexao();

    $idProduto = $_POST['idProd'];
	$qtd=$_POST['quantidadeDel'];

	$queBuscaQtdEstoque = "SELECT QTD
	                        FROM PRODUTO
	                        WHERE IDPROD = '$idProduto'";

	$result = mysqli_query($conexao, $queBuscaQtdEstoque);
	$qtdEstoque = mysqli_fetch_row($result);

    $qtdEstoqueAtualizada = $qtdEstoque[0] - $qtd;

	$queAtualizaEstoque = "UPDATE PRODUTO
                            SET QTD = '$qtdEstoqueAtualizada'
                            WHERE IDPROD = '$idProduto' ";

	mysqli_query($conexao,$queAtualizaEstoque);
 ?>