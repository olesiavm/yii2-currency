<?php
namespace olesiavm\currency;

use yii\base\Model;
use yii\web\NotFoundHttpException;

abstract class Site  extends Model
{
    /**
     * Get url for parsing
     *
     * @param string $day
     * @param string $currency
     * @return string
     */
    abstract public function getUrl($day, $currency);

    /**
     * Get string with course currency from api
     *
     * @param string $url
     * @param string $currency
     * @return string
     */
    public function getDataFromApi($url, $currency) {
        if  (!in_array('curl', get_loaded_extensions())) {
            throw new NotFoundHttpException("CURL is NOT installed on this server");
        }
        $connection = \curl_init();
        \curl_setopt_array($connection, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => 1,
        ));
        $responseString = \curl_exec($connection);
        \curl_close($connection);

        if ($responseString == null || empty($responseString)) {
            throw new NotFoundHttpException('API connection error');
        }

        return $this->getCourseFromSite($currency, $responseString);
    }

    /**
     * Parse string from api and get course currency from site
     *
     * @param string $responseString
     * @param string $currency
     * @return string
     * @throws NotFoundHttpException
     */
    abstract public function getCourseFromSite($currency, $responseString);
}

