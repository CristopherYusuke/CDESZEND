<?php

class Application_Form_Produto_Produto extends Zend_Form {

    public function init() {
        
        $Alnum = new Zend_Validate_Alnum(array('allowWhiteSpace' => true));
        $float = new Zend_Validate_Float();
        $float->setMessage(
                "'%value%' nao é um número decimal válido.", Zend_Validate_Float::NOT_FLOAT);

        $this->setAction("/produtos/create");
        $this->setMethod("POST");

        $this->addElement($id = new Zend_Form_Element_Hidden('idProduto'));
        $id->removeDecorator('label');

        $this->addElement($Status = new Zend_Form_Element_Checkbox('status', array(
            'label' => 'Ativo',
            'Value' => true)
        ));

        $Status
                ->addDecorator('Label', array(
                    'tag' => 'div',
                    'class' => ' small-10 columns text-right '))
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-2 columns ',
                    'id' => array('callback' => array(get_class($Status), 'resolveElementId'))
                ))

        ;
        $this->addElement($inputDesc = new Zend_Form_Element_Text('descricao', array('label' => 'Descricao',
            'required' => true,
            'maxLength' => 49,
            'placeholder' => 'digite a Descrição',
            'disableLoadDefaultDecorators' => TRUE,
        )));

        $inputDesc
                ->addValidators(array($Alnum))
                ->addFilters(array('StripTags', 'StringTrim'))
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-6 columns',
                    'id' => array('callback' => array(get_class($inputDesc), 'resolveElementId'))
                ))
        ;

        $this->addElement($inputPC = new Zend_Form_Element_Text('precoCusto', array('label' => 'Preco de Custo',
            'required' => true,
            'maxLength' => 49,
            'placeholder' => 'digite o seu Preco de Custo',
            'disableLoadDefaultDecorators' => TRUE,
        )));
        $inputPC
                ->addValidators(array($float))
                ->addFilters(array('StripTags', 'StringTrim'))
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-6 columns',
                    'id' => array('callback' => array(get_class($inputPC), 'resolveElementId'))
                ))
        ;
        $this->addElement($inputPV = new Zend_Form_Element_Text('precoVenda', array('label' => 'Preco de Venda',
            'required' => true,
            'maxLength' => 49,
            'placeholder' => 'digite o seu Preco de Venda',
            'disableLoadDefaultDecorators' => TRUE,
        )));
        $inputPV
                ->addValidators(array($float))
                ->addFilters(array('StripTags', 'StringTrim'))
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-6 columns',
                    'id' => array('callback' => array(get_class($inputPV), 'resolveElementId'))
                ))
        ;
        
        
        
        $this->addElement($inputEstoque = new Zend_Form_Element_Text('estoque', array('label' => 'Quantidade',
            'required' => true,
            'maxLength' => 49,
            'placeholder' => 'digite a quantidade',
            'disableLoadDefaultDecorators' => TRUE,
        )));
        $inputEstoque
                ->addFilters(array('StripTags', 'StringTrim'))
                ->addValidators(array('Digits'))
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-6 columns',
                    'id' => array('callback' => array(get_class($inputEstoque), 'resolveElementId'))
                ))
        ;
        $this->addElement($submit = new Zend_Form_Element_Submit('submit', array(
            'label' => 'Salvar',
            'disableLoadDefaultDecorators' => TRUE,
            'class' => 'button'
        )));
        $submit
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-6 columns',
                    'id' => array('callback' => array(get_class($submit), 'resolveElementId'))
                ))
        ;
        $this->addElement($button = new Zend_Form_Element_Button('button', array(
            'label' => 'Voltar',
            'disableLoadDefaultDecorators' => TRUE,
            'onClick' => "parent.location='/produtos'",
            'class' => 'secondary right'
        )));
        $button
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-6 columns',
                    'id' => array('callback' => array(get_class($button), 'resolveElementId'))
                ))
        ;
    }

}

?>
