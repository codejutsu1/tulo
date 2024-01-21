<?php

namespace App\Services;

class PhoneService { 
    public function networkProvider($number)
    {
        $number = $this->formatNumber($number);

        if(strlen($number) != 11 || $number[0] != '0') return 'Wrong Phone Number Format';

        $digit = substr($number, 0, 4);

        $digit_2 = substr($number, 0, 5);

        if(in_array($digit, $this->mtn()) || in_array($digit_2, $this->mtn())){
            return 'mtn';
        }

        if(in_array($digit, $this->airtel())){
            return 'airtel';
        }

        if(in_array($digit, $this->glo())){
            return 'glo';
        }

        if(in_array($digit, $this->mobile_9())){
            return 'etisalat';
        }

        return "Not a Nigeria Number";
    }

    public function formatNumber($number) 
    {
        $number = (string) $number;

        if(strlen($number) == 11 && $number[0] != '0') return 'Wrong Phone Number Format';

        if(strlen($number) > 11){
            $code = substr($number, 0 ,4);

            if($code != '+234') return 'This is not a Nigeria Number';

            $number = substr($number, 4);
        }

        if(strlen($number) == 10) {
            $number = '0' . $number;
        }

        return $number;
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
            
            '0704'
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