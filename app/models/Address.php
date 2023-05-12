<?php

namespace Masch\Getweekdays\models;

class Address
{
    /**
     * @return mixed
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param mixed $street
     */
    public function setStreet($street): void
    {
        $this->street = $street;
    }
    private $street;
    public function __construct(){

    }



}