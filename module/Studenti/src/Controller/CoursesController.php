<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Studenti\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\ServiceManager\ServiceManager;
use Studenti\Form\KursForm;
use Studenti\Model\StudentModel;
use Studenti\Model\SubjectsTable;

/**
 * Description of CoursesController
 *
 * @author a
 */
class CoursesController extends AbstractActionController {
    private $serviceManager;
    
    public function __construct(ServiceManager $serviceManager) {
        $this->serviceManager = $serviceManager;
    }
    
    /**
     * Index
     * {@inheritDoc}
     * @see \Zend\Mvc\Controller\AbstractActionController::indexAction()
     */
    public function indexAction() {
        
        return [];
    }
    
    /**
     * Edit - Promena podataka za kurs.
     * @return \Zend\Http\Response|unknown[]|mixed[]|object[]|array
     */
    public function editAction() {    	
    	$studentId = (int) $this->params()->fromRoute('studentId', 0);
    	if(0 == $studentId)
    	{
    		return $this->redirect()->toRoute(null);
    	}
    	
    	$subjectId = (int) $this->params()->fromRoute('subjectId', 0);
    	if(0 == $subjectId)
    	{
    		return $this->redirect()->toRoute(null);
    	}
    	
    	$studentModel = $this->serviceManager->get(StudentModel::class);
    	$studentModel->setId($studentId);
    	$courses = $studentModel->kursevi;
    	foreach($courses as $course)
    	{
            if($course->predmet_id == $subjectId)
            {
                $kurs = $course;
            }
    	}
    	
    	if(!isset($kurs))
            return $this->redirect()->toRoute(null);
    	
    	$subjectsTable = $this->serviceManager->get(SubjectsTable::class);
    	if(!isset($subjectsTable))
            return $this->redirect()->toRoute(null);
    	$subject = $subjectsTable->getSubject($subjectId);
    	
    	$form = $this->serviceManager->get(KursForm::class);
    	$form->bind($kurs);
    	
    	$request = $this->getRequest();
    	if(! $request->isPost())
    	{
            return ['form' => $form, 'model' => $studentModel, 'subject' => $subject, 'nevalidan' => $kurs->nevalidan];
    	}
    	
    	$data = $request->getPost();
    	
    	$data['predmet_id'] = $subject->id;
    	$form->setData($data);	
    	if(!$form->isValid())
    	{
            return ['form' => $form, 'model' => $studentModel, 'subject' => $subject, 'nevalidan' => $kurs->nevalidan];
    	}
    	
    	$studentModel->save();
    	
    	return $this->redirect()->toRoute('predmeti', ['action' => 'preview', 'id' => $subject->id]);
    }
}
