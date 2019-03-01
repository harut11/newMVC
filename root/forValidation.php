<?php

namespace root;

class forValidation
{
    public function validate($request, array $rules)
    {
        $validation = new Validation($request, $rules);
        $errors = $validation->getErrors();
        if ($errors) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $request;
            redirect('/register');
        }
        return true;
    }
}