<?php namespace Masch\Getweekdays\Controllers;

use Masch\Getweekdays\handlers\DatabaseHandler\Interfaces\DatabaseConstants;
use Masch\Getweekdays\modelHandlers\FileHandler;
use mysqli;

/**
 * The indexController
 * @package controllers
 */
class IndexController
{
    /**
     * The starting point of the request
     */
    public function handleRequest()
    {
        $action = $this->getAction();

        switch ($action) {
            case 'fileIsUploaded':
                $fileHandler = new FileHandler();
                $fileHandler->saveFile();
                $users = $fileHandler->getAll();

                $response = $fileHandler->getResponse();

                //$fileHandler->closeDbConnection();

                if (isset($response['error'])) {
                    $responseText = "Something went wrong";
                    include('../app/views/error_view.html.php');
                }
                include('../app/views/index_view.html.php');
                break;
            case 'export';

                $fileHandler = new FileHandler();
                $fileHandler->exportToCsv();

                if (isset($response['error'])) {
                    $responseText = $response['error'];
                    include('../app/views/error_view.html.php');
                }

                include('../app/views/index_view.html.php');
                break;
            default:
                include('../app/views/index_view.html.php');
                break;
        }
    }

    /**
     * @return string
     */
    protected function getAction(): string
    {
        $action = "";
        if (true === isset($_REQUEST['fileIsUploaded']) and "upload" === $_REQUEST['fileIsUploaded']) {
            $action = "fileIsUploaded";
        }
        if (true === isset($_REQUEST['export']) and "export" === $_REQUEST['export']) {
            $action = "export";
        }
        return $action;
    }
}
