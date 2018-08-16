<?php
namespace Tax;
/**
 * Pph21 Library 
 * Author: Ala Rai AbdiAllah
 * Library ini mengikuti peraturan pph21 yang terbaru
 */

 use Tax\{PropertiesSetter,TaxComponent};

 class  Pph21 {

    protected $data = [];
    use PropertiesSetter, TaxComponent;


    public function __construct($user_ptkp = "tk0")
    {
        $this->user_ptkp = $user_ptkp;
    }

    /**
     * @args: array $data
     * @return void  
     */
    public function setDatas(array $data)
    {
        $this->data = $data;
    }

    /**
     * @args: float $rate
     * @return array  
     */
    public function getResults() : array
    {
        return $this->sumPphs();
    }

    public function sumPphs()
    {
        $pphs = [];
        $loop = 1;
        foreach ($this->data as $row) {
            $netto  = $this->sumNetto($row,$pphs) / $loop;
            $pkp    = $this->sumPKP($netto);
            $pph    = ($this->sumPphMonth($pkp) * $loop) - $this->collectivePphs($pphs);
            $pphs[] = ["netto" => round($netto),"pph" => round($pph)];
            $loop++;
        }

        return $pphs;
    }

    public function getPTKPAmount() : int
    {
        return $this->ptkp[$this->user_ptkp];
    }

    public function getPph($pkp) : int
    {
        $tax = 0;
        foreach ($this->tarif_pph as $rate => $limit) {
            $this->pphProgressive(((float)$rate), $limit, $pkp, $tax);
            if ($pkp < 0) break;
        }
        return round($tax);
    }

    private function sumNetto($data, $pphs)
    {
        $bruto = $data['basic_salary'] + $data['tunjangan'] + $this->sumPremi($data['basic_salary']);
        $deduct = $this->sumIuran($data['basic_salary']) + $this->sumBiayaJabatan($bruto);
        return ($bruto - $deduct) + $this->collectiveNettos($pphs);
    }

    private function sumPKP($netto)
    {
        return ($netto * 12) - $this->getPTKPAmount();
    }

    private function collectiveNettos($pphs)
    {
        $nettos = [];
        foreach ($pphs as $pph) {
            $nettos[] = $pph['netto'];
        }

        return array_sum($nettos);
    }

    private function collectivePphs($pphs)
    {
        $nettos = [];
        foreach ($pphs as $pph) {
            $nettos[] = $pph['pph'];
        }

        return array_sum($nettos);
    }

    private function sumPphMonth($pkp)
    {
        $pph_year = ($pkp > 0) ? $this->getPph($pkp) : 0;
        return ($pph_year / 12);
    }

 }