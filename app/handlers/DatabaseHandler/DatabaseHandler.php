<?php namespace Masch\Getweekdays\handlers\DatabaseHandler;

use Exception;
use Masch\Getweekdays\handlers\DatabaseHandler\Interfaces\Connectable;
use Masch\Getweekdays\handlers\DatabaseHandler\Interfaces\DatabaseConstants;
use Masch\Getweekdays\models\Month;
use Masch\Getweekdays\models\User;
use mysqli;

/**
 *
 */
class DatabaseHandler implements Connectable, DatabaseConstants
{
    private $dbConnection = null;

    /**
     * @param array $data
     *
     * @return array
     */
    public function save(array $data): array
    {
        if (false === $this->isConnected()) {
            $this->connect();
        }

        $year        = $data[0];
        $month       = $data[1];
        $day         = $data[2];
        $name        = $data[3];
        $weekday = end($data);
        $queryString = "INSERT INTO " . User::TABLE . "(`name`, `year`, `month_id`, `day`,`weekday`) VALUES ('$name',$year,$month,$day, '$weekday')";
        $result      = $this->dbConnection->query($queryString);

        return [];
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        if (false === $this->isConnected()) {
            $this->connect();
        }
        $queryString = "SELECT * FROM " . User::TABLE.
                       " INNER JOIN ". Month::TABLE." on users.month_id = months.id ORDER BY users.year, users.month_id, users.day  asc";

        $result      = $this->dbConnection->query($queryString);
        return $result;
    }

    /**
     * @return null|array
     */
    public function connect(): ?array
    {
        $config = require_once("../app/configs/database.php");
        if (null === $config) {
            return ['error'=> 'Could not find the configurationfile'];

        }
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        try {
            $this->dbConnection = new mysqli(
                $config[DatabaseConstants::HOST],
                $config[DatabaseConstants::DB_USER],
                $config[DatabaseConstants::DB_PASSWORD],
                $config[DatabaseConstants::DATABASE],
                $config[DatabaseConstants::PORT]
            );
        }catch(Exception $e){
            return ['error'=> 'Could not connect to database'];
        }
        return [];
    }

    protected function closeConnection()
    {
        $this->dbConnection->close();
    }

    /**
     * @return bool
     */
    public function isConnected(): bool
    {
        if (null !== $this->dbConnection) {
            return true;
        }
        return false;
    }

    /**
     *
     */
    public function xxexportToCsv(){
        if (false === $this->isConnected()) {
            $this->connect();
        }
        // Fetch records from database
        $query = $this->dbConnection->query("SELECT * FROM users ORDER BY id ASC");

        if($query->num_rows > 0){
            $delimiter = ",";
            $filename = "users-data_" . date('Y-m-d') . ".csv";

            // Create a file pointer
            $f = fopen('php://memory', 'w');

            // Set column headers
            $fields = array('ID', 'NAME', 'YEAR', 'MONTH', 'DAY', 'WEEKDAY');
            fputcsv($f, $fields, $delimiter);

            // Output each row of the data, format line as csv and write to file pointer
            while($row = $query->fetch_assoc()){
               // $status = ($row['status'] == 1)?'Active':'Inactive';
                $lineData = array($row['id'], $row['name'], $row['year'], $row['month_id'], $row['day'], $row['weekday']);
                fputcsv($f, $lineData, $delimiter);
            }

            // Move back to beginning of file
            fseek($f, 0);

            // Set headers to download file rather than displayed
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '";');

            //output all remaining data on a file pointer
            fpassthru($f);
        }
        exit;

    }


}
