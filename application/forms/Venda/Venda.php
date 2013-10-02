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
        
         $this->addElement($selectCli = new Zend_Form_Element_Select('idCliente', array(
            'label' => 'Cliente',
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
                    'class' => 'small-12 large-6     columns',
                    'id' => array('callback' => array(get_class($selectCli), 'resolveElementId'))
                ))
        ;
        $Model = new Application_Model_DbTable_Cliente();
        $Clientes = $Model->fetchAll("status = 1")->toArray();
        foreach ($Clientes as $c) {
            $selectCli->addMultiOption($c['idCliente'], $c['nome']);
        }

        
        $this->addElement($dataVenda = new Zend_Form_Element_Text('dataVenda', array('label' => 'Data da venda',
            'required' => true,
            'value' => date('d/m/Y'),
            'disableLoadDefaultDecorators' => TRUE,
        )));
        $dataVenda
                ->addFilters(array('StripTags', 'StringTrim'))
                ->setValidators(array(new Zend_Validate_Date(array('format' => 'dd/MM/yyyy'))))
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-6 columns',
                    'id' => array('callback' => array(get_class($dataVenda), 'resolveElementId'))
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
                    'class' => 'small-12 large-4 columns',
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
                    'class' => 'small-12 large-4 columns',
                    'id' => array('callback' => array(get_class($button), 'resolveElementId'))
                ))
        ;
         $this->addElement($buttonAddItem = new Zend_Form_Element_Button('buttonAdd', array(
            'label' => 'Adicionar Itens de venda',
            'disableLoadDefaultDecorators' => TRUE,
            'onClick' => "parent.location='/venda'",
            'class' => ' right'
        )));
        $buttonAddItem
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-4 columns',
                    'id' => array('callback' => array(get_class($buttonAddItem), 'resolveElementId'))
                ))
        ;
    }

}

?>
