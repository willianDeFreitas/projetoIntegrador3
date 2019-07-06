<?php
    require_once "../../classes/trataDecimais.php";

class compras{

    public function obterDadosProduto($idproduto){
        $con = new conectar();
        $trataDecimais = new TrataDecimais();

        $conexao = $con->conexao();

        $queBuscaProduto = "SELECT QTD, VOL, PRECO
                            FROM PRODUTO
                            WHERE IDPROD = '$idproduto'";

        $result = mysqli_query($conexao, $queBuscaProduto);
        $ver = mysqli_fetch_row($result);/*exibir os dados da consulta*/

        $dados = array(
            'qtd' => $trataDecimais->convertePontoEmVirgula($ver[0]),
            'vol' => $ver[1],
            'preco' => $trataDecimais->convertePontoEmVirgula($ver[2])
        );
        return $dados;
    }

    public function criarCompra(){
        $c= new conectar();
        $conexao=$c->conexao();

        $data=date('Y-m-d');
        $itensCompra=$_SESSION['tabelaCompraTemp'];
        $idUsuario=$_SESSION['idUsu'];
        $totalCompra = 0;

        for ($i=0; $i < count($itensCompra) ; $i++) {
            $d=explode("||", $itensCompra[$i]);

            $totalCompra += $d[7];
            $idFornecedor = $d[8];

        }

        $exiteEstoquista = "SELECT 1 FROM USUARIO WHERE IDACESSO = 3";

        $resultEst = mysqli_query($conexao, $exiteEstoquista);
        $existeEst = mysqli_fetch_row($resultEst);

        if(!$existeEst) {
            $queInsereCompra = "INSERT INTO COMPRA (DATAREGC, TOTALC, IDFORN, IDUSU, CONFERIDO)
				    VALUES ('$data', '$totalCompra', '$idFornecedor', '$idUsuario', 'S')";
        }else{
            $queInsereCompra = "INSERT INTO COMPRA (DATAREGC, TOTALC, IDFORN, IDUSU, CONFERIDO)
				    VALUES ('$data', '$totalCompra', '$idFornecedor', '$idUsuario', 'N')";
        }

        $result=mysqli_query($conexao,$queInsereCompra);

        self::criarItensCompra($itensCompra);

        return $result;
    }

    public function criarItensCompra($itensCompra){
        $c= new conectar();
        $conexao=$c->conexao();

        $queBuscaIdCompra="SELECT MAX(IDCOMPRA)
                            FROM COMPRA";

        $result = mysqli_query($conexao, $queBuscaIdCompra);
        $idCompra = mysqli_fetch_row($result);/*exibir os dados da consulta*/

        for ($i=0; $i < count($itensCompra) ; $i++) {
            $d=explode("||", $itensCompra[$i]);

            $queInsereItemCompra="INSERT INTO ITEMCOMPRA (IDPROD, IDCOMPRA, QTDITEMC, PRECOITEMC)
				    VALUES ('$d[0]', '$idCompra[0]', '$d[6]', '$d[7]')";

            mysqli_query($conexao,$queInsereItemCompra);

        }
    }

    /*para trazer o próximo id de venda que será colocado na venda*/
    public function criarComprovante(){
        $c= new conectar();
        $conexao=$c->conexao();

        $sql="SELECT IDCOMPRA FROM COMPRA GROUP BY IDCOMPRA DESC";
        $resul=mysqli_query($conexao,$sql);
        $id=mysqli_fetch_row($resul)[0];

        if($id=="" or $id==null or $id==0){
            return 1;
        }else{
            return $id + 1;
        }
    }

    public function nomeFornecedor($idFornecedor){
        $c= new conectar();
        $conexao=$c->conexao();

        $sql="SELECT NOME 
                FROM FORNECEDOR
                WHERE IDFORN = '$idFornecedor'";

        $result=mysqli_query($conexao,$sql);

        $ver=mysqli_fetch_row($result);

        return $ver[0];
    }

    public function deletaListaItensCompra(){
        $c= new conectar();
        $conexao=$c->conexao();

        $dados=$_SESSION['tabelaCompraTemp'];
        $r=0;

        for ($i=0; $i < count($dados) ; $i++) {
            $d=explode("||", $dados[$i]);

            $idProd = $d[0];
            $qtd = $d[6];

            $queBuscaQtdEstoque = "SELECT QTD
                                FROM PRODUTO
                                WHERE IDPROD = '$idProd'";

            $result = mysqli_query($conexao, $queBuscaQtdEstoque);

            $qtdEstoque = mysqli_fetch_row($result);
            $qtdEstoqueAtualizada = $qtdEstoque[0] - $qtd;

            $exiteEstoquista = "SELECT 1 FROM USUARIO WHERE IDACESSO = 3";

            $resultEst = mysqli_query($conexao, $exiteEstoquista);
            $existeEst = mysqli_fetch_row($resultEst);

            if(!$existeEst) {
                $queAtualizaEstoque = "UPDATE PRODUTO
                                SET QTD = '$qtdEstoqueAtualizada'
                                WHERE IDPROD = '$idProd' ";

                $r=$r + $resultado=mysqli_query($conexao,$queAtualizaEstoque);
            }else{
                $r = 1;
            }

        }
        return $r;

    }

    public function marcaCompraConferida($idCompra){
        $c= new conectar();
        $conexao=$c->conexao();

        $queMarcaConferenciaEntrada = "UPDATE COMPRA
                                    SET CONFERIDO = 'S'
                                    WHERE IDCOMPRA = '$idCompra' ";

        return mysqli_query($conexao, $queMarcaConferenciaEntrada);
    }
}
?>