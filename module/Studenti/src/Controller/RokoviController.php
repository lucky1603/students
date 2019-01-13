<?php

namespace Studenti\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\ServiceManager\ServiceManager;
use Zend\View\Model\ViewModel;
use Studenti\Model\RokTabela;
use Studenti\Form\RokForm;
use Studenti\Model\Rok;

class RokoviController extends AbstractActionController
{
	private $serviceManager;
	
	public function __construct(ServiceManager $serviceManager) {
		$this->serviceManager = $serviceManager;
	}
	
	public function indexAction() 
	{
		$tabelaRokova = $this->serviceManager->get(RokTabela::class);
		$rokovi = $tabelaRokova->fetchAll();
		return ['rokovi' => $rokovi];
	}
	
	public function addAction()
	{
		$form = $this->serviceManager->get(RokForm::class);
		$request = $this->getRequest();
		if(! $request->isPost())
		{
			return ['form' => $form];
		}
		
		$rok = new Rok();
		$form->setData($request->getPost());
		if(! $form->isValid())
		{
			return ['form' => $form];
		}
		
		$rok->exchangeArray($form->getData());
		$tabelaRokova = $this->serviceManager->get(RokTabela::class);
		$tabelaRokova->saveRok($rok);
		
		return $this->redirect()->toRoute('rokovi', ['action' => 'index']);
	}
	
	public function editAction()
	{
		$table = $this->serviceManager->get(RokTabela::class);
		$id = (int) $this->params()->fromRoute('id', 0);
		if(0 == $id)
		{
			return $this->redirect()->toRoute('rokovi', ['action' => 'index']);
		}
		
		try {
			$rok = $table->getRok($id);
		} catch (\Exception $e) {
			return $this->redirect()->toRoute('rokovi', ['action' => 'index']);
		}
		
		$form = $this->serviceManager->get(RokForm::class);
		$form->bind($rok);
		
		$request = $this->getRequest();
		$viewData = ['id' => $id, 'form' => $form];
		$viewModel = new ViewModel($viewData);
		
		if(! $request->isPost()) {
			return $viewModel;
		}
		
		$form->setData($request->getPost());
		
		if(! $form->isValid()) {
			return $viewModel;
		}
		
		$table->saveRok($rok);
		
		return $this->redirect()->toRoute('rokovi', ['action' => 'index']);
	}
	
	public function deleteAction()
	{
		$table = $this->serviceManager->get(RokTabela::class);
		$id = (int) $this->params()->fromRoute('id', 0);
		if(0 == $id)
		{
			return $this->redirect()->toRoute('rokovi', ['action' => 'index']);
		}
				
		$table->deleteRok($id);
		
		return $this->redirect()->toRoute('rokovi', ['action' => 'index']);
	}
}