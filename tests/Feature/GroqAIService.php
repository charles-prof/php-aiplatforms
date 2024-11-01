<?php

use LucianoTonet\GroqPHP\Groq;

test('Groq AI service Connection', function () {
    $dotenv = \Dotenv\Dotenv::createMutable(__DIR__, '../../.env');
    $dotenv->load();
    $groq = new Groq($_ENV['GROQ_API_KEY']);
    expect($groq->models()->list())->not()->toThrow(Exception::class);
    expect($groq)->toBeInstanceOf(Groq::class);
});

test('Groq Chat Completion', function () {
    $dotenv = \Dotenv\Dotenv::createMutable(__DIR__, '../../.env');
    $dotenv->load();
    $groq = new Groq($_ENV['GROQ_API_KEY']);
    $completion = $groq->chat()->completions()->create([
        'model' => 'gemma-7b-it',
        'messages' => [
            ['role' => 'user', 'content' => 'bring my motivation back in a sentence'],
        ],
    ])
;
    expect($completion['choices'][0]['message']['content'])->not()->toBeEmpty();
});
