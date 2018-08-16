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
        return [$this->sumPph()];
    }

    public function sumPph()
    {
        $pph = 0;
        foreach ($this->data as $row) {
            $bruto  = $row['basic_salary'] + $row['tunjangan'] + $this->sumPremi($row['basic_salary']);
            $deduct = $this->sumIuran($row['basic_salary']) + $this->sumBiayaJabatan($bruto);
            $netto  = $bruto - $deduct;
            $nettos = $netto * 12;
            $pkp    = $nettos - $this->getPTKPAmount();
            $pph    = ($pkp > 0) ? $this->getPph($pkp) : 0;
        }

        return [
           "bruto" => $bruto,
           "deduct" => $deduct,
           "netto" => $nettos,
           "pkp" => $pkp,
           "pph" => ($pph / 12),
        ];
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

    

 }