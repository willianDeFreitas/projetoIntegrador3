<?php
class fornecedores{
    
    public function adicionarFornecedor($dados){
        $con = new conectar();
        $conexao = $con->conexao();
        
        $queInsereFornecedor = "INSERT INTO FORNECEDOR (IDUSU, NOME, ENDERECO, EMAIL, TEL, CNPJ)
                VALUES('$dados[0]','$dados[1]','$dados[2]','$dados[3]','$dados[4]','$dados[5]')";
                
        return mysqli_query($conexao, $queInsereFornecedor);
    }
    
    public function obterDadosFornecedores($dados){
        $con = new conectar();
        $conexao = $con->conexao();
        
        $queBuscaFornecedor = "SELECT IDFORN, NOME, ENDERECO, EMAIL, TEL, CNPJ 
                FROM FORNECEDOR 
                WHERE IDFORN = '$dados'";
                
        $result = mysqli_query($conexao, $queBuscaFornecedor);
        $mostrar = mysqli_fetch_row($result);
        
        $dados = array(
                'IDFORN' => $mostrar[0],
                'nome' => $mostrar[1],
                'endereco' => $mostrar[2],
                'email' => $mostrar[3],
                'telefone' => $mostrar[4],
                'cnpj' => $mostrar[5]
        );
            
        return $dados;
    }
    
    public function atualizarFornecedor($dados){
        $con = new conectar();
        $conexao = $con->conexao();
        
        $queAtualizaFornecedor = "UPDATE FORNECEDOR SET 
                                        NOME = '$dados[1]',
                                        ENDERECO = '$dados[2]',
                                        EMAIL = '$dados[3]',
                                        TEL = '$dados[4]',
                                        CNPJ = '$dados[5]'
                                    WHERE IDFORN = '$dados[0]' ";
        
        echo mysqli_query($conexao, $queAtualizaFornecedor);
    }
    
    public function excluirFornecedor($dados){
        $con = new conectar();
        $conexao = $con->conexao();
        
        $queExcluiFornecedor = "DELETE FROM FORNECEDOR
        WHERE IDFORN = '$dados' ";
        
        return mysqli_query($conexao, $queExcluiFornecedor);
    }
}
?>