<?php 
namespace Framework\Core\Routing;


/**
* 
*/
class Dispatcher 
{
	private $dispatcherRouter;
	private $request;
	private $response;

	public function __construct(RouterInterface $router, \Framework\Core\HttpBasics\Request $request){
		$this->dispatcherRouter = $router;
		$this->request = $request;
		self::dispatch();
	}

	public function dispatch()
	{
		$this->response = $this->dispatcherRouter->getControllerbyRequest($this->request);
		

		try {
			$chosenController = ($this->response->getControllerLabel()) 
				? $this->response->getControllerLabel() 
				: self::chooseController();
				
			$this->response->setControllerLabel($chosenController);			
			$toDispatch = $this->dispatcherRouter->getRoutes()["${chosenController}"]['controller'];

			self::redirectDispatch($toDispatch, $this->response->getArguments());

		} catch (RoutingException $re) {
			$re->getMessage();
		} catch (Exception $e){
			$e->getMessage();
		}

	}

	private function redirectDispatch(string $controllerToDispatch, $args){
		$actionPos = strpos($controllerToDispatch, ':');
		$action = ($actionPos) 
			? substr($controllerToDispatch, $actionPos + 1)
			: 'index' ;
			
		$responsePath = ($actionPos) 
			? substr($controllerToDispatch, 0, $actionPos)
			: $controllerToDispatch;

		$lastSPos = strrpos($responsePath, '/');
		$className = substr($responsePath , ++$lastSPos);
		$classNamespace = 'Controller\\' . str_replace('/','\\',substr($responsePath, 0, $lastSPos));
		
		try 
		{
            $controllerRef = new \ReflectionClass($classNamespace.$className);
        }
        catch (Exception $e) {
            throw new RoutingException("Can't find {$className} in {$responsePath}");
        }   

     	if(! $controllerRef->hasMethod($action))
     		throw new RoutingException("Action {$action} does not exists in {$responsePath}");
     		
     	$controllerObj = $controllerRef->newInstanceArgs();
        if(count($args) === 0) $controllerObj->{$action}();
        else call_user_func_array(array($controllerObj, $action), $args);
	}


	private function chooseController()
	{
		$countArgs = count($this->response->getArguments());
		$returnController = null;

			while (($controller = $this->response->popPossibleController())) {
				lazy_print($this->response->getPossibleControllers(),"Possible Controllers");
				$routes = $this->dispatcherRouter->getRoutes();
				$controllerPath = $routes["$controller"]["path"];	

				if($this->dispatcherRouter->countSlugs($controller) === $countArgs ){
					if($this->dispatcherRouter->hasRequirements($controller) && $this->dispatcherRouter->getValidator()->validateAll($this->response->getArguments(), $routes["$controller"]['requirements'])){
						return $controller;				
					} 
					else $returnController = $controller;	 
				}
			}

			if($returnController !== null)
				return $returnController;
			else
				throw new RoutingException("Can't choose a proper controller");
				
	}

	private function validateReq(array $args, array $req)
	{
		foreach (array_combine(array_values($args), array_values($req)) as $arg => $req) {
			if(! $req) break;
			if(! preg_match($req, $arg))
				return false;
		}
		return true;
	}
}
?>