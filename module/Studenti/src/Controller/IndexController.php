<?php

namespace Studenti\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\ServiceManager\ServiceManager;
use Studenti\Model\SubjectsTable;
use Studenti\Model\SubjectModel;
use Zend\Debug\Debug;

class IndexController extends AbstractActionController
{
    private $serviceManager;
    
    public function __construct(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }
    
    public function indexAction()
    {
        $subjectTable = $this->serviceManager->get(SubjectsTable::class);
        $subjects = $subjectTable->fetchAll();
        $subjectData = [];
        $subjectModel = $this->serviceManager->get(SubjectModel::class);
        
        foreach($subjects as $subject)
        {
            $subjectEntry = [];
            $subjectEntry['id'] = $subject->id;
            $subjectEntry['sifra'] = $subject->sifra;
            $subjectEntry['ime'] = $subject->ime;
            $subjectModel->setId($subject->id);
            $subjectEntry['c1attended'] = $subjectModel->colloquiaIAttended;
            $subjectEntry['c2attended'] = $subjectModel->colloquiaIIAttended;
            $subjectEntry['writtenAttended'] = $subjectModel->writtenPartAttended;
            $subjectEntry['spokenAttended'] = $subjectModel->spokenPartAttended;
            $subjectEntry['totalStudents'] = $subjectModel->totalStudents;
            $subjectData[] = $subjectEntry;
        }
        
        return ["SubjectData" => $subjectData];
    }
}