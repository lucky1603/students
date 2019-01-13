<?php

namespace Studenti\Model;

class Rok 
{
	public $Id;
	public $Name;
	public $Description;
	public $DateBeginning;
	public $DateEnding;
	public $Year;
	
	public function exchangeArray($data)
	{
		$this->Id = isset($data['Id']) ? $data['Id'] : null;
		$this->Name = isset($data['Name']) ? $data['Name'] : null;
		$this->Description = isset($data['Description']) ? $data['Description'] : null;
		$this->Year = isset($data['Year']) ? $data['Year'] : null;
		$this->DateBeginning = isset($data['DateBeginning']) ? $data['DateBeginning'] : null;
		$this->DateEnding = isset($data['DateEnding']) ? $data['DateEnding'] : null;
	}
	
	public function getArrayCopy()
	{
		return [
				'Id' => $this->Id,
				'Name' => $this->Name,
				'Description' => $this->Description,
				'Year' => $this->Year,
				'DateBeginning' => $this->DateBeginning,
				'DateEnding' => $this->DateEnding
		];
	}
}