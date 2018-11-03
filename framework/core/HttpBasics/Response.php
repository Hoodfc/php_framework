<?php
namespace Framework\Core\HttpBasics;

/**
* 
*/
class Response extends HttpCore
{
	private $controllerLabel;
	private $requirements;
	private $possibleControllers;
	
	function __construct(string $controllerLabel = null, array $requirements = null, string $path = null, array $arguments = null)
	{
		parent::__construct($path, $arguments);
		$this->controllerLabel = $controllerLabel;
		$this->requirements = $requirements;
	}

	public function setRequirements(array $requirements)
	{
		$this->requirements = $requirements;		
	}

	public function setControllerLabel(string $controllerLabel)
	{
		$this->controllerLabel = $controllerLabel;
	}


	public function setPossibleControllers(array $possibleControllers)
	{
		$this->possibleControllers = $possibleControllers;
	}

	public function getControllerLabel()
	{
		return $this->controllerLabel;
	}

	public function getRequirements()
	{
		return $this->requirements;
	}

	public function getPossibleControllers()
	{
		return $this->possibleControllers;
	}

	public function popPossibleController()
	{
		return ($this->possibleControllers)
			? array_pop($this->possibleControllers)
			: null
			;
	}


}

?>