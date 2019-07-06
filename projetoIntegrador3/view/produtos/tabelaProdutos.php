<?php
    session_start();

    require_once "../../classes/conexao.php";
    require_once "../../classes/trataDecimais.php";

    $c= new conectar();
    $trataDecimais= new TrataDecimais();

    $conexao=$c->conexao();

    $sql="SELECT PRO.NOME,
            PRO.QTD,
            PRO.VOL,
            PRO.PRECO,
            CAT.NOME,
            PRO.IDPROD
	    FROM PRODUTO AS PRO
	        INNER JOIN CATEGORIA AS CAT ON PRO.IDCAT = CAT.IDCAT";

    $result=mysqli_query($conexao,$sql);
?>
<div class="table-responsive-xl">
<table class="table table-hover table-striped table-bordered" style="text-align: center; white-space: nowrap;">
    <caption>Produtos do Estoque</caption>
    <thead class="thead-dark">
        <tr>
            <th>Nome</th>

            <th>Estoque</th>

            <th>Unidade</th>
            <?php if($_SESSION['nivelAcesso'] == 99 || $_SESSION['nivelAcesso'] == 2): ?>
                <th>Vlr. Unit.</th>
            <?php endif; ?>

            <th>Categoria</th>

            <?php if($_SESSION['nivelAcesso'] == 99 || $_SESSION['nivelAcesso'] == 3): ?>
                <th>Conferência</th>
            <?php endif; ?>

            <?php if($_SESSION['nivelAcesso'] == 99 || $_SESSION['nivelAcesso'] == 2): ?>
                <th>Editar</th>
            <?php endif; ?>

            <?php if($_SESSION['nivelAcesso'] == 99): ?>
                <th>Excluir</th>
            <?php endif; ?>
        </tr>
    </thead>

    <?php while($mostrar=mysqli_fetch_row($result)): ?>
        <tr>
            <td><?php echo $mostrar[0]; ?></td>
            <td><?php echo $trataDecimais->convertePontoEmVirgula($mostrar[1],true) ?></td>
            <td><?php echo $mostrar[2]; ?></td>
            <?php if($_SESSION['nivelAcesso'] == 99 || $_SESSION['nivelAcesso'] == 2): ?>
                <td><?php echo $trataDecimais->convertePontoEmVirgula($mostrar[3],true) ?></td>
            <?php endif; ?>
            <td><?php echo $mostrar[4]; ?></td>
            <?php if($_SESSION['nivelAcesso'] == 99 || $_SESSION['nivelAcesso'] == 3): ?>
            <td>
			    <span  data-toggle="modal"
                       data-target="#abremodalConferenciaProduto"
                       class="btn btn-warning btn-xs"
                       onclick="coferenciaProduto('<?php echo $mostrar[5] ?>')">
				    <span class="fas fa-clipboard-check"></span>
			    </span>
            </td>
            <?php endif; ?>

            <?php if($_SESSION['nivelAcesso'] == 99 || $_SESSION['nivelAcesso'] == 2): ?>
            <td>
			    <span  data-toggle="modal"
                       data-target="#abremodalUpdateProduto"
                       class="btn btn-warning btn-xs"
                       onclick="editarProduto('<?php echo $mostrar[5] ?>')">
				<span class="fas fa-edit"></span>
			</span>
            </td>
            <?php endif; ?>
            <?php if($_SESSION['nivelAcesso'] == 99): ?>
            <td>
			    <span class="btn btn-danger btn-xs" onclick="excluirProduto('<?php echo $mostrar[5] ?>')">
				<span class="fas fa-trash-alt"></span>
			</span>
            </td>
            <?php endif; ?>
        </tr>
    <?php endwhile; ?>
</table>
</div>