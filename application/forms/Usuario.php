<?php

/*
 * 'placement' => Zend_Form_Decorator_Abstract::APPEND
 */

class Application_Form_Usuario extends Zend_Form {
    /*
      public function __construct($options = null) {

      parent::__construct($options);

      //        $this->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'zend_form row '));
      //        $this->addDecorator(array('DivTag' => 'HtmlTag'), array('tag' => 'div', 'class' => 'row'));
      } */

    public function init() {

        $this->setAction("/usuario/create");
        $this->setMethod("POST");

        $this->addElement($id = new Zend_Form_Element_Hidden('idUsuario'));
        $id->removeDecorator('label');

        $this->addElement($inputNome = new Zend_Form_Element_Text('nome', array('label' => 'Nome',
            'required' => true,
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

        $this->addElement($inputLogin = new Zend_Form_Element_Text('login', array('label' => 'Login',
            'required' => true,
            'maxLength' => 49,
            'placeholder' => 'digite o seu Login',
            'disableLoadDefaultDecorators' => TRUE,
        )));
        $inputLogin
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 columns',
                    'id' => array('callback' => array(get_class($inputLogin), 'resolveElementId'))
                ))
        ;

        $this->addElement($inputSenha = new Zend_Form_Element_Password('senha', array(
            'label' => 'Senha',
            'required' => true,
            'maxLength' => 49,
            'placeholder' => 'digite a senha',
            'disableLoadDefaultDecorators' => TRUE,
        )));
        $inputSenha
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 columns',
                    'id' => array('callback' => array(get_class($inputSenha), 'resolveElementId'))
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
            'onClick' => "parent.location='/usuario'",
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
