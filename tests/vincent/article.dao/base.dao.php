<?php
class BaseDAO {
    // --- PROPERTIES ---
    protected $crud;

    // --- CONSTRUCT ---
    public function __construct(Crud $crud) {
        $this->crud = $crud;
    }
}