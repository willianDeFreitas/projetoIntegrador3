<?php
    session_start();
    if(isset($_SESSION['usuario'])){
?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Produtos | Areia e Brita </title>
        <?php require_once "menu.php"; ?>
        <?php require_once "../classes/conexao.php";
            $c= new conectar();
            $conexao=$c->conexao();
        ?>
    </head>
    <body>
        <ul>Gestão de Produtos > <a href="produtos.php"> Produtos</a></ul>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h1 hidden>Produtos</h1>
                </div>
            </div>
        </div>
        <div class="container">
            <?php if($_SESSION['nivelAcesso'] == 99 || $_SESSION['nivelAcesso'] == 2): ?>
            <div class="row">
                <div class="col-sm-1"></div>
                <div class="col-sm-10">
                    <span class="btn btn-primary" id="adicionarProdutoBtn" data-toggle="modal"
                          data-target="#popUpAdicionarProduto">
                        <i class="fas fa-plus"></i>
                        Adicionar Produto
                    </span>
                </div>
                <div class="col-sm-1"></div>
            </div>
            <?php endif; ?>
            <!--linha para dar espaçamento entre itens-->
            <div class="row">
                <div class="col-sm-12">&nbsp;</div>
            </div>
            <!--tabela de produtos cadastrados-->
            <div class="row">
                <div class="col-sm-1"></div>
                <div class="col-sm-10">
                    <div id="tabelaProdutosLoad"></div>
                </div>
                <div class="col-sm-1"></div>
            </div>
        </div>
    <!--INICIO modal Edição do produto -->
    <div class="modal fade" id="abremodalUpdateProduto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Editar Produto</h5>
                    <button type="button" class="close btn btn-danger"  data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="fas fa-times"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frmProdutosU" enctype="multipart/form-data">
                        <input type="text" id="idProdutoU" hidden="" name="idProdutoU">
                        <label for="categoriaSelectU">Categoria:</label>
                        <select class="form-control input-sm" id="categoriaSelectU" name="categoriaSelectU">
                            <option value="A">Selecionar Categoria</option>
                            <?php
                                $sql="SELECT IDCAT, NOME FROM CATEGORIA";
                                $result=mysqli_query($conexao,$sql);
                            ?>
                            <?php while($mostrar=mysqli_fetch_row($result)): ?>
                                <option value="<?php echo $mostrar[0] ?>"><?php echo $mostrar[1]; ?></option>
                            <?php endwhile; ?>
                        </select>
                        <label for="nomeU">Nome do Produto:</label>
                        <input type="text" class="form-control input-sm" id="nomeU" name="nomeU">

                        <label for="quantidadeU">Estoque:</label>
                        <input type="text" class="form-control input-sm" id="quantidadeU" name="quantidadeU" disabled>

                        <label for="unidadeU">Unidade:</label>
                        <input type="text" class="form-control input-sm" id="unidadeU" name="unidadeU" disabled>

                        <label for="precoU">Valor Unitario:</label>
                        <input type="text" class="form-control input-sm" id="precoU" name="precoU">
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="btnAtualizarProduto" type="button" class="btn btn-warning" data-dismiss="modal">Editar</button>

                </div>
            </div>
        </div>
    </div>
    <!--FIM modal Edição do produto -->
    <!--INICIO modal Adição de novo produto -->
    <div class="modal fade" id="popUpAdicionarProduto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Adicionar Produto</h5>
                    <button type="button" class="close btn btn-danger"  data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="fas fa-times"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frmProdutos" enctype="multipart/form-data">
                        <label for="categoriaSelect">Categoria:</label>
                        <select class="form-control input-sm" id="categoriaSelect" name="categoriaSelect">
                            <option value="A">Selecionar Categoria</option>
                            <?php
                            $sql="SELECT IDCAT, NOME FROM CATEGORIA";
                            $result=mysqli_query($conexao,$sql);
                            while($mostrar=mysqli_fetch_row($result)): ?>
                                <option value="<?php echo $mostrar[0] ?>"><?php echo $mostrar[1]; ?></option>
                            <?php endwhile; ?>
                        </select>
                        <label for="nome">Nome do Produto:</label>
                        <input type="text" class="form-control input-sm" id="nome" name="nome" placeholder="nome do produto">

                        <label for="quantidade">Estoque:</label>
                        <input type="text" class="form-control input-sm" id="quantidade" name="quantidade" placeholder="0,00" disabled>

                        <label for="unidade">Unidade:</label>
                        <input type="text" class="form-control input-sm" id="unidade" name="unidade" placeholder="Ex.: m³, kg, ton, m">

                        <label for="preco">Valor Unitário:</label>
                        <input type="text" class="form-control input-sm" id="preco" name="preco" placeholder="0,00">
                    </form>
                </div>
                <div class="modal-footer">
                    <span class="btn btn-danger" data-dismiss="modal" >
                        <i class="fas fa-times"></i>
                        Cancelar
                    </span>
                    <span class="btn btn-primary" id="btnAddProduto" data-dismiss="modal">
                        <i class="far fa-save"></i>
                        Salvar
                    </span>
                </div>
            </div>
        </div>
    </div>
    <!--FIM modal adição do produto -->
        <!--INICIO modal conferência do produto -->
        <div class="modal fade" id="abremodalConferenciaProduto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Conferir Produto</h5>
                        <button type="button" class="close btn btn-danger"  data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="fas fa-times"></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="frmConferencia" enctype="multipart/form-data">
                            <input type="text" id="idProdutoConf" hidden="" name="idProdutoConf">

                            <input type="radio" name="tipoMov" id="tipoMov1" value="1" class="input-group-sm">
                            <label for="tipoMov1">Compra</label><br>

                            <input type="radio" name="tipoMov" id="tipoMov2" value="2" class="input-group-sm">
                            <label for="tipoMov2">Venda</label><br>

                            <label for="nomeProdConf">Nome:</label>
                            <input type="text" class="form-control input-sm" id="nomeProdConf" name="nomeProdConf" disabled>

                            <label for="comprovanteU">Identificador:</label>
                            <input type="text" class="form-control input-sm" id="comprovanteU" name="comprovanteU" placeholder="número identificador da transação">

                            <label for="qtdConf">Quantidade:</label>
                            <input type="text" class="form-control input-sm" id="qtdConf" name="qtdConf" placeholder="0,00">

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button id="btnConferirProduto" type="button" class="btn btn-success" data-dismiss="modal">Confirmar</button>
                    </div>
                </div>
            </div>
        </div>
        <!--FIM modal coferência do produto -->
    </body>
    </html>

    <script type="text/javascript">
        function editarProduto(idproduto){
            $.ajax({
                type:"POST",
                data:"idproduto=" + idproduto,
                url:"../procedimentos/produtos/obterDados.php",
                success:function(r){

                    dado=jQuery.parseJSON(r);
                    $('#idProdutoU').val(dado['IDPROD']);
                    $('#categoriaSelectU').val(dado['id_categoria']);
                    $('#nomeU').val(dado['nome']);
                    $('#unidadeU').val(dado['vol']);
                    $('#quantidadeU').val(dado['quantidade']);
                    $('#precoU').val(dado['preco']);
                }
            });
        }

        function coferenciaProduto(idproduto){
            $.ajax({
                type:"POST",
                data:"idproduto=" + idproduto,
                url:"../procedimentos/produtos/obterDadosConferencia.php",
                success:function(r){
                    dado=jQuery.parseJSON(r);
                    $('#idProdutoConf').val(dado['IDPROD']);
                    $('#nomeProdConf').val(dado['nome']);
                }
            });
        }

        function excluirProduto(idProduto){
            alertify.confirm('Deseja Excluir este Produto?', function(){
                $.ajax({
                    type:"POST",
                    data:"idProduto=" + idProduto,
                    url:"../procedimentos/produtos/excluirProdutos.php",
                    success:function(r){
                        if(r==1){
                            $('#tabelaProdutosLoad').load("produtos/tabelaProdutos.php");
                            alertify.success("Excluído com sucesso.");
                        }else{
                            alertify.error("Erro ao excluir.");
                        }
                    }
                });
            }, function(){
                alertify.error('Cancelado!')
            });
        }
    </script>

    <script type="text/javascript">
        $(document).ready(function(){
            $('#btnAtualizarProduto').click(function(){

                dados=$('#frmProdutosU').serialize();
                $.ajax({
                    type:"POST",
                    data:dados,
                    url:"../procedimentos/produtos/atualizarProdutos.php",
                    success:function(r){
                        if(r==1){
                            $('#tabelaProdutosLoad').load("produtos/tabelaProdutos.php");
                            alertify.success("Editado com sucesso!!");
                        }else{
                            alertify.error("Erro ao editar");
                        }
                    }
                });
            });
        });
    </script>

        <script type="text/javascript">
            $(document).ready(function(){
                $('#btnConferirProduto').click(function(){

                    vazios=validarFormVazio('frmConferencia');
                    if(vazios > 0){
                        alertify.alert("Areia e Brita","Preencha todos os campos!!");
                        return false;
                    }

                    dados=$('#frmConferencia').serialize();
                    $.ajax({
                        type:"POST",
                        data:dados,
                        url:"../procedimentos/produtos/conferirProdutos.php",
                        success:function(r){
                            if(r==1){
                                $('#frmConferencia')[0].reset();
                                $('#tabelaProdutosLoad').load("produtos/tabelaProdutos.php");
                                alertify.success("Conferido com sucesso!");
                            }else{
                                $('#frmConferencia')[0].reset();
                                alertify.error("Erro na conferência.");
                            }
                        }
                    });
                });
            });
        </script>

<!-- Adicionando novo produto -->
        <script type="text/javascript">
            $(document).ready(function(){
                $('#tabelaProdutosLoad').load("produtos/tabelaProdutos.php");

                $('#btnAddProduto').click(function(){
                    vazios=validarFormVazio('frmProdutos');
                    if(vazios > 0){
                        alertify.alert("Areia e Brita","Preencha todos os campos!!");
                        return false;
                    }
                    var formData = new FormData(document.getElementById("frmProdutos"));

                    $.ajax({
                        url: "../procedimentos/produtos/inserirProdutos.php",
                        type: "post",
                        dataType: "html",
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,

                        success:function(r){
                            if(r == 1){
                                $('#frmProdutos')[0].reset();
                                $('#tabelaProdutosLoad').load("produtos/tabelaProdutos.php");
                                alertify.success("Adicionado com sucesso!!");
                            }else{
                                alertify.error("Falha ao Adicionar");
                            }
                        }
                    });

                });
            });
        </script>
        <?php
            }else{
                header("location:../index.php");
            }
        ?>