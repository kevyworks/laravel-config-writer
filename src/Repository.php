<?php

namespace Kevyworks\Laravel\ConfigWriter;

use RuntimeException;
use Illuminate\Config\Repository as RepositoryBase;
use Kevyworks\Laravel\ConfigWriter\DataWriter\FileWriter;

class Repository extends RepositoryBase
{
    /**
     * The config rewriter object.
     *
     * @var Kevyworks\Laravel\ConfigWriter\FileWriter
     */
    protected $writer;

    /**
     * Create a new configuration repository.
     *
     * @param  FileWriter  $writer
     * @param  array       $items
     */
    public function __construct(FileWriter $writer, array $items = [])
    {
        parent::__construct($items);
        $this->writer = $writer;
    }

    /**
     * Write a given configuration value to file.
     *
     * @param  string  $key
     * @param  mixed   $value
     *
     * @return bool
     * @throws RuntimeException
     */
    public function write(string $key, $value): bool
    {
        list($filename, $item) = $this->parseKey($key);
        $result = $this->writer->write($item, $value, $filename);

        if (! $result) {
            throw new RuntimeException('File could not be written to');
        }

        $this->set($key, $value);

        return $result;
    }

    /**
     * Split key into 2 parts. The first part will be the filename.
     *
     * @param  string  $key
     *
     * @return array
     */
    private function parseKey(string $key): array
    {
        return preg_split('/\./', $key, 2);
    }
}
