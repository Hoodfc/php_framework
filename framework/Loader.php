<?php
namespace Core; 

class Loader {
    public static function baseLoader($className) {
        //remove initials backslashes
            require_once('config.php');

            $className = ltrim($className, '\\');
            $fileName  = '';
            $namespace = '';
            //Class modifier such as Controller, Model, etc
            $finalClassModifier = '';
            
            //take out the substring from the start to the first backslash
            //because the are differents location for different types of classes
            //like Controllers which are in {/src/controller} folder or for Core classes 
            // which are in {/core/} folder
            $firstNs = substr($className, 0 ,strpos($className, '\\'));
            $className = substr($className, strpos($className, '\\'));
            $dir = strtolower($firstNs);

            
            //take different strategies for different class' patterns
            switch($dir){
                  case 'controller': {
                        $dir = 'src\\' . $dir;
                        $finalClassModifier = 'Controller';
                        break;
                  }
                  case 'core':
                        break;
            }
            $dir = DIRECTORY_SEPARATOR . $dir;

            if ($lastNsPos = strrpos($className, '\\')) {
                  $namespace = substr($className, 0, $lastNsPos);
                  $className = substr($className, $lastNsPos + 1);
                  $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
            }

            $fileName .= str_replace('\\', DIRECTORY_SEPARATOR, $className) . $finalClassModifier . '.php';
            $fileName = $dir . $fileName;
            require $_SERVER['DOCUMENT_ROOT'] . $fileName;
    }
}

?>