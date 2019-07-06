<?php
    require_once "buscaIds.php";

class Usuarios extends BuscaIds {
    public function gravaUsuario($dadosCadastrais){
        $con = new conectar();
        $conexao = $con->conexao();
        
        $data = date('Y-m-d');
        
        $sql = "INSERT INTO USUARIO (NOME, EMAIL, IDACESSO, SENHA, DATAREG)
                VALUES(
                    '$dadosCadastrais[0]',
                    '$dadosCadastrais[1]',
                    '$dadosCadastrais[2]',
                    '$dadosCadastrais[3]',
                    '$data'
                )";
                
        return mysqli_query($conexao, $sql);
    }

    public function obterDadosUsuario($dados){
        $con = new conectar();
        $conexao = $con->conexao();

        $sql = "SELECT IDUSU, NOME, EMAIL, SENHA, IDACESSO FROM USUARIO WHERE IDUSU = '$dados'";

        $result = mysqli_query($conexao, $sql);
        $mostrar = mysqli_fetch_row($result);

        $dados = array(
            'ID' => $mostrar[0],
            'nome' => $mostrar[1],
            'email' => $mostrar[2],
            'senha' => "",
            'setor' => $mostrar[4]
        );

        return $dados;
    }

    //busca usuário e senha e também inicia sessão do usuário na página
    public function login($dados){
        $con = new conectar();
        $conexao = $con->conexao();

        $senha = sha1($dados[1]);
        
        $_SESSION['usuario'] = $dados[0];
        //o parent significa que a função está na classe extendida
        $_SESSION['nivelAcesso'] = parent::trazerNivelAcesso($dados);
        $_SESSION['nomeUsuario'] = parent::trazerNome($dados);
        $_SESSION['idUsu'] = parent::trazerIdUsu($dados);

        $sql = "SELECT 1 FROM USUARIO 
                WHERE EMAIL = '$dados[0]' AND SENHA = '$senha'";
                
        $result = mysqli_query($conexao, $sql);

        if(mysqli_num_rows($result) == 1){
            return 1;
        }else{
            return 0;
        }
    }

    public function atualizarUsuario($dados){
        $con = new conectar();
        $conexao = $con->conexao();

        if($dados[3] != " "){
            $sql = "UPDATE USUARIO SET 
                    NOME = '$dados[1]',
                    EMAIL = '$dados[2]',
                    SENHA = '$dados[3]',
                    IDACESSO = '$dados[4]'
                WHERE IDUSU = '$dados[0]' ";
        }else{
            $sql = "UPDATE USUARIO SET 
                    NOME = '$dados[1]',
                    EMAIL = '$dados[2]',
                    IDACESSO = '$dados[4]'
                WHERE IDUSU = '$dados[0]' ";
        }

        return mysqli_query($conexao, $sql);
    }

    public function excluirUsuario($dados){
        $con = new conectar();
        $conexao = $con->conexao();

        $sql = "DELETE FROM USUARIO
        WHERE IDUSU = '$dados' ";

        return mysqli_query($conexao, $sql);
    }
}
?>