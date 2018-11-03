<?php 
namespace Framework\Core\HttpBasics;

/**
* 
*/
class HttpCore
{	
	protected $path;
    protected $arguments;

	function __construct(string $path=null, array $arguments = null)
	{
		$this->path = $path;
		$this->arguments = $arguments;
	}

	public function getPath()
    {
    	return $this->path;
    }

    public function getArguments()
    {
    	return $this->arguments;
    }

    public function setPath(string $path)
    {
    	$this->path = $path;
    }

    public function setArguments(array $arguments)
    {
    	$this->arguments = $arguments;
    }

    public function shiftArguments()
    {
    	array_shift($this->arguments);
    }
}


?>