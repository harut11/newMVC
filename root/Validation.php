<?php

namespace root;

class Validation
{
    public $errors = [];

    public function __construct($request, $rules)
    {
        foreach ($request as $field => $value) {
            if (isset($rules[$field])) {
                $error = $this->validateValues($request, $rules[$field], $field);
                if($error) {
                    $this->errors[$field] = $error;
                }
            }
        }
    }

    public function validateValues($request, $rules ,$field)
    {
        $attr = null;
        $rules = explode('|', $rules);
        if ($rules) {
            foreach ($rules as $rule) {
                $rule = explode(":", $rule);
                if(count($rule) > 1) {
                    $attr = $rule[1];
                }
                $validate = $this->validateField($request, $rule[0], $attr, $field);
                if(!$validate) {
                    return $this->getErrorMessage($rule[0], $attr);
                }
            }
        }
        return null;
    }

    public function validateField($request, $rule, $attr, $field)
    {
        switch ($rule) {
            case 'required':
                return !empty($field);
                break;
            case 'min':
                return isset($request[$field]) && $request[$field] >= $attr;
                break;
            case 'max':
                return isset($request[$field]) && $request[$field] <= $attr;
            case 'email':
                $pattern = '/[a-z0-9]+[_a-z0-9\.-]*[a-z0-9]+@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,20})/';
                return isset($request[$field]) && !preg_match($pattern, $request[$field]);
            case 'string':
                $pattern = '/^(([A-Za-z]+[\s]{1}[A-Za-z]+)|([A-Za-z]+))$/';
                return isset($request[$field]) && preg_match($pattern, $request[$field]);
            default:
                return true;
                break;
        }
    }

    public function getErrorMessage($rule, $condition)
    {
        $message = [
            'required' => 'This field is required',
            'min' => 'This field value must be higher then ' . $condition,
            'max' => 'This field value must be lower then ' . $condition,
            'string' => 'This field value must be string',
            'number' => 'This field value must be number',
            'email' => 'Email address is not valid',
            'unique' => 'The field must be unique value',
            'confirm' => 'Please enter a same password',
            'exists' => 'Email or password are written wrong'
        ];

        if (isset($message[$rule])) {
            return $message[$rule];
        }
        return null;
    }

    public function getErrors()
    {
        if($this->errors) {
           return $this->errors;
        }
        return false;
    }
}