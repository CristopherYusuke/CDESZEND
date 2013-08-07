<?php

/*
 * 'placement' => Zend_Form_Decorator_Abstract::APPEND
 */

class Application_Form_Cliente extends Zend_Form {

    public function init() {

        $this->setAction("/cliente/create");
        $this->setMethod("POST");

        $this->addElement($id = new Zend_Form_Element_Hidden('idCliente'));
        $id->removeDecorator('label');

        $this->addElement($radioTipo = new Zend_Form_Element_Radio('Tipo', array(
            'label' => 'Tipo Cliente',
            'required' => true,
            'multiOptions' => array(
                'val1' => 'Text 1',
                'val2' => 'Text 2',
            ))
        ));
        $radioTipo
                ->addDecorator('Label', array(
                    'tag' => 'div',
                    'class' => 'small-3 columns'))
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-9 columns',
                    'id' => array('callback' => array(get_class($radioTipo), 'resolveElementId'))
                ))
        ;

        $this->addElement($inputNome = new Zend_Form_Element_Text('nome', array('label' => 'Nome',
            'maxLength' => 49,
            'placeholder' => 'digite o seu nome',
            'disableLoadDefaultDecorators' => TRUE,
        )));
        $inputNome
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 columns',
                    'id' => array('callback' => array(get_class($inputNome), 'resolveElementId'))
                ))
        ;
        $this->addElement($inputCPF = new Zend_Form_Element_Text('CPF', array('label' => 'CPF',
            'maxLength' => 49,
            'placeholder' => 'CPF',
            'disableLoadDefaultDecorators' => TRUE,
        )));
        $inputCPF
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 columns',
                    'id' => array('callback' => array(get_class($inputCPF), 'resolveElementId'))
                ))
        ;
        $this->addElement($inputCNPJ = new Zend_Form_Element_Text('CNPJ', array('label' => 'CNPJ',
            'maxLength' => 49,
            'placeholder' => 'CNPJ',
            'disableLoadDefaultDecorators' => TRUE,
        )));
        $inputCNPJ
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 columns',
                    'id' => array('callback' => array(get_class($inputCNPJ), 'resolveElementId'))
                ))
        ;

        $this->addElement($inputTelefone = new Zend_Form_Element_Text('telefone', array(
            'label' => 'Telefone',
            'maxLength' => 49,
            'placeholder' => 'Telefone',
            'disableLoadDefaultDecorators' => TRUE,
        )));
        $inputTelefone
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 columns',
                    'id' => array('callback' => array(get_class($inputTelefone), 'resolveElementId'))
                ))
        ;
        $this->addElement($inputCelular = new Zend_Form_Element_Text('celular', array(
            'label' => 'Celular',
            'maxLength' => 49,
            'placeholder' => 'Celular',
            'disableLoadDefaultDecorators' => TRUE,
        )));
        $inputCelular
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 columns',
                    'id' => array('callback' => array(get_class($inputCelular), 'resolveElementId'))
                ))
        ;
        $this->addElement($inputDataNasc = new Zend_Form_Element_Text('dataNasc', array(
            'label' => 'Data de Nascimento',
            'placeholder' => 'Data de Nascimento',
            'class' => 'datepicker',
            'disableLoadDefaultDecorators' => TRUE,
        )));
        $inputDataNasc
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 columns',
                    'id' => array('callback' => array(get_class($inputDataNasc), 'resolveElementId'))
                ))
        ;




        $this->addElement($select = new Zend_Form_Element_Select('tp_acesso', array(
            'label' => 'Tipo de acesso',
            'required' => true,
            'maxLength' => 49,
            'disableLoadDefaultDecorators' => TRUE,
            'class' => 'styled-select'
        )));
        $select
                ->addMultiOption('A', 'Administrador')
                ->addMultiOption('V', 'Vendedor')
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12  columns',
                    'id' => array('callback' => array(get_class($select), 'resolveElementId'))
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
            'onClick' => "parent.location='/cliente'",
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
