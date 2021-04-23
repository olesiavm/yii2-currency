<?php
namespace olesiavm\currency;

use yii\web\NotFoundHttpException;

class SiteRbc extends Site
{
    const RBC_EUR = "EUR";
    const RBC_USD = "USD";

    /**
     * Get url for parsing
     *
     * @param string $day
     * @param string $currency
     * @return string
     */
    public function getUrl($day, $currency) {
        $day = date("Y-m-d", strtotime($day));
        $url = "https://cash.rbc.ru/cash/json/converter_currency_rate/?currency_from=" . $currency ."&currency_to=RUR&source=cbrf&sum=1&date=" . $day;
        return $url;
    }

    /**
     * from rbc
     *
     * @param string $currency
     * @param string $responseString
     * @return string
     * @throws NotFoundHttpException
     */
    public function getCourseFromSite($currency, $responseString) {
        $responseArray = \json_decode($responseString);
        if ($responseArray->data->sum_result !== null) {
            return $responseArray->data->sum_result;
        }
        throw new NotFoundHttpException('Rbc API data is changed');
    }
}


