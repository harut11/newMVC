<?php

namespace root;

class forValidation
{
    public function validate($request, $files = null, array $rules)
    {
        $validation = new Validation($request, $files, $rules);
        $errors = $validation->getErrors();
        if ($errors) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $request;
            redirect($_SERVER['HTTP_REFERER']);
        }
        return true;
    }
}