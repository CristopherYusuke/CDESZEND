<?php

/*
 * 'placement' => Zend_Form_Decorator_Abstract::APPEND
 */

class Application_Form_Venda_Itens extends Zend_Form {

    public function init() {

        $float = new Zend_Validate_Float();
        $float->setMessage(
                "'%value%' nao é um número decimal válido.", Zend_Validate_Float::NOT_FLOAT);


        $this->setAction("");
        $this->setMethod("POST");

        $this->addElement($id = new Zend_Form_Element_Hidden('idItemVenda'));
        $this->addElement($idVenda = new Zend_Form_Element_Hidden('idVenda'));
        
        $id->removeDecorator('label');
        $idVenda->removeDecorator('label');
        
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


        /*
         * 
          $this->addElement($selectFP = new Zend_Form_Element_Select('formasPagamento', array(
          'label' => 'Formas de Pagamento',
          'maxLength' => 50,
          'disableLoadDefaultDecorators' => TRUE,
          'class' => 'styled-select'
          )));

          $selectFP
          ->addMultiOption('0','A vista')
          ->addMultiOption('30','pagamento para 30 dias')
          ->addMultiOption('60','pagamento para 30-60 dias ')
          ->addMultiOption('90','pagamento para 30-60-90 dias')
          ->addMultiOption('120','pagamento para 30-60-90-120 dias')
          ->addDecorator('ViewHelper')
          ->addDecorator('Errors')
          ->addDecorator('Label', array())
          ->setRegisterInArrayValidator(false)
          ->addDecorator('HtmlTag', array(
          'tag' => 'div',
          'class' => 'small-12 large-4     columns',
          'id' => array('callback' => array(get_class($selectFP), 'resolveElementId'))
          ))

          ;

         */

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
                    'class' => 'small-12 large-2 columns',
                    'id' => array('callback' => array(get_class($qtde), 'resolveElementId'))
                ))
        ;

        $this->addElement($valor = new Zend_Form_Element_Text('vendaPreco', array('label' => 'Preço',
            'required' => true,
            'disableLoadDefaultDecorators' => TRUE,
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
            'disableLoadDefaultDecorators' => TRUE,
        )));

        $total
                ->addValidators(array($float))
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-3 columns',
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
