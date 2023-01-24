<?php
/**
 * Page Element Interface
 *
 * @author Geert Weggemans - geert@man-kind.nl
 * @date jan 8 2020
 */
interface iPageElement
{
    public function insert(iPageElement $newelement) : void;
    public function getOrder() : int;
    public function show(?bool $direct_output = true) : string;
}