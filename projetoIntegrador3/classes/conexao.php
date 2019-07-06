<?php
class conectar{
    private $servidor = "AQUI VOCE COLOCA O LINK DO SERVIDOR";
    private $usuario = "AQUI VOCE COLOCA O USUARIO QUE LOGA NO BANCO";
    private $senha = "AQUI VOCE POE A SENHA DO USUARIO COLOCADO NA LINHA DE CIMA";
    private $bd = "ESTE É OPCIONAL MAS PODE COLOCAR O NOME DO BANCO DE DADOS PARA UMA COMPLETA IDENTIFICAÇÃO";

    public function conexao(){
        $conexao = mysqli_connect($this->servidor, $this->usuario, $this->senha, $this->bd);
        return $conexao;
    }
}
?>