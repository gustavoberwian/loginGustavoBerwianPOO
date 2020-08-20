<?php

/**
 * Class Contato
 * Classe desenvolvida durante as aulas do curso técnico em informática
 * @author Gustavo Berwian
 * @version 1.0
 * @access public
 * @copyright GPL 2020, INFO63
 */
class Contato
{
    /**
     * Método responsável por carregar a página de contato
     * @access public
     * @since 18/08/2020
     */
    public function index(){
        include HOME_DIR."view/paginas/contato.php";
    }
}