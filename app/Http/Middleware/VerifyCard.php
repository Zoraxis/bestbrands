<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyCard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $cardNumber = $request->input('cnum');
        $validateLength = true;
        define('CARD_NUMBERS', [
            'american_express' => [
                '34' => ['15'],
                '37' => ['15'],
            ],
            'diners_club' => [
                '36'      => ['14-19'],
                '300-305' => ['16-19'],
                '3095'    => ['16-19'],
                '38-39'   => ['16-19'],
            ],
            'jcb' => [
                '3528-3589' => ['16-19'],
            ],
            'discover' => [
                '6011'          => ['16-19'],
                '622126-622925' => ['16-19'],
                '624000-626999' => ['16-19'],
                '628200-628899' => ['16-19'],
                '64'            => ['16-19'],
                '65'            => ['16-19'],
            ],
            'dankort' => [
                '5019' => ['16'],
                //'4571' => ['16'],// Co-branded with Visa, so it should appear as Visa
            ],
            'maestro' => [
                '6759'   => ['12-19'],
                '676770' => ['12-19'],
                '676774' => ['12-19'],
                '50'     => ['12-19'],
                '56-69'  => ['12-19'],
            ],
            'mastercard' => [
                '2221-2720' => ['16'],
                '51-55'     => ['16'],
            ],
            'unionpay' => [
                '81' => ['16'],// Treated as Discover cards on Discover network
            ],
            'visa' => [
                '4' => ['13-19'],// Including related/partner brands: Dankort, Electron, etc. Note: majority of Visa cards are 16 digits, few old Visa cards may have 13 digits, and Visa is introducing 19 digits cards
            ],
        ]);
        $foundCardBrand = '';
        
        $cardNumber = (string)$cardNumber;
        $cardNumber = str_replace(['-', ' ', '.'], '', $cardNumber);// Trim and remove noise
        
        if(in_array(substr($cardNumber, 0, 1), ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'])) {// Try to find card number only if first digit is a number, if not then there is no need to check
            $cardNumber = preg_replace('/[^0-9]/', '0', $cardNumber);// Set all non-digits to zero, like "X" and "#" that maybe used to hide some digits
            $cardNumber = str_pad($cardNumber, 6, '0', STR_PAD_RIGHT);// If $cardNumber passed is less than 6 digits, will append 0s on right to make it 6
            
            $firstSixDigits   = (int)substr($cardNumber, 0, 6);// Get first 6 digits
            $cardNumberLength = strlen($cardNumber);// Total digits of the card
            
            foreach(CARD_NUMBERS as $brand => $rows) {
                foreach($rows as $prefix => $lengths) {
                    $prefix    = (string)$prefix;
                    $prefixMin = 0;
                    $prefixMax = 0;
                    if(strpos($prefix, '-') !== false) {// If "dash" exist in prefix, then this is a range of prefixes
                        $prefixArray = explode('-', $prefix);
                        $prefixMin = (int)str_pad($prefixArray[0], 6, '0', STR_PAD_RIGHT);
                        $prefixMax = (int)str_pad($prefixArray[1], 6, '9', STR_PAD_RIGHT);
                    } else {// This is fixed prefix
                        $prefixMin = (int)str_pad($prefix, 6, '0', STR_PAD_RIGHT);
                        $prefixMax = (int)str_pad($prefix, 6, '9', STR_PAD_RIGHT);
                    }
    
                    $isValidPrefix = $firstSixDigits >= $prefixMin && $firstSixDigits <= $prefixMax;// Is string starts with the prefix
    
                    if($isValidPrefix && !$validateLength) {
                        $foundCardBrand = $brand;
                        break 2;// Break from both loops
                    }
                    if($isValidPrefix && $validateLength) {
                        foreach($lengths as $length) {
                            $isValidLength = false;
                            if(strpos($length, '-') !== false) {// If "dash" exist in length, then this is a range of lengths
                                $lengthArray = explode('-', $length);
                                $minLength = (int)$lengthArray[0];
                                $maxLength = (int)$lengthArray[1];
                                $isValidLength = $cardNumberLength >= $minLength && $cardNumberLength <= $maxLength;
                            } else {// This is fixed length
                                $isValidLength = $cardNumberLength == (int)$length;
                            }
                            if($isValidLength) {
                                $foundCardBrand = $brand;
                                break 3;// Break from all 3 loops
                            }
                        }
                    }
                }
            }
        }
        
        return $foundCardBrand;
    }
}
