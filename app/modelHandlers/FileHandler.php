<?php namespace Masch\Getweekdays\modelHandlers;

use Exception;
use Masch\Getweekdays\handlers\DatabaseHandler\DatabaseHandler;
use Masch\Getweekdays\modelHandlers\Interfaces\FileChecker;
use Masch\Getweekdays\utilities\CalculateWeekdayFromDate;

/**
 *
 */
class FileHandler extends DatabaseHandler implements FileChecker
{
    protected $response = [];

    /**
     * @return array
     */
    public function getResponse(): array
    {
       return $this->response;
    }

    /**
     * @return string[]
     */
    public function saveFile(): array
    {
        if (false === $this->isExpectedFileExtension()) {
            $this->response = ['error' => 'error-message'];
            return [];
        }
        $data = $this->extractFileToArray();
        // Save to database
        $this->save( $data);

        return [];
    }

    /**
     * @param array $data
     *
     * @return array|void
     */
    public function save(array $data): array
    {
        // row: year, month, day, name.
        foreach ($data as $row) {
            $weekday = $this->getWeekdayForDate($row);
            $row[]   = $weekday;
            parent::save($row);
        }
        return [];
    }

    public function isFile(array $fileData): bool
    {
        return true;
    }

    /**
     * @param string $extension
     *
     * @return bool
     */
    public function isExpectedFileExtension(string $extension = 'csv'): bool
    {
        $target_file   = basename($_FILES["fileToUpload"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        return $imageFileType === $extension ? true : false;
    }

    protected function extractFileToArray(): array
    {
        try {
            $filenameTmp  = $_FILES["fileToUpload"]["tmp_name"];
            $file_to_read = fopen($filenameTmp, 'r');
            $returnData   = [];
            if ($file_to_read !== false) {
                while (($data = fgetcsv($file_to_read, 100, ',')) !== false) {

                    $data = array_map("utf8_encode", $data);
                    // Remove the tables headers.

                    for ($i = 0; $i < count($data); $i++) {

                        $row          = $data[$i];
                        $rowItem      = explode(";", $row);
                        $returnData[] = $rowItem;
                    }
                }
                fclose($file_to_read);
            }
        }catch(\Exception $e){
            $this->response['error'] = $e->getMessage();
        }
        // Remove the tables headers.
        array_shift($returnData);
        return $returnData;
    }

    private function closeDbConnection()
    {
        parent::closeConnection();
    }

    /**
     * row:  year, month, day ,name.
     *
     * @param array $row
     *
     * @return string
     */
    private function getWeekdayForDate(array $row): string
    {
        $calculator    = new CalculateWeekdayFromDate();
        $weekdayResult = $calculator->getWeekday($row[0], $row[1], $row[2]);
        return $weekdayResult['weekday'];
    }

    /**
     *
     */
    public function exportToCsv(): void
    {
        $query = parent::getAll();
        if($query->num_rows > 0){
            $delimiter = ",";
            $filename = "users-data_" . date('Y-m-d') . ".csv";

            try {
                // Create a file pointer
                $f = fopen('php://memory', 'w');

                // Set column headers
                $fields = ['ID', 'NAME', 'YEAR', 'MONTH', 'DAY', 'WEEKDAY'];
                fputcsv($f, $fields, $delimiter);

                // Output each row of the data, format line as csv and write to file pointer
                while ($row = $query->fetch_assoc()) {
                    // $status = ($row['status'] == 1)?'Active':'Inactive';
                    $lineData = [$row['id'], $row['name'], $row['year'], $row['month_id'], $row['day'], $row['weekday']];
                    fputcsv($f, $lineData, $delimiter);
                }

                // Move back to beginning of file
                fseek($f, 0);

                // Set headers to download file rather than displayed
                header('Content-Type: text/csv');
                header('Content-Disposition: attachment; filename="' . $filename . '";');

                //output all remaining data on a file pointer
                fpassthru($f);
            }catch(Exception $e){
                $this->response['error'] = $e->getMessage();
            }
        }
        exit;
    }
}

