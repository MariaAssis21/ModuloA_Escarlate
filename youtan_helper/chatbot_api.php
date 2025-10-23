<?php
header("Content-Type: application/json");

// substitua pela sua chave da OpenAI
//caso não exista pegue sua chave no site da openAI
$apiKey = "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";

$data = json_decode(file_get_contents("php://input"), true);
$userMessage = $data["message"] ?? "";

$contexto = "Você é Youtan Helper, assistente virtual de um sistema de gestão de ativos. 
Ajude o usuário a entender o funcionamento de módulos como cadastro, manutenções, alertas e relatórios.";

$payload = [
    "model" => "gpt-4o-mini",
    "messages" => [
        ["role" => "system", "content" => $contexto],
        ["role" => "user", "content" => $userMessage]
    ]
];

$ch = curl_init("https://api.openai.com/v1/chat/completions");
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        "Authorization: Bearer $apiKey"
    ],
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($payload)
]);

$response = curl_exec($ch);
curl_close($ch);

if ($response) {
    $data = json_decode($response, true);
    echo json_encode(["reply" => $data["choices"][0]["message"]["content"] ?? "Desculpe, não entendi."]);
} else {
    echo json_encode(["reply" => "Erro ao conectar à API."]);
}
?>
