<?php

/*
 * 'placement' => Zend_Form_Decorator_Abstract::APPEND
 */

class Application_Form_Venda_Venda extends Zend_Form {

    public function __construct($options = null) {
        parent::__construct($options);

//        $this->setAction("");

        /*
         * 
         

         */
        $this->addElement($cliente = new Zend_Form_Element_Text('cliente', array('label' => 'cliente',
            'readonly' => true,
            'disableLoadDefaultDecorators' => TRUE,
            'class' => 'disabled'
        )));
        $cliente
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-4 columns',
                    'id' => array('callback' => array(get_class($cliente), 'resolveElementId'))
                ))
        ;
        $this->addElement($dataVenda = new Zend_Form_Element_Text('dataVenda', array('label' => 'Data da venda',
            'readonly' => true,
            'disableLoadDefaultDecorators' => TRUE,
            'class' => 'disabled'
        )));
        $dataVenda
                ->addFilters(array('StripTags', 'StringTrim'))
                ->setValidators(array(new Zend_Validate_Date(array('format' => 'dd/MM/yyyy'))))
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-4 columns',
                    'id' => array('callback' => array(get_class($dataVenda), 'resolveElementId'))
                ))
        ;

        $this->addElement($situacao = new Zend_Form_Element_Text('situacao', array('label' => 'situacao',
            'readonly' => true,
            'disableLoadDefaultDecorators' => TRUE,
            'class' => 'disabled'
        )));
        $situacao
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-4 columns',
                    'id' => array('callback' => array(get_class($situacao), 'resolveElementId'))
                ))
        ;


        $this->addElement($Encerrar = new Zend_Form_Element_Button('Faturar', array(
            'label' => 'Faturar Venda',
            'disableLoadDefaultDecorators' => TRUE,
        )));
        $Encerrar
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-6 large-6 columns',
                    'id' => array('callback' => array(get_class($Encerrar), 'resolveElementId'))
                ))

        ;


        $this->addElement($button = new Zend_Form_Element_Button('button', array(
            'label' => 'Voltar',
            'disableLoadDefaultDecorators' => TRUE,
            'onClick' => "parent.location='/venda'",
            'class' => 'secondary right'
        )));
        $button
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-6 large-6 columns',
                    'id' => array('callback' => array(get_class($button), 'resolveElementId'))
                ))
        ;
    }

}

?>
