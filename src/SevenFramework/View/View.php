<?php

namespace WallaceMaxters\SevenFramework\View;

use Throwable;
use ArrayObject;
use SplObjectStorage;
use RuntimeException;
use WallaceMaxters\SevenFramework\TraitHelpers\CreateObjectTrait;

class View
{

	use CreateObjectTrait;
	/**
	 * @var \ArrayObject
	 * */
	protected $data;

	/**
	 * @var string
	 * */
	protected $name;

	/**
	 * @var string
	*/
	protected $extension = 'php';

	/**
	 * @var Section
	 * */
	protected $extendedView;

	/**
	 * @var WallaceMaxters\SevenFramework\View\SectionCollection
	 * */
	protected $sections;

	public function __construct(string $name, array $data = [])
	{

		$this->data = new ArrayObject;

		$this->sections = new SectionCollection;

		$this->setName($name);

		$this->setDataArray($data);
	}

	public function getData() : ArrayObject
	{
		return $this->data;
	}

	public function setData(ArrayObject $arrayObject)
	{
		$this->data = $arrayObject;
	}

	public function setDataArray(array $array)
	{
		$this->data->exchangeArray(
			$array + $this->data->getArrayCopy()
		);
	}

	public function setName(string $name)
	{
		$this->name = $name;
	}

	public function getName() : string
	{
		return $this->name . '.' . $this->extension;
	}

	public function render() : string
	{
		ob_start();

		try {

			extract($this->data->getArrayCopy());

			include $this->getName();

			if ($this->extendedView) {

				include $this->extendedView->getName();
			}

		} catch (Throwable $e) {

			$this->handleException($e);
		}

		return ltrim(ob_get_clean());
	}

	public function startSection(string $name)
	{
		$section = $this->sections->findOrCreate($name);

		$section->start();

	}

	public function endSection()
	{
		$section = $this->sections->last();

		if (! $section) {

			throw new RuntimeException('closeSection called without start a section');
		}

		$section->end();
	}

	public function appendSection()
	{
		$section = $this->sections->last();

		if (! $section) {

			throw new RuntimeException('closeSection called without start a section');
		}

		$section->append();
	}

	public function getSection(string $name, string $default = '') : string
	{
		$section = $this->sections->find($name);

		if ($section instanceof Section) {

			return $section->getContent();
		}

		return $default;
	}

	public function getSectionsCollection() : SectionCollection
	{
		return $this->sections;
	}

	public function setSectionsCollection(SectionCollection $sections)
	{
		$this->sections = $sections;
	}

	public function extend(string $name, array $data = [])
	{
		$this->extendedView = new self($name, $data);
	}

	public function handleExcepton(Throwable $exception)
	{
		return $exception->getMessage();
	}

	public function __toString() 
	{
		return $this->render();
	}

}