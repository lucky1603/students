<?php
namespace Studenti\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Studenti\Model\StudentsTable;
use Zend\ServiceManager\ServiceManager;
use Studenti\Form\StudentsForm;
use Studenti\Model\Student;
use Zend\View\Model\ViewModel;
use Studenti\Model\StudentModel;
use Zend\Session\Container;
use Studenti\Form\KursForm;
use Studenti\Model\SubjectModel;
use Studenti\Model\Kurs;

class StudentsController extends AbstractActionController
{
    private $serviceManager;
    public function __construct(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }
    
    public function indexAction()
    {
        $studentsTable = $this->serviceManager->get(StudentsTable::class);
        $students = $studentsTable->fetchAll();
        
        $session = new Container('models');
        if(isset($session->studentModelData))
        {
            unset($session->studentModelData);
        }
        
        return ['students' => $students];               
    }
    
    public function addAction()
    {
        $imgDir = getcwd() . '/public';
        
        $form = new StudentsForm();
        $request = $this->getRequest();
        if(! $request->isPost())
        {
            return ['form' => $form];
        }
        
        $student = new Student();
        $data = $request->getPost();
            
        $file = $this->params()->fromFiles('image');
        $data['image']  = '/img/studenti/'.$file['name'];
        
        $form->bind($student);
        $form->setData($data);
        if(! $form->isValid())
        {
            return ['form' => $form];
        }
        
        copy($file['tmp_name'], $imgDir.$data['image']);
        
        
        //$student->exchangeArray($form->getData());
        $studentsTable = $this->serviceManager->get(StudentsTable::class);
        $studentsTable->saveStudent($student);
        
        return $this->redirect()->toRoute('studenti', ['action' => 'index']);
    }
    
    public function addWithModelAction()
    {
        $imgDir = getcwd() . '/public';
        
        $form = new StudentsForm();
        
        $studentModel = $this->serviceManager->get(StudentModel::class);
        $session = new Container('models');
        if(isset($session->studentModelData)) {
            $studentModel->exchangeArray($session->studentModelData);
            $form->bind($studentModel->student);
        }
        
        $request = $this->getRequest();
        if(! $request->isPost())
        {
            return ['form' => $form, 'model' => $studentModel];
        }
        
        $data = $request->getPost();
        $file = $this->params()->fromFiles('photo');

        if($file != null && !empty($file['name']))
        {
           $data['image']  = '/img/studenti/'.$file['name']; 
           copy($file['tmp_name'], $imgDir.$data['image']);
        }
       
        $form->bind($studentModel->student);
        $form->setData($data);
        if(! $form->isValid())
        {
            return ['form' => $form, 'model' => $studentModel];
        }
        
        if(isset($data['image']) && !empty($data['image'])) {            
            $studentModel->student->image = $data['image'];
        } 
        
        $studentModel->save();
        unset($session->studentModelData);
        
        return $this->redirect()->toRoute('studenti');
    }
    
    public function editAction()
    {
        $imgDir = getcwd() . '/public';
        
        $form = new StudentsForm();
        
        $table = $this->serviceManager->get(StudentsTable::class);
        
        $id = (int) $this->params()->fromRoute('id', 0);
        if(0 == $id)
        {
            die('redirected to add');
            return $this->redirect()->toRoute('studenti', ['action' => 'add']);
        }
        
        try {
            $student = $table->getStudent($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('studenti');
        }
        
        $photo = $student->image;
        $form->bind($student);        
        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form, 'photo' => $photo];
        $viewModel = new ViewModel($viewData);
        $viewModel->setTemplate('/studenti/students/add');
        if(! $request->isPost())
        {
            return $viewModel;
        }
                
        $data = $request->getPost();
               
        $file = $this->params()->fromFiles('image');
        if(! empty($file['name']) && $file['name'] != "")
        {
            $data['image']  = '/img/studenti/'.$file['name'];
        }
        
        $form->setData($request->getPost());
        if(! $form->isValid())
        {
            return $viewModel;
        }
        
        if(! empty($file['name']) && $file['name'] != null) {
            copy($file['tmp_name'], $imgDir.$data['image']);
        }
                
        $table->saveStudent($student);
        
        return $this->redirect()->toRoute('studenti');
    }
    
    public function editWithModelAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if(0 == $id)
        {
            return $this->redirect()->toRoute('studenti', ['action' => 'addWithModel']);
        }
        
        $studentModel = $this->serviceManager->get(StudentModel::class);
        
        $session = new Container('models');
        if(isset($session->studentModelData))
        {
            $studentModel->exchangeArray($session->studentModelData);
            if($studentModel->student->id != $id)
            {
                $studentModel->setId($id);
                $session->studentModelData = $studentModel->getArrayCopy();
            } 
        } else {
            $studentModel->setId($id);
            $session->studentModelData = $studentModel->getArrayCopy();
        }
                        
        $imgDir = getcwd() . '/public';
        $form = new StudentsForm();
       
        $form->bind($studentModel->student);
        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form, 'model' => $studentModel];
        
        $viewModel = new ViewModel($viewData);
        $viewModel->setTemplate('/studenti/students/add-with-model');
        if(! $request->isPost())
        {
            return $viewModel;
        }
        
        $data = $request->getPost();
        
        $file = $this->params()->fromFiles('photo');
        
        if(! empty($file['name']) && $file['name'] != "")
        {
            $data['photo']  = '/img/studenti/'.$file['name'];
        }
        
        $form->setData($request->getPost());
        if(! $form->isValid())
        {
            return $viewModel;
        }
        
        if(! empty($file['name']) && $file['name'] != null) {
            copy($file['tmp_name'], $imgDir.$data['photo']);
        }
        
        if(isset($data['photo'])) {
            $studentModel->student->image = $data['photo'];
        }
        
        $studentModel->save();
        
        return $this->redirect()->toRoute('studenti');
        
    }
    
    public function deleteAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);
        if(0 == $id)
        {
            return $this->redirect()->toRoute('studenti');
        }
        
        $table = $this->serviceManager->get(StudentsTable::class);
        $table->deleteStudent($id);
        
        return $this->redirect()->toRoute('studenti');
    }
    
    public function deleteWithModelAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);
        if(0 == $id)
        {
            return $this->redirect()->toRoute('studenti');
        }
        
        $studentModel = $this->serviceManager->get(StudentModel::class);
        $studentModel->setId($id);
        $studentModel->delete();
        
        return $this->redirect()->toRoute('studenti');
    }
    
    public function addCourseAction()
    {
        $studentModel = $this->serviceManager->get(StudentModel::class);
        $session = new Container('models');
        $studentModel->exchangeArray($session->studentModelData);
        
        $form = $this->serviceManager->get(KursForm::class);
        $request = $this->getRequest();
        if(! $request->isPost())
        {
            return [
                'form' => $form,
                'model' => $studentModel,
            ];
        }
        
        $kurs = new \Studenti\Model\Kurs();
        $form->bind($kurs);
        $data = $request->getPost();
        $form->setData($data);
        if(! $form->isValid())
        {
            \Zend\Debug\Debug::dump($form->getMessages());
            return [
                'form' => $form,
                'model' => $studentModel,
            ];
        }
        
        $noviKurs = $this->CorrectCourseEntries($kurs);
        $studentModel->addCourse($noviKurs);
                
        $session->studentModelData = $studentModel->getArrayCopy();
        
        if(isset($studentModel->student->id) && $studentModel->student->id != 0 )
        {
            return $this->redirect()->toUrl('/students/editWithModel/'.$studentModel->student->id.'#tab2');
        }
        
        return $this->redirect()->toUrl('/students/addWithModel/#tab2');
    }
    
    private function CorrectCourseEntries(Kurs $kurs)
    {
    	$noviKurs = new Kurs();
    	$noviKurs->exchangeArray($kurs->getArrayCopy());
    	
    	if($kurs->prisustvo == '')
    	{
    		$noviKurs->prisustvo = '0';
    	}
    	
    	if($kurs->aktivnost == '')
    	{
    		$noviKurs->aktivnost = '0';
    	}
    	
    	if($kurs->samostalni_zadaci == '')
    	{
    		$noviKurs->samostalni_zadaci= '0';
    	}
    	
    	if($kurs->datum_pocetka == '')
    	{
    		$noviKurs->datum_pocetka = '0000-00-00';
    	}
    	
    	if($kurs->datum_okoncanja == '')
    	{
    		$noviKurs->datum_okoncanja = '0000-00-00';
    	}
    	
    	if($kurs->kolokvijum_1_datum == '')
    	{
    		$noviKurs->kolokvijum_1_datum= '0000-00-00';
    	}
    	
    	if($kurs->kolokvijum_2_datum == '')
    	{
    		$noviKurs->kolokvijum_2_datum= '0000-00-00';
    	}
    	
    	if($kurs->pismeni_datum == '')
    	{
    		$noviKurs->pismeni_datum= '0000-00-00';
    	}
    	
    	if($kurs->usmeni_datum == '')
    	{
    		$noviKurs->usmeni_datum= '0000-00-00';
    	}
    	
    	if($kurs->kolokvijum_1_poeni == '')
    	{
    		$noviKurs->kolokvijum_1_poeni= '0';
    	}
    	
    	if($kurs->kolokvijum_2_poeni == '')
    	{
    		$noviKurs->kolokvijum_2_poeni= '0';
    	}
    	
    	if($kurs->pismeni_poeni == '')
    	{
    		$noviKurs->pismeni_poeni = '0';
    	}
    	
    	if($kurs->usmeni_poeni == '')
    	{
    		$noviKurs->usmeni_poeni= '0';
    	}
    	
    	if($kurs->poeni_zbir == '')
    	{
    		$noviKurs->poeni_zbir = '0';
    	}
    	
    	if($kurs->poeni_ukupno_do_usmenog == '')
    	{
    		$noviKurs->poeni_ukupno_do_usmenog = '0';
    	}
    	
    	return $noviKurs;
    }
    
    public function editCourseAction()
    {
        $studentModel = $this->serviceManager->get(StudentModel::class);
        $session = new Container('models');
        $studentModel->exchangeArray($session->studentModelData);
        /* course id */
        $id = (int) $this->params()->fromRoute('id', 0);
        if(0 == $id)
        {
            return $this->redirect()->toRoute('studenti', ['action' => 'addCourse']);
        }
                
        $kurs = $studentModel->kursevi[$id - 1];
        $form = $this->serviceManager->get(KursForm::class);
        $form->bind($kurs);       
        
        $subjectModel = $this->serviceManager->get(SubjectModel::class);
        $subjectModel->setId($kurs->predmet_id);
        
        $request = $this->getRequest();
        $viewData = ['id' => $id, 'model' => $studentModel, 'form' => $form, 'kurs' => $kurs, 'subject' => $subjectModel->subject, 'nevalidan' => $kurs->nevalidan];
        $viewModel = new ViewModel($viewData);
        $viewModel->setTemplate('/studenti/students/add-course');
        if(! $request->isPost())
        {
            return $viewModel;
        }
        
        $form->setData($request->getPost());
        if(! $form->isValid())
        {
            \Zend\Debug\Debug::dump($form->getMessages());
            return $viewModel;
        }
        
        // Promena zbog toga sto je na Debian servervu zabranjeno da se unose prazane vrednosti u bazu.
        $noviKurs = $this->CorrectCourseEntries($studentModel->kursevi[$id - 1]);
        
        $studentModel->kursevi[$id - 1] = $noviKurs;           
        $kursModel = $this->serviceManager->get(\Studenti\Model\KursModel::class);
        $studentModel->kursevi[$id - 1]->nevalidan = $kursModel->isNotValid($studentModel->kursevi[$id - 1]);
                
        //$studentModel->kursevi[$id-1] = $kurs;
        $session->studentModelData = $studentModel->getArrayCopy();
                
        return $this->redirect()->toUrl('/students/editWithModel/'.$studentModel->student->id.'#tab2');
    }
    
    public function deleteCourseAction()
    {        
        $studentModel = $this->serviceManager->get(StudentModel::class);
        $session = new Container('models');
        $studentModel->exchangeArray($session->studentModelData);

        /* course id */
        $id = (int) $this->params()->fromRoute('id', 0);
        if(0 == $id)
        {
            return $this->redirect()->toRoute('studenti', ['action' => 'index']);
        }
        
        $kurs = $studentModel->kursevi[$id - 1];
        $studentModel->deleteCourse($kurs);
        $session->studentModelData = $studentModel->getArrayCopy();

        if(isset($studentModel->student->id) && $studentModel->student->id != 0 )
        {
            return $this->redirect()->toUrl('/students/editWithModel/'.$studentModel->student->id.'#tab2');
        }

        return $this->redirect()->toUrl('/students/addWithModel/#tab2');
    }
}

