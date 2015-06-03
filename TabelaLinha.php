<?php

/**
 * @package HotClass
 * @subpackage Tabela
 * @author  Diego Schell Fernandes <diego@areacentral.com.br>
 * @since   3.9.6 
 */

class TabelaLinha {

    /**
     * Atributos adicionais da tabela
     * @var array
     */
    private $attr = array();

    /**
     * Informações das colunas
     * @var array
     */
    private $colunas = array();

    /**
     * Tipo de coluna (td, th)
     * @var string
     */
    private $tipo;

    /**
     * Cria uma nova tabela
     * @param boolean $header Se o <thead> será visível
     * @param boolean $footer Se o <thoot> será visível
     */ 
    public function __construct($attr = array(), $tipo) {
        $this->attr = $attr;
        $this->tipo = $tipo;
    }

    /**
     * Adiciona uma nova coluna à tabela
     * @param string $nome  Nome da coluna para o <thead>
     * @param array  $attr  Atributos adicionais do <td>
     * @return TabelaLinha Objeto de tabela atual
     */ 
    public function addColuna($nome, $attr = array(), $main = false) {
        $this->colunas[] = array(
            'nome' => $nome,
            'attr' => $attr,
            'main' => $main
        );

        return $this;
    }

    /**
     * Retorna uma coluna em uma determinada posição
     * @param  int   $index Posição
     * @return array        Coluna
     */
    public function getColuna($index) {
        if (sizeof($this->colunas) > 0) {
            return false;
        }

        return $this->colunas[$index];
    }

    /**
     * Converte a linha em html
     * @param  boolean $return  Caso "true" retorna ao invés de imprimir
     * @param  integer $colunas Número de colunas da tabela para colspan
     * @return boolean|string|void          
     */
    public function toHtml($return = false, $colunas = 0) {
        if (sizeof($this->colunas) == 0) {
            return false;
        }

        $linhaAttributes = array();
        if ($this->attr) {
            foreach ($this->attr as $attribute => $value) {
                $linhaAttributes[] = sprintf('%s="%s"', $attribute, $value);
            }
        }

        $html[] = sprintf('<tr %s>', implode(' ', $linhaAttributes));

        foreach ($this->colunas as $coluna) {
            $colunaAttributes = array();
            if ($coluna['attr']) {
                foreach ($coluna['attr'] as $attribute => $value) {
                    $colunaAttributes[] = sprintf('%s="%s"', $attribute, $value);
                }
            }

            $html[] = sprintf('<%1$s %2$s %3$s>%4$s</%1$s>', 
                $this->tipo,
                implode(' ', $colunaAttributes), 
                ($coluna['main'] && sizeof($this->colunas) < $colunas ? sprintf('colspan="%s"',  $colunas - sizeof($this->colunas) + 1) : ''),
                $coluna['nome']
            );
        }

        $html[] = '</tr>';

        $retorno = implode('', $html);

        if ($return) {
            return $retorno;
        }

        echo $retorno;
    }

}