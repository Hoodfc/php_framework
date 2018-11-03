<?php 
namespace Framework\Core;

/**
* 
*/
class Kernel
{
    private $request;
    private $router;
    private $dispatcher;

    public function __construct(string $requestUri,\Framework\Core\Routing\RouterInterface $router = null){
        $this->request = new \Framework\Core\HttpBasics\Request($requestUri);
        
        $this->router = ($router === null) 
            ? new \Framework\Core\Routing\RouterJson()
            : $router;

        $this->dispatcher = new \Framework\Core\Routing\Dispatcher($this->router , $this->request);
    }
}


?>