<?php
namespace Studenti\Model;

use Zend\Db\TableGateway\TableGateway;

class RokTabela {
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
	
	/**
	 * Vraca kurs za dati id.
	 * @param unknown $id
	 * @throws \RuntimeException
	 * @return mixed
	 */
	public function getRok($id)
	{
		$id = (int)$id;
		$rows = $this->tableGateway->select(['Id' => $id]);
		$row = $rows->current();
		
		if(! $row) {
			throw new \RuntimeException(sprintf(
					'Could not find row with identifier $d',
					$id
					));
		}
		
		return $row;
	}
	
	public function SaveRok(Rok $rok)
	{

		$data = [
				'Name' => $rok->Name,
				'Description' => $rok->Description,
				'Year' => $rok->Year,
				'DateBeginning' => $rok->DateBeginning,
				'DateEnding' => $rok->DateEnding,
		];
		
		$Id = (int) $rok->Id;
		if($Id == 0)
		{
			$this->tableGateway->insert($data);
			$rows = $this->tableGateway->getAdapter()->query('SELECT max(Id) FROM rokovi')->execute();
			return $rows->current()["max(id)"];
		} else {
			$this->tableGateway->update($data, ['Id' => $Id]);
			return $id;
		}
	}
	
	public function deleteRok($id)
	{
		return $this->tableGateway->delete(['id' => $id]);
	}
}