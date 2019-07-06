<?php 
	require_once "../../classes/conexao.php";
	require_once "../../classes/vendas.php";
    require_once "../../classes/trataDecimais.php";

	$c= new conectar();
	$conexao=$c->conexao();

    $objv= new vendas();
    $objTrataDecimais = new TrataDecimais();

	$idvenda=$_GET['idvenda'];

    $sql="SELECT V.IDVENDA,
                V.DATAREGV, 
                V.IDCLI, 
                P.NOME, 
                P.PRECO, 
                P.VOL
        FROM VENDA AS V
        INNER JOIN ITEMVENDA AS IV ON IV.IDVENDA = V.IDVENDA
        INNER JOIN PRODUTO AS P ON IV.IDPROD = P.IDPROD
        WHERE V.IDVENDA = '$idvenda'";

    $result=mysqli_query($conexao,$sql);
	$ver=mysqli_fetch_row($result);

	$comp=$ver[0];
	$data=$ver[1];
	$idcliente=$ver[2];
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
 			Cliente: <?php echo $objv->nomeCliente($idcliente); ?>
 		</p>
 		
 		<table style="border-collapse: collapse;" border="1" width="145px">
 			<tr>
 				<td>Produto</td>
 				<td>Preço</td>
 				<td>Quantidade</td>
 			</tr>
 			<?php 
 				$sql="SELECT V.IDVENDA, 
                            V.DATAREGV, 
                            V.IDCLI, 
                            P.NOME, 
                            P.PRECO, 
                            P.VOL, 
                            ROUND(IV.QTDITEMV,2), 
                            ROUND(V.TOTALV,2)
                    FROM VENDA AS V 
                    INNER JOIN ITEMVENDA AS IV ON IV.IDVENDA = V.IDVENDA
                    INNER JOIN PRODUTO AS P ON IV.IDPROD = P.IDPROD
                    WHERE V.IDVENDA = '$idvenda'";

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