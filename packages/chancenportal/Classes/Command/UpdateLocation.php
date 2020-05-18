<?php

namespace Chancenportal\Chancenportal\Command;

use Chancenportal\Chancenportal\Domain\Repository\OfferRepository;
use Chancenportal\Chancenportal\Domain\Repository\ProviderRepository;
use TYPO3\CMS\Extbase\Configuration\BackendConfigurationManager;

/**
 * Task zur aktualliserung von Standortdaten der Anbieter und Angeboten über die Google API.
 *
 * @package Chancenportal\Chancenportal\Command
 */
class UpdateLocation extends \TYPO3\CMS\Scheduler\Task\AbstractTask
{
    protected $objectManager = null;

    protected $persistenceManager = null;
    protected $configurationManager = null;
    protected $settings = null;

    /**
     * @var \Chancenportal\Chancenportal\Domain\Repository\OfferRepository
     */
    protected $offerRepository = null;

    /**
     * @var \Chancenportal\Chancenportal\Domain\Repository\ProviderRepository
     */
    protected $providerRepository = null;

    public function execute()
    {
        $this->objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $this->persistenceManager = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
        $this->offerRepository = $this->objectManager->get(OfferRepository::class);
        $this->providerRepository = $this->objectManager->get(ProviderRepository::class);

        $backendConfigurationManager = $this->objectManager->get(BackendConfigurationManager::class);
        $backendConfiguration = $backendConfigurationManager->getConfiguration();
        $this->settings = $backendConfiguration['settings'];

        $offers = $this->offerRepository->findAll();
        $providers = $this->providerRepository->findAll();

        foreach ($providers as $provider) {
            if (empty($provider->getCity()) || empty($provider->getZip()) || empty($provider->getStreet()) || empty($provider->getLat()) || empty($provider->getLng())) {
                $provider = $this->updateLocation($provider);
                if($provider) {
                    $this->providerRepository->update($provider);
                    $this->persistenceManager->persistAll();
                }
            }
        }

        foreach ($offers as $offer) {
            if (empty($offer->getCity()) || empty($offer->getZip()) || empty($offer->getStreet()) || empty($offer->getLat()) || empty($offer->getLng())) {
                $offer = $this->updateLocation($offer);
                if($offer) {
                    $this->offerRepository->update($offer);
                    $this->persistenceManager->persistAll();
                }
            }
        }

        return true;
    }

    private function updateLocation($obj)
    {
        if (empty($obj->getAddress())) {
            $address = $obj->getStreet() . ', ' . $obj->getZip() . ' ' . $obj->getCity();
        } else {
            $address = $obj->getAddress();
        }

        if (empty($address)) {
            return false;
        }

        $key = !empty($this->settings['chancenportal']['google_maps_api_key_no_restrictions']) ? $this->settings['chancenportal']['google_maps_api_key_no_restrictions'] : $this->settings['chancenportal']['google_maps_api_key'];
        $url = "https://maps.google.com/maps/api/geocode/json?key=" . $key . "&address=" . urlencode($address);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $resp_json = curl_exec($ch);

        if (curl_errno($ch)) {
        } else {
            curl_close($ch);
        }

        $resp = json_decode($resp_json, true);

        if ($resp['status'] == 'OK') {
            $data = $resp['results'][0];
            $lat = $data['geometry']['location']['lat'];
            $lng = $data['geometry']['location']['lng'];
            $obj->setAddress($data['formatted_address']);
            $obj->setLat($lat);
            $obj->setLng($lng);

            $street = '';
            $street_nr = '';

            for ($j = 0; $j < count($data['address_components']); $j++){
                for ($k = 0; $k < count($data['address_components'][$j]['types']); $k++){

                    if ($data['address_components'][$j]['types'][$k] == "postal_code") {
                        $obj->setZip($data['address_components'][$j]['long_name']);
                    }
                    if ($data['address_components'][$j]['types'][$k] == "route") {
                        $street = $data['address_components'][$j]['long_name'];
                    }
                    if ($data['address_components'][$j]['types'][$k] == "street_number") {
                        $street_nr = $data['address_components'][$j]['long_name'];
                    }
                    if ($data['address_components'][$j]['types'][$k] == "locality") {
                        $obj->setCity($data['address_components'][$j]['long_name']);
                    }
                }
            }

            if(!empty($street)) {
                $obj->setStreet($street . ' ' . $street_nr);
            }
        }

        return $obj;
    }
}
