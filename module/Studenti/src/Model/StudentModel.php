<?php
namespace Studenti\Model;

use Zend\ServiceManager\ServiceManager;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;

class StudentModel
{
    public $student;
    public $kursevi;
    
    private $serviceManager;
    private $adapter;
    private $predmeti;
    private $tabelaPredmeti;
    
    public function __construct(ServiceManager $manager)
    {
        $this->serviceManager = $manager;
        $this->adapter = $this->serviceManager->get(Adapter::class);
        $this->student = new Student();
        $this->kursevi = array();
        $this->tabelaPredmeti = new TableGateway('predmeti', $this->adapter);
    }
    
    public function exchangeArray($data)
    {
        $this->student->exchangeArray($data);
        $this->kursevi = [];
        if(isset($data['kursevi']))
        {
            foreach ($data['kursevi'] as $kursData)
            {
                $kurs = new Kurs();
                $kurs->exchangeArray($kursData);
                $this->kursevi[] = $kurs;
            }
        }
    }
    
    public function getArrayCopy() 
    {   
        $data = $this->student->getArrayCopy();
        if(isset($this->kursevi) && count($this->kursevi) > 0) {
            foreach ($this->kursevi as $kurs)
            {
                $data['kursevi'][] = $kurs->getArrayCopy();
            } 
        }
        return $data;
    }
    
    public function setId($id)
    {
        $id = (int)$id;
        if(0 == $id)
        {
            return;
        }
        
        $studentsTable = $this->serviceManager->get(StudentsTable::class);
        $this->student = $studentsTable->getStudent($id);
        // $kursTabela = $this->serviceManager->get(KursTabela::class);
        // $this->kursevi = $kursTabela->fetchForStudent($id);
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->from('kursevi')
                ->join(['p' => 'predmeti'], 'predmet_id = p.id', ['imePredmeta' => 'ime', 'imeProfesora' => 'profesor', 'sifraPredmeta' => 'sifra'])
                ->join(['s' => 'studenti'], 'student_id = s.id', ['imeStudenta' => "ime", 'prezimeStudenta' => "prezime", 'brojIndeksa' => 'broj_indeksa'])
                ->where(['student_id' => $id]);
        $statement = $sql->prepareStatementForSqlObject($select);
        $rows = $statement->execute();
        $this->kursevi = [];
        foreach($rows as $row)
        {
            $kurs = new Kurs();
            $kurs->exchangeArray($row);
            $this->kursevi[] = $kurs;
        }
        
    }
    
    public function save()
    {        
        $studentsTable = $this->serviceManager->get(StudentsTable::class);
        $student_id = $studentsTable->saveStudent($this->student);
        
        $kurseviTabela = $this->serviceManager->get(KursTabela::class);
        foreach($this->kursevi as $kurs)
        {
            
            if($kurs->student_id == null) {
                $kurs->student_id = $student_id;
            }
            
            $kurseviTabela->saveKurs($kurs);
            
        }
    }
    
    public function delete() {
        $id = (int) $this->student->id;
        
        $studentsTable = $this->serviceManager->get(StudentsTable::class);
        $studentsTable->deleteStudent($this->student);
        $kurseviTabela = new TableGateway('kursevi', $this->adapter);
        $kurseviTabela->delete(['student_id' => $id]);
        
        unset($this->student);
        unset($this->kursevi);
        
        $this->student = new Student();
        $this->kursevi = [];
    }
    
    public function addCourse(Kurs $kurs)
    {
        $predmet_id = $kurs->predmet_id;
        $rows = $this->tabelaPredmeti->select(['id' => $predmet_id]);
        $row = $rows->current();
        $kurs->imePredmeta = $row['ime'];
        $kurs->sifraPredmeta = $row['sifra'];
        $kurs->imeProfesora = $row['profesor'];
        $this->kursevi[] = $kurs;
    }
}

