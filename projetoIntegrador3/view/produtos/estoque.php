<?php
require_once "../../classes/conexao.php";
require_once "../../classes/trataDecimais.php";

$c= new conectar();
$trataDecimais = new TrataDecimais();

$conexao=$c->conexao();

$sql="SELECT PRO.NOME,
            ROUND(PRO.QTD,2),
            PRO.VOL,
            ROUND(PRO.PRECO,2),
            CAT.NOME,
            PRO.IDPROD
	    FROM PRODUTO AS PRO
	        INNER JOIN CATEGORIA AS CAT ON PRO.IDCAT = CAT.IDCAT";

$result=mysqli_query($conexao,$sql);
?>


        <div class="table-responsive-xl">
            <table class="table table-responsive-sm table-hover table-striped table-bordered" style="text-align: center; white-space: nowrap;">
                <caption>Estoque de produtos</caption>
                <thead class="thead-dark">
                <tr>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Unidade</th>
                    <th>Categoria</th>
                </tr>
                </thead>

                <?php while($mostrar=mysqli_fetch_row($result)): ?>
                    <tr>
                        <td><?php echo $mostrar[0]; ?></td>
                        <td><!--Realiza tratativa para produtos com casas decimais-->
                            <?php echo $trataDecimais->convertePontoEmVirgula($trataDecimais->trataZeroPosVirgula($mostrar[1]), true) ?>
                        </td>
                        <td><?php echo $mostrar[2]; ?></td>
                        <td><?php echo $mostrar[4]; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>