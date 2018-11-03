<?php 
namespace Framework\Fundamentals\MVC;

abstract class Controller {
    
    public function render($viewsPath, $argArray) {
        extract($argArray);
        require_once($viewsPath);
    }   

    // public function call($controller, $controllerArg = array()){
    //     $request = $controller . implode('/', $controllerArg);
    //     \Core\Fundamentals\Kernel::call($request);
    // }

}

?>