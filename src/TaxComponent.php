<?php

namespace Tax;

/**
 * This trait for store all tax component calculation
 */
trait TaxComponent
{

    /**
     * @args: int $basic_salary
     * @return int  
     */
    private function sumBPJSTK(int $basic_salary) : int
    {
        $sum = $basic_salary * ($this->bpjstk_rate / 100);
        return round($sum);
    }

    /**
     * @args: int $basic_salary
     * @return int  
     */
    private function sumBPJSKes(int $basic_salary) : int
    {
        $sum = $basic_salary * ($this->bpjskes_rate / 100);
        if ($basic_salary > $this->bpjskes_limit) {
            $sum = $this->bpjskes_limit * ($this->bpjskes_rate / 100);
        }
        return round($sum);
    }

    /**
     * @args: int $basic_salary
     * @return int  
     */
    private function sumJKK(int $basic_salary) : int
    {
        $sum = $basic_salary * ($this->jkk_rate / 100);
        return round($sum);
    }

    /**
     * @args: int $basic_salary
     * @return int  
     */
    private function sumJKM(int $basic_salary) : int
    {
        $sum = $basic_salary * ($this->jkm_rate / 100);
        return round($sum);
    }

    /**
     * @args: int $basic_salary
     * @return int  
     */
    private function sumJP(int $basic_salary) : int
    {
        $sum = $basic_salary * ($this->jp_rate / 100);
        return round($sum);
    }

    /**
     * @args: int $basic_salary
     * @return int  
     */
    private function sumIuran(int $basic_salary) : int
    {
        $sum = 0;
        $sum += $this->getBPJSStatus('bpjstk') ? $this->sumBPJSTK($basic_salary) : 0; 
        $sum += $this->getBPJSStatus('jp') ? $this->sumJP($basic_salary) : 0;
        return round($sum);
    }

    /**
     * @args: int $basic_salary
     * @return int  
     */
    private function sumPremi(int $basic_salary) : int
    {
        $sum = 0;
        $sum += $this->getBPJSStatus('jkk') ? $this->sumJKK($basic_salary) : 0;
        $sum += $this->getBPJSStatus('jkm') ? $this->sumJKM($basic_salary) : 0;
        $sum += $this->getBPJSStatus('bpjskes') ? $this->sumBPJSKes($basic_salary) : 0;
        return round($sum);
    }

    /**
     * @args: int $bruto
     * @return int  
     */
    private function sumBiayaJabatan(int $bruto) : int
    {
        $sum = ($this->bj_rate / 100) * $bruto;
        $sum = $sum > $this->bj_limit ? $this->bj_limit : $sum;
        return round($sum);
    }

    /**
     * @return void  
     */
    public function isResign() : bool
    {
        return $this->resign;
    }

    public function hasNPWP() : bool
    {
        return $this->npwp;
    }

    private function pphRate(float $rate)
    {
        return (!$this->hasNPWP()) ? $rate + ($rate * 0.2) : $rate;
    }

    private function pphProgressive($rate,$limit,&$pkp, &$tax)
    {
        $rate = $this->pphRate($rate);
        if ($pkp >= $limit) $tax += $limit * $rate;
        else if ($pkp > 0) $tax += $pkp * $rate;
        $pkp -= $limit;
    }

}
 