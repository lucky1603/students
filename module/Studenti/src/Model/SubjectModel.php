<?php

namespace Studenti\Model;

use Zend\ServiceManager\ServiceManager;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\Adapter;

class SubjectModel 
{   
    public $subject;
    public $colloquiaIAttended;
    public $colloquiaIIAttended;
    public $writtenPartAttended;
    public $spokenPartAttended;
    public $totalStudents;
    public $students;
    
    private $serviceManager;
    private $sql;
    
    public function __construct(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
        $this->sql = new Sql($this->serviceManager->get(Adapter::class));
    }
    
    public function setId($id, $full = false)
    {
        $kursModel = $this->serviceManager->get(KursModel::class);
        $subjectsTable = $this->serviceManager->get(SubjectsTable::class);
        $this->subject = $subjectsTable->getSubject($id);
        
        $this->colloquiaIAttended = $kursModel->getColloquiaI($id);
        $this->colloquiaIIAttended = $kursModel->getColloquiaII($id);
        $this->writtenPartAttended =    $kursModel->getWrittenPart($id);
        $this->spokenPartAttended = $kursModel->getSpokenPart($id);
        $this->totalStudents = $kursModel->getTotalStudents($id);
        
        $this->students = [];
        
        // Set the connected courses.
        if($full)
        {
            $select = $this->sql->select();
            $select->from('kursevi')
                    ->join('studenti', 'kursevi.student_id = studenti.id', 
                            ['StudentId' => 'id', 
                             'BrojIndeksa' => 'broj_indeksa', 
                             'Ime' => 'ime', 
                             'Prezime' => 'prezime'])
                    ->where(['kursevi.predmet_id' => $id]);
            $statement = $this->sql->prepareStatementForSqlObject($select);
            $results = $statement->execute();
            if($results->count())
            {

                foreach($results as $result)
                {                           
                    $student = [];
                    $student['id'] = $result['StudentId'];
                    $student['broj_indeksa'] = $result['BrojIndeksa'];
                    $student['puno_ime'] = $result['Ime'].' '.$result['Prezime'];
                    $student['prisustvo'] = $result['prisustvo'];
                    $student['aktivnost'] = $result['aktivnost'];
                    $student['samostalni_zadaci'] = $result['samostalni_zadaci'];
                    $student['kolokvijum_1_datum'] = $result['kolokvijum_1_datum'];
                    $student['kolokvijum_1_poeni'] = $result['kolokvijum_1_poeni'];
                    $student['kolokvijum_2_datum'] = $result['kolokvijum_2_datum'];
                    $student['kolokvijum_2_poeni'] = $result['kolokvijum_2_poeni'];
                    $student['pismeni_datum'] = $result['pismeni_datum'];
                    $student['pismeni_poeni'] = $result['pismeni_poeni'];
                    $student['usmeni_datum'] = $result['usmeni_datum'];
                    $student['usmeni_poeni'] = $result['usmeni_poeni'];
                    $student['poeni_ukupno_do_usmenog'] = $result['poeni_ukupno_do_usmenog'];
                    $student['poeni_zbir'] = $result['poeni_zbir'];
                    $student['ocena'] = $result['ocena'];
                    $student['nevalidan'] = $kursModel->isNotValidById($result['id']);
                                        
                    $this->students[] = $student;
                }
                
            } 

        }
    }
}