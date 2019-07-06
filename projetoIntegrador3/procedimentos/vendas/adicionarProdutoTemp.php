<?php 
	session_start();

	require_once "../../classes/conexao.php";
    require_once "../../classes/trataDecimais.php";

	$c= new conectar();
    $trataDcimais = new TrataDecimais();

	$conexao=$c->conexao();

	$idcliente=$_POST['clienteVenda'];
	$idproduto=$_POST['produtoVenda'];
    $estoque = $_POST['estoqueV'];
	$unidade=$_POST['unidadeV'];

    $valorUnit = $trataDcimais->converteVirgulaEmPonto($_POST['precoV']);
    $qtdNegCPonto = $trataDcimais->converteVirgulaEmPonto($_POST['qtdNegV'], true);

	$totalItemVenda = $qtdNegCPonto * $valorUnit;

	$queBuscaNomeCliente="SELECT NOME
            FROM CLIENTE
            WHERE IDCLI =  '$idcliente'";

	$result=mysqli_query($conexao,$queBuscaNomeCliente);
	$c=mysqli_fetch_row($result);
	$ncliente=$c[0];

    $queBuscaNomeProduto="SELECT NOME
            FROM PRODUTO
            WHERE IDPROD = '$idproduto'";

	$result=mysqli_query($conexao,$queBuscaNomeProduto);
	$nomeproduto=mysqli_fetch_row($result)[0];

	$produto=$idproduto."||".
                $nomeproduto."||".
				$unidade."||".
                $valorUnit."||".
				$ncliente."||".
				$estoque."||".
                $qtdNegCPonto."||".
				$totalItemVenda."||".
				$idcliente;

	$_SESSION['tabelaVendaTemp'][]=$produto;

	$exiteEstoquista = "SELECT 1 FROM USUARIO WHERE IDACESSO = 3";

	$resultEst = mysqli_query($conexao, $exiteEstoquista);
	$existeEst = mysqli_fetch_row($resultEst);

    if(!$existeEst) {
        /*atualização do estoque no final da venda*/
        $quantNova = $estoque - $qtdNegCPonto;
        $queAtualizaEstoque = "UPDATE PRODUTO SET QTD = '$quantNova' WHERE IDPROD = '$idproduto' ";

        mysqli_query($conexao, $queAtualizaEstoque);
    }
 ?>