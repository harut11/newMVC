<?php

namespace root;

use app\Models\users;

class Validation
{
    public $errors = [];

    public function __construct($request, $files = null, $rules)
    {
        foreach ($request as $field => $value) {
            if (isset($rules[$field])) {
                $error = $this->validateValues($request, $rules[$field], $field);
                if($error) {
                    $this->errors[$field] = $error;
                }
            }
        }
        if (isset($files)) {
            foreach ($files as $field => $value) {
                if (isset($rules[$field])) {
                    $error = $this->validateValues($files, $rules[$field], $field);
                    if ($error) {
                        $this->errors[$field] = $error;
                    }
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
        if (is_array($request[$field])) {
            $value = $request[$field]['name'];
        } else {
            $value = trim($request[$field]);
        }

        switch ($rule) {
            case 'required':
                return !empty($value);
                break;
            case 'min':
                return isset($value) && strlen($value) >= $attr;
                break;
            case 'max':
                return isset($value) && strlen($value) <= $attr;
            case 'email':
                $pattern = '/[a-z0-9]+[_a-z0-9\.-]*[a-z0-9]+@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,20})/';
                return isset($value) && preg_match($pattern, $value);
            case 'string':
                $pattern = '/^(([A-Za-z]+[\s]{1}[A-Za-z]+)|([A-Za-z]+))$/';
                return isset($value) && preg_match($pattern, $value);
            case 'unique':
                return !users::query()->where($field, '=', $value)->getAll();
                break;
            case 'confirm':
                return $value === $_REQUEST['password'];
            case 'registered':
                $user = users::query()->where('email', '=', $request[$field])->get('password');
                return password_verify($request['password'], $user[0]['password']);
                break;
            case 'img':
                $imgType = explode('/', $_FILES['avatar']['type']);
                return ($_FILES['avatar']['size'] !== 0 && $imgType[0] === 'image') || $_FILES['avatar']['size'] === 0;
                break;
            case 'updateUnique':
                return !users::query()->where('id', '<>', session_get('user_details', 'id'))
                    ->andWhere($field, '=', $value)->getAll();
                break;
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
            'registered' => 'Email or password are written wrong',
            'img' => 'Image format are not valid',
            'updateUnique' => 'The field must be unique value',
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