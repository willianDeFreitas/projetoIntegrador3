<?php 
    require_once "../../classes/conexao.php";
    require_once "../../classes/compras.php";
    require_once "../../classes/trataDecimais.php";

    $c= new conectar();
    $conexao=$c->conexao();

    $objCompra = new compras();
    $trataDecimais= new TrataDecimais();

    $sql="SELECT IDCOMPRA, DATAREGC, IDFORN, ROUND(TOTALC,2) 
	    	FROM COMPRA GROUP BY IDCOMPRA";

    $result=mysqli_query($conexao,$sql);
?>
<div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-10">
        <h1 hidden>Compras Confirmadas</h1>
    </div>
    <div class="col-sm-1"></div>
</div>
<div class="row">
    <div class="col-sm-12">&nbsp;</div>
</div>
<div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-10">
        <div class="table-responsive-xl">
			<table class="table table-hover table-striped table-bordered" style="text-align: center;">
                <caption>Compras confirmadas</caption>
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Código</th>
                        <th scope="col">Data da Compra</th>
                        <th scope="col">Fornecedor</th>
                        <th scope="col">Vlr. Negociado</th>
                        <th scope="col">Comprovante</th>
                        <th scope="col">Relatório</th>
                    </tr>
                </thead>
		        <?php while($ver=mysqli_fetch_row($result)): ?>
				<tr>
					<td><?php echo $ver[0] ?></td>
					<td><?php echo date("d/m/Y", strtotime($ver[1])) ?></td>
					<td>
						<?php
							if($objCompra->nomeFornecedor($ver[2])==" "){
								echo "S/F";
							}else{
								echo $objCompra->nomeFornecedor($ver[2]);
							}
						 ?>
					</td>
					<td>
						<?php 
							echo "R$ ".$trataDecimais->convertePontoEmVirgula($trataDecimais->trataZeroPosVirgula($ver[3]), true);
						 ?>
					</td>
					<td>
						<a href="../procedimentos/compras/criarComprovantePdf.php?idcompra=<?php echo $ver[0] ?>" class="btn btn-warning btn-sm" target="_blank">
							<span class="fas fa-sticky-note"> Imprimir</span>
                        </a>
					</td>
					<td>
						<a href="../procedimentos/compras/criarRelatorioPdf.php?idcompra=<?php echo $ver[0] ?>" class="btn btn-warning btn-sm" target="_blank">
                            <span class="fas fa-file-alt"> Imprimir</span>
						</a>	
					</td>
				</tr>
		<?php endwhile; ?>
			</table>
		</div>
	</div>
	<div class="col-sm-1"></div>
</div>