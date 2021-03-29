<?php
namespace App\Core\Http;

use App\Core\Bus\Rules;
use ReflectionException;
use ReflectionMethod;

class Validation extends Rules
{
    /**
     * Holds validated attributes
     *
     * @var array
     */
    private $validatedFields;

    /**
     * Validate fields vs rules
     *
     * @param array $data
     * @param array $rules
     * @return void
     */
    public function make(array $data,array $rules=[]){
        foreach ($data as $fieldKey => $fieldValue) {
            if (array_key_exists($fieldKey, $rules)) {
                foreach ($rules[$fieldKey] as $ruleKey => $ruleValue) {
                    $this->startValidation($ruleKey, $ruleValue, $fieldValue, $fieldKey);
                    $this->validatedFields[$fieldKey] = $fieldValue;
                }
            }
        }
    }

    /**
     * Start validation
     *
     * @param string $ruleKey
     * @param string $ruleValue
     * @param string $fieldValue
     * @param string $fieldKey
     * @return mixed
     */
    private function startValidation($ruleKey,$ruleValue,$fieldValue,$fieldKey){
        if(is_int($ruleKey)){
            $ruleKey = $ruleValue;
            $ruleValue = true;
        }
        try {
            $method = new ReflectionMethod($this, $ruleKey);
            $method->setAccessible(true);
            $method->invokeArgs($this, [$fieldKey, $fieldValue, $ruleValue]);
        }catch(ReflectionException $e){
            die($e);
        }
    }

    /**
     * Check if validation failed
     *
     * @return boolean
     */
    public function fails():bool{
       return empty($this->errorBag)? false:true;
    }

    /**
     * Load error messages
     *
     * @return mixed
     */
    public function getErrorMessages(){
        if (empty($this->errorBag)) {
            return false;
        }
        http_response_code(400);
        return $this->errorBag;
    }

    /**
     * Return clean validated data
     *
     * @return array
     */
    public function validated():array{
        return $this->validatedFields;
    }
}