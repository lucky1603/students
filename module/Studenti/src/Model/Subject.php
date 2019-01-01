<?php
namespace Studenti\Model;

class Subject
{
    public $id;
    public $sifra;
    public $ime;
    public $opis;
    public $fond_casova;
    public $profesor;
    
    public function exchangeArray($data)
    {
        $this->id = isset($data['id']) ? $data['id'] : null;
        $this->sifra = isset($data['sifra']) ? $data['sifra'] : null;
        $this->ime = isset($data['ime']) ? $data['ime'] : null;
        $this->opis = isset($data['opis']) ? $data['opis'] : null;
        $this->fond_casova = isset($data['fond_casova']) ? $data['fond_casova'] : null;
        $this->profesor = isset($data['profesor']) ? $data['profesor'] : null;
    }
    
    public function getArrayCopy()
    {
        return [
            'id' => $this->id,
            'sifra' => $this->sifra,
            'ime' => $this->ime,
            'opis' => $this->opis,
            'fond_casova' => $this->fond_casova,
            'profesor' => $this->profesor,
        ];
    }
}

