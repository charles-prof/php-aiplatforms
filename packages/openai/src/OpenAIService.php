<?php

declare(strict_types=1);

namespace Games\PhpAIPlatforms\OpenAI;

interface AIService {
    public function process($request);
}

final class OpenAIService implements AIService
{

    public function process($request) {
        // OpenAI processing logic
        return "OpenAI response for: " . $request;
    }
    
}
