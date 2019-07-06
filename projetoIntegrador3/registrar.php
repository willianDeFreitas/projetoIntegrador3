<?php
    require_once "classes/conexao.php";
    $obj = new conectar();
    $conexao = $obj->conexao();

    $sql = "SELECT 1 
            FROM USUARIO U
                INNER JOIN ACESSO A ON A.IDACESSO = U.IDACESSO 
            WHERE A.NIVELACESSO = 99";

    $result = mysqli_query($conexao,$sql);

    $validar = 0;
    if(mysqli_num_rows($result) > 0){
        header("location:index.php");
    }
?>

<!DOCTYPE html>
<html>
<head>
	<title>Registrar Usuário</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" type="text/css" href="lib/bootstrap/css/bootstrap.css">
	<script src="lib/jquery-3.2.1.min.js"></script>
	<script src="js/funcoes.js"></script>

</head>
<body class="bg-info">
	<div class="container mt-5">
		<div class="row">
			<div class="col-sm-4"></div>
			<div class="col-sm-4 border border-warning rounded bg-white shadow-lg p-3 mb-5">
				<div class="panel panel-danger">
					<h3 class="text-center mt-3">Registrar Administrador</h3>
					<div class="panel panel-body">
						<form id="frmRegistro" class="form-signin">
							<label for="nome">Nome completo:</label>
							<input type="text" class="form-control" name="nome" id="nome" placeholder="Nome do administrador do sistema" required autofocus>

                            <label for="usuario">E-mail:</label>
							<input type="email" class="form-control" name="usuario" id="usuario" placeholder="digite um email" required>

                            <label for="email">Repita o E-mail:</label>
							<input type="email" class="form-control" name="email" id="email" placeholder="repita o email" required>

                            <label for="senha">Senha:</label>
							<input type="password" class="form-control" name="senha" id="senha" placeholder="senha(use letras e números)" required>

                            <div class="row"><div class="col-sm-12">&nbsp;</div></div>
                            <div class="float-right mb-3">
                                <a href="index.php" class="btn btn-warning">Login</a>
							    <span class="btn btn-primary" id="registro">Registrar</span>
                            </div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-sm-4"></div>
		</div>
	</div>
</body>
</html>

<script type="text/javascript">
	$(document).ready(function(){
		$('#registro').click(function(){
			vazios=validarFormVazio('frmRegistro');
			if(vazios > 0){
				alert("Preencha todos os campos!");
				return false;
			}

			dados=$('#frmRegistro').serialize();
			$.ajax({
				type:"POST",
				data:dados,
				url:"procedimentos/login/registrarUsuario.php",
				success:function(r){
					if(r==1){
                        alert("Inserido com Sucesso");
                        document.getElementById('frmRegistro').reset();
                        window.location.reload();
					}else{
						alert("Erro no cadastro do administrador");
					}
				}
			});
		});
	});
</script>