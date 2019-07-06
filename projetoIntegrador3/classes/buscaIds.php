<?php
    require_once "usuarios.php";

class BuscaIds {

    //busca o ID do usuário para ser usado na abertura de sessão da página
    public function trazerNivelAcesso($dados){
        $con = new conectar();
        $conexao = $con->conexao();

        $senha = sha1($dados[1]);

        $sql = "SELECT A.NIVELACESSO FROM USUARIO U
                    INNER JOIN ACESSO A ON A.IDACESSO = U.IDACESSO
                WHERE EMAIL = '$dados[0]' AND SENHA = '$senha'";

        $result = mysqli_query($conexao, $sql);
        //retorna o resultado da linha encontrada na query
        return mysqli_fetch_row($result)[0];
    }
    //função para trazer o nome do usuário logado e apresentar no menu
    public function trazerNome($dados){
        $con = new conectar();
        $conexao = $con->conexao();

        $senha = sha1($dados[1]);

        $sql = "SELECT U.NOME FROM USUARIO U
                    INNER JOIN ACESSO A ON A.IDACESSO = U.IDACESSO
                WHERE EMAIL = '$dados[0]' AND SENHA = '$senha'";

        $result = mysqli_query($conexao, $sql);
        //retorna o resultado da linha encontrada na query
        $texto = mysqli_fetch_row($result)[0];
        /*int strpos (string principal, string procurado)*/
        $pos = strpos($texto, " ");
        $primeiroNome = substr($texto, 0 , $pos );

        return $primeiroNome;
    }
    //função para trazer o IDUSU do usuário
    public function trazerIdUsu($dados){
        $con = new conectar();
        $conexao = $con->conexao();

        $senha = sha1($dados[1]);

        $sql = "SELECT U.IDUSU FROM USUARIO U
                    INNER JOIN ACESSO A ON A.IDACESSO = U.IDACESSO
                WHERE EMAIL = '$dados[0]' AND SENHA = '$senha'";

        $result = mysqli_query($conexao, $sql);
        //retorna o resultado da linha encontrada na query
        return mysqli_fetch_row($result)[0];
    }

}
?>