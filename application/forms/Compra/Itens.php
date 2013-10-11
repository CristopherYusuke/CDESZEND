<?php

/*
 * 'placement' => Zend_Form_Decorator_Abstract::APPEND
 */

class Application_Form_Compra_Itens extends Zend_Form {

    public function init() {

        $float = new Zend_Validate_Float();
        $float->setMessage(
                "'%value%' nao é um número decimal válido.", Zend_Validate_Float::NOT_FLOAT);


        $this->setAction("");
        $this->setMethod("POST");

        $this->addElement($id = new Zend_Form_Element_Hidden('idItemCompra'));
        $this->addElement($idCompra = new Zend_Form_Element_Hidden('idCompra'));

        $id->removeDecorator('label');
        $idCompra->removeDecorator('label');
        $this->addElement($selectPro = new Zend_Form_Element_Select('idProduto', array(
            'required' => true,
            'label' => 'Produto',
            'disableLoadDefaultDecorators' => TRUE)));
        $selectPro
                ->addMultiOption('', 'selecione')
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->setRegisterInArrayValidator(false)
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-4 columns',
                    'id' => array('callback' => array(get_class($selectPro), 'resolveElementId'))
                ))
        ;
        $Model = new Application_Model_DbTable_Produto();
        $produtos = $Model->fetchAll("status = 1")->toArray();
        foreach ($produtos as $c) {
            $selectPro->addMultiOption($c['idProduto'], $c['descricao']);
        }


        $this->addElement($qtde = new Zend_Form_Element_Text('qtde', array('label' => 'Quantidade',
            'required' => true,
            'disableLoadDefaultDecorators' => TRUE,
        )));
        $qtde
                ->addFilters(array('StripTags', 'StringTrim'))
                ->addValidators(array('Digits'))
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-3 columns',
                    'id' => array('callback' => array(get_class($qtde), 'resolveElementId'))
                ))
        ;

        $this->addElement($valor = new Zend_Form_Element_Text('compraPreco', array('label' => 'Preço',
            'required' => true,
            'readonly' => true,
            'disableLoadDefaultDecorators' => TRUE,
            'class' => 'disabled'            
        )));
        $valor
                ->addValidators(array($float))
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-3 columns',
                    'id' => array('callback' => array(get_class($valor), 'resolveElementId'))
                ))
        ;




        $this->addElement($total = new Zend_Form_Element_Text('total', array('label' => 'Total',
            'required' => true,
            'readonly' => true,
            'disableLoadDefaultDecorators' => TRUE,
            'class' => 'disabled'            
        )));


        $total
                ->addValidators(array($float))
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-2 columns',
                    'id' => array('callback' => array(get_class($total), 'resolveElementId'))
                ))
        ;

        $this->addElement($button = new Zend_Form_Element_Submit('addIten', array(
            'label' => 'Adicionar Item',
            'disableLoadDefaultDecorators' => TRUE,
            'onClick' => "parent.location='/venda'",
            'class' => 'button success small right'
        )));
        $button
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-2 columns',
                    'id' => array('callback' => array(get_class($button), 'resolveElementId'))
                ))
        ;
    }

}

?>
