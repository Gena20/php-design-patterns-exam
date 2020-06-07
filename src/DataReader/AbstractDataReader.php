<?php


namespace App\DataReader;


use SplFileObject;

/**
 * Class AbstractDataReader
 * @package App\DataReader
 */
abstract class AbstractDataReader
{
    protected string $filename;

    /**
     * AbstractDataReader constructor.
     * @param string $filename
     */
    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    /**
     * @return iterable
     */
    public final function getData(): iterable
    {
        $file = $this->getFile();
        return $this->parseFileData($file);
    }

    /**
     * @return SplFileObject
     */
    protected function getFile(): SplFileObject
    {
        return new SplFileObject($this->filename, 'rb');
    }

    /**
     * @param SplFileObject $file
     * @return iterable
     */
    abstract protected function parseFileData(SplFileObject $file): iterable;
}