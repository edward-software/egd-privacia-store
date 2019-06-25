<?php

namespace Goondi\ToolsBundle\Services;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpKernel\Log\LoggerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Doctrine\ORM\ORMException;

class CurrencyManager
{

    private $em;
    private $container;
    private $logger;

    private $rates;

    // ISO 4217 Currency Codes
    private $isoCurrencyCode = array('AFN' => '971','EUR' => '978','ALL' => '008','DZD' => '012','USD' => '840','AOA' => '973','XCD' => '951',
        'ARS' => '032','AMD' => '051','AWG' => '533','AUD' => '036','AZN' => '944','BSD' => '044','BHD' => '048','BDT' => '050',
        'BBD' => '052','BYR' => '974','BZD' => '084','XOF' => '952','BMD' => '060','BTN' => '064','INR' => '356','BOB' => '068',
        'BOV' => '984','BAM' => '977','BWP' => '072','NOK' => '578','BRL' => '986','BND' => '096','BGN' => '975','BIF' => '108',
        'CVE' => '132','KHR' => '116','XAF' => '950','CAD' => '124','KYD' => '136','CLF' => '990','CLP' => '152','CNY' => '156',
        'COP' => '170','COU' => '970','KMF' => '174','CDF' => '976','NZD' => '554','CRC' => '188','HRK' => '191','CUC' => '931',
        'CUP' => '192','ANG' => '532','CZK' => '203','DKK' => '208','DJF' => '262','DOP' => '214','EGP' => '818','SVC' => '222',
        'ERN' => '232','ETB' => '230','FKP' => '238','FJD' => '242','XPF' => '953','GMD' => '270','GEL' => '981','GHS' => '936',
        'GIP' => '292','GTQ' => '320','GBP' => '826','GNF' => '324','GYD' => '328','HTG' => '332','HNL' => '340','HKD' => '344',
        'HUF' => '348','ISK' => '352','IDR' => '360','XDR' => '960','IRR' => '364','IQD' => '368','ILS' => '376','JMD' => '388',
        'JPY' => '392','JOD' => '400','KZT' => '398','KES' => '404','KPW' => '408','KRW' => '410','KWD' => '414','KGS' => '417',
        'LAK' => '418','LBP' => '422','LSL' => '426','ZAR' => '710','LRD' => '430','LYD' => '434','CHF' => '756','MOP' => '446',
        'MKD' => '807','MGA' => '969','MWK' => '454','MYR' => '458','MVR' => '462','MRO' => '478','MUR' => '480','XUA' => '965',
        'MXN' => '484','MXV' => '979','MDL' => '498','MNT' => '496','MAD' => '504','MZN' => '943','MMK' => '104','NAD' => '516',
        'NPR' => '524','NIO' => '558','NGN' => '566','OMR' => '512','PKR' => '586','PAB' => '590','PGK' => '598','PYG' => '600',
        'PEN' => '604','PHP' => '608','PLN' => '985','QAR' => '634','RON' => '946','RUB' => '643','RWF' => '646','SHP' => '654',
        'WST' => '882','STD' => '678','SAR' => '682','RSD' => '941','SCR' => '690','SLL' => '694','SGD' => '702','XSU' => '994',
        'SBD' => '090','SOS' => '706','SSP' => '728','LKR' => '144','SDG' => '938','SRD' => '968','SZL' => '748','SEK' => '752',
        'CHE' => '947','CHW' => '948','SYP' => '760','TWD' => '901','TJS' => '972','TZS' => '834','THB' => '764','TOP' => '776',
        'TTD' => '780','TND' => '788','TRY' => '949','TMT' => '934','UGX' => '800','UAH' => '980','AED' => '784','USN' => '997',
        'UYI' => '940','UYU' => '858','UZS' => '860','VUV' => '548','VEF' => '937','VND' => '704','YER' => '886','ZMW' => '967',
        'ZWL' => '932','XBA' => '955','XBB' => '956','XBC' => '957','XBD' => '958','XTS' => '963','XAU' => '959','XPD' => '964',
        'XPT' => '962','XAG' => '961');

    public function __construct($em, Container $container, LoggerInterface $logger)
    {
        $this->em = $em;
        $this->container = $container;
        $this->logger = $logger;
    }


    public function isCurrencyCode($code)
    {
        if(in_array($code, $this->isoCurrencyCode))
        {
            return true;
        }
        return false;
    }

    public function isCurrencyName($name)
    {
        if(array_key_exists($name, $this->isoCurrencyCode))
        {
            return true;
        }
        return false;
    }


    /**
     * Get ISO Name from ISO Code
     * @param $code
     * @return bool|mixed
     */
    public function getName($code)
    {
        if(in_array($code, $this->isoCurrencyCode))
        {
            return array_search($code, $this->isoCurrencyCode);
        }
        return false;
    }

    /**
     * Get ISO Code form ISO Name
     * @param $name
     * @return bool
     */
    public function getCode($name)
    {
        if(array_key_exists($name, $this->isoCurrencyCode))
        {
            return $this->isoCurrencyCode[$name];
        }
        return false;
    }

    public function load()
    {
        $currencyRates = $this->em->getRepository("GoondiToolsBundle:CurrencyRate")->findAll();

        $rates = array();

        foreach($currencyRates as $rate)
        {
            $rates[$rate->getSource()][$rate->getTarget()] = $rate->getRate();
        }

        $this->rates = $rates;
    }

    public function convert($sourceCurrency, $targetCurrency, $amount, $precision = null)
    {
        if(! is_array($this->rates) && ! count($this->rates)) {
            $this->load();
        }

        if(! in_array($sourceCurrency, $this->isoCurrencyCode)) {
            $sourceCurrency = $this->getCode($sourceCurrency);
        }

        if(! in_array($targetCurrency, $this->isoCurrencyCode)) {
            $targetCurrency = $this->getCode($targetCurrency);
        }

        if(! $sourceCurrency) {
            return false;
        }

        if(! $targetCurrency) {
            return false;
        }

        if($sourceCurrency == $targetCurrency) {
            return $amount;
        }

        if(! isset($this->rates[$sourceCurrency]) || ! is_array($this->rates[$sourceCurrency]) || ! isset($this->rates[$sourceCurrency][$targetCurrency])) {
            return false;
        }
        $rate = $this->rates[$sourceCurrency][$targetCurrency];

        $value = $amount * $rate;

        if($precision !== null)
            return round($value, $precision);

        return $value;
    }


}
