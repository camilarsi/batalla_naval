<?php


class ChatGPTConnector
{

    private $client;
    private $model;
    private $temperature;
    private $maxTokens;
    private $prompt;
    private $stop;

    function __construct($apiKey, $model = 'gpt-3.5-turbo', $temperature = 0.5, $maxTokens = 50, $prompt = '', $stop = null)
    {
        $this->client = OpenAI::client($apiKey);
        $this->model = $model;
        $this->temperature = $temperature;
        $this->maxTokens = $maxTokens;
        $this->prompt = $prompt;
        $this->stop = $stop;
    }

    public function askQuestion($question)
    {
        $response = $this->client->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'user', 'content' => $question],
            ],
        ]);

        //$response->id; //'chatcmpl-6pMyfj1HF4QXnfvjtfzvufZSQq6Eq'
        //$response->object;  //'chat.completion'
        //$response->created; // 1677701073
        //$response->model; // 'gpt-3.5-turbo-0301'
        // foreach ($response->choices as $result) {
        //     $result->index; // 0
        //     $result->message->role; // 'assistant'
        //     $result->message->content; // '\n\nHello there! How can I assist you today?'
        //     $result->finishReason; // 'stop'
        // }

        $text = $response['choices'][0]['message']['content'];
        return $text;
    }

}
?>