<?php
namespace Studenti\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\Form\Element\Email;

class StudentsForm extends Form
{

    public function __construct($name = null, $options = array())    
    {
        parent::__construct("StudentsForm");        
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setAttribute('class', 'form-horizontal');
        $this->setAttribute('role', 'form');
        
        // Id.
        $this->add([
            'name' => 'id',
            'type' => 'hidden'
        ]);
        
        
        // Name of the subject/member.
        $this->add([
            'name' => 'ime',
            'type' => 'text',
            'required' => 'required',
            'class' => 'form-control',
            'options' => [
                'label' => 'Ime',
                'label_attributes' => [
                    'class' => 'control-label col-xs-2',
                ]
            ]
        ]);
        
        // Name of the subject/member.
        $this->add([
            'name' => 'prezime',
            'type' => 'text',
            'required' => 'required',
            'class' => 'form-control',
            'options' => [
                'label' => 'Prezime',
                'label_attributes' => [
                    'class' => 'control-label col-xs-2',
                ]
            ]
        ]);
        
        // Name of the subject/member.
        $this->add([
            'name' => 'broj_indeksa',
            'type' => 'text',
            'required' => 'required',
            'class' => 'form-control',
            'options' => [
                'label' => 'Broj indeksa',
                'label_attributes' => [
                    'class' => 'control-label col-xs-2',
                ]
            ]
        ]);
        
        $email = new Email('email');
        $email->setLabel('EMail');
        $email->setLabelAttributes([
            'class' => 'control-label col-xs-2'
        ]);
        $this->add($email);
        
        // Single file upload
        $image = new Element\File('photo');
        $image->setLabel('Izaberite sliku');
        $image->setLabelAttributes([
            'class' => 'control-label col-xs-2',
        ]);
        $this->add($image);
        
        $this->add([
            'name' => 'submit',
            'attributes' => [
                'type' => 'submit',
                'value' => 'Sacuvaj promene',
                'id' => 'submitbutton',
                'class' => 'form-control',
            ],
        ]);
        
    }
}

