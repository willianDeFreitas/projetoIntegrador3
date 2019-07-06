<?php 
	require_once "../../classes/conexao.php";
	require_once "../../classes/compras.php";
    require_once "../../classes/trataDecimais.php";

	$c= new conectar();
    $objc= new compras();
    $objTrataDecimais = new TrataDecimais();

    $conexao=$c->conexao();

	$idCompra=$_GET['idcompra'];

    $sql="SELECT C.IDCOMPRA,
                C.DATAREGC, 
                C.IDFORN, 
                P.NOME, 
                P.PRECO, 
                P.VOL
        FROM COMPRA AS C
        INNER JOIN ITEMCOMPRA AS IC ON IC.IDCOMPRA = C.IDCOMPRA
        INNER JOIN PRODUTO AS P ON IC.IDPROD = P.IDPROD
        WHERE C.IDCOMPRA = '$idCompra'";

    $result=mysqli_query($conexao,$sql);
	$ver=mysqli_fetch_row($result);

	$comp=$ver[0];
	$data=$ver[1];
	$idForn=$ver[2];
 ?>
 	<style type="text/css">
        @page {
            margin-top: 0.3em;
            margin-left: 0.6em;
        }
        body{
            font-size: xx-small;
        }
	</style>
 		<p>Vendas</p>
 		<p>
 			Data: 
 			<?php echo date("d/m/Y", strtotime($data)) ?>
 		</p>
 		<p>
 			Comprovante: <?php echo $comp ?>
 		</p>
 		<p>
 			Fornecedor: <?php echo $objc->nomeFornecedor($idForn); ?>
 		</p>
 		
 		<table style="border-collapse: collapse;" border="1" width="145px">
 			<tr>
 				<td>Produto</td>
 				<td>Preço</td>
 				<td>Quantidade</td>
 			</tr>
 			<?php 
 				$sql="SELECT C.IDCOMPRA, 
                            C.DATAREGC, 
                            C.IDFORN, 
                            P.NOME, 
                            P.PRECO, 
                            P.VOL, 
                            ROUND(IC.QTDITEMC,2), 
                            ROUND(C.TOTALC,2)
                    FROM COMPRA AS C 
                    INNER JOIN ITEMCOMPRA AS IC ON IC.IDCOMPRA = C.IDCOMPRA
                    INNER JOIN PRODUTO AS P ON IC.IDPROD = P.IDPROD
                    WHERE C.IDCOMPRA = '$idCompra'";

				$result=mysqli_query($conexao,$sql);
				$total=0;
				while($mostrar=mysqli_fetch_row($result)){
 			 ?>
 			<tr>
 				<td><?php echo $mostrar[3]; ?></td>
 				<td><?php echo "R$ ".$objTrataDecimais->convertePontoEmVirgula($mostrar[4]) ?></td>
 				<td><?php echo $objTrataDecimais->convertePontoEmVirgula($mostrar[6], false) ?></td>
 			</tr>
 			<?php
                    $total = $mostrar[7];
 				} 
 			 ?>
 			 <tr>
 			 	<td colspan="3">Total: <?php echo "R$ ".$objTrataDecimais->convertePontoEmVirgula($total, false) ?></td>
 			 </tr>
 		</table>