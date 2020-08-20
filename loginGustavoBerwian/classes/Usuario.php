<?php

/**
 * Class Usuario
 * Classe desenvolvida durante as aulas do curso técnico em informática
 * @author Gustavo Berwian
 * @version 1.0
 * @access public
 * @copyright GPL 2020, INFO63
 */
class Usuario{

    /**
     * Método responsável por carregar a página de usuário
     * @access public
     * @since 17/08/2020
     */
    public function index(){
        $this->listar();
    }

    /**
     * Método responsável por listar os usuários
     * @access public
     * @since 18/08/2020
     */
    public function listar(){
        if(!isset($_SESSION['usuario'])){
            $msg[0]['msg']="Você precisa estar logado para acessar essa página!";
            $msg[0]['class']="danger";
            $_SESSION['msg'] = $msg;

            header("Location: ".HOME_URI);
            return;
        }
        $conexao=Conexao::getConexao();

        $resultado=$conexao->query(
            "SELECT id, nome, email FROM usuario ORDER BY id ASC"
        );

        $usuarios=null;
        while($usuario=$resultado->fetch(PDO::FETCH_OBJ)){
            $usuarios[]=$usuario;
        }

        include HOME_DIR."view/paginas/usuarios/listar.php";
    }

    /**
     * Método responsável por chamar o formulário para poder criar um novo usuário
     * @access public
     * @since 18/08/2020
     */
    public function criar(){
        include HOME_DIR."view/paginas/usuarios/form_usuario.php";
    }

    /**
     * Método resopnsável por salvar um novo usuário
     * @access public
     * @since 18/08/2020
     */
    public function salvar(){
        if(!isset($_POST['enviar'])){
            $msg[0]['msg']="Página inacessível!";
            $msg[0]['class']="danger";
            $_SESSION['msg'] = $msg;

            header("Location: ".HOME_URI."usuario/criar");
            return;
        }
        if($_POST['nome'] == "" || $_POST['email'] == ""){
            $msg[0]['msg']="Preencha todos os campos!";
            $msg[0]['class']="danger";
            $_SESSION['msg'] = $msg;

            header("Location: ".HOME_URI."usuario/criar");
            return;
        }

        $nomeUsuario = $_POST['nome'];
        $emailUsuario = $_POST['email'];

        $conexao=Conexao::getConexao();

        $verifica=$conexao->query(
            "SELECT id, nome, email FROM usuario WHERE email = "."'$emailUsuario'"
        );

        if($verifica->fetch(PDO::FETCH_OBJ)){
            $msg[0]['msg']="Email já cadastrado!";
            $msg[0]['class']="danger";
            $_SESSION['msg'] = $msg;

            header("Location: ".HOME_URI."usuario/criar");
            return;
        }
        
        
        $cadastro = $conexao->prepare(
            "INSERT INTO usuario (nome, email, senha) VALUES (?, ?, ?)"
        );
        if($cadastro->execute([$nomeUsuario, $emailUsuario, md5(SENHA_PADRAO)])){
            $msg[0]['msg']="Usuario cadastrado!";
            $msg[0]['class']="info";
        }else{
            $msg[0]['msg']="Erro ao cadastrar usuário!";
            $msg[0]['class']="danger";
        }

        $_SESSION['msg'] = $msg;
        header("Location: ".HOME_URI);

    }

    /**
     * Método responsável por mostrar a tela de login
     * @access public
     * @since 18/08/2020
     */
    public function login(){
        include HOME_DIR."view/paginas/usuarios/login.php";
    }

    /**
     * Método responsável por fazer o logout do usuário
     * @access public
     * @since 18/08/2020
     */
    public function logout(){
            unset($_SESSION['usuario']);

            $msg[0]['msg']="Você desconectou!";
            $msg[0]['class']="danger";
            $_SESSION["msg"]=$msg;

            header("Location: ".HOME_URI);
    }

    /**
     * Método responsável por logar o usuário
     * @access public
     * @since 18/08/2020
     */
    public function autenticar(){
        if(!isset($_POST['login'])){
            include HOME_DIR."view/paginas/erro104.php";
            return;
        }

        $emailUsuario = $_POST['email'];
        $senhaUsuario = md5($_POST['senha']);

        $conexao=Conexao::getConexao();
        $login=$conexao->query(
            "SELECT id, nome, email FROM usuario WHERE email = "."'$emailUsuario'"." AND senha = "."'$senhaUsuario'"
        );

        $_SESSION['usuario'] = null;
        if($usuario=$login->fetch(PDO::FETCH_OBJ)){
            if($senhaUsuario == md5(SENHA_PADRAO)){
                header("Location: ".HOME_URI."usuario/senhaPadrao/".$usuario->id);
                return;
            }

            $_SESSION['usuario'] = array(
                "id" => $usuario->id,
                "nome" => $usuario->nome,
                "email" => $usuario->email
            );

            $msg[0]['msg']="Você está logado!";
            $msg[0]['class']="info";
            $_SESSION["msg"]=$msg;

            header("Location: ".HOME_URI."usuario");
        }else{
            $msg[0]['msg']="Usuario ou senha incorretos!";
            $msg[0]['class']="danger";
            $_SESSION["msg"]=$msg;
            header("Location: ".HOME_URI."usuario/login");
        }
        
    }

    /**
     * Método responsável por excluir um usuário
     * @access public
     * @since 18/08/2020
     * @param $id
     */
    public function deletar($id){
        $conexao=Conexao::getConexao();

        $deletar = $conexao->prepare(
            "DELETE FROM usuario WHERE id = ?"
        );
        if($deletar->execute([$id])){
            $msg[0]['msg']="Usuario deletado!";
            $msg[0]['class']="info";
        }else{
            $msg[0]['msg']="Erro ao deletar usuario!";
            $msg[0]['class']="danger";
        }

        $_SESSION["msg"]=$msg;
        header("Location: ".HOME_URI."usuario");

    }

    /**
     * Método responsável por chamar o formulário para editar um usuário
     * @access public
     * @since 18/08/2020
     * @param $id
     */
    public function editar($id){
        include HOME_DIR . "view/paginas/usuarios/form_editar.php";
    }

    /**
     * Método responsável por editar um usuário
     * @access public
     * @since 18/08/2020
     */
    public function realizaEdicao(){
        if(!isset($_POST['editar'])){
            $msg[0]['msg']="Página inacessível!";
            $msg[0]['class']="danger";
            $_SESSION['msg'] = $msg;

            header("Location: ".HOME_URI."usuario/editar/".$_POST['id']);
            return;
        }
        if($_POST['nome'] == "" || $_POST['email'] == "" || $_POST['senha'] == ""){
            $msg[0]['msg']="Preencha todos os campos!";
            $msg[0]['class']="danger";
            $_SESSION['msg'] = $msg;

            header("Location: ".HOME_URI."usuario/editar/".$_POST['id']);
            return;
        }

        $id = $_POST['id'];
        $nomeUsuario = $_POST['nome'];
        $emailUsuario = $_POST['email'];
        $senhaUsuario = md5($_POST['senha']);

        $conexao=Conexao::getConexao();

        $editar = $conexao->prepare(
            "UPDATE usuario SET nome="."'$nomeUsuario', "."email="."'$emailUsuario', "."senha="."'$senhaUsuario'"." WHERE id = ?"
        );
        if($editar->execute([$id])){
            $msg[0]['msg']="Usuario editado!";
            $msg[0]['class']="info";
        }else{
            $msg[0]['msg']="Erro ao editar usuario!";
            $msg[0]['class']="danger";
        }

        $_SESSION["msg"]=$msg;
        header("Location: ".HOME_URI."usuario");
    }

    /**
     * Método responsável por fornecer uma senha padrão
     * @access public
     * @since 18/08/2020
     * @param $id
     */
    public function senhaPadrao($id){
        include HOME_DIR . "view/paginas/usuarios/form_senha.php";
    }

    /**
     * Método resopnsável por atualizar a senha
     * @public access
     * @since 18/08/2020
     */
    public function atualizar(){
        if(!isset($_POST['editar'])){
            $msg[0]['msg']="Página inacessível!";
            $msg[0]['class']="danger";
            $_SESSION['msg'] = $msg;

            header("Location: ".HOME_URI."usuario/senhaPadrao/".$_POST['id']);
            return;
        }
        if($_POST['senha'] == "" || $_POST['confirmaSenha'] == ""){
            $msg[0]['msg']="Preencha todos os campos!";
            $msg[0]['class']="danger";
            $_SESSION['msg'] = $msg;

            header("Location: ".HOME_URI."usuario/senhaPadrao/".$_POST['id']);
            return;
        }

        $id = $_POST['id'];
        $senha = md5($_POST['senha']);
        $confirmaSenha = md5($_POST['confirmaSenha']);

        if($senha != $confirmaSenha){
            $msg[0]['msg']="Senhas não coincidem!";
            $msg[0]['class']="danger";
            $_SESSION['msg'] = $msg;

            header("Location: ".HOME_URI."usuario/senhaPadrao/".$_POST['id']);
            return;
        }

        $conexao=Conexao::getConexao();

        $editar = $conexao->prepare("UPDATE usuario SET senha="."'$senha'"." WHERE id = ?");
        if($editar->execute([$id])){
            $msg[0]['msg']="Senha atualizada!";
            $msg[0]['class']="info";
        }else{
            $msg[0]['msg']="Erro ao atualizar senha!";
            $msg[0]['class']="danger";
        }

        $_SESSION["msg"]=$msg;
        header("Location: ".HOME_URI);
    }
}