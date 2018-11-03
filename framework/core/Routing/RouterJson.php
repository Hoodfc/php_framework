<?php 
namespace Framework\Core\Routing;
use \Framework\Core\HttpBasics\Request;
use \Framework\Core\HttpBasics\Response;

Class RouterJson implements RouterInterface {
	private $routes;
	private $validator;

	public function __construct(){
		$jsonContent = file_get_contents(FRAMEWORK_PATH . 'route.json');
        $this->routes = json_decode($jsonContent, true);
        $this->validator = new RouterJsonValidator();
	}

	public function getRoutes(){return $this->routes;}	

	public function getValidator(){return $this->validator;}


	public function hasRequirements(string $routeLabel)
	{
		return array_key_exists("requirements", $this->routes["$routeLabel"]);
	}

	public function countSlugs(string $routeLabel)
	{
		$controllerPath = $this->routes["$routeLabel"]['path'];
		$count = 0;
		$slugPos = strpos($controllerPath, "{");
		while ($slugPos) {			
			$count++;
			$controllerPath = substr_replace($controllerPath, '', 0, ++$slugPos);
			$slugPos = strpos($controllerPath, '{');
		}

		return $count;
	}

	public function getControllerbyPath(string $path)
	{
		foreach ($this->routes as $routeName => $value) {
			if($value['path'] === $path)
				return $routeName;
		}
		return null;
	}

	public function getControllerbyRequest(Request $request){
		return self::getMostPreciseController($request);
	}

	private function getMostPreciseController(Request $request)
	{
		//print $query . '<BR>';
		$query = $request->getQueryString();
		$precPath = "";
		$tempPathArray = array();
		$response = new Response();

		if (strlen($query) == 0) $query = '/';

		//does exist a path which is precisely equal to the query?
		if($this->existsPath($query)){
			$response->setControllerLabel($this->getControllerbyPath($query));
			return $response;	
		}

		//if not, framework can't determine the exact controller but return a 
		//collection of possible controllers
		
		while(true){
			$query = ltrim($query, '/');
			$slashPos = strpos($query, '/');
			$pathChunk = substr($query, 0, $slashPos);
			$path = $precPath . '/' . ((strlen($pathChunk) > 0) ? $pathChunk : $query);
			
			if(!$this->existsPath($path) || (strlen($query) === 0)){			
				$response->setPossibleControllers($this->getPrefixPaths(implode('',$tempPathArray)));
				$response->setArguments(explode('/',$query));
				return $response;
			}
			else
			{
				array_push($tempPathArray,  '/' . $pathChunk);
				$precPath = $path;
				
				$query = (strlen($pathChunk) > 0) 
					? substr_replace($query, '', 0, $slashPos)
					: "";
			}
		}

	}

	private function getPrefixPaths(string $path)
	{
		$arrayReturn = array();
		foreach ($this->routes as $routesName => $value) {			
			if($path == substr($value['path'], 0, strlen($path)))
				array_push($arrayReturn, $routesName);
		}

		return $arrayReturn;
	}

	private function existsPath(string $path) {
		foreach ($this->routes as $routeNames => $value) {
			if($value['path'] === $path)
				return true;
		}
		return false;
	}

}

?>