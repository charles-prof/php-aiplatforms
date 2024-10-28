<?php

namespace Games\PhpAIPlatforms\Services;

use Games\PhpAIPlatforms\Contracts\AIService;

class OpenAIService implements AIService {
    public function process($request) {
        // OpenAI processing logic
        return "OpenAI response for: " . $request;
    }
}