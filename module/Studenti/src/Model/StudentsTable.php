<?php
namespace Studenti\Model;

use Zend\Db\TableGateway\TableGateway;

class StudentsTable
{
    private $tableGateway;
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll()
    {
        return $this->tableGateway->select();
    }
    
    public function getStudent($id)
    {
        $id = (int)$id;
        $rows = $this->tableGateway->select(['id' => $id]);
        $row = $rows->current();
        
        if(! $row) {
            throw new \RuntimeException(sprintf(
                'Could not find row with identifier $d',
                $id
                ));
        }
        
        return $row;    
    }
    
    public function saveStudent(Student $student)
    {
        $data = [
            'ime' => $student->ime,
            'prezime' => $student->prezime,
            'broj_indeksa' => $student->broj_indeksa,
            'email' => $student->email,
            'image' => $student->image,
        ];
        
        $id = (int) $student->id;
        if($id == 0)
        {
            $this->tableGateway->insert($data);
            $rows = $this->tableGateway->getAdapter()->query('SELECT max(id) FROM studenti')->execute();
            return $rows->current()["max(id)"];
        } else {
            $this->tableGateway->update($data, ['id' => $id]);
            return $id;
        }
    }
    
    public function deleteStudent($id)
    {
        return $this->tableGateway->delete(['id' => $id]);
    }
}

