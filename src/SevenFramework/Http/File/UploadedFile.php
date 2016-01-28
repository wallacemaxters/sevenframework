<?php

namespace WallaceMaxters\SevenFramework\Http\File;

use SplFileInfo;
use SplFileObject;
use UnexpectedValueException;

/**
* @author Wallace de Souza Vizerra <wallacemaxters@gmail.com>
*/

class UploadedFile extends SplFileInfo
{

	/**
	* The client filename
	* @var string
	*/
	protected $clientName = '';

	/**
	* Size of uploaded file
	* @var int
	*/
	protected $size;

	public function __construct(string $tmpfile, string $clientName, int $size = 0)
	{	

		if ($tmpfile === null) {

			throw new UnexpectedValueException("doesnt have uploaded file with name {$name}");
		}

		$this->clientName = $clientName;

		$this->size = $size;	

		parent::__construct($tmpfile);
	}

	public function move(string $directory, string $filename = null)
	{

		if (! is_dir($directory)) {

			mkdir($directory, 0755, true);
		}

		if ($filename === null) {

			$filename = $this->getClientName();
		}

		$target = $directory . '/' . $filename;

		if (move_uploaded_file($this->getRealpath(), $target)) {

			return new SplFileObject($target, 'r');
		}

		return false;
	}

	public function getClientName() : string
	{
		return $this->clientName;
	}

	public function getSize() : int
	{
		return $this->size;
	}
}