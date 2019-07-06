<?php
    require_once "../../classes/conexao.php";
    $obj = new conectar();
    $con = $obj->conexao();

    $sql = "SELECT U.IDUSU, U.NOME, U.EMAIL, A.NOMEACESSO 
            FROM USUARIO U
                INNER JOIN ACESSO A ON A.IDACESSO = U.IDACESSO";

    $result = mysqli_query($con,$sql);
?>
<div class="table-responsive-xl">
    <table class="table table-hover table-striped table-bordered" style="text-align: center; white-space: nowrap;">
        <thead class="thead-dark">
            <tr>
		        <th>Nome</th>
	 	        <th>Email</th>
	 	        <th>Setor</th>
	 	        <th style="width: 10%;">Editar</th>
	 	        <th style="width: 10%;">Excluir</th>
	        </tr>
        </thead>
	    <?php while($dado = mysqli_fetch_row($result)): ?>
            <tr>
                <td><?php echo $dado[1] ?></td>
                <td><?php echo $dado[2] ?></td>
                <td><?php echo $dado[3] ?></td>
                <td>
                    <span data-toggle="modal" data-target="#atualizaUsuarioModal" class="btn btn-warning btn-sm" onclick="editarUsuario('<?php echo $dado[0]; ?>')">
                        <span class="fas fa-edit"></span>
                    </span>
                </td>
                <td>
                    <span class="btn btn-danger btn-sm" onclick="excluirUsuario('<?php echo $dado[0] ?>')">
                        <span class="fas fa-trash-alt"></span>
                    </span>
                </td>
            </tr>
        <?php endWhile; ?>
    </table>
</div>