<?php

namespace root;

class Middleware
{
    public function __construct($condition)
    {
        switch ($condition) {
            case 'guest':
                if(!isAuth()) {
                    return true;
                }
                redirect('/');
                return false;
                break;
            case 'auth':
                if(isAuth()) {
                    return true;
                }
                redirect('/');
                return false;
                break;
            default:
                return false;
                break;
        }
    }
}