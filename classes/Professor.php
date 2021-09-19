<?php

/**
 * Esta classe representa a tabela 'professor' no banco de dados
 * @author Kayki Garcia de Araujo
 * @version 1.0
 * @access public
 */
class Professor {
    /**
     * Representa a coluna 'codigo'
     * @access private
     * @name codigo 
     */
    private $codigo;

    /**
     * Representa a coluna 'nome'
     * @access private
     * @name nome
     */
    private $nome;

    /**
     * Insere valores nos parametros da classe
     * @access public
     * @name setProfessor
     * @param Int $codigo Codigo do Professor
     * @param String $nome Nome do Professor
     * @return void
     */
    public function setProfessor($codigo, $nome) {
        $this->codigo = $codigo;
        $this->nome = $nome;
    }

    /**
     * Retorno codigo do professor
     * @access public
     * @name getCodigo
     * @return Int codigo
     */
    public function getCodigo() {
        return $this->codigo;
    }

    /**
     * Retorno nome do professor
     * @access public
     * @name getNome
     * @return String nome
     */
    public function getNome() {
        return $this->nome;
    }

    /**
     * Salva o objeto atual e seus paramentros para o banco de dados
     * @access public
     * @name salvar
     * @return Boolean true se salvou; false se não salvou
     */
    public function salvar() {
        try {
            $db = Database::conexao();
            if (empty($this->codigo)) {
                $stm = $db->prepare("INSERT INTO professor (nome) VALUES (:nome)");
                $stm->execute(array(":nome" => $this->getNome()));
            } else {
                $stm = $db->prepare("UPDATE professor SET nome=:nome WHERE codigo=:codigo");
                $stm->execute(array(":nome" => $this->nome, ":codigo" => $this->codigo));
            }
            #ppegar o id do registro no banco de dados
            #setar o id do objeto
            return true;
        } catch (Exception $ex) {
            echo $ex->getMessage() . "<br>";
            return false;
        }
        return true;
    }

    /**
     * Retorna as colunas da tabela professor em um array
     * @name listar
     * @access public
     * @static
     * @return Array lista 
     */
    public static function listar() {
        $db = Database::conexao();
        $professores = null;
        $retorno = $db->query("SELECT * FROM professor");
        while ($item = $retorno->fetch(PDO::FETCH_ASSOC)) {
            $professor = new Professor();
            $professor->setProfessor($item['codigo'], $item['nome']);

            $professores[] = $professor;
        }

        return $professores;
    }

    /**
     * Retorna uma instancia de professor
     * @access public
     * @static
     * @param Int $codigo codigo do professor
     * @return Professor
     * @return Boolean false: caso não exista o professor
     */
    public static function getProfessor($codigo) {
        $db = Database::conexao();
        $retorno = $db->query("SELECT * FROM professor WHERE codigo= $codigo");
        if ($retorno) {
            $item = $retorno->fetch(PDO::FETCH_ASSOC);
            $professor = new Professor();
            $professor->setProfessor($item['codigo'], $item['nome']);
            return $professor;
        }
        return false;
    }

    /**
     * Exclui um aluno pelo codigo
     * @access public
     * @static
     * @param Int $codigo codigo do professor
     * @return Boolean true: caso deletado
     * @return Boolean false: caso não deletado
     */
    public static function excluir($codigo) {
        $db = Database::conexao();
        try {
            $db->query("DELETE FROM professor WHERE codigo=$codigo");
            return true;
        } catch (Exception $exc) {
            return false;
        }
        return false;
    }
}
