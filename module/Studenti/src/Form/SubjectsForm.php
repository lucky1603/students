<?php
namespace Studenti\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class SubjectsForm extends Form
{

    public function __construct($name = null, $options = array())
    {
        parent::__construct("SubjectForm");
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
            'name' => 'sifra',
            'type' => 'text',
            'required' => 'required',
            'class' => 'form-control',
            'options' => [
                'label' => 'Šifra',
                'label_attributes' => [
                    'class' => 'control-label col-xs-2',
                ]
            ]
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
        
        // Description of subject.
        $this->add([
            'name' => 'opis',
            'attributes' => [
                'type' => 'textarea',
                'COLS' => 40,
                'ROWS' => 4,
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Opis',
                'label_attributes' => [
                    'class' => 'control-label col-sm-2'
                ]
            ]
        ]);
        
        $number = new Element\Number('fond_casova');
        $number
        ->setLabel('Fond časova')
        ->setLabelAttributes([
            'class' => 'control-label col-xs-2',
        ])
        ->setAttributes(array(
            'min'  => '1',
            'max'  => '200',
            'step' => '1', // default step interval is 1
        ));
        
        $this->add($number);
        
        // Name of the professor.
        $this->add([
            'name' => 'profesor',
            'type' => 'text',
            'required' => 'required',
            'class' => 'form-control',
            'options' => [
                'label' => 'Profesor',
                'label_attributes' => [
                    'class' => 'control-label col-xs-2',
                ]
            ]
        ]);
        
        
        $this->add([
            'name' => 'submit',
            'attributes' => [
                'type' => 'submit',
                'value' => 'Sačuvaj promene',
                'id' => 'submitbutton',
                'class' => 'form-control',
            ],
        ]);
        
    }
    
}

