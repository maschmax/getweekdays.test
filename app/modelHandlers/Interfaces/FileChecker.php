<?php namespace Masch\Getweekdays\modelHandlers\Interfaces;

/**
 *
 */
interface FileChecker
{
    /**
     * @param string $extension
     *
     * @return bool
     */
    public function isExpectedFileExtension(string $extension): bool;


    /**
     * @param array $fileData
     *
     * @return bool
     */
    public function isFile(array $fileData): bool;

}