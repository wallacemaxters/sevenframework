<?php


namespace WallaceMaxters\SevenFramework\Controller;

use function WallaceMaxters\Helpers\str_camelize;

class Inspector
{
	protected $controller;

	public function __construct(ControllerInteface $controller)
	{
		$this->controller = $controller;
	}


	public function getRoutableMethods() : array
	{
		$reflect = new ReflectionClass($this->controller);

		return $reflect->getMethods(ReflectionMethod::IS_PUBLIC);
	}

	public function routableMethodsToRoutes(Router $router, string $prefix = null)
	{

		foreach ($this->getRoutableMethods() as $method) {

			$name = $method->getName();

			$pattern = str_slug($name);

			$method = strtok($name, '-');

			$router->addRoute(
				$method,
				$prefix . '/' . $pattern,
				$this->controller .'::' . $name
			);
		}
	}
}


__halt_compiler();

$i = new Inspector('Controller');

$i->getRoutableMethods();