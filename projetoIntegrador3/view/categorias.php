<?php 
    session_start();
    if(isset($_SESSION['usuario'])){
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Categorias | Areia e Brita</title>
		<?php require_once "menu.php"; ?>
	</head>
	<body>
        <ul>Gestão de Produtos > <a href="categorias.php">Categorias</a></ul>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h1>Categorias</h1>
                </div>
            </div>
        </div>
		<div class="container">
            <div class="row">
                <div class="col-sm-1"></div>
                <div class="col-sm-10">
                    <div id="tabelaCategoriaLoad"></div>
                </div>
                <div class="col-sm-1"></div>
            </div>
            <div class="row">
                <div class="col-sm-12">&nbsp;</div>
            </div>
			<div class="row">
                <div class="col-sm-1"></div>
				<div class="col-sm-10">
					<form id="frmCategorias">
                        <label for="categoria">Nova Categoria:</label>
                        <p>
                            <input type="text"
                                   class="form-control-sm"
                                   name="categoria"
                                   id="categoria"
                                   placeholder="Escreva nome da nova categoria" size="34">
                        </p>
                        <p><span class="btn btn-primary" id="btnAdicionarCategoria">
                            <i class="fas fa-plus"></i>
                            Adicionar
                        </span></p>
					</form>
				</div>
                <div class="col-sm-1"></div>
			</div>
		</div>
		<!--INICIO popUp de edição da categoria-->
		<div class="modal fade" id="atualizaCategoria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Editar categoria</h4>
                        <button type="button" class="close btn btn-danger"  data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="fas fa-times"></span>
                        </button>
					</div>
					<div class="modal-body">
						<form id="frmCategoriaU">
							<input type="text" hidden="" id="idcategoria" name="idcategoria">
							<label>Nome da Categoria:</label>
							<input type="text" id="categoriaU" name="categoriaU" class="form-control form-control-sm">
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" id="btnAtualizaCategoria" class="btn btn-warning" data-dismiss="modal">Salvar</button>
					</div>
				</div>
			</div>
		</div>
        <!--FIM popUp de edição da categoria-->
	</body>
	</html>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#tabelaCategoriaLoad').load("categorias/tabelaCategorias.php");
			$('#btnAdicionarCategoria').click(function(){
				vazios=validarFormVazio('frmCategorias');
				if(vazios > 0){
					alertify.alert("Areia e Brita","Preencha todos os campos!");
					return false;
				}
				dados=$('#frmCategorias').serialize();
				$.ajax({
					type:"POST",
					data:dados,
					url:"../procedimentos/categorias/adicionarCategorias.php",
					success:function(r){
						if(r==1){
					        //limpar formulário
					        $('#frmCategorias')[0].reset();
					        $('#tabelaCategoriaLoad').load("categorias/tabelaCategorias.php");
					        alertify.success("Categoria adicionada.");
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
			$('#btnAtualizaCategoria').click(function(){
				dados=$('#frmCategoriaU').serialize();
				$.ajax({
					type:"POST",
					data:dados,
					url:"../procedimentos/categorias/atualizarCategorias.php",
					success:function(r){
						if(r==1){
							$('#tabelaCategoriaLoad').load("categorias/tabelaCategorias.php");
							alertify.success("Atualizado com sucesso.");
						}else{
							alertify.error("Não foi possível atualizar.");
						}
					}
				});
			});
		});
	</script>
	<script type="text/javascript">
		function editarCategoria(idCategoria,categoria){
			$('#idcategoria').val(idCategoria);
			$('#categoriaU').val(categoria);
		}
		function excluirCategoria(idcategoria){
			alertify.confirm("Areia e Brita",'Deseja excluir esta categoria?', function(){
				$.ajax({
					type:"POST",
					data:"idcategoria=" + idcategoria,
					url:"../procedimentos/categorias/excluirCategorias.php",
					success:function(r){
						if(r==1){
							$('#tabelaCategoriaLoad').load("categorias/tabelaCategorias.php");
							alertify.success("Excluído com sucesso");
						}else{
							alertify.error("Não foi possível excluir");
						}
					}
				});
			}, function(){ 
				alertify.error('Cancelado')
			});
		}
    </script>
<?php
    }else{
        header("location:../index.php");
    }
?>