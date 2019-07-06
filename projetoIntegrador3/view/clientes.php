<?php 
    session_start();
    if(isset($_SESSION['usuario'])){
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Clientes | Areia e Brita</title>
		<?php require_once "menu.php"; ?>
	</head>
	<body>
        <ul>Gestão de Pessoas > <a href="clientes.php">Clientes</a></ul>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h1 hidden>Clientes</h1>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <form id="frmBuscaCliente" >

                        <label for="nomeBuscaCliente">Buscar cliente:</label>
                        <input type="text"
                               class="form-control form-control-sm"
                               id="nomeBuscaCliente"
                               name="nomeBuscaCliente"
                               placeholder="digite o nome do cliente ou parte dele (Ex.: Joao ou J)">

                        <details>
                            <summary>Ajuda da busca</summary>
                            <p>Use caracter "%" como coringa na busca.</p>
                            <p>Exemplo 1: Para buscar todos os clientes insira o caractere coringa e pressione buscar.</p>
                            <p>Exemplo 2: Quero buscar "Antônio Augusto", mas não lembro do primeiro nome, utilizando o caractere coringa preencho o campo desta forma: "%Augusto%"</p>
                        </details>
                        <br>

                        <span class="btn btn-primary" id="btnBuscaCliente">
                            <i class="fas fa-search"></i>
                            Buscar
                        </span>

                        <?php if($_SESSION['nivelAcesso'] == 99 || $_SESSION['nivelAcesso'] == 2): ?>
                        <span class="btn btn-primary" id="adicionarClienteBtn" data-toggle="modal" data-target="#popUpAdicionarCliente">
                            <i class="fas fa-plus"></i>
                            Adicionar Cliente
                        </span>
                        <?php endif; ?>

                    </form>
                </div>
            </div>

            <!--tabela de clientes cadastrados-->
            <div class="row">
                <div class="col-sm-12">
                    <div id="tabelaClientesLoad"></div>
                </div>
            </div>
        </div>
		<!-- INICIO popUp Edição Cliente -->
		<div class="modal fade" id="abremodalClientesUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Adicionar Cliente</h5>
                        <button type="button" class="close btn btn-danger"  data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="fas fa-times"></span>
                        </button>
					</div>
					<div class="modal-body">
						<form id="frmClientesU">
							<input type="text" hidden="" id="idclienteU" name="idclienteU">
							<label for="nomeU">Nome do Cliente:</label>
							<input type="text" class="form-control form-control-sm" id="nomeU" name="nomeU" placeholder="Nome completo do cliente">

							<label for="enderecoU">Endereço:</label>
							<input type="text" class="form-control form-control-sm" id="enderecoU" name="enderecoU" placeholder="Ex: Rua João Silva, 123, bl2 apto123">

							<label for="emailU">Email:</label>
							<input type="text" class="form-control form-control-sm" id="emailU" name="emailU" >

							<label for="telefoneU">Telefone:</label>
							<input type="text"
                                   class="form-control form-control-sm"
                                   id="telefoneU"
                                   name="telefoneU"
                                   placeholder="(000)00000-0000"
                                   onKeyPress="inserirMascara('telefoneU','(000)00000-0000')">

							<label for="cpfU">CPF:</label>
							<input type="text"
                                   class="form-control form-control-sm"
                                   id="cpfU"
                                   name="cpfU"
                                   placeholder="000.000.000-00"
                                   onKeyPress="inserirMascara('cpfU','000.000.000-00')">
						</form>
					</div>
					<div class="modal-footer">
						<button id="btnAdicionarClienteU" type="button" class="btn btn-primary" data-dismiss="modal">Atualizar</button>
					</div>
				</div>
			</div>
		</div>
        <!-- FIM popUp Edição Cliente -->
        <!--INICIO popUp Adição de novo cliente -->
        <div class="modal fade" id="popUpAdicionarCliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Adicionar Cliente</h5>
                        <button type="button" class="close btn btn-danger"  data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="fas fa-times"></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="frmClientes">
                            <label for="nome">Nome completo:</label>
                            <input type="text" class="form-control form-control-sm" id="nome" name="nome" placeholder="Nome completo do cliente">

                            <label for="endereco">Endereço:</label>
                            <input type="text" class="form-control form-control-sm" id="endereco" name="endereco" placeholder="Ex: Rua João Silva, 123, bl2 apto123">

                            <label for="email">Email:</label>
                            <input type="text" class="form-control form-control-sm" id="email" name="email" placeholder="email@email.com.br">

                            <label for="telefone">Telefone:</label>
                            <input type="text" 
                                class="form-control form-control-sm" 
                                id="telefone" 
                                name="telefone" 
                                placeholder="(000)00000-0000"
                                onKeyPress="inserirMascara('telefone','(000)00000-0000')">

                            <label for="cpf">CPF:</label>
                            <input type="text" 
                                class="form-control form-control-sm" 
                                id="cpf" 
                                name="cpf" 
                                placeholder="000.000.000-00"
                                onKeyPress="inserirMascara('cpf','000.000.000-00')">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <span class="btn btn-danger" data-dismiss="modal" >
                            <i class="fas fa-times"></i>
                            Cancelar
                        </span>
                        <span class="btn btn-primary" id="btnAdicionarCliente" data-dismiss="modal">
                            <i class="far fa-save"></i>
                            Salvar
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <!--FIM popUp adição do cliente -->
    </body>
	</html>
	<script type="text/javascript">
		function adicionarDado(idcliente){

			$.ajax({
				type:"POST",
				data:"idcliente=" + idcliente,
				url:"../procedimentos/clientes/obterDadosCliente.php",
				success:function(r){
					dado=jQuery.parseJSON(r);
					$('#idclienteU').val(dado['IDCLI']);
					$('#nomeU').val(dado['nome']);
					$('#enderecoU').val(dado['endereco']);
					$('#emailU').val(dado['email']);
					$('#telefoneU').val(dado['telefone']);
					$('#cpfU').val(dado['cpf']);
				}
			});
		}

		function excluirCliente(idcliente){
			alertify.confirm("Areia e Brita",'Deseja excluir este cliente?', function(){
				$.ajax({
					type:"POST",
					data:"idcliente=" + idcliente,
					url:"../procedimentos/clientes/excluirClientes.php",
					success:function(r){
						if(r==1){
							$('#tabelaClientesLoad').load("clientes/tabelaClientes.php");
							alertify.success("Excluído com sucesso.");
						}else{
							alertify.error("Não foi possível excluir.");
						}
					}
				});
			}, function(){ 
				alertify.error('Cancelado.')
			});
		}
	</script>

	<script type="text/javascript">
		$(document).ready(function(){
			$('#tabelaClientesLoad').load("clientes/tabelaClientes.php");
			$('#btnAdicionarCliente').click(function(){
				vazios=validarFormVazio('frmClientes');
				if(vazios > 0){
					alertify.alert("Areia e Brita","Preencha todos os Campos!");
					return false;
				}
				dados=$('#frmClientes').serialize();
				$.ajax({
					type:"POST",
					data:dados,
					url:"../procedimentos/clientes/adicionarClientes.php",
					success:function(r){
						if(r==1){
							$('#frmClientes')[0].reset();
							$('#tabelaClientesLoad').load("clientes/tabelaClientes.php");
							alertify.success("Adicionado com sucesso.");
						}else{
							alertify.error("Não foi possível adicionar.");
						}
					}
				});
			});
		});
	</script>

	<script type="text/javascript">
		$(document).ready(function(){
			$('#btnAdicionarClienteU').click(function(){
				dados=$('#frmClientesU').serialize();

				$.ajax({
					type:"POST",
					data:dados,
					url:"../procedimentos/clientes/atualizarClientes.php",
					success:function(r){
                        if(r==1){
							$('#frmClientes')[0].reset();
							$('#tabelaClientesLoad').load("clientes/tabelaClientes.php");
							alertify.success("Atualizado com sucesso.");
						}else{
							alertify.error("Não foi possível atualizar.");
						}
					}
				});
			})
		})
	</script>

        <script type="text/javascript">
            $('#btnBuscaCliente').click(function(){
                vazios=validarFormVazio('frmBuscaCliente');

                /*valida o preenchimento completo do formulário*/
                if (vazios > 0) {
                    alertify.alert("Areia e Brita","Preencha os Campos!!");
                    <?php unset($_SESSION['tabelaClienteTemp']); ?>
                    $('#tabelaClientesLoad').load("clientes/tabelaClientes.php");

                    return false;
                }

                dados=$('#frmBuscaCliente').serialize();
                $.ajax({
                    type:"POST",
                    data:dados,
                    url:"../procedimentos/clientes/adicionarClienteTemp.php",
                    success:function(r){
                        <?php
                            if(count($_SESSION['tabelaClienteTemp'])!=0) {
                                ?>
                                $('#nomeBuscaCliente').val("");
                                $('#tabelaClientesLoad').load("clientes/tabelaClientes.php");
                        <?php
                            }else{
                                unset($_SESSION['tabelaClienteTemp']);
                                ?>
                            $('#tabelaClientesLoad').load("clientes/tabelaClientes.php");
                        <?php
                            }
                            ?>
                    }
                });
            });
        </script>
        <?php
}else{
	header("location:../index.php");
}
?>