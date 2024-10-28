<?php

namespace Games\PhpAIPlatforms;

use Games\PhpAIPlatforms\Contracts\AIService;

class AIServiceAdapter {
    private $services = [];

    public function registerService(AIService $service) {
        $this->services[] = $service;
    }

    public function getRegisteredServices() {
        return $this->services;
    }

    public function processRequest($request) {
        $responses = [];
        foreach ($this->services as $service) {
            $responses[] = $service->process($request);
        }
        return $responses;
    }
}
