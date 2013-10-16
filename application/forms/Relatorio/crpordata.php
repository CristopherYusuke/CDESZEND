<?php

/*
 * 'placement' => Zend_Form_Decorator_Abstract::APPEND
 */

class Application_Form_Relatorio_crpordata extends Zend_Form {

    public function __construct($options = null) {
        parent::__construct($options);

        $this->setAttrib('class', 'custom');
        $date = new DateTime(date("Y-m-d"));



        $this->addElement($inputNome = new Zend_Form_Element_Text('nome', array('label' => 'Nome do Cliente',
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
                    'class' => 'small-12 large-3 columns',
                    'id' => array('callback' => array(get_class($inputNome), 'resolveElementId'))
                ))
        ;



        $this->addElement($selectStatus = new Zend_Form_Element_Select('situacao', array(
            'label' => 'situação da contas a receber   ',
            'disableLoadDefaultDecorators' => TRUE,
        )));
        $selectStatus
                ->addMultiOption('', 'Selecione')
                ->addMultiOption(0, 'Aberta')
                ->addMultiOption(1, 'Faturada')
                ->addMultiOption(2, 'Extornada')
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-3  columns',
                    'id' => array('callback' => array(get_class($selectStatus), 'resolveElementId'))
                ))
        ;


        $this->addElement($dataInicio = new Zend_Form_Element_Text('dataInicio', array('label' => 'Data inicio',
            'value' => $date->format('d/m/Y'),
            'required' => true,
            'disableLoadDefaultDecorators' => TRUE,
            'class' => 'datepicker'
        )));
        $dataInicio
                ->addFilters(array('StripTags', 'StringTrim'))
                ->setValidators(array(new Zend_Validate_Date(array('format' => 'dd/MM/yyyy'))))
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-3 columns',
                    'id' => array('callback' => array(get_class($dataInicio), 'resolveElementId'))
                ))
        ;
         $data = $date->modify('+1 month');
        $this->addElement($dataFinal = new Zend_Form_Element_Text('dataFinal', array('label' => 'Data Final ',
            'value' => $data->format('d/m/Y'),
            'required' => true,
            'disableLoadDefaultDecorators' => TRUE,
            'class' => 'datepicker'
        )));
        
       
        
        $dataFinal
                ->addFilters(array('StripTags', 'StringTrim'))
                ->setValidators(array(new Zend_Validate_Date(array('format' => 'dd/MM/yyyy'))))
                ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Label', array())
                ->addDecorator('HtmlTag', array(
                    'tag' => 'div',
                    'class' => 'small-12 large-3 columns',
                    'id' => array('callback' => array(get_class($dataFinal), 'resolveElementId'))
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
