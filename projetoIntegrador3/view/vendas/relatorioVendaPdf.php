<?php
require_once "../../classes/conexao.php";
require_once "../../classes/vendas.php";
require_once "../../classes/trataDecimais.php";

$trataDecimais= new TrataDecimais();
$objv= new vendas();
$c= new conectar();

$conexao=$c->conexao();

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
<link rel="stylesheet" type="text/css" href="../../lib/bootstrap/css/bootstrap.css">
<img src="../../img/logo1.jpeg" width="200" height="200">
<br>
<table class="table">
    <tr>
        <td>Data:
            <?php echo date("d/m/Y", strtotime($data)) ?>
        </td>
    </tr>
    <tr>
        <td>Id. da Venda: <?php echo $comp ?></td>
    </tr>
    <tr>
        <td>Cliente: <?php echo $objv->nomeCliente($idcliente); ?></td>
    </tr>
</table>
<table class="table">
    <tr>
        <td>Produto</td>
        <td>Preço</td>
        <td>Quantidade</td>
        <td>Unidade</td>
    </tr>
    <?php
    $sql="SELECT V.IDVENDA, 
                V.DATAREGV, 
                V.IDCLI, 
                P.NOME, 
                ROUND(P.PRECO,2), 
                P.VOL, 
                ROUND(IV.QTDITEMV,2), 
                ROUND(V.TOTALV,2)
        FROM VENDA AS V 
              INNER JOIN ITEMVENDA AS IV ON IV.IDVENDA = V.IDVENDA
              INNER JOIN PRODUTO AS P ON IV.IDPROD = P.IDPROD
        WHERE V.IDVENDA = '$idvenda'";

    $result=mysqli_query($conexao,$sql);
    $total=0;
    while($mostrar=mysqli_fetch_row($result)):
        ?>
        <tr>
            <td><?php echo $mostrar[3] ?></td>
            <td><?php echo "R$ ".$trataDecimais->convertePontoEmVirgula($mostrar[4]) ?></td>
            <td><?php echo $trataDecimais->convertePontoEmVirgula($mostrar[6]) ?></td>
            <td><?php echo $mostrar[5] ?></td>
        </tr>
        <?php
        $total = $mostrar[7];
    endwhile;
    ?>
    <tr>
        <td colspan="4">Total  <?php echo "R$ ".$trataDecimais->convertePontoEmVirgula($total) ?></td>
    </tr>
</table>