<?php
/**
 * Class Conexao
 * Classe desenvolvida durante as aulas do curso técnico em informática
 * @author Gustavo Berwian
 * @version 1.0
 * @access public
 * @copyright GPL 2020, INFO63
 */
class Conexao {
    /**
     * Método responsável por realizar a conexão com o banco de dados
     * @access public
     * @since 09/07/2020
     * @return Object PDO objeto para conexão com banco de dados
     */
    static public function getConexao(){
        return new PDO (SGBD.":host=".HOST_DB.";dbname=".DB."",USER_DB, PASS_DB);
    }

}