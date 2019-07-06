<?php
session_start();

require_once "../../classes/trataDecimais.php";

$trataDecimais= new TrataDecimais();
?>
<br><br><br>
<div class="table-responsive-xl">
    <table class="table table-responsive-sm table-hover table-striped table-bordered" style="text-align: center; white-space: nowrap;">
        <caption>Lista de compras</caption>
        <thead class="thead-dark">
            <th>Produto</th>
            <th>Quantidade</th>
            <th>Unidade</th>
            <th>Valor</th>
            <th>Excluir</th>
        </thead>
        <?php
            $total=0;//total da compra
            if(isset($_SESSION['tabelaCompraTemp'])):
                $i=0;
                foreach (@$_SESSION['tabelaCompraTemp'] as $key) {

                    $d=explode("||", @$key);
                    ?>

                <tr>
                    <td><?php echo $d[1] ?></td>
                    <td><?php echo $trataDecimais->convertePontoEmVirgula($d[6], true) ?></td>
                    <td><?php echo $d[2] ?></td>
                    <td><?php echo "R$ ".$trataDecimais->convertePontoEmVirgula($d[3], true)?></td>
                    <td>
                        <span class="btn btn-danger btn-xs"
                              onclick="deletarProduto('<?php echo $i; ?>'), editarP('<?php echo $d[0]; ?>','<?php echo $d[6]; ?>')">
                            <span class="fas fa-trash-alt"></span>
                        </span>
                    </td>
                </tr>

                <?php
                    $total = $total + $d[7];
                    $i++;
            }
            endif;
        ?>

        <tr>
            <td colspan="5" style="text-align: right;">
                Total: <?php echo " R$ ".$trataDecimais->trataZeroPosVirgula($total) ?>
            </td>
        </tr>

    </table>
    <span class="btn btn-success" onclick="criarCompra()">
        <i class="fas fa-check"></i>
        Confirmar
    </span>

    <span class="btn btn-danger" onclick="limparCompras()">
        <span class="fas fa-trash-alt"></span>
        Limpar lista
    </span>
</div>
<br>