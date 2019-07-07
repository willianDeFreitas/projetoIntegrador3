<?php 
    session_start();
    if(isset($_SESSION['usuario'])){
?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Gestão de Usuários | Areia e Brita</title>
            <?php require_once "menu.php"; ?>
            <?php require_once "../classes/conexao.php";
                $c= new conectar();
                $conexao=$c->conexao();
            ?>
        </head>
        <body>
        <ul>Configuração de Usuário > <a href="usuarios.php">Gestão de usuários</a></ul>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h1 hidden>Gestão de usuários</h1>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-sm-1"></div>
                <div class="col-sm-10">
                    <span class="btn btn-primary"
                          id="adicionarUsuarioBtn"
                          data-toggle="modal"
                          data-target="#popUpAdicionarUsuario">
                        <i class="fas fa-plus"></i>
                        Adicionar usuário
                    </span>
                </div>
                <div class="col-sm-1"></div>
            </div>
            <!--linha para dar espaçamento entre itens-->
            <div class="row">
                <div class="col-sm-12">&nbsp;</div>
            </div>
            <!--tabela de usuarios cadastrados-->
            <div class="row">
                <div class="col-sm-1"></div>
                <div class="col-sm-10">
                    <div id="tabelaUsuariosLoad"></div>
                </div>
                <div class="col-sm-1"></div>
            </div>
        </div>
        <!-- popUp de Edição de Usuário -->
        <div class="modal fade" id="atualizaUsuarioModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Editar Usuário</h5>
                        <button type="button" class="close btn btn-danger"  data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="fas fa-times"></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="frmAtualizarUsuarioU">
                            <input type="text" hidden="" id="idUsuarioU" name="idUsuarioU">

                            <label for="nomeU">Nome completo:</label>
                            <input type="text" class="form-control form-control-sm" name="nomeU" id="nomeU">

                            <label for="emailU">E-mail:</label>
                            <input type="text" class="form-control form-control-sm" name="emailU" id="emailU">

                            <label for="senhaU">Senha:</label>
                            <input type="password" class="form-control form-control-sm" name="senhaU" id="senhaU" value="">

                            <label for="setorU">Setor:</label>
                            <select class="form-control form-control-sm" id="setorU" name="setorU">
                                <option value="A">Selecionar</option>
                                <?php
                                    $sql="SELECT DISTINCT(A.NIVELACESSO), A.NOMEACESSO 
                                        FROM USUARIO U
                                            INNER JOIN ACESSO A ON U.IDACESSO = A.IDACESSO
                                        WHERE A.NIVELACESSO <> 99";
                                    $result=mysqli_query($conexao,$sql);
                                ?>
                                <?php while ($nivel=mysqli_fetch_row($result)):?>
                                    <option value="<?php echo $nivel[0] ?>"><?php echo $nivel[1]; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button id="btnAtualizaUsuarioU" type="button" class="btn btn-warning" data-dismiss="modal">Editar</button>
                    </div>
                </div>
            </div>
        </div>
        <!--INICIO popUp Adição de novo usuário -->
        <div class="modal fade" id="popUpAdicionarUsuario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Adicionar Usuário</h5>
                        <button type="button" class="close btn btn-danger"  data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="fas fa-times"></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="frmAdicionarNovoUsuario">
                            <label for="nome">Nome completo:</label>
                            <input type="text" class="form-control form-control-sm" name="nome" id="nome" placeholder="digite o nome completo">

                            <label for="email">E-mail:</label>
                            <input type="text" class="form-control form-control-sm" name="email" id="email" placeholder="email@email.com">

                            <label for="senha">Senha:</label>
                            <input type="password" class="form-control form-control-sm" name="senha" id="senha" placeholder="digite a senha com letras ou números">

                            <label for="setor">Setor:</label>
                            <select class="form-control form-control-sm" id="setor" name="setor">
                                <option value="A">Selecionar</option>
                                <option value="2">Comercial</option>
                                <option value="3">Estoque</option>
                            </select>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <span class="btn btn-danger" data-dismiss="modal" >
                            <i class="fas fa-times"></i>
                            Cancelar
                        </span>
                        <span class="btn btn-primary" id="btnAdicionarUsuario" data-dismiss="modal">
                            <i class="far fa-save"></i>
                            Salvar
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <!--FIM popUp adição do produto -->
        </body>
        </html>
        <script type="text/javascript">
            function editarUsuario(idUsuario){
                $.ajax({
                    type:"POST",
                    data:"idUsuario=" + idUsuario,
                    url:"../procedimentos/usuarios/obterDadosUsuarios.php",
                    success:function(r){
                        dado=jQuery.parseJSON(r);
                        $('#idUsuarioU').val(dado['ID']);
                        $('#nomeU').val(dado['nome']);
                        $('#emailU').val(dado['email']);
                        $('#senhaU').val(dado['senha']);
                        $('#setorU').val(dado['setor']);
                    }
                });
            }

            function excluirUsuario(idUsuario){
                alertify.confirm('Deseja excluir este usuario?', function(){
                    $.ajax({
                        type:"POST",
                        data:"idUsuario=" + idUsuario,
                        url:"../procedimentos/usuarios/excluirUsuarios.php",
                        success:function(r){
                            if(r==1){
                                $('#tabelaUsuariosLoad').load('usuarios/tabelaUsuarios.php');
                                alertify.success("Excluído com sucesso");
                            }else{
                                alertify.error("Erro ao excluir");
                            }
                        }
                    });
                }, function(){
                    alertify.error('Cancelado')
                });
            }
        </script>
        <script type="text/javascript">
            $(document).ready(function(){
                $('#btnAtualizaUsuarioU').click(function(){
                    dados=$('#frmAtualizarUsuarioU').serialize();
                    $.ajax({
                        type:"POST",
                        data:dados,
                        url:"../procedimentos/usuarios/atualizarUsuarios.php",
                        success:function(r){
                            if(r==1){
                                $('#tabelaUsuariosLoad').load('usuarios/tabelaUsuarios.php');
                                alertify.success("Editado com sucesso.");
                            }else{
                                alertify.error("Não foi possível editar.");
                            }

                        }
                    });
                });
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function(){
                $('#tabelaUsuariosLoad').load('usuarios/tabelaUsuarios.php');
                $('#btnAdicionarUsuario').click(function(){
                    vazios=validarFormVazio('frmAdicionarNovoUsuario');
                    if(vazios > 0){
                        alertify.alert("Preencha todos os campos!");
                        return false;
                    }
                    dados=$('#frmAdicionarNovoUsuario').serialize();
                    $.ajax({
                        type:"POST",
                        data:dados,
                        url:"../procedimentos/login/registrarUsuario.php",
                        success:function(r){
                            if(r==1){
                                $('#criacaoUsuario').hide();
                                $('#frmAdicionarNovoUsuario')[0].reset();
                                $('#tabelaUsuariosLoad').load('usuarios/tabelaUsuarios.php');
                                alertify.success("Adicionado com sucesso.");
                            }else{
                                alertify.error("Falha ao adicionar.");
                            }
                        }
                    });
                });
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function(){
                $('#tabelaUsuariosLoad').load('usuarios/tabelaUsuarios.php');
            });
        </script>
        <?php
            }else{
	            header("location:../index.php");
            }
        ?>