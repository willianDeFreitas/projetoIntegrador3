<?php
    require_once "classes/conexao.php";
    $obj = new conectar();
    $conexao = $obj->conexao();

    $sql = "SELECT 1 FROM USUARIO U
                INNER JOIN ACESSO A ON A.IDACESSO = U.IDACESSO
			WHERE A.NIVELACESSO = 99";

    $result = mysqli_query($conexao,$sql);

    $validar = 0;
    if(mysqli_num_rows($result) == 1){
        $validar = 1;
    }
?>
<!DOCTYPE html>
<html lang="pt">
<head>
	<title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" type="text/css" href="lib/bootstrap/css/bootstrap.css">
    <!-- Estilos customizados para esse template -->
    <link rel="stylesheet" type="text/css" href="css/login.css" >
	<script src="lib/jquery-3.2.1.min.js"></script>
	<script src="js/funcoes.js"></script>
</head>
<body class="bg-dark">
	<div class="container">
		<div class="row">
			<div class="col-sm-4"></div>
			<div class="col-sm-4">
				<div class="panel panel-primary mt-4">
					<div class="panel panel-body">
                        <img class="rounded" src="img/logo4.jpeg" width="100%" alt="logo do sistema">
                        <div class="row"><div class="col-sm-12">&nbsp;</div></div>
						<form id="frmLogin" class="form-signin">
                            <h5 class="text-light">Login</h5>
							<label for="usuario" class="sr-only">Endereço de e-mail:</label>
							<input type="email" class="form-control focus" name="usuario" id="usuario" placeholder="digite seu e-mail" required autofocus>

							<label for="senha" class="sr-only">Senha</label>
							<input type="password" name="senha" id="senha" class="form-control" placeholder="senha" required>

                            <div class="row"><div class="col-sm-12">&nbsp;</div></div>
                            <!--Este if utilizado no php dessa forma ele deve sempre estar inline, não pode haver quebra de linha-->
                            <div class="float-right">
                            <?php if(!$validar): ?>
                                <a class="btn btn-warning" role="button"  href="registrar.php">Registrar</a>
                            <?php endif; ?>
                                <span class="btn btn-primary" id="entrarSistema" accesskey="13">Entrar</span>
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
		$('#entrarSistema').click(function(){
			vazios=validarFormVazio('frmLogin');
			if(vazios > 0){
				alert("Todos os campos devem ser preenchidos.");
				return false;
			}
		    dados=$('#frmLogin').serialize();
		    $.ajax({
			    type:"POST",
			    data:dados,
			    url:"procedimentos/login/login.php",
			    success:function(r){
				    if(r==1){
				        //caso aconteça o login (r=1) ocorre o encaminhamento para página de início
					    window.location="view/inicio.php";
				    }else{
                        document.getElementById('frmLogin').reset();
				        //caso contrário exibe um alerta de acesso negado
					    alert("Usuário ou senha inválidos!");
				    }
			    }
		    });
	    });
        $('#entrarSistema').accessKey(function(){
            vazios=validarFormVazio('frmLogin');
            if(vazios > 0){
                alert("Todos os campos devem ser preenchidos.");
                return false;
            }
            dados=$('#frmLogin').serialize();
            $.ajax({
                type:"POST",
                data:dados,
                url:"procedimentos/login/login.php",
                success:function(r){
                    if(r==1){
                        //caso aconteça o login (r=1) ocorre o encaminhamento para página de início
                        window.location="view/inicio.php";
                    }else{
                        document.getElementById('frmLogin').reset();
                        //caso contrário exibe um alerta de acesso negado
                        alert("Usuário ou senha inválidos!");
                    }
                }
            });
        });
	});
</script>