<?php

class Currency
{
    const ISO_CODE_EURO = 978;
    const SYMBOL_EURO = '¤';
    const ISO_CODE_USD_DOLLAR = 840;
    const SYMBOL_USD_DOLLAR = '$';
    
    public static function create()
    {
        return new Currency();
    }
    
    public function getCurrencyByIsoCode( $currencyIsoCode )
    {
        $response = array ( 'symbol' => '', 'name' => '' );
        $currencies = $this->getCurrenciesFromDb();
        
        if ( isset($currencies[$currencyIsoCode]) )
        {
            $response = $currencies[$currencyIsoCode];
        }
    
        return $response;
    }
    
    public function getCurrenciesFromDb()
    {
        $currencies = array (
            Currency::ISO_CODE_EURO => array ('symbol' => Currency::SYMBOL_EURO, 'name' => 'Euro' ),
            Currency::ISO_CODE_USD_DOLLAR => array ('symbol' => Currency::SYMBOL_USD_DOLLAR, 'name' => 'USD Dollars' )
                );
        
        return $currencies;
    }

}
