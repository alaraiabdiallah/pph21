<?php

namespace Tax;

/**
 * This trait for store all properties function
 */

trait PropertiesSetter
{

    /**
     * All rate on percentage
     */

    protected $npwp = true;
    protected $user_ptkp = "tk0";
    protected $bpjstk_rate = 2;
    protected $bpjskes_rate = 4;
    protected $bpjskes_limit = 8000000;
    protected $jp_limit = 8094000;
    protected $jp_rate = 1;
    protected $bj_rate = 5;
    protected $bj_limit = 500000;
    protected $jkk_rate = 0.54;
    protected $jkm_rate = 0.3;
    protected $resign = false;
    protected $bpjs_status = [
        'jkk' => true,
        'jkm' => true,
        'jp'  => true,
        'bpjstk' => true,
        'bpjskes' => true
    ];

    protected $tarif_pph = [
        "0.05" => 50000000,
        "0.15" => 200000000,
        "0.25" => 250000000,
        "0.3"  => 500000000 
    ];

    protected $ptkp = [
        "tk0" => 54000000,
        "k0" => 58500000,
        "k1" => 63000000,
        "k2" => 67500000,
        "k3" => 72000000
    ];
    
    /**
     * @args: float $rate
     * @return void  
     */
    public function setJPRate(float $rate)
    {
        $this->jp_rate = $rate;
    }

    /**
     * @args: float $rate
     * @return void  
     */
    public function setBJRate(float $rate)
    {
        $this->bj_rate = $rate;
    }

    /**
     * @args: float $rate
     * @return void  
     */
    public function setBJLimit(float $limit)
    {
        $this->bj_limit = $limit;
    }

    /**
     * @args: float $rate
     * @return void  
     */
    public function setBPJSKesLimit(float $limit)
    {
        $this->bpjskes_limit = $limit;
    }

    /**
     * @args: float $rate
     * @return void  
     */
    public function setJPLimit(float $limit)
    {
        $this->jp_limit = $limit;
    }

    /**
     * @args: float $rate
     * @return void  
     */
    public function setBPJSTKRate(float $rate)
    {
        $this->bpjstk_rate = $rate;
    }

    /**
     * @args: float $rate
     * @return void  
     */
    public function setBPJSKesRate(float $rate)
    {
        $this->bpjskes_rate = $rate;
    }

    /**
     * @args: float $rate
     * @return void  
     */
    public function setJKKRate(float $rate)
    {
        $this->jkk_rate = $rate;
    }

    /**
     * @args: float $rate
     * @return void  
     */
    public function setJKMRate(float $rate)
    {
        $this->jkm_rate = $rate;
    }

    /**
     * @args: array $resign
     * @return void  
     */
    public function setResign(bool $resign)
    {
        $this->resign = $resign;
    }

    public function setPTKP(string $ptkp)
    {
        try{
            if (!array_key_exists($ptkp,$this->ptkp))
                throw new \Exception("PTKP type is invalid!. Allowed type : ". implode(', ',array_keys($this->ptkp)));
            $this->user_ptkp = $ptkp;
        }catch(\Exception $e){
            echo "Caught exception: ".$e->getMessage();
        }
    }

    public function setNPWP(bool $npwp)
    {
        $this->npwp = $npwp;
    }

    public function setBPJSStatus(string $key,bool $value)
    {
        if (isset($this->bpjs_status[$key])) {
            $this->bpjs_status[$key] = $value;
        }
    }

    public function getBPJSStatus(string $key) : bool
    {
        return isset($this->bpjs_status[$key]) ? $this->bpjs_status[$key] : false;
    }

}