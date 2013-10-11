 <?php

/*
 * 'placement' => Zend_Form_Decorator_Abstract::APPEND
 */

class Application_Form_Compra_Compra extends Zend_Form {

    public function __construct($options = null) {
        parent::__construct($options);
        $this->addElement($fornecedor = new Zend_Form_Element_Text('fornecedor', array('label' => 'fornecedor',
            'readonly' => true,
            'disableLoadDefaultDecorators' => TRUE,
            'class' => 'disabled'
        )));
        $fornecedor
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-4 columns',
                    'id' => array('callback' => array(get_class($fornecedor), 'resolveElementId'))
                ))
        ;
        $this->addElement($dataCompra = new Zend_Form_Element_Text('dataCompra', array('label' => 'Data da compra',
            'readonly' => true,
            'disableLoadDefaultDecorators' => TRUE,
            'class' => 'disabled'
        )));
        $dataCompra
                ->addFilters(array('StripTags', 'StringTrim'))
                ->setValidators(array(new Zend_Validate_Date(array('format' => 'dd/MM/yyyy'))))
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-4 columns',
                    'id' => array('callback' => array(get_class($dataCompra), 'resolveElementId'))
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
            'label' => 'Faturar Compra',
            'disableLoadDefaultDecorators' => TRUE,
            'onClick' =>'parent.location=/ContasPagar/create/idCompra/'
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
            'onClick' => "parent.location='/compra'",
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
