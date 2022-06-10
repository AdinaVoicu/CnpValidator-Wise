<?php

declare(strict_types=1);

namespace Library;

use DateTime;

final class CNP
{
    const COUNTY_CODES = [
        "01" =>    "Alba",              "25" =>    "Mehedinți",
        "02" =>    "Arad",              "26" =>    "Mureș",
        "03" =>    "Argeș",             "27" =>    "Neamț",
        "04" =>    "Bacău",             "28" =>    "Olt",
        "05" =>    "Bihor",             "29" =>    "Prahova",
        "06" =>    "Bistrița-Năsăud",   "30" =>    "Satu Mare",
        "07" =>    "Botoșani",          "31" =>    "Sălaj",
        "08" =>    "Brașov",            "32" =>    "Sibiu",
        "09" =>    "Brăila",            "33" =>    "Suceava",
        "10" =>    "Buzău",             "34" =>    "Teleorman",
        "11" =>    "Caraș-Severin",     "35" =>    "Timiș",
        "12" =>    "Cluj",              "36" =>    "Tulcea",
        "13" =>    "Constanța",         "37" =>    "Vaslui",
        "14" =>    "Covasna",           "38" =>    "Vâlcea",
        "15" =>    "Dâmbovița",         "39" =>    "Vrancea",
        "16" =>    "Dolj",              "40" =>    "București",
        "17" =>    "Galați",            "41" =>    "București Sector 1",
        "18" =>    "Gorj",              "42" =>    "București Sector 2",
        "19" =>    "Harghita",          "43" =>    "București Sector 3",
        "20" =>    "Hunedoara",         "44" =>    "București Sector 4",
        "21" =>    "Ialomița",          "45" =>    "București Sector 5",
        "22" =>    "Iași",              "46" =>    "București Sector 6",
        "23" =>    "Ilfov",             "51" =>    "Călărași",
        "24" =>    "Maramureș",         "52" =>    "Giurgiu"

    ];
    const CNP_CONTROL_KEY = "279146358279"; //static control key for validate of CNP control digit  

    private bool      $isValid = false;
    private string   $cnp;

    private int      $sex;
    private int      $year;
    private string   $month = '';
    private string   $day = '';
    private DateTime $bornDate;
    private string   $county = '';
    private int      $nnn;

    public function __construct(string $cnp)
    {
        $this->cnp = trim($cnp);
        $this->isCnpValid($this->cnp);
    }

    public function getIsValid(): bool
    {
        return $this->isValid;
    }

    private function isCnpValid(string $value): bool
    {
        if (strlen($value) == 13 and ctype_digit($value)) {
            $this->sex    = intval($this->cnp[0]);
            $this->year   = intval($this->cnp[1] . $this->cnp[2]);
            $this->month  = $this->cnp[3] . $this->cnp[4];
            $this->day    = $this->cnp[5] . $this->cnp[6];
            $this->county = $this->cnp[7] . $this->cnp[8];
            $this->nnn    = intval($this->cnp[9] . $this->cnp[10] . $this->cnp[11]);

            $dateCheck     = $this->check_date(); //check date validity
            $countyCheck  = (self::COUNTY_CODES[$this->county]) ?? false; //check if county in list const COUNTY_CODES
            $nnnCheck     = ($this->nnn >= 1 and $this->nnn <= 999) ? true : false; //check unique number alocated per county per day
            $codeCheck    = $this->check_control_digit();

            if ($dateCheck && $countyCheck && $nnnCheck && $codeCheck)
                $this->isValid = true;
        }
        return $this->isValid;
    }

    private function check_date()
    {
        $century = match ((int)$this->sex) {
            1, 2     => 1900,
            3, 4     => 1800,
            5, 6     => 2000,
            7, 8, 9  => 1900,
            default  => 0
        }; //get century according to CNP sex digit
        $this->year = $century + intval($this->year); // born year
        $date = $this->year . "-" . $this->month . "-" . $this->day;//born date
        $this->bornDate = DateTime::createFromFormat("Y-m-d", $date);
        return ($this->bornDate && $this->bornDate->format("Y-m-d") === $date);
    }
    private function check_control_digit(): bool
    {
        $control_sum = 0;
        for ($i = 0; $i < 12; $i++) {
            $control_sum += $this->cnp[$i] * self::CNP_CONTROL_KEY[$i];
        }
        $control_sum = $control_sum % 11;
        $control_sum = ($control_sum == 10) ? 1 : $control_sum;
        if ($control_sum === intval($this->cnp[12]))
            return true;
        return false;
    }
}
