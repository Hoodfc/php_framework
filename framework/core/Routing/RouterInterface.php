<?php 
namespace Framework\Core\Routing;
use \Framework\Core\HttpBasics\Request;

interface RouterInterface {

	public function getRoutes();
	public function getControllerbyPath(string $path);
	public function getControllerbyRequest(Request $request);
	public function hasRequirements(string $routeLabel);
	public function countSlugs(string $routeLabel);

}


?>