<?php

/*
 * 'placement' => Zend_Form_Decorator_Abstract::APPEND
 */

class Application_Form_CR_ContasReceber extends Application_Form_Venda_Venda {

    public function __construct($options = null) {
        parent::__construct($options);

        $this->getElement('situacao')->addDecorator('HtmlTag', array(
            'class' => 'small-12 large-6 columns',
        ));
        $this->getElement('dataVenda')->addDecorator('HtmlTag', array(
            'class' => 'small-12 large-6 columns',
        ));

        $this->getElement('cliente')->addDecorator('HtmlTag', array(
            'class' => 'small-12 large-6 columns',
        ));

        $this->addElement($TV = new Zend_Form_Element_Text('totalVenda', array('label' => 'Total da Venda',
            'readonly' => true,
            'disableLoadDefaultDecorators' => TRUE,
            'class' => 'disabled'
        )));
        $TV
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-6 columns',
                    'id' => array('callback' => array(get_class($TV), 'resolveElementId'))
                ))
        ;


        $this->addElement($selectFP = new Zend_Form_Element_Select('formasPagamento', array(
            'label' => 'Formas de Pagamento',
            'maxLength' => 50,
            'disableLoadDefaultDecorators' => TRUE,
            'class' => 'styled-select'
        )));

        $selectFP
                ->addMultiOption('0', 'A vista')
                ->addMultiOption('1', 'pagamento para 30 dias')
                ->addMultiOption('2', 'pagamento para 30-60 dias ')
                ->addMultiOption('3', 'pagamento para 30-60-90 dias')
                ->addMultiOption('4', 'pagamento para 30-60-90-120 dias')
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->setRegisterInArrayValidator(false)
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 small-centered large-4 columns',
                    'id' => array('callback' => array(get_class($selectFP), 'resolveElementId'))
                ))

        ;
        
        $this->addElement($Encerrar = new Zend_Form_Element_Submit('Faturar', array(
            'label' => 'Faturar Venda',
            'disableLoadDefaultDecorators' => TRUE,
            'class'=>'button expand'
        )));
        $Encerrar
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 small-centered large-4 columns',
                    'id' => array('callback' => array(get_class($Encerrar), 'resolveElementId'))
                ))

        ;
        
        
    }

}

?>
