<?php

namespace WallaceMaxters\SevenFramework\Http\Parameters;

use WallaceMaxters\SevenFramework\Http\File\UploadedFile;

class Files extends Parameters
{

    const FIELDS = [
        'error',
        'name',
        'size',
        'tmp_name',
        'type',
    ];

    const DEFAULTS = [
        'error'    => 0,
        'name'     => '',
        'size'     => 0,
        'tmp_name' => NULL,
    ];

    public function __construct(array $data)
    {

        $callback = function ($value) {

            return new UploadedFile($value['tmp_name'], $value['name']);
        };

        foreach ($data as $key => &$value) {
           
            $value = $this->convertToUploadedFileObject($value);

            $this->set($key, $value);
        }
    }

    protected function convertToUploadedFileObject(array $data)
    {
        $data += static::DEFAULTS;

        if (is_array($data['name'])) {


            print_r($this->fixPhpFilesArray($data));

            foreach ($data['name'] as $key => $value) {

                $collection[$key] = new UploadedFile($tmpname, $filename, $size);
            }

            return $collection;
        }

        return new UploadedFile($data['tmp_name'], $data['name'], $data['size']);
    }

    protected function fixPhpFilesArray($data)
    {
        if (!is_array($data)) return $data;

        $keys = array_keys($data);

        sort($keys);

        if (self::FIELDS != $keys || !isset($data['name']) || !is_array($data['name'])) {
            return $data;
        }

        $collection = [];

        foreach (array_keys($data['name']) as $key) {

            $files[$key] = $this->fixPhpFilesArray(array(
                'error'    => $data['error'][$key],
                'name'     => $data['name'][$key],
                'type'     => $data['type'][$key],
                'tmp_name' => $data['tmp_name'][$key],
                'size'     => $data['size'][$key],
            ));
        }

        return $files;
    }
}
