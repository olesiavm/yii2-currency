<?php
namespace olesiavm\currency;

use \XMLReader;
use \DOMDocument;
use yii\web\NotFoundHttpException;

class SiteCbr extends Site
{
    const CBR_EUR = "R01239";
    const CBR_USD = "R01235";

    /**
     * Get url for parsing
     *
     * @param string $day
     * @param string $currency
     * @return string
     */

    public function getUrl($day, $currency) {
        if (strtotime($day) > \time()) {
            throw new NotFoundHttpException('Wrong date');
        }
        $day = date("d/m/Y", strtotime($day));
        $url = 'http://www.cbr.ru/scripts/XML_daily.asp?date_req=' . $day;
        return $url;
    }

    /**
     * From cbr
     *
     * @param string $currency
     * @param string $responseString
     * @return string
     * @throws NotFoundHttpException
     */
    public function getCourseFromSite($currency, $responseString) {
        $reader = new XMLReader();
        if (!$reader->xml($responseString)) {
            throw new NotFoundHttpException('API connection error');
        }

        $doc = new DOMDocument;
        while ($reader->read()) {
            if ($reader->nodeType == XMLReader::ELEMENT && $reader->name == 'ValCurs') {
                while ($reader->read()) {
                    if ($reader->nodeType == XMLReader::ELEMENT && $reader->name == 'Valute') {
                        $id = $reader->getAttribute('ID');
                        if ($id == $currency) {
                            $node = \simplexml_import_dom($doc->importNode($reader->expand(), true));
                            return $node->Value;
                        }
                    }
                }
            }
        }
        throw new NotFoundHttpException('Cbr API data is changed');
    }
}

