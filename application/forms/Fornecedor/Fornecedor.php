<?php

/*
 * 'placement' => Zend_Form_Decorator_Abstract::APPEND
 */

class Application_Form_Fornecedor_Fornecedor extends Zend_Form {

    public function init() {

        $this->setAction("/fornecedor/create");
        $this->setMethod("POST");
       
                
        $this->addElement($id = new Zend_Form_Element_Hidden('idFornecedor'));
        $id->removeDecorator('label');

        $this->addElement($radioTipo = new Zend_Form_Element_Radio('tipo', array(
            'label' => 'Tipo Fornecedor',
            'required' => true,
            'multiOptions' => array(
                'F' => 'Fisico',
                'J' => 'Juridico',
            ))
        ));

        $radioTipo
                ->addDecorator('Label', array(
                    'tag' => 'div',
                    'class' => 'small-6 columns text-right '))
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => ' small-6 columns panel ',
                    'id' => array('callback' => array(get_class($radioTipo), 'resolveElementId'))
                ))
                ->setValue("F");
        ;

        $this->addElement($Status = new Zend_Form_Element_Checkbox('status', array(
            'label' => 'Ativo',
            'Value' => true
            )
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

        $this->addElement($inputNome = new Zend_Form_Element_Text('nome', array('label' => 'Nome',
            'maxLength' => 49,
            'placeholder' => 'digite o seu nome',
            'disableLoadDefaultDecorators' => TRUE,
        )));
        $inputNome
                ->setRequired(true)
                ->addFilters(array('StripTags','StringTrim'))
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-6 columns',
                    'id' => array('callback' => array(get_class($inputNome), 'resolveElementId'))
                ))
        ;
        $this->addElement($inputCPF_CNPJ = new Zend_Form_Element_Text('CPF_CNPJ', array('label' => 'CPF_CNPJ',
            'maxLength' => 49,
            'placeholder' => 'CPF_CNPJ',
            'disableLoadDefaultDecorators' => TRUE,
        )));
        $inputCPF_CNPJ
                ->setRequired(true)
                ->addValidator(new Zend_Validate_Db_NoRecordExists('fornecedor', 'CPF_CNPJ'))
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addFilter('Digits')
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-6  columns',
                    'id' => array('callback' => array(get_class($inputCPF_CNPJ), 'resolveElementId'))
                ))
        ;


        $this->addElement($inputTelefone = new Zend_Form_Element_Text('telefone', array(
            'label' => 'Telefone',
            'maxLength' => 49,
            'placeholder' => 'Telefone',
            'disableLoadDefaultDecorators' => TRUE,
        )));
        $inputTelefone
                ->addValidators(array('Digits'))
                ->addFilters(array('StripTags','StringTrim'))
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12  large-4 columns',
                    'id' => array('callback' => array(get_class($inputTelefone), 'resolveElementId'))
                ))
        ;


        /*
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
         */

        $this->addElement($inputEndereco = new Zend_Form_Element_Text('endereco', array(
            'label' => 'Endereco',
            'maxLength' => 49,
            'placeholder' => 'Endereco',
            'disableLoadDefaultDecorators' => TRUE,
        )));
        $inputEndereco
                ->setRequired(true)
                ->addFilters(array('StripTags','StringTrim'))
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
            'label' => 'Numero',
            'placeholder' => 'Numero',
            'disableLoadDefaultDecorators' => TRUE,
        )));
        $inputNumero
                ->setRequired(true)
                ->addValidators(array('Digits'))
                ->addFilters(array('StripTags','StringTrim'))
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
                ->addFilters(array('StripTags','StringTrim','alnum'))
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-4 columns',
                    'id' => array('callback' => array(get_class($inputBairro), 'resolveElementId'))
                ))
        ;
        $this->addElement($selectUF = new Zend_Form_Element_Select('UF', array(
            'label' => 'Estado',
            'maxLength' => 49,
            'disableLoadDefaultDecorators' => TRUE,
            'class' => 'styled-select'
        )));
        $selectUF
                ->addMultiOption('', 'Selecione')
                ->addMultiOption('AL', 'Alagoas')
                ->addMultiOption('AM', 'Amazonas')
                ->addMultiOption('AP', 'Amapá')
                ->addMultiOption('BA', 'Bahia')
                ->addMultiOption('CE', 'Ceará')
                ->addMultiOption('DF', 'Distrito Federal')
                ->addMultiOption('ES', 'Espírito Santo')
                ->addMultiOption('GO', 'Goiás')
                ->addMultiOption('MA', 'Maranhão')
                ->addMultiOption('MG', 'Minas Gerais')
                ->addMultiOption('MS', 'Mato Grosso do Sul')
                ->addMultiOption('MT', 'Mato Grosso')
                ->addMultiOption('PA', 'Pará')
                ->addMultiOption('PB', 'Paraíba')
                ->addMultiOption('PE', 'Pernambuco')
                ->addMultiOption('PI', 'Piauí')
                ->addMultiOption('PR', 'Paraná')
                ->addMultiOption('RJ', 'Rio de Janeiro')
                ->addMultiOption('RN', 'Rio Grande do Norte')
                ->addMultiOption('SC', 'Santa Catarina')
                ->addMultiOption('SP', 'São Paulo')
                ->addMultiOption('TO', 'Tocantins')
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-4  columns',
                    'id' => array('callback' => array(get_class($selectUF), 'resolveElementId'))
                ))
        ;
        $this->addElement($selectCID = new Zend_Form_Element_Select('cidade', array(
            'label' => 'Cidade',
            'maxLength' => 50,
            'disableLoadDefaultDecorators' => TRUE,
            'class' => 'styled-select'
        )));
        $selectCID
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->setRegisterInArrayValidator(false)
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-4     columns',
                    'id' => array('callback' => array(get_class($selectCID), 'resolveElementId'))
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
            'onClick' => "parent.location='/fornecedor'",
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
