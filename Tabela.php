<?php

require_once 'TabelaLinha.php';

/**
 * @package HotClass
 * @subpackage Tabela
 * @author  Diego Schell Fernandes <diego@areacentral.com.br>
 * @since   3.9.6 
 */
class Tabela {
    /**
     * Se o <thead> ser� vis�vel
     * @var boolean
     */
    private $header = true;

    /**
     * Se o <tfoot> ser� vis�vel
     * @var boolean
     */
    private $footer = false;

    /**
     * Mensagem caso nenhum valor for encontrado
     * @var string
     */
    private $errorMsg;

    /**
     * Atributos adicionais da tabela
     * @var array
     */
    private $attr = array();

    /**
     * Informa��es das colunas
     * @var array
     */
    private $colunas = array();

    /**
     * Informa��es das linhas
     * @var array
     */
    private $linhas = array();

    /**
     * Cria uma nova tabela
     * @param boolean $header Se o <thead> ser� vis�vel
     * @param boolean $footer Se o <thoot> ser� vis�vel
     */ 
    public function __construct($header = true, $footer = false, $attr = array(), $errorMsg = 'Nenhuma informa��o dispon�vel') {
        $this->header   = $header;
        $this->footer   = $footer;
        $this->errorMsg = $errorMsg;
        $this->attr     = $attr;
    }

    /**
     * Adiciona uma nova coluna � tabela
     * @param string $nome  Nome da coluna para o <thead>
     * @param array  $attr  Atributos adicionais do <td>
     * @return Tabela       Objeto de tabela atual
     */ 
    public function addColuna($nome, $attr = array()) {
        $this->colunas[] = array(
            'nome'  => $nome,
            'attr'  => $attr
        );

        return $this;
    }

    /**
     * Adiciona uma nova linha � tabela
     * @param array  $attr    Atributos adicionais do <td>
     * @return Linha          Objeto de linha atual
     */
    public function addLinha($attr = array(), $tipo = 'td') {
        $linha = new TabelaLinha($attr, $tipo);
        $this->linhas[] = $linha;

        return $linha;
    }

    /**
     * Retorna uma coluna em uma determinada posi��o
     * @param  int   $index Posi��o
     * @return array        Coluna
     */
    public function getColuna($index) {
        if (sizeof($this->colunas) > 0) {
            return false;
        }

        return $this->colunas[$index];
    }

    /**
     * Retorna uma linha de uma determinada posi��o
     * @param  int   $index Posi��o
     * @return TabelaLinha  Linha
     */
    public function getLinha($index) {
        if (sizeof($this->linhas) > 0) {
            return false;
        }

        return $this->linhas[$index];
    }

    /**
     * Retorna a tabela em html
     * @param  boolean $return Caso "true" retorna ao inv�s de imprimir
     * @return boolean|string|void    
     */
    public function toHtml($return = false) {
        if (sizeof($this->colunas) == 0) {
            return false;
        }

        if ($this->attr) {
            $tableAttributes = array();
            foreach ($this->attr as $attribute => $value) {
                $tableAttributes[] = sprintf('%s="%s"', $attribute, $value);
            }
        }

        $html[] = sprintf('<table %s>', implode(' ', $tableAttributes));

        $tableHeader = array();
        foreach ($this->colunas as $coluna) {
            $colunaAttributes = array();
            if ($coluna['attr']) {
                foreach ($coluna['attr'] as $attribute => $value) {
                    $colunaAttributes[] = sprintf('%s="%s"', $attribute, $value);
                }
            }
            
            $tableHeader[] = sprintf('<th %s>%s</td>', implode(' ', $colunaAttributes), $coluna['nome']);
        }

        if ($this->header) {
            $html[] = '<thead>';
            $html[] = implode('', $tableHeader);
            $html[] = '</thead>';
        }

        $html[] = '<tbody>';
        //Conte�do
        if (sizeof($this->linhas) == 0) {
            $html[] = sprintf('<tr><td colspan="%s">%s</td></tr>', sizeof($this->colunas), Mensagem($this->errorMsg));
        }else{
            foreach($this->linhas as $linha) {
                $html[] = $linha->toHtml(true, sizeof($this->colunas));
            }
        }

        $html[] = '</tbody>';

        if ($this->footer) {
            $html[] = '<tfoot>';
            $html[] = implode('', $tableHeader);
            $html[] = '</tfoot>';
        }

        $html[] = '</table>';

        $retorno = implode('', $html);

        if ($return) {
            return $retorno;
        }

        echo $retorno;
    }
}