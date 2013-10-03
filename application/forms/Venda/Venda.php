<?php

/*
 * 'placement' => Zend_Form_Decorator_Abstract::APPEND
 */

class Application_Form_Venda_Venda extends Zend_Form {

    public function init() {

//        $this->setAction("");
        $this->setMethod("POST");


        $this->addElement($id = new Zend_Form_Element_Hidden('idVenda'));
        $id->removeDecorator('label');


/*
 * 
        $this->addElement($selectFP = new Zend_Form_Element_Select('formasPagamento', array(
            'label' => 'Formas de Pagamento',
            'maxLength' => 50,
            'disableLoadDefaultDecorators' => TRUE,
            'class' => 'styled-select'
        )));

        $selectFP
                ->addMultiOption('0','A vista')
                ->addMultiOption('30','pagamento para 30 dias')
                ->addMultiOption('60','pagamento para 30-60 dias ')
                ->addMultiOption('90','pagamento para 30-60-90 dias')
                ->addMultiOption('120','pagamento para 30-60-90-120 dias')
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->setRegisterInArrayValidator(false)
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-4     columns',
                    'id' => array('callback' => array(get_class($selectFP), 'resolveElementId'))
                ))

        ;

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
            'value' => 'Aberta',
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


        $this->addElement($Encerrar = new Zend_Form_Element_Button('Encerrar', array(
            'label' => 'Encerrar Venda',
            'disableLoadDefaultDecorators' => TRUE,
            'class' => 'button'
        )));
        $Encerrar
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-4 columns',
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
                    'class' => 'small-12 large-4 columns',
                    'id' => array('callback' => array(get_class($button), 'resolveElementId'))
                ))
        ;
    }

}

?>
