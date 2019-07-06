<?php
require_once "../../classes/conexao.php";
require_once "../../classes/compras.php";
require_once "../../classes/trataDecimais.php";

$trataDecimais= new TrataDecimais();
$objc = new compras();
$c= new conectar();

$conexao=$c->conexao();

$idcompra=$_GET['idcompra'];

$sql="SELECT C.IDCOMPRA, 
            C.DATAREGC, 
            C.IDFORN, 
            P.NOME, 
            P.PRECO, 
            P.VOL
        FROM COMPRA AS C 
        INNER JOIN ITEMCOMPRA AS IC ON IC.IDCOMPRA = C.IDCOMPRA
        INNER JOIN PRODUTO AS P ON IC.IDPROD = P.IDPROD
        WHERE C.IDCOMPRA = '$idcompra'";

$result=mysqli_query($conexao,$sql);
$ver=mysqli_fetch_row($result);
$comp=$ver[0];
$data=$ver[1];
$idForn=$ver[2];
?>
<link rel="stylesheet" type="text/css" href="../../lib/bootstrap/css/bootstrap.css">
<br>
<table class="table">
    <tr>
        <td>Data:
            <?php echo date("d/m/Y", strtotime($data)) ?>
        </td>
    </tr>
    <tr>
        <td>Identificador da Compra: <?php echo $comp ?></td>
    </tr>
    <tr>
        <td>Cliente: <?php echo $objc->nomeFornecedor($idForn); ?></td>
    </tr>
</table>
<table class="table">
    <tr>
        <td>Produto</td>
        <td>Quantidade</td>
        <td>Unidade</td>
    </tr>
    <?php
    $sql="SELECT C.IDCOMPRA, 
                C.DATAREGC, 
                C.IDFORN, 
                P.NOME, 
                ROUND(P.PRECO,2), 
                P.VOL, 
                ROUND(IC.QTDITEMC,2), 
                ROUND(C.TOTALC,2)
        FROM COMPRA AS C 
              INNER JOIN ITEMCOMPRA AS IC ON IC.IDCOMPRA = C.IDCOMPRA
              INNER JOIN PRODUTO AS P ON IC.IDPROD = P.IDPROD
        WHERE C.IDCOMPRA = '$idcompra'";

    $result=mysqli_query($conexao,$sql);
    $total=0;
    while($mostrar=mysqli_fetch_row($result)):
        ?>
        <tr>
            <td><?php echo $mostrar[3] ?></td>
            <td><?php echo $trataDecimais->convertePontoEmVirgula($mostrar[6]) ?></td>
            <td><?php echo $mostrar[5] ?></td>
        </tr>
        <?php
    endwhile;
    ?>
</table>