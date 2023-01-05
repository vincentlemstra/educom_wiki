<?php

class BaseModel {
    // --- PROPERTIES ---
    protected Crud $crud;

    // --- CONSTRUCT ---
    public function __construct(Crud $crud) {
        $this->crud = $crud;
    }
}
?>