<?php

use Games\PhpAIPlatforms\AIServiceAdapter;
use Games\PhpAIPlatforms\Contracts\AIService;
use Games\PhpAIPlatforms\Services\GoogleAIService;
use Games\PhpAIPlatforms\Services\OpenAIService;
use SebastianBergmann\Environment\Console;
use LucianoTonet\GroqPHP\Groq;


test('basic test call', function () {
    $dotenv = \Dotenv\Dotenv::createMutable(__DIR__, '../../.env');
    $dotenv->load();
    $groq = new Groq($_ENV['GROQ_API_KEY']);
    // print_r(array_column($groq->models()->list()['data'], 'id'));
    $completion = $groq->chat()->completions()->create([
        'model' => 'gemma-7b-it',
        'messages' => [
            ['role' => 'user', 'content' => 'bring my motivation back in a sentence'],
        ],
    ]);
    echo $completion['choices'][0]['message']['content'];

    $openai_client = OpenAI::client($_ENV['OPENAI_API_KEY']);
    $result = $openai_client->chat()->create([
        'model' => 'gpt-4',
        'messages' => [
            ['role' => 'user', 'content' => 'Hello!'],
        ],
    ]);
    
    echo $result->choices[0]->message->content; // Hello! How can I assist you today?
});

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
