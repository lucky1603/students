<?php
namespace Studenti\Model;

use Zend\Db\TableGateway\TableGateway;

class SubjectsTable
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
    
    public function getSubject($id)
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
    
    public function saveSubject(Subject $subject)
    {
        $data = [
            'ime' => $subject->ime,
            'sifra' => $subject->sifra,
            'opis' => $subject->opis,
            'fond_casova' => $subject->fond_casova,
            'profesor' => $subject->profesor,
        ];
        
        $id = (int) $subject->id;
        if($id == 0)
        {
            $this->tableGateway->insert($data);
        } else {
            $this->tableGateway->update($data, ['id' => $id]);
        }
    }
    
    public function deleteSubject($id)
    {
        return $this->tableGateway->delete(['id' => $id]);
    }
}

