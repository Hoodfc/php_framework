<?php 
namespace Framework\Core\Routing;


class RouterJsonValidator implements RouterValidatorInterface
{
	private $defaultConf;

    public function __construct($defaultConf = null)
    {
    	$this->defaultConf = ($defaultConf === null)
    		? self::setDefaults()
    		: $defaultConf
    		;
    }

    private static function setDefaults()
    {
    	return array(
			'IS_NULLABLE' => 'nullable' , 
			'IS_DIGIT' => '/\\d+/', 
			'IS_ALFABETIC' => '/[a-zA-Z]+/',
			'IS_FLOAT' => '/\d*(?:\.\d+)?/' 
			);
    }

    public function validate(string $argument, $requirement){
        if(!is_array($requirement))
            return self::validateSingle($argument, $requirement);
        else 
            return self::validateArray($argument, $requirement);
    }
    

    public function validateAll(array $arguments, array $requirements){
        $evaluatedArray = array_combine($arguments, $requirements);
        $alreadyNullable = false;
        foreach ($evaluatedArray as $arg => $req) {
            if(! is_array($req)){
                try{
                    $tokenType = self::hasDefault($req);
                    $regEx = (self::isNotDefault($tokenType))
                        ? $req
                        : $regEx;

                    if(self::isNullable($regEx) && !alreadyNullable)
                        $alreadyNullable = true;

                    if(!self::isNullable($regEx))
                        return ($alreadyNullable) 
                            ? false
                            : (preg_match($regEx, $arg));

                } catch(RoutingException $re){
                    $re->getMessage();
                }

            } else {
                if(! self::validate($arg, $req)) return false;
            }            
        }

        return true;
    }


    private function hasDefault(string $requirement){
    	switch ($requirement) {
    		case 'IS_DIGIT':
    			return self::takeDigit();
    			break;

			case 'IS_ALFABETIC':
				return self::takeAlfabetic();
				break;

			case 'IS_FLOAT':
				return self::takeFloat();
				break;

    		default:
                return 'NO_DEFAULT';
    			break;
    	}
    }

    public function takeAlfabetic()
    {
    	if(array_key_exists('IS_ALFABETIC', $this->defaultConf))
    		return $this->defaultConf['IS_ALFABETIC'];
    	throw new RoutingException("Can't find a default configuration of the string {IS_ALFABETIC} for validation");
    }

    public function takeDigit()
    {
    	if(array_key_exists('IS_DIGIT', $this->defaultConf))
    		return $this->defaultConf['IS_DIGIT'];
    	throw new RoutingException("Can't find a default configuration of the string {IS_DIGIT} for validation");
    }

    public function takeFloat()
    {
    	if(array_key_exists('IS_FLOAT', $this->defaultConf))
    		return $this->defaultConf['IS_FLOAT'];
    	throw new RoutingException("Can't find a default configuration of the string {IS_FLOAT} for validation");
    }

    private function isNullable(string $reqType ){return $reqType === 'IS_NULLABLE';}
    private function isAlfabetic(string $reqType){return $reqType === 'IS_ALFABETIC';}
    private function isDigit(string $reqType) {return $reqType === 'IS_DIGIT';}
    private function isFloat(string $reqType) {return $reqType === 'IS_FLOAT';}
    private function isNotDefault(string $reqType) {return $reqType === 'NO_DEFAULT';}


    private function validateSingle(string $argument, string $requirement){
        $regEx = self::hasDefault;
        $regEx = (isNotDefault($regEx))
            ? $requirements
            : $regEx;
        return (isNullable($requirement))
            ? true
            : (preg_match($regEx, $argument));
    }

    private function validateArray(string $argument, array $requirements){
       $alreadyNullable = false;            
        foreach ($requirements as $req) {
            try{
                $regEx = self::hasDefault($req);
                $regEx = (self::isNotDefault($regEx))
                    ? $req
                    : $regEx;

                if(self::isNullable($req) && !$alreadyNullable)
                    $alreadyNullable = true;

                lazy_print($regEx,"Reg Ex");

                if(!self::isNullable($req))
                    return ($alreadyNullable) 
                        ? false
                        : (preg_match($regEx, $argument));

            } catch(RoutingException $re){
                $re->getMessage();
            }           
        }
        return true;
    }
}
?>