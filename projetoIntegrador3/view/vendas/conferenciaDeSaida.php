<?php
require_once "../../classes/conexao.php";
require_once "../../classes/vendas.php";
require_once "../../classes/trataDecimais.php";

$c= new conectar();
$objVenda= new vendas();
$trataDecimais= new TrataDecimais();

$conexao=$c->conexao();

$sql="SELECT IDVENDA, DATAREGV, IDCLI, ROUND(TOTALV,2) 
	    	FROM VENDA
	    	WHERE CONFERIDO = 'N' 
	    	GROUP BY IDVENDA";

$result=mysqli_query($conexao,$sql);
?>
<div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-10">
        <h1 hidden>Conferência de Saída</h1>
    </div>
    <div class="col-sm-1"></div>
</div>
<div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-10">
        <div class="table-responsive-xl">
            <table class="table table-hover table-striped table-bordered" style="text-align: center;">
                <caption>Conferência de Saída</caption>
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Código</th>
                    <th scope="col">Data da Venda</th>
                    <th scope="col">Cliente</th>
                    <th scope="col">Relatório</th>
                    <th scope="col">Conferência</th>
                </tr>
                </thead>
                <?php while($ver=mysqli_fetch_row($result)): ?>
                    <tr>
                        <td><?php echo $ver[0] ?></td>
                        <td><?php echo date("d/m/Y", strtotime($ver[1])) ?></td>
                        <td>
                            <?php
                            if($objVenda->nomeCliente($ver[2])==" "){
                                echo "S/C";
                            }else{
                                echo $objVenda->nomeCliente($ver[2]);
                            }
                            ?>
                        </td>
                        <td>
                            <a href="../procedimentos/vendas/criarConferenciaPDF.php?idvenda=<?php echo $ver[0] ?>" class="btn btn-warning btn-sm" target="_blank">
                                <span class="fas fa-file-alt"> Imprimir</span>
                            </a>
                        </td>
                        <td>
                            <a href="../procedimentos/vendas/criarConferenciaPDF.php?idvenda=<?php echo $ver[0] ?>" target="_blank">
                                <span class="btn btn-success" onclick="marcarConferido('<?php echo $ver[0] ?>')">
                                    <i class="fas fa-check"></i>
                                    Iniciar
                                </span>
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>
    <div class="col-sm-1"></div>
</div>