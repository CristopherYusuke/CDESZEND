<?php

/*
 * 'placement' => Zend_Form_Decorator_Abstract::APPEND
 */

class Application_Form_Produto_Busca extends Zend_Form {

    public function init() {

        
        
        $this->setAction("/Produtos");
        $this->setMethod("POST");
        
        $this->addElement($inputNome = new Zend_Form_Element_Text('descricao', array(
            'label' => 'Descrição   ',
            'maxLength' => 49,
            'placeholder' => 'Digite a descrição do produto para busca',
            'disableLoadDefaultDecorators' => TRUE,
        )));
        $inputNome
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-8 columns',
                    'id' => array('callback' => array(get_class($inputNome), 'resolveElementId'))
                ))
        ;
      
          $this->addElement($selectStatus = new Zend_Form_Element_Select('status', array(
            'label' => 'Status do Produto   ',
            'maxLength' => 49,
            'disableLoadDefaultDecorators' => TRUE,
            
        )));
        $selectStatus
                ->addMultiOption(1, 'Ativo')
                ->addMultiOption(0, 'Inativo')
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-4  columns',
                    'id' => array('callback' => array(get_class($selectStatus), 'resolveElementId'))
                ))
        ;
        
        
        $this->addElement($submit = new Zend_Form_Element_Submit('submit', array(
            'label' => 'Buscar',
            'disableLoadDefaultDecorators' => TRUE,
            'class' => 'button '
        )));
        $submit
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-2 columns',
                    'id' => array('callback' => array(get_class($submit), 'resolveElementId'))
                ))

        ;

    }

}

?>
