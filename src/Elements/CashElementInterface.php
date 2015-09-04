<?php namespace Vdbf\Components\Cashweb\Elements;


interface CashElementInterface
{

    /**
     * @param \DOMDocument $document
     * @author Eelke van den Bos <eelkevdbos@gmail.com>
     * @return \DOMNode
     */
    public function assemble(\DOMDocument $document);

}