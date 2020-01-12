<?php

function __autoload($classname)
{
    if(file_exists('public/'.$classname.'.php'))
    {
        require_once 'public/'.$classname.'.php';
    }
}
