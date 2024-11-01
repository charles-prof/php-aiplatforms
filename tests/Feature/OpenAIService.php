<?php

use OpenAI\Client;

test('Open AI service Connection', function () {
    $dotenv = \Dotenv\Dotenv::createMutable(__DIR__, '../../.env');
    $dotenv->load();

    $openai_client = OpenAI::client($_ENV['OPENAI_API_KEY']);

    expect($openai_client->models()->list())->not()->toThrow(Exception::class);

    expect($openai_client)->toBeInstanceOf(Client::class);
});


test('Open AI service Completion', function () {
    $dotenv = \Dotenv\Dotenv::createMutable(__DIR__, '../../.env');
    $dotenv->load();
    $openai_client = OpenAI::client($_ENV['OPENAI_API_KEY']);
    $completion = $openai_client->completions()->create([
        'model' => 'babbage-002',
        'prompt' => 'Once upon a time',
        'max_tokens' => 5,
    ]);
    expect($completion['choices'][0]['text'])->not()->toBeEmpty();
});