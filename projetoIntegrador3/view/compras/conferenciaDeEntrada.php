<?php
require_once "../../classes/conexao.php";
require_once "../../classes/compras.php";
require_once "../../classes/trataDecimais.php";

$c= new conectar();
$objCompra= new compras();
$trataDecimais= new TrataDecimais();

$conexao=$c->conexao();

$sql="SELECT IDCOMPRA, DATAREGC, IDFORN, ROUND(TOTALC,2) 
	    	FROM COMPRA
	    	WHERE CONFERIDO = 'N' 
	    	GROUP BY IDCOMPRA";

$result=mysqli_query($conexao,$sql);
?>
<div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-10">
        <h1 hidden>Conferência de Entrada</h1>
    </div>
    <div class="col-sm-1"></div>
</div>
<div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-10">
        <div class="table-responsive-xl">
            <table class="table table-hover table-striped table-bordered" style="text-align: center;">
                <caption>Conferência de Entrada</caption>
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Código</th>
                    <th scope="col">Data da Compra</th>
                    <th scope="col">Fornecedor</th>
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
                            if($objCompra->nomeFornecedor($ver[2])==" "){
                                echo "S/C";
                            }else{
                                echo $objCompra->nomeFornecedor($ver[2]);
                            }
                            ?>
                        </td>
                        <td>
                            <a href="../procedimentos/compras/criarConferenciaPDF.php?idcompra=<?php echo $ver[0] ?>" class="btn btn-warning btn-sm" target="_blank">
                                <span class="fas fa-file-alt"> Imprimir</span>
                            </a>
                        </td>
                        <td>
                            <a href="../procedimentos/compras/criarConferenciaPDF.php?idcompra=<?php echo $ver[0] ?>" target="_blank">
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