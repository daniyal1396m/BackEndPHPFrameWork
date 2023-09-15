<?php

function envFile(): array
{
    return parse_ini_file('.env');
}

function env(string $key)
{
    return envFile()[$key];
}

function asset(string $resource): string
{
    return env('APP_URL') . '/public/assets/' . $resource;
}

function redirect(string $endpoint): void
{
    header("Location: /{$endpoint}");
}

function view(string $viewName, $context = []): void
{
    extract($context);
    $filePath = str_replace('.', '/', $viewName);
    include "app/Views/{$filePath}.php";
}

function jsonResponse(array $data): void
{
    header('Content-Type: application/json');

    echo json_encode(
        [
            'status' => http_response_code(),
            'data' => $data
        ]
    );
}

function errorResponse(string $type, string $message): void
{
    header('Content-Type: application/json');
    http_response_code(statusCode($type));
    echo json_encode(
        [
            'status' => statusCode($type),
            'message' => $message
        ]
    );
}

function noContentResponse(): void
{
    header('Content-Type: application/json');
    http_response_code();
}

function statusCode(string $type): int
{
    return match ($type) {
        'validation' => 422,
        'method' => 405,
        'not_found' => 404,
        default => 500,
    };
}

function partial(string $partial): void
{
    include_once "app/Views/layouts/{$partial}.php";
}
