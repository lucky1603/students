<?php

namespace Studenti\Model;

use Zend\ServiceManager\ServiceManager;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\Adapter;

class KursModel 
{
    private $serviceManager;
    private $sql;
    
    public function __construct(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
        $this->sql = new Sql($this->serviceManager->get(Adapter::class));
    }
    
    /**
     * Broj studenata koji su izasli na kolokvijum 1.
     * @param unknown $subjectId
     * @return unknown
     */
    public function getColloquiaI($subjectId)
    {
        $kurses = $this->serviceManager->get(KursTabela::class);
        
        $select = $this->sql->select();
        
        $select->from('kursevi')
            ->where->notEqualTo("kolokvijum_1_datum", "0000-00-00")
            ->AND
            ->equalTo('predmet_id', $subjectId);
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        
        return $results->count();
    }
    
    /**
     * Broj studenata koji su izasli na kolokvijum 2.
     * @param unknown $subjectId
     * @return unknown
     */
    public function getColloquiaII($subjectId)
    {
        $select = $this->sql->select();
        $select->from('kursevi')
            ->where->notEqualTo("kolokvijum_2_datum", "0000-00-00")
            ->AND
            ->equalTo('predmet_id', $subjectId);
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        return $results->count();
    }
    
    /**
     * Broj studenata koji su izasli na kolokvijum 2.
     * @param unknown $subjectId
     * @return unknown
     */
    public function getWrittenPart($subjectId)
    {
        $select = $this->sql->select();
        $select->from('kursevi')
                ->where->notEqualTo("pismeni_datum", "0000-00-00")
                ->AND
                ->equalTo('predmet_id', $subjectId);
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        return $results->count();
    }
    
    /**
     * Broj studenata koji su izasli na kolokvijum 2.
     * @param unknown $subjectId
     * @return unknown
     */
    public function getSpokenPart($subjectId)
    {
        $select = $this->sql->select();
        $select->from('kursevi')
                ->where
                    ->notEqualTo("usmeni_datum", "0000-00-00")
                    ->AND
                    ->equalTo('predmet_id', $subjectId);
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        return $results->count();
    }
    
    /**
     * Broj studenata koji su izasli na kolokvijum 2.
     * @param unknown $subjectId
     * @return unknown
     */
    public function getTotalStudents($subjectId)
    {
        $select = $this->sql->select();
        $select->from('kursevi')
            ->where(['predmet_id' => $subjectId]);
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        return $results->count();
    }
    
}