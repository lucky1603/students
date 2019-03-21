<?php

namespace Studenti\Form;

use Zend\Form\Form;
use Zend\Form\Element\Select;

class RokForm extends Form 
{
	private $serviceManager;
	
	public function __construct($name = null, $options = array()) {
		parent::__construct("KursForm");
		
		$this->setAttribute('method', 'post');
		$this->setAttribute('enctype', 'multipart-form/data');
		$this->setAttribute('class', 'form-horizontal');
		$this->setAttribute('role', 'form');
		
		$this->serviceManager = $options['service_manager'];
		
		$this->add([
                    'name' => 'Id',
                    'type' => 'hidden',
		]);
		
		/* Naziv */
		$this->add([
                    'name' => 'Name',
                    'attributes' => [
                        'type' => 'text',
                        'class' => 'form-control',
                    ],
                    'options' => [
                        'label' => 'Naziv',
                        'label_attributes' => [
                        'class' => 'col-xs-2 control-label',
                        ]
                    ]
		]);
		
		/* Opis */
		$this->add([
                    'name' => 'Description',
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
		
		/* Skolska godina */
		$skolska_godina = new Select('Year');
		$skolska_godina->setLabel("Školska godina");
		$skolska_godina->setLabelAttributes([
                    'class' => 'col-xs-2 control-label',
		]);
		
		$skolska_godina->setValueOptions([
                    '2018/2019' => '2018/2019',
                    '2019/2020' => '2019/2020',
                    '2020/2021' => '2020/2021',
		]);
		
		$skolska_godina->setAttribute('class', 'form-control');
		$skolska_godina->setAttribute('id', 'student_id');
		$this->add($skolska_godina);
		
		/* Datum početka */
		$datum_pocetka = new \Zend\Form\Element\Date('DateBeginning');
		$datum_pocetka->setLabel("Datum početka:");
		$datum_pocetka->setLabelAttributes([
                    'class' => 'control-label col-sm-2',
		]);
		$datum_pocetka->setOptions([
                    'min' => '2017-09-01',
                    'max' => '2020-09-01',
                    'step' => '1'
		]);
		$datum_pocetka->setAttribute('id', 'DateBeginning');
		$datum_pocetka->setAttribute('class', 'form-control');
		$datum_pocetka->setAttribute('required', false);
		
		$this->add($datum_pocetka);
		
		/* Datum završetka */
		$datum_zavrsetka = new \Zend\Form\Element\Date('DateEnding');
		$datum_zavrsetka->setLabel("Datum završetka:");
		$datum_zavrsetka->setLabelAttributes([
                    'class' => 'control-label col-sm-2',
		]);
		$datum_zavrsetka->setOptions([
                    'min' => '2017-09-01',
                    'max' => '2020-09-01',
                    'step' => '1'
		]);
		$datum_zavrsetka->setAttribute('id', 'DateEnding');
		$datum_zavrsetka->setAttribute('class', 'form-control');
		$datum_zavrsetka->setAttribute('required', false);
		
		$this->add($datum_zavrsetka);
		
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