<?php

/*
 * 'placement' => Zend_Form_Decorator_Abstract::APPEND
 */

class Application_Form_Venda_Busca extends Zend_Form {

    public function init() {

        
        
        $this->setAction("/venda");
        $this->setMethod("POST");
        
        $this->addElement($inputNome = new Zend_Form_Element_Text('nome', array('label' => 'Nome',
            'maxLength' => 49,
            'placeholder' => 'digite o nome para busca',
            'disableLoadDefaultDecorators' => TRUE,
        )));
        $inputNome
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-8 columns',
                    'id' => array('callback' => array(get_class($inputNome), 'resolveElementId'))
                ))
        ;
      
        
        /*
           $this->addElement($selectCli = new Zend_Form_Element_Select('idCliente', array(
        'label' => 'Cliente')));
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
         */
        

        $this->addElement($selectStatus = new Zend_Form_Element_Select('status', array(
            'label' => 'situação da venda   ',           
            'disableLoadDefaultDecorators' => TRUE,
            
        )));
        $selectStatus
                ->addMultiOption(0, 'Aberta')
                ->addMultiOption(1, 'Cancelada')
                ->addMultiOption(2, 'Faturada')
                ->addMultiOption(3, 'Finalizada')
                ->addMultiOption(4, 'Extornada')
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-4  columns',
                    'id' => array('callback' => array(get_class($selectStatus), 'resolveElementId'))
                ))
        ;
   

        $this->addElement($submit = new Zend_Form_Element_Submit('submit', array(
            'label' => 'Buscar',
            'disableLoadDefaultDecorators' => TRUE,
            'class' => 'button'
        )));
        $submit
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-12 columns',
                    'id' => array('callback' => array(get_class($submit), 'resolveElementId'))
                ))

        ;

    }

}

?>
