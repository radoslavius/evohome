<?php
/**
 * Created by PhpStorm.
 * User: radek
 * Date: 25.7.17
 * Time: 9:09
 */

namespace AppBundle\Utils;

use GuzzleHttp\Client;

class Evohome {

    private $params;
    private $sessionId;
    private $userId;

    /** @var \GuzzleHttp\Client */
    private $client;

    /**
     * Evohome constructor.
     *
     * @param $params
     */
    public function __construct($params) {
        $this->params = $params;

        $this->client = new Client([
            'base_uri' => 'https://tccna.honeywell.com/WebAPI/api/',
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'exceptions' => FALSE,
            'defaults' => [
                'verify' => FALSE,
            ]
        ]);

        $this->login();
    }

    private function login() {
        $response = $this->client->post('Session', [
            'json' => [
                "Username" => $this->params['username'],
                "Password" => $this->params['password'],
                "ApplicationId" => $this->params['applicationid']
            ]
        ]);

        $session = json_decode($response->getBody(), TRUE);
        $this->sessionId = $session['sessionId'];
        $this->userId = $session['userInfo']['userID'];
    }

    /**
     * @return array
     */
    public function getTemperatures() {
        $locationsResponse = $this->client->get('locations?userId=' . $this->userId . '&allData=True', [
            'headers' => [
                'sessionId' => $this->sessionId
            ],
        ]);

        $locationsData = json_decode($locationsResponse->getBody(), TRUE);

        $temperatures = [];
        foreach ($locationsData as $location) {
            foreach ($location['devices'] as $device) {
                $temperatures[$device['name']] = $device['thermostat']['indoorTemperature'];
            }
        }

        return $temperatures;
    }
}