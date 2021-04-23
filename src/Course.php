<?php
namespace olesiavm\currency;

use yii\base\Model;

class Course extends Model
{
    /**
     * object site rbc.ru
     *
     * @var SiteRbc
     */
    public $siteRbc;
    /**
     * object site cbr.ru
     *
     * @var SiteCbr
     */
    public $siteCbr;

    public function init() {
        $this->siteRbc = new SiteRbc();
        $this->siteCbr = new SiteCbr();
        parent::init();
    }

    /**
     * @param string $day
     * @return array
     */
    public function getAverageCourse($day) {
        $averageEurCourses = [
            'averageEur' => $this->getAverageEurCourse($day),
            'averageUsd' => $this->getAverageUsdCourse($day)
        ];

        return $averageEurCourses;
    }

    /**
     * Get Euro average course
     *
     * @param string $day
     * @return string
     */
    public function getAverageEurCourse($day) {
        $urlEurCbr = $this->siteCbr->getUrl($day, SiteCbr::CBR_EUR);
        $eurCbr    = $this->siteCbr->getDataFromApi($urlEurCbr, SiteCbr::CBR_EUR);

        $urlEurRbc = $this->siteRbc->getUrl($day, SiteRbc::RBC_EUR);
        $eurRbc    = $this->siteRbc->getDataFromApi($urlEurRbc, SiteRbc::RBC_EUR);

        return ($eurCbr + $eurRbc)/2;
    }

    /**
     * Get USD average course
     *
     * @param string $day
     * @return string
     */
    public function getAverageUsdCourse($day) {
        $urlUsdCbr = $this->siteCbr->getUrl($day, SiteCbr::CBR_USD);
        $usdCbr    = $this->siteCbr->getDataFromApi($urlUsdCbr, SiteCbr::CBR_USD);

        $urlUsdRbc = $this->siteRbc->getUrl($day, SiteRbc::RBC_USD);
        $usdRbc    = $this->siteRbc->getDataFromApi($urlUsdRbc, SiteRbc::RBC_USD);

        return ($usdCbr + $usdRbc)/2;
    }

}








