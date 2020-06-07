<?php


namespace App\DataReader;


use SplFileObject;

class CsvDataReader extends AbstractDataReader
{
    use ConvertValueTrait;

    protected array $options = [
        'delimiter' => ',',
        'enclosure' => '"',
        'escape' => '\\'
    ];

    public function __construct(string $filename, $toDateTime=['issueDate'])
    {
        parent::__construct($filename);
        $this->toDateTime = $toDateTime;
    }

    /**
     * @inheritDoc
     */
    protected function parseFileData(SplFileObject $file): iterable
    {
        $headers = $file->fgetcsv();

        $data = [];
        while (!$file->eof()) {
            $line = [];
            $values = $file->fgetcsv(...array_values($this->options));
            for ($i = 0; $i < count($headers); $i++) {
                $line[$headers[$i]] = $this->convertValue($values[$i]);
            }
            $data[] = $line;
        }

        return $data;
    }
}