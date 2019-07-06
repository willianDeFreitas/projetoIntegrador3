<?php
    require_once "../../classes/trataDecimais.php";

    class vendas{

    public function obterDadosProduto($idproduto){
        $con = new conectar();
        $conexao = $con->conexao();

        $queBuscaProduto = "SELECT QTD, VOL, PRECO
                            FROM PRODUTO
                            WHERE IDPROD = '$idproduto'";

        $result = mysqli_query($conexao, $queBuscaProduto);
        $ver = mysqli_fetch_row($result);/*exibir os dados da consulta*/

        $trataDecimais= new TrataDecimais();

        $dados = array(
            'qtd' => $trataDecimais->convertePontoEmVirgula($ver[0]),
            'vol' => $ver[1],
            'valorUnit' => $trataDecimais->convertePontoEmVirgula($ver[2])
        );
        return $dados;
    }

    public function criarVenda(){
        $c= new conectar();
        $conexao=$c->conexao();

        $data=date('Y-m-d');
        $itensVenda=$_SESSION['tabelaVendaTemp'];
        $idusuario=$_SESSION['idUsu'];
        $totalVenda = 0;

        for ($i=0; $i < count($itensVenda) ; $i++) {
            $d=explode("||", $itensVenda[$i]);

            $totalVenda += $d[7];
            $idCliente = $d[8];

        }

        $exiteEstoquista = "SELECT 1 FROM USUARIO WHERE IDACESSO = 3";

        $resultEst = mysqli_query($conexao, $exiteEstoquista);
        $existeEst = mysqli_fetch_row($resultEst);

        if(!$existeEst) {
            $queInsereVenda = "INSERT INTO VENDA (DATAREGV, TOTALV, IDCLI, IDUSU, CONFERIDO)
				    VALUES ('$data', '$totalVenda', '$idCliente', '$idusuario', 'S')";
        }else{
            $queInsereVenda = "INSERT INTO VENDA (DATAREGV, TOTALV, IDCLI, IDUSU, CONFERIDO)
				    VALUES ('$data', '$totalVenda', '$idCliente', '$idusuario', 'N')";
        }

        $result=mysqli_query($conexao,$queInsereVenda);

        self::criarItensVenda($itensVenda);

        return $result;
    }

    public function criarItensVenda($itensVenda){
        $c= new conectar();
        $conexao=$c->conexao();

        $queBuscaIdVenda="SELECT MAX(IDVENDA)
                            FROM VENDA";

        $result = mysqli_query($conexao, $queBuscaIdVenda);
        $idVenda = mysqli_fetch_row($result);/*exibir os dados da consulta*/

        for ($i=0; $i < count($itensVenda) ; $i++) {
            $d=explode("||", $itensVenda[$i]);

            $queInsereItemVenda="INSERT INTO ITEMVENDA (IDPROD, IDVENDA, QTDITEMV, PRECOITEMV)
				    VALUES ('$d[0]', '$idVenda[0]', '$d[6]', '$d[7]')";

            mysqli_query($conexao,$queInsereItemVenda);

        }
    }

    /*para trazer o próximo id de venda que será colocado na venda*/
    public function criarComprovante(){
        $c= new conectar();
        $conexao=$c->conexao();

        $sql="SELECT IDVENDA FROM VENDA GROUP BY IDVENDA DESC";
        $resul=mysqli_query($conexao,$sql);
        $id=mysqli_fetch_row($resul)[0];

        if($id=="" or $id==null or $id==0){
            return 1;
        }else{
            return $id + 1;
        }
    }

    public function nomeCliente($idCliente){
        $c= new conectar();
        $conexao=$c->conexao();

        $sql="SELECT NOME 
                FROM CLIENTE
                WHERE IDCLI = '$idCliente'";
        $result=mysqli_query($conexao,$sql);

        $ver=mysqli_fetch_row($result);

        return $ver[0];
    }

    public function deletaListaItensVenda(){
        $c= new conectar();
        $conexao=$c->conexao();

        $dados=$_SESSION['tabelaVendaTemp'];
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
            $qtdEstoqueAtualizada = $qtdEstoque[0] + $qtd;

            $exiteEstoquista = "SELECT 1 FROM USUARIO WHERE IDACESSO = 3";

            $resultEst = mysqli_query($conexao, $exiteEstoquista);
            $existeEst = mysqli_fetch_row($resultEst);

            if(!$existeEst) {
                $queAtualizaEstoque = "UPDATE PRODUTO
                                SET QTD = '$qtdEstoqueAtualizada'
                                WHERE IDPROD = '$idProd' ";

                $r = $r + $resultado = mysqli_query($conexao, $queAtualizaEstoque);
            }else{
                $r = 1;
            }

        }
        return $r;

    }

    public function marcaVendaConferida($idVenda){
        $c= new conectar();
        $conexao=$c->conexao();

        $queMarcaConferenciaSaida = "UPDATE VENDA
                                    SET CONFERIDO = 'S'
                                    WHERE IDVENDA = '$idVenda' ";

        return mysqli_query($conexao, $queMarcaConferenciaSaida);
    }
}
?>