<?php
namespace App\Core\Http;

use App\Core\Bus\Rules;
use ReflectionException;
use ReflectionMethod;

class Validation extends Rules
{
    private $validatedFields;
    public function make($data,$rules=[]){
        foreach ($data as $fieldKey => $fieldValue) {
            if (array_key_exists($fieldKey, $rules)) {
                foreach ($rules[$fieldKey] as $ruleKey => $ruleValue) {
                    $this->startValidation($ruleKey, $ruleValue, $fieldValue, $fieldKey);
                    $this->validatedFields[$fieldKey] = $fieldValue;
                }
            }
        }
    }

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

    public function fails():bool{
       return empty($this->errorBag)? false:true;
    }

    public function getErrorMessages(){
        if (empty($this->errorBag)) {
            return false;
        }
        http_response_code(400);
        return $this->errorBag;
    }

    public function validated():array{
        return $this->validatedFields;
    }
}