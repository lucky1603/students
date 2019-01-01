<?php
namespace Studenti\Model;

class Student
{
    public $id;
    public $ime;
    public $prezime;
    public $broj_indeksa;
    public $email;
    public $image;
    
    
    public function exchangeArray($data)
    {
        $this->id = isset($data['id']) ? $data['id'] : null;
        $this->ime = isset($data['ime']) ? $data['ime'] : null;
        $this->prezime = isset($data['prezime']) ? $data['prezime'] : null;
        $this->broj_indeksa = isset($data['broj_indeksa']) ? $data['broj_indeksa'] : null;
        $this->email = isset($data['email']) ? $data['email'] : null;
        $this->image = isset($data['image']) ? $data['image'] : null;
    }
    
    public function getArrayCopy()
    {
        return [
            'id' => $this->id,
            'ime' => $this->ime,
            'prezime' => $this->prezime,
            'broj_indeksa' => $this->broj_indeksa,
            'email' => $this->email,
            'image' => $this->image,
        ];
    }
}

