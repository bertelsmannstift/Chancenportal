<?php
namespace UI\UiProvider\Utility;

/***
 *
 * This file is part of the "u+i | Provider" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019 Sebastian Swan <seswan@uandi.com>, www.uandi.com
 *
 ***/

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class GeocoderUtility
 * @package UI\UiProvider\Utility
 */
class GeocoderUtility
{
    /**
     * Geocode address
     *
     * @param $location
     * @param array $options
     * @return array|null
     *
     * Usage
     * -----
     * GeocoderUtility::geocode([
     *     'address' => 'Karl-Eilers-Str. 13',
     *     'zip' => '33602',
     *     'city' => 'Bielefeld',
     *     'country' => 'Deutschland'
     * ], [
     *     'google_api_key' => 'XYZ'
     *     'ignoreRateLimit' => true
     * ]);
     */
    public static function geocode($location, $options = [])
    {
        $result = null;

        if(empty($result) && !empty($options['google_api_key'])) {
            $result = self::geocodeGMaps($location, $options);
        }

        if(empty($result)) {
            $result = self::geocodeOSM($location, $options);
        }

        return $result;
    }

    /**
     * Geocode address with OpenStreetMap
     *
     * @param $location
     * @param $options
     * @return array|null
     *
     * Usage
     * -----
     * GeocoderUtility::geocodeOSM([
     *     'address' => 'Karl-Eilers-Str. 13',
     *     'zip' => '33602',
     *     'city' => 'Bielefeld',
     *     'country' => 'Deutschland'
     * ], [
     *     'ignoreRateLimit' => true
     * ]);
     */
    public static function geocodeOSM($location, $options = [])
    {
        $locationString = implode(', ', [
            $location['address'],
            $location['zip'],
            $location['country'],
        ]);

        $geocodeUrl = 'http://nominatim.openstreetmap.org/?format=json&addressdetails=1&q='.urlencode($locationString).'&format=json&limit=1';
        $geocodeData = json_decode(GeneralUtility::getUrl($geocodeUrl));

        if(!isset($options['ignoreRateLimit']) || $options['ignoreRateLimit'] === false) {
            sleep(3); // Avoid Rate limit
        }

        if ($geocodeData && !empty($geocodeData[0])) {
            if (is_numeric($geocodeData[0]->lat) && is_numeric($geocodeData[0]->lon)) {
                return [
                    'lat' => floatval($geocodeData[0]->lat),
                    'lng' => floatval($geocodeData[0]->lon)
                ];
            }
        }

        return null;
    }

    /**
     * Geocode address with Google Maps
     *
     * @param $location
     * @param $options
     * @return array|null
     *
     * Usage
     * -----
     * GeocoderUtility::geocodeOSM([
     *     'address' => 'Karl-Eilers-Str. 13',
     *     'zip' => '33602',
     *     'city' => 'Bielefeld',
     *     'country' => 'Deutschland'
     * ], [
     *     'google_api_key' => 'XYZ'
     * ]);
     */
    public static function geocodeGMaps($location, $options = [])
    {
        $locationString = implode(', ', [
            $location['address'],
            $location['zip'],
            $location['country'],
        ]);

        $geocodeUrl = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($locationString) . '&sensor=false&key=' . $options['google_api_key'];
        $geocodeData = json_decode(GeneralUtility::getUrl($geocodeUrl));

        if ($geocodeData && $geocodeData->status === 'OK' && !empty($geocodeData->results)) {
            if (is_numeric($geocodeData->results[0]->geometry->location->lat) && is_numeric($geocodeData->results[0]->geometry->location->lng)) {
                return [
                    'lat' => floatval($geocodeData->results[0]->geometry->location->lat),
                    'lng' => floatval($geocodeData->results[0]->geometry->location->lng)
                ];
            }
        }

        return null;
    }
}