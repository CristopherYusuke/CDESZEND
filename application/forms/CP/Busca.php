<?php

/*
 * 'placement' => Zend_Form_Decorator_Abstract::APPEND
 */

class Application_Form_CR_Busca extends Zend_Form {

    public function init() {

        $this->setAction("/ContasReceber");
        $this->setMethod("POST");
        
        $this->addElement($inputNome = new Zend_Form_Element_Text('nome', array('label' => 'Nome',
            'maxLength' => 49,
            'placeholder' => 'digite o nome para busca',
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
                    'class' => 'small-12 large-5 columns',
                    'id' => array('callback' => array(get_class($inputNome), 'resolveElementId'))
                ))
        ;
        $this->addElement($idVenda = new Zend_Form_Element_Text('idVenda', array('label' => 'Identificação da Venda',
            'maxLength' => 49,
            'placeholder' => 'digite o id da venda',
            'disableLoadDefaultDecorators' => TRUE,
        )));
        $idVenda
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-3 columns',
                    'id' => array('callback' => array(get_class($idVenda), 'resolveElementId'))
                ))
        ;
      
        
                

        $this->addElement($selectStatus = new Zend_Form_Element_Select('situacao', array(
            'label' => 'situação da venda   ',           
            'disableLoadDefaultDecorators' => TRUE,
            
        )));
        $selectStatus
                ->addMultiOption(0, 'Aberta')
                ->addMultiOption(1, 'Faturada')
                ->addMultiOption(2, 'Extornada')
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
            'class' => 'button'
        )));
        $submit
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-12 columns',
                    'id' => array('callback' => array(get_class($submit), 'resolveElementId'))
                ))

        ;

    }

}

?>
