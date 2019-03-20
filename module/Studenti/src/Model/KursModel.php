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
    
   
    /**
     * Vraca stanje kursa. Ako je proslo vise od tri roka od zavrsetka II kolokvijuma, kurs je navalidan.
     * @param type $kursId
     * @return type
     */
    public function isNotValid(/* $kursId */ Kurs $kurs)
    {        
        if($kurs->usmeni_datum != '0000-00-00')
        {
            return false;
        }
        
        $datumPismenogIspita = $kurs->pismeni_datum;
        if($datumPismenogIspita != '0000-00-00')
        {
            $datumFrom = $datumPismenogIspita;
        } else {
            $datumKolokvijuma = $kurs->kolokvijum_2_datum;
            if($datumKolokvijuma != '0000-00-00')
            {
                $datumFrom = $datumKolokvijuma;
            }            
        }
        
        if(!isset($datumFrom))
        {
            return false;
        }
                
    	$danasnjiDatum = \date('Y-m-d');
        $tabelaRokova = $this->serviceManager->get(RokTabela::class);
                
        return $tabelaRokova->getRokCount($datumFrom, $danasnjiDatum) <= 3 ? false : true;
    }
    
    public function isNotValidById($kursId)
    {
        $kursTabela = $this->serviceManager->get(KursTabela::class);
        $kurs = $kursTabela->getKurs($kursId);
        return $this->isNotValid($kurs);
    }
        
}