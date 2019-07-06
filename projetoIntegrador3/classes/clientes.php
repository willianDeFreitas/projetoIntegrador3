<?php
class clientes {
    
    public function adicionarCliente($dados){
        $con = new conectar();
        $conexao = $con->conexao();
        
        $sql = "INSERT INTO CLIENTE (IDUSU, NOME, ENDERECO, EMAIL, TEL, CPF)
                VALUES('$dados[0]','$dados[1]','$dados[2]','$dados[3]','$dados[4]','$dados[5]')";
                
        return mysqli_query($conexao, $sql);
    }
    
    public function obterDadosCliente($dados){
        $con = new conectar();
        $conexao = $con->conexao();
        
        $sql = "SELECT IDCLI, NOME, ENDERECO, EMAIL, TEL, CPF FROM CLIENTE
                WHERE IDCLI = '$dados'";
                
        $result = mysqli_query($conexao, $sql);
        $mostrar = mysqli_fetch_row($result);
        
        $dados = array(
                'IDCLI' => $mostrar[0],
                'nome' => $mostrar[1],
                'endereco' => $mostrar[2],
                'email' => $mostrar[3],
                'telefone' => $mostrar[4],
                'cpf' => $mostrar[5]
            );
            
        return $dados;
    }
    
    public function atualizarCliente($dados){
        $con = new conectar();
        $conexao = $con->conexao();
        
        $sql = "UPDATE CLIENTE SET 
                    NOME = '$dados[1]',
                    ENDERECO = '$dados[2]',
                    EMAIL = '$dados[3]',
                    TEL = '$dados[4]',
                    CPF = '$dados[5]'
                WHERE IDCLI = '$dados[0]' ";
        
        echo mysqli_query($conexao, $sql);
    }
    
    public function excluirCliente($dados){
        $con = new conectar();
        $conexao = $con->conexao();
        
        $sql = "DELETE FROM CLIENTE
        WHERE IDCLI = '$dados' ";
        
        return mysqli_query($conexao, $sql);
    }
}
?>