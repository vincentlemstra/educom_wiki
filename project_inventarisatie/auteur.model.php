<?php

class AuteurModel implements iAuteurModel
{
    public function getAuteurById(int $id) : array | false;
    {
        // dummy data
        if ($id == 0) {
            return false;
        } 

        return [
            'voornaam'      =>  'vincent',
            'achternaam'    =>  'lemstra'
        ];
        
    }

    public function getAllAuteurs() : array | false;
    {
        //
    }
}