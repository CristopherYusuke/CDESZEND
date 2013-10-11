<?php

class Application_Form_CP_Pagamento extends Zend_Form {

    public function __construct($options = null) {
        parent::__construct($options);

        $this->addElement($id = new Zend_Form_Element_Hidden('idContasP'));
        $id->removeDecorator('label');

        $this->addElement($idvenda = new Zend_Form_Element_Hidden('idCompra'));
        $idvenda->removeDecorator('label');

        $this->addElement($inputNome = new Zend_Form_Element_Text('nome', array('label' => 'Nome',
            'required' => true,
            'maxLength' => 49,
            'placeholder' => 'digite o seu nome',
            'disableLoadDefaultDecorators' => TRUE,
        )));
        $inputNome
                ->addFilters(array('StripTags', 'StringTrim'))
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-6 columns',
                    'id' => array('callback' => array(get_class($inputNome), 'resolveElementId'))
                ))
        ;
        $this->addElement($valorPago = new Zend_Form_Element_Text('valorPago', array('label' => 'Valor Pago',
            'required' => true,
            'maxLength' => 49,
            'placeholder' => 'digite o Valor que sera pago',
            'disableLoadDefaultDecorators' => TRUE,
        )));
        $valorPago
                ->addFilters(array('StripTags', 'StringTrim'))
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-6 columns',
                    'id' => array('callback' => array(get_class($valorPago), 'resolveElementId'))
                ))
        ;
        $this->addElement($valor = new Zend_Form_Element_Text('valor', array('label' => 'Valor ',
            'required' => true,
            'maxLength' => 49,
            'disableLoadDefaultDecorators' => TRUE,
        )));
        $valor
                ->addFilters(array('StripTags', 'StringTrim'))
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-6 columns',
                    'id' => array('callback' => array(get_class($valor), 'resolveElementId'))
                ))
        ;
        $this->addElement($vencimento = new Zend_Form_Element_Text('vencimento', array('label' => 'Data de Vencimento',
            'required' => true,
            'maxLength' => 49,
            'placeholder' => 'digite o seu nome',
            'disableLoadDefaultDecorators' => TRUE,
        )));
        $vencimento
                ->addFilters(array('StripTags', 'StringTrim'))
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-6 columns',
                    'id' => array('callback' => array(get_class($vencimento), 'resolveElementId'))
                ))
        ;
        $this->addElement($pagamento = new Zend_Form_Element_Text('pagamento', array('label' => 'Data de Pagamento',
            'required' => true,
            'maxLength' => 49,
            'disableLoadDefaultDecorators' => TRUE,
        )));
        $pagamento
                ->addFilters(array('StripTags', 'StringTrim'))
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-6 columns',
                    'id' => array('callback' => array(get_class($pagamento), 'resolveElementId'))
                ))
        ;
        $this->addElement($numParcela = new Zend_Form_Element_Text('numParcela', array('label' => 'Numero da Parcela',
            'required' => true,
            'maxLength' => 49,
            'disableLoadDefaultDecorators' => TRUE,
        )));
        $numParcela
                ->addFilters(array('StripTags', 'StringTrim'))
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-6 columns',
                    'id' => array('callback' => array(get_class($numParcela), 'resolveElementId'))
                ))
        ;
        $this->addElement($situacao = new Zend_Form_Element_Text('situacao', array('label' => 'Situação',
            'required' => true,
            'maxLength' => 49,
            'disableLoadDefaultDecorators' => TRUE,
        )));
        $situacao
                ->addFilters(array('StripTags', 'StringTrim'))
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-6 columns',
                    'id' => array('callback' => array(get_class($situacao), 'resolveElementId'))
                ))
        ;

        $this->addElement($button = new Zend_Form_Element_Submit('submit', array('label' => 'Pagar Fatura', 'class' => 'button')));
        $button
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-12 columns',
                    'id' => array('callback' => array(get_class($button), 'resolveElementId'))
                ))

        ;
    }

}

?>
