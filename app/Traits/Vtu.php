<?php

namespace App\Traits;

trait Vtu {
    protected function username()
    {
        return config('vtu.vtu_username');
    }

    protected function password()
    {
        return config('vtu.vtu_password');
    }
}