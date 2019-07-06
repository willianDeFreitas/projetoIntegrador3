<?php 
	session_start();

	require_once "../../classes/conexao.php";
    require_once "../../classes/trataDecimais.php";

	$c= new conectar();
    $trataDcimais = new TrataDecimais();

	$conexao=$c->conexao();

	$idFornecedor=$_POST['fornecedorCompra'];
	$idproduto=$_POST['produtoCompra'];
    $estoque=$_POST['estoqueV'];
	$unidade=$_POST['unidadeV'];

    $valorUnit = $trataDcimais->converteVirgulaEmPonto($_POST['precoV']);
    $qtdNegCPonto = $trataDcimais->converteVirgulaEmPonto($_POST['qtdNegV'], true);

    $totalItemCompra = $qtdNegCPonto * $valorUnit;

	$queBuscaNomeFornecedor="SELECT NOME
            FROM FORNECEDOR
            WHERE IDFORN =  '$idFornecedor'";

	$result=mysqli_query($conexao,$queBuscaNomeFornecedor);
	$f=mysqli_fetch_row($result);
	$nomeFornecedor=$f[0];

	$queBuscaNomeProduto="SELECT NOME
            FROM PRODUTO
            WHERE IDPROD = '$idproduto'";

	$result=mysqli_query($conexao,$queBuscaNomeProduto);
	$nomeproduto=mysqli_fetch_row($result)[0];

	$produto=$idproduto."||".
                $nomeproduto."||".
				$unidade."||".
				$valorUnit."||".
                $nomeFornecedor."||".
				$estoque."||".
				$qtdNegCPonto."||".
                $totalItemCompra."||".
				$idFornecedor;

	$_SESSION['tabelaCompraTemp'][]=$produto;

    $exiteEstoquista = "SELECT 1 FROM USUARIO WHERE IDACESSO = 3";

    $resultEst = mysqli_query($conexao, $exiteEstoquista);
    $existeEst = mysqli_fetch_row($resultEst);

    if(!$existeEst) {
        /*atualização do estoque no final da compra*/
        $quantNova = $estoque + $qtdNegCPonto;
        $queAtualizaEstoque = "UPDATE PRODUTO SET QTD = '$quantNova' WHERE IDPROD = '$idproduto' ";

        mysqli_query($conexao,$queAtualizaEstoque);
    }
 ?>