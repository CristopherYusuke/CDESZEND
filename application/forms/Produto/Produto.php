<?php

class Application_Form_Produto_Produto extends Zend_Form {

    public function init() {

        $this->setAction("/usuario/create");
        $this->setMethod("POST");

        $this->addElement($id = new Zend_Form_Element_Hidden('idProduto'));
        $id->removeDecorator('label');

        $this->addElement($Status = new Zend_Form_Element_Checkbox('status', array(
            'label' => 'Ativo')
        ));

        $Status
                ->addDecorator('Label', array(
                    'tag' => 'div',
                    'class' => ' small-10 columns text-right '))
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-2 columns panel',
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
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 columns',
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
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-6 columns',
                    'id' => array('callback' => array(get_class($inputPC), 'resolveElementId'))
                ))
        ;
        $this->addElement($inputEstoque = new Zend_Form_Element_Text('estoque', array('label' => 'Quantidade',
            'required' => true,
            'maxLength' => 49,
            'placeholder' => 'digite a quantidade',
            'disableLoadDefaultDecorators' => TRUE,
        )));
        $inputEstoque
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
