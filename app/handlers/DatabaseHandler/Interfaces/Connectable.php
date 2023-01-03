<?php namespace Masch\Getweekdays\handlers\DatabaseHandler\Interfaces;

/**
 *
 */
interface Connectable
{

    /**
     * @param array $data
     *
     * @return array
     */
    public function save(array $data): array;

    /**
     * @return null|array
     */
    public function connect(): ?array;

    /**
     * @return bool
     */
    public function isConnected(): bool;

    /**
     * @return Connectable
     */
   // public function getConnection(): mysqli;

}