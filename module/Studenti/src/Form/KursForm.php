<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Studenti\Form;

use Zend\Form\Form;
use Zend\Form\Element\Select;

/**
 * Description of KursForm
 *
 * @author a
 */
class KursForm extends Form {
    //put your code here4
    private $serviceManager;
    
    public function __construct($name = null, $options = array()) {
        parent::__construct("KursForm");
        
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart-form/data');
        $this->setAttribute('class', 'form-horizontal');
        $this->setAttribute('role', 'form');
        
        $this->serviceManager = $options['service_manager'];
        
        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);
        
        /* Get all students from the students table */
        $studentsTable = $this->serviceManager->get(\Studenti\Model\StudentsTable::class);
        $students = $studentsTable->fetchAll();
        $studentOptions = [];
        foreach($students as $student)
        {
            $studentOptions[$student->id] = $student->ime . " " . $student->prezime;
        }
        
        /* Init 'select students' element */
        $selectStudent = new Select('student_id');
        $selectStudent->setLabel("Student");
        $selectStudent->setLabelAttributes([
            'class' => 'col-sm-2 control-label',
        ]);
        $selectStudent->setValueOptions($studentOptions);
        $selectStudent->setAttribute('class', 'form-control');
        $selectStudent->setAttribute('id', 'student_id');
        //$this->add($selectStudent);
        
        /* Get all subjects from the subjects table */
        $subjectsTable = $this->serviceManager->get(\Studenti\Model\SubjectsTable::class);
        $subjects = $subjectsTable->fetchAll();
        $subjectOptions = [];
        foreach($subjects as $subject)
        {
            $subjectOptions[$subject->id] = $subject->ime;
        }
        
        /* Init 'select students' element */
        $selectSubject = new Select('predmet_id');
        $selectSubject->setLabel("Predmet");
        $selectSubject->setLabelAttributes([
            'class' => 'control-label',
        ]);
        $selectSubject->setValueOptions($subjectOptions);
        $selectSubject->setAttribute('class', 'form-control');
        $selectSubject->setAttribute('id', 'predmet_id');
        $this->add($selectSubject);
        
        /* Aktivnost */
        $this->add([
            'name' => 'aktivnost',
            'attributes' => [
                'type' => 'text',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Aktivnost',
                'label_attributes' => [
                    'class' => 'col-sm-2 control-label',
                ]
            ]
        ]);
        
        /* Prisustvo */
        $this->add([
            'name' => 'prisustvo',
            'attributes' => [
                'type' => 'text',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Prisustvo',
                'label_attributes' => [
                    'class' => 'col-sm-2 control-label',
                ]
            ]
        ]);
        
        /* Broj časova */
        $this->add([
            'name' => 'broj_casova',
            'attributes' => [
                'type' => 'text',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Broj časova',
                'label_attributes' => [
                    'class' => 'col-sm-2 control-label',
                ]
            ]
        ]);
        
        /* Samostalni zadaci */
        $this->add([
            'name' => 'samostalni_zadaci',
            'attributes' => [
                'type' => 'text',         
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Samostalni zadatak',
                'label_attributes' => [
                    'class' => 'col-sm-2 control-label',
                ]
            ]
        ]);
        
        /* Kolokvijum 1 poeni */
        $this->add([
            'name' => 'kolokvijum_1_poeni',
            'attributes' => [
                'type' => 'text',                
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Poeni',
                'label_attributes' => [
                    'class' => 'control-label',
                ]
            ]
        ]);
        
        /* Datum prvojg kolokvijuma */
        $kolokvijum1Date = new \Zend\Form\Element\Date('kolokvijum_1_datum');
        $kolokvijum1Date->setLabel("Datum");
        $kolokvijum1Date->setLabelAttributes([
            'class' => 'control-label',
        ]);
        $kolokvijum1Date->setOptions([
            'min' => '2017-09-01',
            'max' => '2018-09-01',
            'step' => '1'
        ]);
        $kolokvijum1Date->setAttribute('id', 'kolokvijum_1_datum');
        $kolokvijum1Date->setAttribute('class', 'form-control');
        
        $kolokvijum1Date->setOptions(['required' => false]);
        $this->add($kolokvijum1Date);        
        
        /* Kolokvijum 2 poeni */
        $this->add([
            'name' => 'kolokvijum_2_poeni',
            'attributes' => [
                'type' => 'text',                
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Poeni',
                'label_attributes' => [
                    'class' => 'control-label',
                ]
            ]
        ]);
        
        /* Datum drugog kolokvijuma */
        $kolokvijum2Date = new \Zend\Form\Element\Date('kolokvijum_2_datum');
        $kolokvijum2Date->setLabel("Datum");
        $kolokvijum2Date->setLabelAttributes([
            'class' => 'control-label',
        ]);
        $kolokvijum2Date->setOptions([
            'min' => '2017-09-01',
            'max' => '2018-09-01',
            'step' => '1'
        ]);
        $kolokvijum2Date->setAttribute('id', 'kolokvijum_1_datum');
        $kolokvijum2Date->setAttribute('class', 'form-control');
        $kolokvijum2Date->setAttribute('required', false);
        $this->add($kolokvijum2Date);
        
        /* Datum pismenog ispita */
        $pismeniDatum = new \Zend\Form\Element\Date('pismeni_datum');
        $pismeniDatum->setLabel("Datum");
        $pismeniDatum->setLabelAttributes([
            'class' => 'control-label',
        ]);
        $pismeniDatum->setOptions([
            'min' => '2017-09-01',
            'max' => '2018-09-01',
            'step' => '1'
        ]);
        $pismeniDatum->setAttribute('id', 'pismeni_datum');
        $pismeniDatum->setAttribute('class', 'form-control');
        $pismeniDatum->setAttribute('required', false);
        $this->add($pismeniDatum);
        
        /* Pismeni ispit poeni */
        $this->add([
            'name' => 'pismeni_poeni',
            'attributes' => [
                'type' => 'text',                
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Poeni',
                'label_attributes' => [
                    'class' => 'control-label',
                ]
            ]
        ]);
        
        /* Datum usmenog ispita */
        $usmeniDatum = new \Zend\Form\Element\Date('usmeni_datum');
        $usmeniDatum->setLabel("Datum");
        $usmeniDatum->setLabelAttributes([
            'class' => 'control-label',
        ]);
        $usmeniDatum->setOptions([
            'min' => '2017-09-01',
            'max' => '2018-09-01',
            'step' => '1'
        ]);
        $usmeniDatum->setAttribute('id', 'usmeni_datum');
        $usmeniDatum->setAttribute('class', 'form-control');
        $usmeniDatum->setAttribute('required', false);
        
        $this->add($usmeniDatum);
        
        /* Usmeni ispit poeni */
        $this->add([
            'name' => 'usmeni_poeni',
            'attributes' => [
                'type' => 'text',                
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Poeni',
                'label_attributes' => [
                    'class' => 'control-label',
                ]
            ]
        ]);
        
        /* Poeni ukupno do usmenog */
        $this->add([
            'name' => 'poeni_ukupno_do_usmenog',
            'attributes' => [
                'type' => 'text',                
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Poeni do usmenog',
                'label_attributes' => [
                    'class' => 'col-sm-2 control-label',
                ]
            ]
        ]);
        
        /* Poeni zbir */
        $this->add([
            'name' => 'poeni_zbir',
            'attributes' => [
                'type' => 'text',                
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Zbir poena',
                'label_attributes' => [
                    'class' => 'col-sm-2 control-label',
                ]
            ]
        ]);
        
        /* Ocena */
        $this->add([
            'name' => 'ocena',
            'attributes' => [
                'type' => 'text',                
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Ocena',
                'label_attributes' => [
                    'class' => 'col-sm-2 control-label',
                ]
            ]
        ]);
        
        /* Napomena */
        $this->add([
            'name' => 'napomene',
            'attributes' => [
                'type' => 'textarea',
                'COLS' => 40,
                'ROWS' => 4,
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Napomena',
                'label_attributes' => [
                    'class' => 'control-label col-sm-2'
                ]
            ]
        ]);
                       
        /* Datum upisa na kurs */
        $datum_pocetka = new \Zend\Form\Element\Date('datum_pocetka');
        $datum_pocetka->setLabel("Datum pocetka:");
        $datum_pocetka->setLabelAttributes([
        		'class' => 'control-label',
        ]);
        $datum_pocetka->setOptions([
        		'min' => '2017-09-01',
        		'max' => '2018-09-01',
        		'step' => '1'
        ]);
        $datum_pocetka->setAttribute('id', 'usmeni_datum');
        $datum_pocetka->setAttribute('class', 'form-control');
        $datum_pocetka->setAttribute('required', false);
        
        $this->add($datum_pocetka);
        
        /* Datum okoncanja kursa */
        $datum_okoncanja = new \Zend\Form\Element\Date('datum_okoncanja');
        $datum_okoncanja->setLabel("Datum okoncanja:");
        $datum_okoncanja->setLabelAttributes([
        		'class' => 'control-label',
        ]);
        $datum_okoncanja->setOptions([
        		'min' => '2017-09-01',
        		'max' => '2018-09-01',
        		'step' => '1'
        ]);
        $datum_okoncanja->setAttribute('id', 'usmeni_datum');
        $datum_okoncanja->setAttribute('class', 'form-control');
        $datum_okoncanja->setAttribute('required', false);
        
        $this->add($datum_okoncanja);
        
        /* Godina upisa */
        $skolska_godina = new Select('skolska_godina');
        $skolska_godina->setLabel("Skolska godina");
        $skolska_godina->setLabelAttributes([
        		'class' => 'col-sm-2 control-label',
        ]);
        $skolska_godina->setValueOptions([
        	'2018' => '2018',
        	'2019' => '2019', 
        	'2020' => '2020',
        ]);
        $skolska_godina->setAttribute('class', 'form-control');
        $skolska_godina->setAttribute('id', 'student_id');
        $this->add($skolska_godina);
        
        /* Submit */
        $this->add([
        		'name' => 'submit',
        		'attributes' => [
        				'type' => 'Submit',
        				'value' => 'Sačuvaj',
        				'id' => 'submitbutton',
        				'class' => 'ui-button form-control',
        		],
        ]);
        
    }
}
