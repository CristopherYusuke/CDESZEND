<?php

/*
 * 'placement' => Zend_Form_Decorator_Abstract::APPEND
 */

class Application_Form_Venda_Venda extends Zend_Form {

    public function init() {

        $this->setAction("/venda/create");
        $this->setMethod("POST");


        $this->addElement($id = new Zend_Form_Element_Hidden('idVenda'));
        $id->removeDecorator('label');


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



        $this->addElement($inputTelefone = new Zend_Form_Element_Text('telefone', array(
            'required' => true,
            'label' => 'Telefone',
            'maxLength' => 49,
            'placeholder' => 'Telefone',
            'disableLoadDefaultDecorators' => TRUE,
        )));
        $inputTelefone
                ->addValidators(array('Digits'))
                ->addFilters(array('StripTags', 'StringTrim'))
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12  large-4 columns',
                    'id' => array('callback' => array(get_class($inputTelefone), 'resolveElementId'))
                ))
        ;

        $this->addElement($inputEndereco = new Zend_Form_Element_Text('endereco', array(
            'required' => true,
            'label' => 'Endereco',
            'maxLength' => 49,
            'placeholder' => 'Endereco',
            'disableLoadDefaultDecorators' => TRUE,
        )));
        $inputEndereco
                ->addFilters(array('StripTags', 'StringTrim'))
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-4 columns',
                    'id' => array('callback' => array(get_class($inputEndereco), 'resolveElementId'))
                ))
        ;

        $this->addElement($inputNumero = new Zend_Form_Element_Text('numero', array(
            'required' => true,
            'label' => 'Numero',
            'placeholder' => 'Numero',
            'disableLoadDefaultDecorators' => TRUE,
        )));
        $inputNumero
                ->addFilters(array('StripTags', 'StringTrim'))
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-4 columns',
                    'id' => array('callback' => array(get_class($inputNumero), 'resolveElementId'))
                ))
        ;

        $this->addElement($inputBairro = new Zend_Form_Element_Text('bairro', array(
            'label' => 'Bairro',
            'placeholder' => 'Bairro',
            'disableLoadDefaultDecorators' => TRUE,
        )));
        $inputBairro
                ->addFilters(array('StripTags', 'StringTrim', 'alnum'))
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-4 columns',
                    'id' => array('callback' => array(get_class($inputBairro), 'resolveElementId'))
                ))
        ;

        $this->addElement($selectCli = new Zend_Form_Element_Select('idCliente', array(
            'label' => 'Cidade',
            'maxLength' => 50,
            'disableLoadDefaultDecorators' => TRUE,
            'class' => 'styled-select'
        )));
        $selectCli
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->setRegisterInArrayValidator(false)
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-4     columns',
                    'id' => array('callback' => array(get_class($selectCli), 'resolveElementId'))
                ))
        ;
        $Model = new Application_Model_DbTable_Cliente();
        $Clientes = $Model->fetchAll("status = 1")->toArray();
        foreach ($Clientes as $c) {
            $selectCli->addMultiOption($c['idCliente'], $c['nome']);
        }


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
            'onClick' => "parent.location='/venda'",
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
