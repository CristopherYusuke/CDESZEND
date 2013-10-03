<?php

/*
 * 'placement' => Zend_Form_Decorator_Abstract::APPEND
 */

class Application_Form_Usuario_Login extends Zend_Form {
    public function __construct($options = null) {
        parent::__construct($options);
        $this->setAction('/login');
        $this->setMethod("POST");
        $this->addElement($inputLogin = new Zend_Form_Element_Text('login', array(
            'label' => 'Login',
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
                    'class' => 'small-12 small-centered large-10 columns',
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
                    'class' => 'small-12 small-centered large-10 columns',
                    'id' => array('callback' => array(get_class($inputSenha), 'resolveElementId'))
                ))
        ;
        $this->addElement($submit = new Zend_Form_Element_Submit('submit', array(
            'label' => 'Entrar',
            'disableLoadDefaultDecorators' => TRUE,
            'class' => 'button small success expand'
        )));
        $submit
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 small-centered large-10 columns',
                    'id' => array('callback' => array(get_class($submit), 'resolveElementId'))
                ))

        ;
    }
}

?>
