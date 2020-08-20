<?php
/**
 * Class Comentario
 * Classe desenvolvida durante as aulas do curso técnico em informática
 * @author Gustavo Berwian
 * @version 1.0
 * @access public
 * @copyright GPL 2020, INFO63
 */
class Comentario{
    /**
     * Método responsável por mostrar os comentários na tela
     * @access public
     * @since 18/08/2020
     */
    public function listarComentarios($id){
        $conexao = Conexao::getConexao();

        $resultado = $conexao->query("SELECT id, comentario, (SELECT nome FROM usuario WHERE comentario.usuario_id = id) AS nome, usuario_id FROM comentario WHERE noticia_id = $id ORDER BY id ASC");
        $comentarios = null;
        while ($comentario = $resultado->fetch(PDO::FETCH_OBJ)) {
            $comentarios[] = $comentario;
        }

        if(!$comentarios)
            $comentarios = false;

        return $comentarios;
    }

    /**
     * Método responsável por criar novo comentário
     * @access public
     * @since 18/08/2020
     * @param $noticia_id
     */
    public function salvar($noticia_id){
        if(!isset($_POST['enviar'])){
            header("location: ".HOME_URI);
            return;
        }
        $conexao = Conexao::getConexao();
        $salvar = $conexao->prepare("INSERT INTO comentario (comentario, noticia_id, usuario_id) VALUES(?,?,?)");

        $salvar->execute([$_POST['comentario'],$noticia_id],$_SESSION['usuario']['id']);
        header("location: ".HOME_URI."noticia/ver/".$noticia_id);
    }

    /**
     * Método responsável por excluir um comentário
     * @access public
     * @since 18/08/2020
     * @param $noticia_id
     * @param $comentario_id
     */
    public function excluir($noticia_id, $comentario_id){
        $conexao = Conexao::getConexao();
        $excluir = $conexao->prepare("DELETE FROM comentario WHERE id = ?");

        $excluir->execute([$comentario_id]);
        header("location: ".HOME_URI."noticia/ver/".$noticia_id);
    }
}