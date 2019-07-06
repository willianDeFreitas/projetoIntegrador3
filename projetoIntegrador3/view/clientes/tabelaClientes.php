<?php
    session_start();
?>
<!--linha para dar espaçamento entre itens-->
<div class="row"><div class="col-sm-12">&nbsp;</div></div>
<div class="table-responsive-xl">
    <table class="table table-responsive-sm table-hover table-striped table-bordered" style="text-align: center;">
        <caption>Tabela de clientes da Areia e Brita</caption>
        <thead class="thead-dark">
            <tr>
                <th>Cliente</th>
                <th>Endereço</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>CPF</th>
                <?php if($_SESSION['nivelAcesso'] == 99 || $_SESSION['nivelAcesso'] == 2): ?>
                <th>Editar</th>
                <?php endif; ?>
                <?php if($_SESSION['nivelAcesso'] == 99): ?>
                <th>Excluir</th>
                <?php endif; ?>
            </tr>
        </thead>

        <?php
        if(count($_SESSION['tabelaClienteTemp'])!=0):
            if (isset($_SESSION['tabelaClienteTemp'])):
                $i = 0;
                foreach (@$_SESSION['tabelaClienteTemp'] as $key) {

                    $dadosCliente = explode("||", @$key);

                    ?>

                    <tr>
                        <td><?php echo $dadosCliente[1] ?></td>
                        <td><?php echo $dadosCliente[2] ?></td>
                        <td><?php echo $dadosCliente[3] ?></td>
                        <td><?php echo $dadosCliente[4] ?></td>
                        <td><?php echo $dadosCliente[5] ?></td>
                        <?php if($_SESSION['nivelAcesso'] == 99 || $_SESSION['nivelAcesso'] == 2): ?>
                        <td>
                            <span class="btn btn-warning btn-sm"
                                  data-toggle="modal"
                                  data-target="#abremodalClientesUpdate"
                                  onclick="adicionarDado('<?php echo $dadosCliente[0] ?>')">
                                <span class="fas fa-edit"></span>
                            </span>
                        </td>
                        <?php endif; ?>
                        <?php if($_SESSION['nivelAcesso'] == 99): ?>
                        <td>
                            <span class="btn btn-danger btn-sm"
                                  onclick="excluirCliente('<?php echo $dadosCliente[0] ?>')">
                                <span class="fas fa-trash-alt"></span>
                            </span>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php
                }
            endif;
        endif;
                ?>
    </table>
</div>