<?php 

namespace App\Services;

use App\Mail\VtuError;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Mail;

class ErrorService {
    use HttpResponses;
    public function returnErrorMessages($response)
    {
        $errors = ['empty_username', 'empty_password', 'invalid_username', 'Incorrect_password'];

        foreach($errors as $error){
            if($response['code'] === $error) {
                Mail::to('codejutsu@protonmail.com')->send(new VtuError($response['message']));

                return $this->message('Something went wrong, contact the Admin.', 500);
            }        
        }

        if($response['code'] === 'failure') {
            if(str_contains($response['message'], 'wallet balance') && str_contains($response['message'], 'insufficient')) {
                Mail::to('codejutsu@protonmail.com')->send(new VtuError($response['message']));

                return $this->message('Something went wrong, contact the Admin.', 500);
            } 
        }

        return $this->error($response['message'], 422);
    }
}