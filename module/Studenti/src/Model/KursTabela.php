<?php
namespace Studenti\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Where;

class KursTabela
{
    private $tableGateway;
    public function __construct(TableGateway $t)
    {
        $this->tableGateway = $t;
    }
    
    /**
     * Fetch all rows.
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function fetchAll()
    {
        return $this->tableGateway->select();
    }
    
    public function fetchForStudent($student_id)
    {
        $student_id = (int) $student_id;
        return $this->tableGateway->select(['student_id' => $student_id]);
    }
    
    /**
     * Gets the kurs element with the given id.
     * @param unknown $id
     * @return array|ArrayObject|NULL
     */
    public function getKurs($id)
    {
        $id = (int)$id;
        $rows = $this->tableGateway->select(['id' => $id]);
        $row = $rows->current();
        return $row;
    }
    
    /**
     * Saves the handed kurs element to the database.
     * @param Kurs $kurs
     */
    public function saveKurs(Kurs $kurs)
    {
        $data = [
            'student_id' => $kurs->student_id,
            'predmet_id' => $kurs->predmet_id,
        	'aktivnost' => $kurs->aktivnost,
            'prisustvo' => $kurs->prisustvo,
            'broj_casova' => $kurs->broj_casova,
            'samostalni_zadaci' => $kurs->samostalni_zadaci,
            'kolokvijum_1_poeni' => $kurs->kolokvijum_1_poeni,
            'kolokvijum_2_poeni' => $kurs->kolokvijum_2_poeni,
            'kolokvijum_1_datum' => $kurs->kolokvijum_1_datum,            
            'kolokvijum_2_datum' => $kurs->kolokvijum_2_datum,
            'pismeni_datum' => $kurs->pismeni_datum,
            'pismeni_poeni' => $kurs->pismeni_poeni,
            'usmeni_datum' => $kurs->usmeni_datum,
            'usmeni_poeni' => $kurs->usmeni_poeni,
            'poeni_ukupno_do_usmenog' => $kurs->poeni_ukupno_do_usmenog,
            'poeni_zbir' => $kurs->poeni_zbir,
            'ocena' => $kurs->ocena,
            'napomene' => $kurs->napomene, 
        	'datum_pocetka' => $kurs->datum_pocetka,
        	'datum_okoncanja' => $kurs->datum_okoncanja,
        ];
                            
        if(empty($kurs->id))
        {
            $this->tableGateway->insert($data);
        } else {
            $this->tableGateway->update($data, ['id' => $kurs->id]);
        }                            
    }
    /**
     * Deletes the kurs element from the database.
     * @param unknown $id
     * @return number
     */
    public function deleteKurs($id)
    {
        return $this->tableGateway->delete(['id' => $id]);
    }
    
    /**
     * Fetch rows for the given criteria.
     * @param Where $where
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function fetch(Where $where)
    {
        return $this->tableGateway->select($where);
    }
    
    
}

