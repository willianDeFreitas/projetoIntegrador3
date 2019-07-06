<?php
session_start();

require_once "../../classes/conexao.php";

$c= new conectar();
$conexao=$c->conexao();

?>
<div class="row">
    <div class="col-sm-4">
        <form id="frmVendasProdutos" class="pt-sm-5">

            <label for="clienteVenda">Cliente:</label>
            <select class="form-control input-sm" id="clienteVenda" name="clienteVenda">
                <?php
                if(count($_SESSION['tabelaVendaTemp']) != 0){
                    $dados=$_SESSION['tabelaVendaTemp'];

                    for ($i=0; $i < count($dados) ; $i++) {
                        $d=explode("||", $dados[$i]);

                        $queBuscaClienteUsado="SELECT IDCLI, NOME 
                                FROM CLIENTE
                                WHERE IDCLI = '$d[8]'";

                        $resultClienteUsado = mysqli_query($conexao,$queBuscaClienteUsado);
                    }
                    while ($clienteUsado=mysqli_fetch_row($resultClienteUsado)):
                ?>
                    <option value="<?php echo $clienteUsado[0] ?>"><?php echo $clienteUsado[1] ?></option>
                <?php endwhile;

                }else{
                ?>
                    <option value="A">Selecionar</option>
                    <option value="0">Sem Cliente</option>
                <?php
                    $sql="SELECT IDCLI, NOME FROM CLIENTE";

                    $result=mysqli_query($conexao,$sql);
                    while ($cliente=mysqli_fetch_row($result)):
                        ?>
                        <option value="<?php echo $cliente[0] ?>"><?php echo $cliente[1] ?></option>
                <?php endwhile;} ?>
            </select>

            <label for="produtoVenda">Produto:</label>
            <select class="form-control input-sm" id="produtoVenda" name="produtoVenda">
                <option value="A">Selecionar</option>
                <?php
                    $sql="SELECT IDPROD, NOME FROM PRODUTO";
                    $result=mysqli_query($conexao,$sql);

                    while ($produto=mysqli_fetch_row($result)):
                    ?>

                        <option value="<?php echo $produto[0] ?>"><?php echo $produto[1] ?></option>
                    <?php endwhile; ?>
            </select>

            <label>Estoque:</label>
            <input readonly="" type="text" class="form-control input-sm" id="estoqueV" name="estoqueV" placeholder="campo preenchido automaticamente">

            <label>Unidade:</label>
            <input readonly="" type="text" class="form-control input-sm" id="unidadeV" name="unidadeV" placeholder="campo preenchido automaticamente">

            <label>Valor unit.: (R$)</label>
            <input readonly="" type="text" class="form-control input-sm" id="precoV" name="precoV" placeholder="campo preenchido automaticamente">

            <label for="qtdNegV">Qtd. Negociada:</label>
            <input type="text" class="form-control input-sm" id="qtdNegV" name="qtdNegV" placeholder="0,00">
            <br>

            <span class="btn btn-primary" id="btnAddVenda">
                <i class="fas fa-plus"></i>
                Adicionar na Lista
            </span>
            <br>
        </form>
    </div>

    <div class="col-sm-8">
        <div class="row">
            <div class="col-sm-12">
                <div id="tabelaVendasTempLoad"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">&nbsp;</div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#tabelaVendasTempLoad').load("vendas/tabelaVendasTemp.php");
        $('#produtoVenda').change(function(){
            $.ajax({
                type:"POST",
                data:"idproduto=" + $('#produtoVenda').val(),
                url:"../procedimentos/vendas/obterDadosProdutos.php",
                success:function(r){
                    dado=jQuery.parseJSON(r);/*recebimento dos dados via json do result da query*/
                    $('#estoqueV').val(dado['qtd']);
                    $('#unidadeV').val(dado['vol']);
                    $('#precoV').val(dado['valorUnit']);
                }
            });
        });

        $('#btnAddVenda').click(function(){
            vazios=validarFormVazio('frmVendasProdutos');
            var qtdNeg  = parseFloat($('#qtdNegV').val());/*quantidade digitada pelo usuario*/
            var qtdEstoque = parseFloat($('#estoqueV').val());/*quantidade do estoque*/

            /*valida o preenchimento completo do formulário*/
            if(vazios == 1990) {
                $('#qtdNegV').val("");
                return false;
            }
            if (vazios > 0) {
                alertify.alert("Areia e Brita","Preencha todos os campos!");
                return false;
            }

            if (qtdNeg > qtdEstoque) {
                alertify.alert("Areia e Brita","Quantidade inexistente em estoque.");
                quant = $('#qtdNegV').val("");
                return false;
            } else if (qtdNeg <= 0) {
                alertify.alert("Areia e Brita","Quantidade não pode ser menor ou igual a zero.");
                $('#qtdNegV').val("");
                return false;
            }

            dados=$('#frmVendasProdutos').serialize();
            $.ajax({
                type:"POST",
                data:dados,
                url:"../procedimentos/vendas/adicionarProdutoTemp.php",
                success:function(r){
                    $('#produtoVenda').val(0);
                    $('#qtdNegV').val("");
                    $('#vendaProdutos').load('vendas/vendasDeProdutos.php');
                    $('#tabelaVendasTempLoad').load("vendas/tabelaVendasTemp.php");
                }
            });
        });
    });
</script>
<script type="text/javascript">
    function editarP(idProduto, qtd){
        $.ajax({
            type:"POST",
            data:{idProd: idProduto
                ,quantidadeDel: qtd
            },
            url:"../procedimentos/vendas/editarEstoque.php",
            success:function(r){
                $('#vendaProdutos').load('vendas/vendasDeProdutos.php');
                $('#tabelaVendasTempLoad').load("vendas/tabelaVendasTemp.php");
                alertify.success("Estoque Atualizado com Sucesso!!");
            }
        });
    }

    function deletarProduto(index){
        $.ajax({
            type:"POST",
            data:"ind=" + index,
            url:"../procedimentos/vendas/deletarProduto.php",
            success:function(r){
                $('#tabelaVendasTempLoad').load("vendas/tabelaVendasTemp.php");
                alertify.success("Produto Removido com Sucesso!!");
            }
        });
    }

    function criarVenda(){
        $.ajax({
            url:"../procedimentos/vendas/criarVenda.php",
            success:function(r){
                if(r > 0){
                    $('#tabelaVendasTempLoad').load("vendas/tabelaVendasTemp.php");
                    $('#frmVendasProdutos')[0].reset();
                    $('#vendaProdutos').load('vendas/vendasDeProdutos.php');
                    alertify.alert("Venda Criada com Sucesso!");
                }else if(r==0){
                    alertify.alert("Não possui lista de Vendas");
                }else{
                    alertify.error("Venda não efetuada");
                }
            }
        });
    }

    function limparVendas(){
        $.ajax({
            url:"../procedimentos/vendas/limparTemp.php",
            success:function(r){
                $('#frmVendasProdutos')[0].reset();
                $('#vendaProdutos').load('vendas/vendasDeProdutos.php');
                $('#tabelaVendasTempLoad').load("vendas/tabelaVendasTemp.php");
            }
        });
    };
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#clienteVenda').select2();
        $('#produtoVenda').select2();
    });
</script>