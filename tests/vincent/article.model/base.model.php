<?php
class BaseModel {
    // --- PROPERTIES ---
    protected $crud;

    // --- CONSTRUCT ---
    public function __construct(Crud $crud) {
        $this->crud = $crud;
    }
}