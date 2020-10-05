<?php

namespace App\Http\Middleware;

use Closure;

use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use RenatoMarinho\LaravelPageSpeed\Middleware\PageSpeed as PageSpeedObj;

class CollapseWhitespace extends PageSpeedObj
{
    public function apply($buffer)
    {
        // set as blank replacer
        $replace = array();

        // check if user is not logged in then minify and remove white space from the pages
        if(\Auth::check() == false){
            $replace = [
                "/\n([\S])/" => '$1',
                "/\r/" => '',
                "/\n/" => '',
                "/\t/" => '',
                "/ +/" => ' ',
                "/> +</" => '><',
            ];
        }

        return $this->replace($replace, $buffer);
    }
}
