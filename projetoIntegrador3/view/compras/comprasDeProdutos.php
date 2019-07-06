<?php
session_start();

require_once "../../classes/conexao.php";

$c= new conectar();
$conexao=$c->conexao();

?>
<div class="row">
    <div class="col-sm-4">
        <form id="frmComprasProdutos" class="pt-sm-5">

            <label for="fornecedorCompra">Fornecedor:</label>
            <select class="form-control input-sm" id="fornecedorCompra" name="fornecedorCompra">
                <?php
                if(count($_SESSION['tabelaCompraTemp']) != 0){
                    $dados=$_SESSION['tabelaCompraTemp'];

                    for ($i=0; $i < count($dados) ; $i++) {
                        $d=explode("||", $dados[$i]);

                        $queBuscaFornecedorUsado="SELECT IDFORN, NOME 
                                FROM FORNECEDOR
                                WHERE IDFORN = '$d[8]'";

                        $resultFornecedorUsado = mysqli_query($conexao,$queBuscaFornecedorUsado);
                    }
                    while ($fornecedorUsado=mysqli_fetch_row($resultFornecedorUsado)):
                ?>
                    <option value="<?php echo $fornecedorUsado[0] ?>"><?php echo $fornecedorUsado[1] ?></option>
                <?php endwhile;

                }else{
                ?>
                    <option value="A">Selecionar</option>
                    <option value="0">Sem Fornecedor</option>
                <?php
                    $sql="SELECT IDFORN, NOME FROM FORNECEDOR";

                    $result=mysqli_query($conexao,$sql);
                    while ($fornecedor=mysqli_fetch_row($result)):
                        ?>
                        <option value="<?php echo $fornecedor[0] ?>"><?php echo $fornecedor[1] ?></option>
                <?php endwhile;} ?>
            </select>

            <label for="produtoCompra">Produto:</label>
            <select class="form-control input-sm" id="produtoCompra" name="produtoCompra">
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
            <input type="text" class="form-control input-sm" id="precoV" name="precoV" placeholder="0,00">

            <label for="qtdNegV">Quantidade Negociada:</label>
            <input type="text" class="form-control input-sm" id="qtdNegV" name="qtdNegV" placeholder="0,00">
            <br>

            <span class="btn btn-primary" id="btnAddCompra">
                <i class="fas fa-plus"></i>
                Adicionar na Lista
            </span>
        </form>
    </div>

    <div class="col-sm-8">
        <div class="row">
            <div class="col-sm-12">
                <div id="tabelaComprasTempLoad"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">&nbsp;</div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#tabelaComprasTempLoad').load("compras/tabelaComprasTemp.php");
        $('#produtoCompra').change(function(){
            $.ajax({
                type:"POST",
                data:"idproduto=" + $('#produtoCompra').val(),
                url:"../procedimentos/compras/obterDadosProdutos.php",
                success:function(r){
                    dado=jQuery.parseJSON(r);/*recebimento dos dados via json do result da query*/
                    $('#estoqueV').val(dado['qtd']);
                    $('#unidadeV').val(dado['vol']);
                    $('#precoV').val(dado['preco']);
                }
            });
        });

        $('#btnAddCompra').click(function(){
            vazios=validarFormVazio('frmComprasProdutos');
            var qtdNeg  = parseFloat($('#qtdNegV').val());/*quantidade digitada pelo usuario*/
            var qtdEstoque = parseFloat($('#estoqueV').val());/*quantidade do estoque*/

            /*valida o preenchimento completo do formulário*/
            if(vazios == 1990) {
                $('#qtdNegV').val("");
                return false;
            }
            if(vazios > 0){
                alertify.alert("Areia e Brita","Preencha todos os campos!");
                return false;
            }

            if(qtdNeg <= 0){
                alertify.alert("Areia e Brita","Quantidade não pode ser menor ou igual a zero.");
                $('#qtdNegV').val("");
                return false;
            }

            dados=$('#frmComprasProdutos').serialize();
            $.ajax({
                type:"POST",
                data:dados,
                url:"../procedimentos/compras/adicionarProdutoTemp.php",
                success:function(r){
                    $('#produtoCompra').val(0);
                    $('#qtdNegV').val("");
                    $('#compraProdutos').load('compras/comprasDeProdutos.php');
                    $('#tabelaComprasTempLoad').load("compras/tabelaComprasTemp.php");
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
            url:"../procedimentos/compras/editarEstoque.php",
            success:function(r){
                $('#compraProdutos').load('compras/comprasDeProdutos.php');
                $('#tabelaComprasTempLoad').load("compras/tabelaComprasTemp.php");
                alertify.success("Estoque Atualizado com Sucesso!!");
            }
        });
    }

    function deletarProduto(index){
        $.ajax({
            type:"POST",
            data:"ind=" + index,
            url:"../procedimentos/compras/deletarProduto.php",
            success:function(r){
                $('#tabelaComprasTempLoad').load("compras/tabelaComprasTemp.php");
                alertify.success("Produto Removido com Sucesso!!");
            }
        });
    }

    function criarCompra(){
        $.ajax({
            url:"../procedimentos/compras/criarCompra.php",
            success:function(r){
                if(r > 0){
                    $('#tabelaComprasTempLoad').load("compras/tabelaComprasTemp.php");
                    $('#frmComprasProdutos')[0].reset();
                    $('#compraProdutos').load('compras/comprasDeProdutos.php');
                    alertify.alert("Compra Criada com Sucesso!");
                }else if(r==0){
                    alertify.alert("Não possui lista de Compras");
                }else{
                    alertify.error("Compra não efetuada");
                }
            }
        });
    }

    function limparCompras() {
        $.ajax({
            url:"../procedimentos/compras/limparTemp.php",
            success:function(r){
                $('#frmComprasProdutos')[0].reset();
                $('#compraProdutos').load('compras/comprasDeProdutos.php');
                $('#tabelaComprasTempLoad').load("compras/tabelaComprasTemp.php");
            }
        });
    };

</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#fornecedorCompra').select2();
        $('#produtoCompra').select2();
    });
</script>