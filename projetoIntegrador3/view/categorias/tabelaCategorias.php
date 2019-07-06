<?php
    require_once "../../classes/conexao.php";
    $obj = new conectar();
    $conexao = $obj->conexao();

    $sql = "SELECT IDCAT, NOME FROM CATEGORIA";

    $result = mysqli_query($conexao,$sql);
?>
<div class="table-responsive-xl">
    <table class="table table-hover table-striped table-bordered" style="text-align: center; white-space: nowrap;">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Nome</th>
                <th scope="col" style="width: 10%;">Editar</th>
                <th scope="col" style="width: 10%;">Excluir</th>
            </tr>
        </thead>
	    <?php while($mostrar = mysqli_fetch_row($result)): ?>
            <tr>
                <td><?php echo $mostrar[1] ?></td>
                <td>
                    <span class="btn btn-warning btn-xs"
                          data-toggle="modal"
                          data-target="#atualizaCategoria"
                          onclick="editarCategoria('<?php echo $mostrar[0] ?>','<?php echo $mostrar[1] ?>')">
                        <span class="fas fa-edit"></span>
                    </span>
                </td>
                <td>
                    <span class="btn btn-danger btn-xs" onclick="excluirCategoria('<?php echo $mostrar[0] ?>')">
                        <span class="fas fa-trash-alt"></span>
                    </span>
                </td>
            </tr>
        <?php endWhile; ?>
    </table>
</div>