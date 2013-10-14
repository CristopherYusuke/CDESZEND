<?php

/*
 * 'placement' => Zend_Form_Decorator_Abstract::APPEND
 */

class Application_Form_CP_Busca extends Zend_Form {

    public function init() {

        $this->setAction("/ContasPagar");
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
        $this->addElement($idCompra = new Zend_Form_Element_Text('idCompra', array('label' => 'Identificação da Compra',
            'maxLength' => 49,
            'placeholder' => 'digite o id da Compra',
            'disableLoadDefaultDecorators' => TRUE,
        )));
        $idCompra
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-3 columns',
                    'id' => array('callback' => array(get_class($idCompra), 'resolveElementId'))
                ))
        ;
      
        
                

        $this->addElement($selectStatus = new Zend_Form_Element_Select('situacao', array(
            'label' => 'situação da compra   ',           
            'disableLoadDefaultDecorators' => TRUE,
            
        )));
        $selectStatus
                ->addMultiOption(0, 'Aberta')
                ->addMultiOption(1, 'Faturada')
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
