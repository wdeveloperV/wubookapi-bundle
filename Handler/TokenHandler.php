<?php

namespace Kamilwozny\WubookAPIBundle\Handler;

use Kamilwozny\WubookAPIBundle\Client;
use Kamilwozny\WubookAPIBundle\Utils\YamlFileManager;

class TokenHandler extends Client
{
    /**
     * @var YamlFileManager
     */
    private $yamlFileManager;

    public function __constructor(YamlFileManager $yamlFileManager)
    {
        $this->yamlFileManager = $yamlFileManager;
    }

    public function acquireToken()
    {
        $args = [
            $this->credentials['username'],
            $this->credentials['password'],
            $this->credentials['provider_key']
        ];

        $token = $this->request('acquire_token', $args);
        if($token) {
            $this->saveToken($token); //todo string token
        }

        return $token;//todo wyciagnac string token
    }

    public function isTokenValid($token)
    {
        $args = [ $token ];
        $isValid = $this->request('is_token_valid', $args); //todo boola zwracac
        return true;
    }

    private function saveToken($token)
    {
        $this->yamlFileManager->write(['parameters' => ['wubook_token' => $token]]);
        $this->yamlFileManager->clearCache();
    }
}