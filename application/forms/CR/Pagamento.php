<?php

class Application_Form_CR_Pagamento extends Zend_Form {

    public function __construct($options = null) {
        parent::__construct($options);
        $float = new Zend_Validate_Float();
        $this->addElement($id = new Zend_Form_Element_Hidden('idContasR'));
        $id->removeDecorator('label');

        $this->addElement($idvenda = new Zend_Form_Element_Hidden('idVenda'));
        $idvenda->removeDecorator('label');

        $this->addElement($inputNome = new Zend_Form_Element_Text('nome', array('label' => 'Nome',
            'readonly' => 'true',
            'class' => 'disabled',
            'disableLoadDefaultDecorators' => TRUE,
        )));
        $inputNome
                ->addFilters(array('StripTags', 'StringTrim'))
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-4 columns',
                    'id' => array('callback' => array(get_class($inputNome), 'resolveElementId'))
                ))
        ;


        $this->addElement($vencimento = new Zend_Form_Element_Text('vencimento', array('label' => 'Data de Vencimento',
            'readonly' => true,
            'class' => 'disabled',
            'disableLoadDefaultDecorators' => TRUE,
        )));
        $vencimento
                ->addFilters(array('StripTags', 'StringTrim'))
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-4 columns',
                    'id' => array('callback' => array(get_class($vencimento), 'resolveElementId'))
                ))
        ;

        $this->addElement($numParcela = new Zend_Form_Element_Text('numParcela', array('label' => 'Numero da Parcela',
            'readonly' => true,
            'class' => 'disabled',
            'disableLoadDefaultDecorators' => TRUE,
        )));
        $numParcela
                ->addFilters(array('StripTags', 'StringTrim'))
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-4 columns',
                    'id' => array('callback' => array(get_class($numParcela), 'resolveElementId'))
                ))
        ;

        $this->addElement($valor = new Zend_Form_Element_Text('valor', array('label' => 'Valor ',
            'readonly' => true,
            'class' => 'disabled',
            'disableLoadDefaultDecorators' => TRUE,
        )));
        $valor
                ->addFilters(array('StripTags', 'StringTrim'))
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12   large-6 columns',
                    'id' => array('callback' => array(get_class($valor), 'resolveElementId'))
                ))
        ;



        $this->addElement($valorPago = new Zend_Form_Element_Text('valorPago', array('label' => 'Valor Pago',
            'readonly' => true,
            'class' => 'disabled',
            'disableLoadDefaultDecorators' => TRUE,
        )));
        $valorPago
                ->addFilters(array('StripTags', 'StringTrim'))
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12   large-6 columns',
                    'id' => array('callback' => array(get_class($valorPago), 'resolveElementId'))
                ))
        ;
        $this->addElement($valorPagar = new Zend_Form_Element_Text('valorPagar', array('label' => 'Valora Pagar',
            'required' => true,
            'maxLength' => 49,
            'placeholder' => 'digite o Valor que sera pago',
            'disableLoadDefaultDecorators' => TRUE,
        )));
        $valorPagar
                ->addValidator($float)
                ->addFilters(array('StripTags', 'StringTrim'))
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12   large-6 columns',
                    'id' => array('callback' => array(get_class($valorPago), 'resolveElementId'))
                ))
        ;
        $this->addElement($restante = new Zend_Form_Element_Text('restante', array('label' => 'Restante/Troco',
            'readonly' => true,
            'class' => 'disabled',
            'placeholder' => 'Restante',
            'disableLoadDefaultDecorators' => TRUE,
        )));
        $restante
                ->addFilters(array('StripTags', 'StringTrim'))
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12   large-6 columns',
                    'id' => array('callback' => array(get_class($restante), 'resolveElementId'))
                ))
        ;


        $this->addElement($button = new Zend_Form_Element_Submit('submit', array('label' => 'PAGAR', 'class' => 'button')));
        $button
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-6 large-6 columns',
                    'id' => array('callback' => array(get_class($button), 'resolveElementId'))
                ))

        ;
        $this->addElement($voltar = new Zend_Form_Element_Button('Voltar', array('label' => 'VOLTAR', 'class' => 'button secondary right')));
        $voltar
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-6 large-6  columns',
                    'id' => array('callback' => array(get_class($voltar), 'resolveElementId'))
                ))

        ;
    }

}

?>
