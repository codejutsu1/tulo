<?php

namespace App\Services;

class PhoneService { 
    public function networkProvider($number)
    {
        $number = $this->formatNumber($number);

        return $number;
    }

    public function formatNumber($number) 
    {
        $numberLength = strlen($number);

        $response = $this->validateNumber($number);

        if($response === true) {
            if($numberLength == 10) {
                return $number = '0' . $number;
            }

            return $number;
        }

        return $response;
    }

    private function validateNumber($number)
    {
        $message = 'Invalid Number';

        $number = (string) $number;

        $code = substr($number, 0 ,4);

        $numberLength = strlen($number);

        if($code === '+234') {
           $number = substr($number, 4);


           if($number[0] != 0) $number = '0' . $number;

           if(strlen($number) != 11) return $message;

           return $number;
        }

        if($numberLength == 11 && $number[0] != '0') return $message ;
    
        return true;
    }

    private function mtn() 
    {
        return [
            '0803',

            '0806',
                
            '0810',
                
            '0813',
                
            '0814',
                
            '0816',
                
            '0903',
                
            '0906',
                
            '0913',
                
            '0916',
                
            '07025',
                
            '07026',
                
            '0703',
                    
            '0706', 
            
            'o704'
        ];
    }

    private function airtel()
    {
        return [
            '0701',

            '0708',

            '0802',

            '0808',

            '0812',

            '0901',

            '0902',

            '0904',

            '0907',

            '0912'
        ];
    }

    private function glo() 
    {
        return [
            '0805', '0807', '0811', '0815', '0705', '0905', '0915'
        ];
    }

    private function mobile_9() 
    {
        return [
            '0809', '0817', '0818', '0908', '0909'
        ];
    }
}