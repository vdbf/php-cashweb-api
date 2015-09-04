<?php namespace Vdbf\Components\Cashweb\Elements;

use DOMDocument;

class AbstractElement implements CashElementInterface
{

    protected $name;

    protected $value;

    protected $children = [];

    protected $attributes = [];

    /**
     * @param DOMDocument $document
     * @author Eelke van den Bos <eelkevdbos@gmail.com>
     * @return \DOMNode
     */
    public function assemble(DOMDocument $document)
    {
        /** @var \DOMNode $node */
        $element = $document->createElement($this->getName(), $this->getValue());
        $node = $document->appendChild($element);

        foreach ($this->getChildren() as $child) {

            /** @var CashElementInterface $child */
            $node->appendChild($child->assemble($document));
        }

        foreach ($this->getAttributes() as $key => $value) {
            $node->setAttribute($key, $value);
        }

        return $node;
    }

    public function appendElement(CashElementInterface $element)
    {
        $this->children[] = $element;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return array
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param array $children
     */
    public function setChildren($children)
    {
        $this->children = $children;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param array $attributes
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Strip string from all illegal chars used by cash
     *
     * @param $input
     * @author Eelke van den Bos <eelkevdbos@gmail.com>
     * @return mixed
     */
    public static function safeStr($input)
    {
        return str_replace(['%', '/', '.', '+', '&'], '', $input);
    }

}