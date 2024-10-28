<?php

use Games\PhpAIPlatforms\AIServiceAdapter;
use Games\PhpAIPlatforms\Contracts\AIService;
use Games\PhpAIPlatforms\Services\GoogleAIService;
use Games\PhpAIPlatforms\Services\OpenAIService;

it('adapter can add services', function () {
    $adapter = new \Games\PhpAIPlatforms\AIServiceAdapter();
    $service = new \Games\PhpAIPlatforms\Services\OpenAIService();
    $adapter->registerService($service);
    expect($adapter->getRegisteredServices())->toContain($service);
});

it('adapter can process request through multiple services', function () {
    $adapter = new AIServiceAdapter();
    $service1 = new OpenAIService();
    $service2 = new GoogleAIService();
    $adapter->registerService($service1);
    $adapter->registerService($service2);
    $request = 'Test request';
    $responses = $adapter->processRequest($request);
    expect($responses)->toHaveCount(2);
    expect($responses[0])->toBeString();
    expect($responses[1])->toBeString();
});

test('adapter returns empty array when no services are added', function () {
    $adapter = new AIServiceAdapter();
    $request = 'Test request';
    $responses = $adapter->processRequest($request);
    expect($responses)->toBeEmpty();
});

test('adapter throws exception when service does not implement AIService interface', function () {
    $adapter = new AIServiceAdapter();
    $service = new stdClass();
    /**
     * @disregard P1006 Expected type 'AIService'. Found 'stdClass'.
     */
    $adapter->registerService($service);
})->throws(\TypeError::class);
