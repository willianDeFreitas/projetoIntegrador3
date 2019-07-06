<?php
class produtos{
    
    public function inserirProduto($dados){
        $con = new conectar();
        $conexao = $con->conexao();

        $data = date('Y-m-d');

        $sql = "INSERT INTO PRODUTO (IDCAT, IDUSU, NOME, QTD, VOL, PRECO, DATAREG) 
                VALUES('$dados[0]','$dados[1]','$dados[2]','$dados[3]','kg','$dados[5]','$data')";
            
        return mysqli_query($conexao, $sql);
    }
    
    public function atualizarProdutos($dados){
        $con = new conectar();
        $conexao = $con->conexao();
        
        $sql = "UPDATE PRODUTO SET 
                    IDCAT = '$dados[1]',
                    NOME = '$dados[2]',
                    PRECO = '$dados[5]'
                WHERE IDPROD = '$dados[0]' ";
        
        echo mysqli_query($conexao, $sql);
    }
    
    public function excluirProduto($idProduto){
        $con = new conectar();
        $conexao = $con->conexao();
        
        $sql = "DELETE FROM PRODUTO
        WHERE IDPROD = '$idProduto' ";
        
        return mysqli_query($conexao, $sql);
    }

    public function obterDados($idProd){
        $con = new conectar();
        $conexao = $con->conexao();

        $sql = " SELECT IDPROD, IDCAT, NOME, VOL, QTD, PRECO
                    FROM PRODUTO 
                    WHERE IDPROD = '$idProd'";

        $result = mysqli_query($conexao, $sql);
        $mostrar = mysqli_fetch_row($result);

        $preco = $mostrar[5];
        $decimais = ".";
        $procuraPonto = strpos($preco, $decimais);
        if($procuraPonto === false){
            $precoP = $preco.",00";
        }else{
            $precoFormatado = str_replace(".",",",$preco);
            $precoP = $precoFormatado;
        }

        $dados = array(
            "IDPROD" => $mostrar[0],
            "id_categoria" => $mostrar[1],
            "nome" => $mostrar[2],
            "vol" => $mostrar[3],
            "quantidade" => $mostrar[4],
            "preco" => $precoP
        );
        return $dados;
    }

    public function obterDadosConferencia($idProd){
        $con = new conectar();
        $conexao = $con->conexao();

        $sql = " SELECT IDPROD, NOME
                    FROM PRODUTO 
                    WHERE IDPROD = '$idProd'";

        $result = mysqli_query($conexao, $sql);
        $mostrar = mysqli_fetch_row($result);

        $dados = array(
            "IDPROD" => $mostrar[0],
            "nome" => $mostrar[1]
        );
        return $dados;
    }

    public function conferirProdutos($dados){
        $con = new conectar();
        $conexao = $con->conexao();

        $idProduto = $dados[0];
        $tipoMov = $dados[1];
        $comprovante = $dados[2];
        $qtd = $dados[3];

        $estoque = self::buscaEstoque($idProduto);

        if($tipoMov == 1){
            if(self::verificaQtdCompra($idProduto,$comprovante,$qtd)){
                $qtdUpdate = $estoque + $qtd;
            }else{
                $qtdUpdate = 0;
            }
        }else if($tipoMov ==2){
            if(self::verificaQtdVenda($idProduto,$comprovante,$qtd)){
                $qtdUpdate = $estoque - $qtd;
            }else{
                $qtdUpdate = 0;
            }
        }else{
            $qtdUpdate = 0;
        }

        if($qtdUpdate > 0) {
            $atualizaEstoque = "UPDATE PRODUTO 
                            SET QTD = '$qtdUpdate'
                            WHERE IDPROD = '$idProduto' ";

            $result = mysqli_query($conexao, $atualizaEstoque);
        }else{
            $result = 0;
        }

        echo $result;
    }

    public function verificaQtdVenda($idProduto,$comprovante,$qtd){
        $con = new conectar();
        $conexao = $con->conexao();

        $queVerificaQtd = "SELECT QTDITEMV 
                            FROM ITEMVENDA 
                            WHERE IDVENDA = '$comprovante' 
                                    AND IDPROD = '$idProduto' ";

        $result = mysqli_query($conexao, $queVerificaQtd);
        $mostrar = mysqli_fetch_row($result);

        if($mostrar[0] == $qtd){
            $podeConferir = true;
        }else{
            $podeConferir = false;
        }

        return $podeConferir;
    }

    public function verificaQtdCompra($idProduto,$comprovante,$qtd){
        $con = new conectar();
        $conexao = $con->conexao();

        $queVerificaQtd = "SELECT QTDITEMC 
                            FROM ITEMCOMPRA 
                            WHERE IDCOMPRA = '$comprovante' 
                                    AND IDPROD = '$idProduto' ";

        $result = mysqli_query($conexao, $queVerificaQtd);
        $mostrar = mysqli_fetch_row($result);

        if($mostrar[0] == $qtd){
            $podeConferir = true;
        }else{
            $podeConferir = false;
        }

        return $podeConferir;
    }

    public function buscaEstoque($idProd){
        $con = new conectar();
        $conexao = $con->conexao();

        $queBuscaEstoque = "SELECT round(QTD,2) 
                            FROM PRODUTO 
                            WHERE IDPROD = '$idProd' ";

        $result = mysqli_query($conexao, $queBuscaEstoque);
        $mostrar = mysqli_fetch_row($result);

        return $mostrar[0];
    }
}
?>