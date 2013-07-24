<?php


class Application_Form_Usuario extends Zend_Form {

    public function init() {
      

        $this->setAction("/usuario/create");
        $this->setMethod("POST");
        $this->addAttribs(array('class'=>'custom'));
        
        
        
        $id = new Zend_Form_Element_Hidden('idUsuario');;
        $this->addElement($id);
          
        $this->addElement('text', 'NOME', array('label' => 'Nome',
            'required' => true,
            'maxLength' => 49,
            'placeholder' => 'digite o seu nome')
        );

        $this->addElement('text', 'LOGIN', array('label' => 'Login',
            'required' => true,
            'maxLength' => 49,
            'placeholder' => 'digite um login')
        );
        $this->addElement('Password', 'SENHA', array('label' => 'Senha',
            'required' => true,
            'maxLength' => 49,
            'placeholder' => 'digite a senha')
        );
        
        $select = new Zend_Form_Element_Select('TpUsuario');
        $select->addMultiOption('A', 'Administrador');
        $select->addMultiOption('V', 'Vendedor');
        $this->addElement($select);

        $this->addElement('submit', 'submit', array(
            'label' => 'Salvar',
            'class' => 'button')
        );
        
        $this->addElement('button', 'button', array(
            'label' => 'Voltar',
            'onClick' => "parent.location='/usuario'",
            'class' => 'secondary right')
        );
    }

}

?>
