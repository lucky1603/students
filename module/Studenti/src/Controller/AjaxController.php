<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Studenti\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceManager;
use Zend\Session\Container;
use Studenti\Model\StudentModel;

class AjaxController extends AbstractActionController
{
    private $serviceManager;
    private $viewModel;
    
    public function __construct(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }
    
    public function onDispatch(MvcEvent $mvcEvent)
    {
        $this->viewModel = new ViewModel; // Don't use $mvcEvent->getViewModel()!
        $this->viewModel->setTemplate('/studenti/ajax/response');
        $this->viewModel->setTerminal(true); // Layout won't be rendered
        
        return parent::onDispatch($mvcEvent);
    }
    
    public function someAction()
    {
        return $this->viewModel->setVariable('response', json_encode("Hej!!!"));
    }
    
    /**
     * Saves member model to the post session.
     * @return \Zend\View\Model\ViewModel
     */
    public function rememberStudentModelAction()
    {        
        $session = new Container('models');
        $studentModel = $this->serviceManager->get(StudentModel::class);
        if(isset($session->studentModelData))
        {
            $studentModel->exchangeArray($session->studentModelData);
        }
        
        $data = $this->request->getPost();             
        $file = $this->params()->fromFiles('photo');
        if($file != null && !empty($file['name']))
        {
            $imgDir = getcwd() . '/public';
            $data['image'] = '/img/temp/'.$file['name'];
            copy($file['tmp_name'], $imgDir.$data['image']);
        }
        
        $studentModel->student->exchangeArray($data);
        $session->studentModelData = $studentModel->getArrayCopy();
                
        $this->viewModel->setVariable('response', json_encode($session->studentModelData));
        return $this->viewModel;
    }
    
}

