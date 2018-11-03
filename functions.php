<?php 
    //this file and index.php are only for develpment purpose
    //this file clone the core.php file during develpment


   function recursiveDir($dir) {
        $controllers = array();
        $it = new \DirectoryIterator($dir);
        foreach ($it as $fileinfo)
        {   

            if (!$fileinfo->isDot()) {
                if((! preg_match('/\.[a-zA-Z]*$/', $fileinfo)) ){
                    recursiveDir($dir . $fileinfo);
                }
                else
                {
                    $cPos = strpos($fileinfo, 'Controller');
                    $isPHP = strpos($fileinfo, '.php');   
                    if($cPos && $isPHP ){
                        $controllerName =  substr($fileinfo, 0, $cPos);
                        if(! in_array($controllerName, $controllers) )
                            array_push($controllers, $controllerName);
                    }
                }
            }
        }
        return $controllers;
    }



?>