<?php
namespace App\Core\Bus;

abstract class Rules
{
    protected $errorBag;
    private function max($field,$value,$expectedLength){
        if(strlen($value) > $expectedLength){
          $this->errorBag[$field][] =  "{$field} must not be greater than {$expectedLength} characters";
        }
    }
    private function required($field,$value,$required){
        if(empty($value) && $required){
          $this->errorBag[$field][] =  "{$field} is required";
        }
    }

    private function min($field,$value,$expectedLength){
        if(strlen($value) < $expectedLength){
            $this->errorBag[$field][] = "{$field} must not be less than {$expectedLength} characters";
          }
    }

    private function string($field,$value){
        if(!is_string($value)){
          $this->errorBag[$field][] =  "{$field} must be a string";
        }
    }

    private function email($field,$value){
      if(!filter_vaR($value,FILTER_VALIDATE_EMAIL)){
        $this->errorBag[$field][] =  "please provide a proper email address";
      }
    }

    private function alphanumeric($field,$value){
        if(!ctype_alnum($value)){
          $this->errorBag[$field][] =  "{$field} can only be alphabet and numerical characters";
        }
    }
}