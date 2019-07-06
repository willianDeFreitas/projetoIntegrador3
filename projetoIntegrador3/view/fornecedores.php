<?php 
    session_start();
    if(isset($_SESSION['usuario'])){
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Fornecedores | Areia e Brita</title>
		<?php require_once "menu.php"; ?>
	</head>
	<body>
        <ul>Gestão de Pessoas > <a href="fornecedores.php"> Fornecedores</a></ul>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h1 hidden>Fornecedores</h1>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <form id="frmBuscaFornecedor" >

                        <label for="nomeBuscaFornecedor">Buscar fornecedor:</label>
                        <input type="text"
                               class="form-control form-control-sm"
                               id="nomeBuscaFornecedor"
                               name="nomeBuscaFornecedor"
                               placeholder="digite o nome do fornecedor ou parte dele (Ex.: Joao ou J)">

                        <details>
                            <summary>Ajuda da busca</summary>
                            <p>Use caracter "%" como coringa na busca.</p>
                            <p>Exemplo 1: Para buscar todos os fornecedores insira o caractere coringa e pressione buscar.</p>
                            <p>Exemplo 2: Quero buscar "Antônio Augusto", mas não lembro do primeiro nome, utilizando o caracter coringa preencho o campo "%Augusto%"</p>
                        </details>
                        <br>
                        
                        <span class="btn btn-primary" id="btnBuscaFornecedor">
                            <i class="fas fa-search"></i>
                            Buscar
                        </span>

                        <?php if($_SESSION['nivelAcesso'] == 99 || $_SESSION['nivelAcesso'] == 2): ?>
                            <span class="btn btn-primary"
                                  id="adicionarFornecedorBtn"
                                  data-toggle="modal"
                                  data-target="#popUpAdicionarFornecedor">
                                <i class="fas fa-plus"></i>
                                Adicionar Fornecedor
                            </span>
                        <?php endif; ?>

                    </form>
                </div>
            </div>

            <!--tabela de Fornecedores cadastrados-->
            <div class="row">
                <div class="col-sm-12">
                    <div id="tabelaFornecedoresLoad"></div>
                </div>
            </div>
        </div>
		<!-- INICIO popUp edição fornecedor -->
		<div class="modal fade" id="abremodalFornecedoresUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Adicionar Fornecedor</h5>
                        <button type="button" class="close btn btn-danger"  data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="fas fa-times"></span>
                        </button>
					</div>
					<div class="modal-body">
						<form id="frmFornecedorU">
							<input type="text" hidden="" id="idFornecedorU" name="idFornecedorU">

                            <label for="nomeU">Nome Completo:</label>
                            <input type="text" class="form-control input-sm" id="nomeU" name="nomeU">

                            <label for="enderecoU">Endereço:</label>
							<input type="text" class="form-control input-sm" id="enderecoU" name="enderecoU">

                            <label for="emailU">Email:</label>
							<input type="text" class="form-control input-sm" id="emailU" name="emailU">

                            <label for="telefoneU">Telefone:</label>
							<input type="text"
                                   class="form-control input-sm"
                                   id="telefoneU"
                                   name="telefoneU"
                                   placeholder="(000)00000-0000"
                                   onKeyPress="inserirMascara('telefoneU','(000)00000-0000')">

                            <label for="cnpjU">CNPJ:</label>
							<input type="text"
                                   class="form-control input-sm"
                                   id="cnpjU"
                                   name="cnpjU"
                                   placeholder="00.000.000/0000-00"
                                   onKeyPress="inserirMascara('cnpjU','00.000.000/0000-00')">
						</form>
					</div>
					<div class="modal-footer">
						<button id="btnAdicionarFornecedorU" type="button" class="btn btn-primary" data-dismiss="modal">Atualizar</button>
					</div>
				</div>
			</div>
		</div>
        <!-- FIM popUp edição fornecedor -->
        <!--INICIO popUp Adição de novo fornecedor -->
        <div class="modal fade" id="popUpAdicionarFornecedor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Adicionar Fornecedor</h5>
                        <button type="button" class="close btn btn-danger"  data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="fas fa-times"></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="frmFornecedores">
                            <label for="nome">Nome completo:</label>
                            <input type="text" class="form-control form-control-sm" id="nome" name="nome" placeholder="Nome do fornecedor">

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

                            <label for="cnpj">CNPJ:</label>
                            <input type="text"
                                   class="form-control form-control-sm"
                                   id="cnpj"
                                   name="cnpj"
                                   placeholder="00.000.000/0000-00"
                                   onKeyPress="inserirMascara('cnpj','00.000.000/0000-00')">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <span class="btn btn-danger" data-dismiss="modal" >
                            <i class="fas fa-times"></i>
                            Cancelar
                        </span>
                        <span class="btn btn-primary" id="btnAdicionarFornecedores" data-dismiss="modal">
                            <i class="far fa-save"></i>
                            Salvar
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <!--FIM popUp adição do fornecedor -->
	</body>
	</html>

	<script type="text/javascript">
		function adicionarDado(idFornecedor){
			$.ajax({
				type:"POST",
				data:"idFornecedor=" + idFornecedor,
				url:"../procedimentos/fornecedores/obterDadosFornecedores.php",
				success:function(r){
					dado=jQuery.parseJSON(r);
					$('#idFornecedorU').val(dado['IDFORN']);
					$('#nomeU').val(dado['nome']);
					$('#enderecoU').val(dado['endereco']);
					$('#emailU').val(dado['email']);
					$('#telefoneU').val(dado['telefone']);
					$('#cnpjU').val(dado['cnpj']);
				}
			});
		}

		function excluirFornecedor(idFornecedor){
			alertify.confirm("Areia e Brita",'Deseja excluir este fornecedor?', function(){
				$.ajax({
					type:"POST",
					data:"idFornecedor=" + idFornecedor,
					url:"../procedimentos/fornecedores/excluirFornecedores.php",
					success:function(r){
						if(r==1){
							$('#tabelaFornecedoresLoad').load("fornecedores/tabelaFornecedores.php");
							alertify.success("Excluido com sucesso!!");
						}else{
							alertify.error("Não foi possível excluir");
						}
					}
				});
			}, function(){ 
				alertify.error('Cancelado !')
			});
		}
	</script>

	<script type="text/javascript">
		$(document).ready(function(){
			$('#tabelaFornecedoresLoad').load("fornecedores/tabelaFornecedores.php");
			$('#btnAdicionarFornecedores').click(function(){
				vazios=validarFormVazio('frmFornecedores');
				if(vazios > 0){
					alertify.alert("Areia e Brita","Preencha os Campos!!");
					return false;
				}
				dados=$('#frmFornecedores').serialize();
				$.ajax({
					type:"POST",
					data:dados,
                    /*URL que a variavel dados é enviada*/
					url:"../procedimentos/fornecedores/adicionarFornecedores.php",
					success:function(r){

						if(r==1){
							$('#frmFornecedores')[0].reset();
							$('#tabelaFornecedoresLoad').load("fornecedores/tabelaFornecedores.php");
							alertify.success("Fornecedor Adicionado");
						}else{
							alertify.error("Não foi possível adicionar");
						}
					}
				});
			});
		});
	</script>

	<script type="text/javascript">
		$(document).ready(function(){
			$('#btnAdicionarFornecedorU').click(function(){
				dados=$('#frmFornecedorU').serialize();
				$.ajax({
					type:"POST",
					data:dados,
					url:"../procedimentos/fornecedores/atualizarFornecedores.php",
					success:function(r){
                        if(r==1){
							$('#frmFornecedores')[0].reset();
							$('#tabelaFornecedoresLoad').load("fornecedores/tabelaFornecedores.php");
							alertify.success("Fornecedor atualizado com sucesso!");
						}else{
							alertify.error("Não foi possível atualizar fornecedor");
						}
					}
				});
			})
		})
	</script>
        <script type="text/javascript">
            $('#btnBuscaFornecedor').click(function(){
                vazios=validarFormVazio('frmBuscaFornecedor');

                /*valida o preenchimento completo do formulário*/
                if (vazios > 0) {
                    alertify.alert("Areia e Brita","Preencha os Campos!!");
                    <?php unset($_SESSION['tabelaFornecedorTemp']); ?>
                    $('#tabelaFornecedoresLoad').load("fornecedores/tabelaFornecedores.php");

                    return false;
                }

                dados=$('#frmBuscaFornecedor').serialize();
                $.ajax({
                    type:"POST",
                    data:dados,
                    url:"../procedimentos/fornecedores/adicionarFornecedorTemp.php",
                    success:function(r){
                        <?php
                        if(count($_SESSION['tabelaFornecedorTemp'])!=0) {
                        ?>
                        $('#nomeBuscaFornecedor').val("");
                        $('#tabelaFornecedoresLoad').load("fornecedores/tabelaFornecedores.php");
                        <?php
                        }else{
                        unset($_SESSION['tabelaFornecedorTemp']);
                        ?>
                        $('#tabelaFornecedoresLoad').load("fornecedores/tabelaFornecedores.php");
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