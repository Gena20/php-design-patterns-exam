<?php


namespace App\DataReader;


use SplFileObject;

class JsonDataReader extends AbstractDataReader
{
    use ConvertValueTrait;

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
        $rawData = json_decode($file->fread($file->getSize()));
        $data = [];

        foreach ($rawData as $line) {
            $lineData = [];
            foreach ($line as $lineKey => $lineVal) {
                $lineData[$lineKey] = $this->convertValue($lineVal);
            }
            $data[] = $lineData;
        }

        return $data;
    }
}