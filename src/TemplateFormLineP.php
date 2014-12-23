<?php

namespace hemio\form;

use hemio\html;

/**
 * 
 *
 */
class TemplateFormLineP
        extends Abstract_\TemplateFormLine {

    protected $blnContentSattled = false;
    protected $objFormElement = null;
    public $value = '';

    public function __construct() {
        $this['_P'] = new html\P;
        $this['_P']['_LABEL'] = new html\Label();
        $this['_P']['_LABEL']['_SPAN'] = new html\Span();
    }

    public function addInheritableAppendage($key, $appendage) {
        parent::addInheritableAppendage($key, $appendage);
        switch ($key) {
            case '_INPUT_ELEMENT':
                $this->blnContentSattled = false;
                break;
        }
    }

    public function __toString() {
        if (!$this->blnContentSattled) {
            $this->sattleContent();
        }

        return parent::__toString();
    }

    public function setFormElement(Abstract_\Input $objFormElement) {
        $this->objFormElement = $objFormElement;
    }

    public function sattleContent() {
        $inputHtml = $this->getInheritableAppendage('_INPUT_ELEMENT');
        if (!($inputHtml instanceof html\Interface_\InputElement))
                trigger_error('TemplateFormLineP got no Input field',
                    E_USER_ERROR);

        $inputForm = $this->objFormElement;

        if ($inputHtml !== null && $inputForm !== null) {
            $inputHtml->setAttribute('name', $inputForm->getHtmlName());
            $inputHtml->setId($inputForm->getHtmlName());

            $this['_P']['_INPUT_ELEMENT'] = $inputHtml;
            $this['_P']['_LABEL']['_SPAN'][] = new L10nStr($inputForm->getName());

            $this->blnContentSattled = true;
        }
    }

}