<?php

namespace WallaceMaxters\SevenFramework\View;

class Section
{	

	protected $content = '';

	protected $started = false;

	protected $closed = true;

	protected $name;

	public function __construct(string $name)
	{
		$this->name = $name;
	}

	public function setName(string $name)
	{
		$this->name = $name;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function setContent(string $content)
	{
		$this->content = $content;
	}

	public function appendContent(string $content)
	{
		$this->content .= $content;
	}

	public function getContent()
	{
		return $this->content;
	}

	public function append()
	{
		$this->appendContent(ob_get_clean());
	}

	public function start()
	{
		if ($this->started) {

			return;
		}

		ob_start();

		$this->started = true;

		$this->closed = false;		
	}

	public function end()
	{
		$this->setContent(ob_get_clean());
	}

	public function __toString()
	{
		return $this->getContent();
	}
}
