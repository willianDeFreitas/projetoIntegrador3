<?php
class categorias{
    
    public function adicionarCategoria($dados){
        $con = new conectar();
        $conexao = $con->conexao();
        
        $sql = "INSERT INTO CATEGORIA (IDUSU, NOME, DATAREG)
                VALUES('$dados[0]','$dados[1]','$dados[2]')";
                
        return mysqli_query($conexao, $sql);
    }
    
    public function atualizarCategoria($dados){
        $con = new conectar();
        $conexao = $con->conexao();
        
        $sql = "UPDATE CATEGORIA SET NOME = '$dados[1]'
                WHERE IDCAT = '$dados[0]' ";
        
        echo mysqli_query($conexao, $sql);
    }
    
    public function excluirCategoria($dados){
        $con = new conectar();
        $conexao = $con->conexao();
        
        $sql = "DELETE FROM CATEGORIA
        WHERE IDCAT = '$dados' ";
        
        return mysqli_query($conexao, $sql);
    }
}
?>