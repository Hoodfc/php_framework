<?php 
namespace Framework\Core\HttpBasics;


/**
 * summary
 */
class Request extends HttpCore
{
    private $queryString;
    private $controllerLabel;
    
    public function __construct($requestString)
    {
        $this->queryString = $requestString;
    }

    public function getQueryString()
    {
    	return $this->queryString;
    }

    public function getControllerLabel()
    {
    	return $this->controllerLabel;
    }  

    public function setControllerLabel($controllerLabel)
    {
    	$this->controllerLabel = $controllerLabel;
    }


}

?>