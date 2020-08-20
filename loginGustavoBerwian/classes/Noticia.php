<?php

/**
 * Class Noticia
 * Classe desenvolvida durante as aulas do curso técnico em informática
 * @author Gustavo Berwian
 * @version 1.0
 * @access public
 * @copyright GPL 2020, INFO63
 */
class Noticia{
    /**
     * Método responsável por carregar a página de notícias
     * @access public
     * @since 17/08/2020
     */
    public function index(){
       $this->listar();
    }

    /**
     * Método responsável por listar as notícias da página de notícias
     * @access public
     * @since 17/08/2020
     */
    public function listar(){
        $conexao=Conexao::getConexao();
        $resultado=$conexao->query(
            "SELECT id, titulo, descricao,DATE_FORMAT(data, '%d/%m/%Y') AS data, (SELECT nome FROM usuario WHERE id=noticia.usuario_id) AS nome_usuario FROM noticia ORDER BY id DESC LIMIT 5"
        );
        
        $noticias=null;
        while($noticia=$resultado->fetch(PDO::FETCH_OBJ)){
            $noticias[]=$noticia;
        }
        include HOME_DIR."view/paginas/noticias/noticias.php";
    }

    /**
     * Método responsável por criar uma nova notícia
     * @access public
     * @since 17/08/2020
     */
    public  function criar(){
        if(isset($_SESSION['usuario'])){
            include(HOME_DIR."view/paginas/noticias/nova_noticia.php");
        }else{
            header("location:index.php");
        }
    }

    /**
     * Método responsável por mostrar as notícias na página de notícias
     * @access public
     * @param $id
     * @since 17/08/2020
     */
    public  function ver($id){
        $conexao=Conexao::getConexao();
        $resultado=$conexao->query(
            "SELECT id, titulo, descricao,DATE_FORMAT(data, '%d/%m/%Y') AS data,
             (SELECT nome FROM usuario WHERE id=noticia.usuario_id) AS nome_usuario
             FROM noticia  
             WHERE id=".$id
        );
       
        $noticia=$resultado->fetch(PDO::FETCH_OBJ);
       
        include HOME_DIR."view/paginas/noticias/noticia.php";
    }

    /**
     * Método responsável por excluir uma notícia
     * @access public
     * @param $id
     * @since 17/08/2020
     */
    public function excluir($id){
        $conexao = Conexao::getConexao();
        $excluirComent = $conexao->prepare("DELETE FROM comentario WHERE noticia_id = ?");
        $excluir = $conexao->prepare("DELETE FROM noticia WHERE id = ?");

        $excluirComent->execute([$id]);
        $excluir->execute([$id]);
        header("location: ".HOME_URI."noticia");
    }

    /**
     * Metodo que salva uma nova notícia
     * @access public
     * @since 17/08/2020
     */
    public function salvar(){
        if(!isset($_POST['publicar'])){
            header("location: ".HOME_URI);
            return;
        }
        $usuarioId = $_POST['id'];
        $titulo = $_POST['titulo'];
        $descricao = $_POST['descricao'];

        $conexao = Conexao::getConexao();
        $publicar = $conexao->prepare("INSERT INTO noticia(titulo, descricao, data, usuario_id) VALUES(?,?,?,?)");

        $publicar->execute([$titulo, $descricao, date("Y-m-d"), $usuarioId]);
        header("location: ".HOME_URI."noticia");
    }

    /**
     * Método responsável por chamar o formulário de edição
     * @access public
     * @since 17/08/2020
     * @param $id
     */
    public function editar($id){
        include HOME_DIR."view/paginas/noticias/edita_noticia.php";
    }

    /**
     * Método responsável por editar uma notícia
     * @access public
     * @since 17/08/2020
     */
    public function edicao(){
        if(!isset($_POST['editar'])){
            header("location: ".HOME_URI);
            return;
        }
        $id = $_POST['id'];
        $titulo = $_POST['titulo'];
        $descricao = $_POST['descricao'];

        $conexao = Conexao::getConexao();
        $editar = $conexao->prepare("UPDATE noticia SET titulo = '$titulo', descricao = '$descricao' WHERE id = ?");

        $editar->execute([$id]);
        header("location: ".HOME_URI."noticia");
    }
}
?>