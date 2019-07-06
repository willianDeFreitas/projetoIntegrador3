<?php
    session_start();
?>
<!--linha para dar espaçamento entre itens-->
<div class="row"><div class="col-sm-12">&nbsp;</div></div>
<div class="table-responsive-xl">
<table class="table table-responsive-sm table-hover table-striped table-bordered" style="text-align: center;">
    <caption>Tabela de fornecedores da Areia e Brita</caption>
    <thead class="thead-dark">
    <tr>
        <th>Fornecedor</th>
        <th>Endereço</th>
        <th>Email</th>
        <th>Telefone</th>
        <th>CNPJ</th>
        <?php if($_SESSION['nivelAcesso'] == 99 || $_SESSION['nivelAcesso'] == 2): ?>
        <th>Editar</th>
        <?php endif; ?>
        <?php if($_SESSION['nivelAcesso'] == 99): ?>
        <th>Excluir</th>
        <?php endif; ?>
    </tr>
    </thead>

	<?php
    if(count($_SESSION['tabelaFornecedorTemp'])!=0):
        if (isset($_SESSION['tabelaFornecedorTemp'])):
            $i = 0;
            foreach (@$_SESSION['tabelaFornecedorTemp'] as $key) {

                $dadosFornecedor = explode("||", @$key);

                ?>

                <tr>
                    <td><?php echo $dadosFornecedor[1] ?></td>
                    <td><?php echo $dadosFornecedor[2] ?></td>
                    <td><?php echo $dadosFornecedor[3] ?></td>
                    <td><?php echo $dadosFornecedor[4] ?></td>
                    <td><?php echo $dadosFornecedor[5] ?></td>
                    <?php if ($_SESSION['nivelAcesso'] == 99 || $_SESSION['nivelAcesso'] == 2): ?>
                        <td>
                            <span class="btn btn-warning btn-xs"
                                  data-toggle="modal"
                                  data-target="#abremodalFornecedoresUpdate"
                                  onclick="adicionarDado('<?php echo $dadosFornecedor[0] ?>')">
                                <span class="fas fa-edit"></span>
                            </span>
                        </td>
                    <?php endif; ?>
                    <?php if ($_SESSION['nivelAcesso'] == 99): ?>
                        <td>
                            <span class="btn btn-danger btn-xs"
                                  onclick="excluirFornecedor('<?php echo $dadosFornecedor[0] ?>')">
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