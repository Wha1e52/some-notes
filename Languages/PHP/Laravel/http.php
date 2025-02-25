<?php
/*

// По умолчанию HTTP-клиент, прежде чем завершить запрос, ждет ответа 30 секунд и не будет повторять его.

// Простые случаи использования HTTP-фасада
use Illuminate\Support\Facades\Http;
$response = Http::get('http://my-api.com/posts');
$response = Http::post('http://my-api.com/posts/2/comments', [
    'title' => 'I loved this post!',
]);
$response = Http::withHeaders([
    'X-Custom-Header' => 'header value here'
])->post(...);
$response = Http::withToken($authToken)->post(...);
$response = Http::accept('application/json')->get('http://my-api.com/users');

// Часто используемые методы объекта Response HTTP-клиента
$response->body() : string;
$response->json($key = null, $default = null) : mixed;
$response->object() : object;
$response->collect($key = null) : Illuminate\Support\Collection;
$response->resource() : resource;
$response->status() : int;
$response->successful() : bool;
$response->redirect(): bool;
$response->failed() : bool;
$response->clientError() : bool;
$response->header($header) : string;
$response->headers() : array;

// определить тайм-аут
$response = Http::timeout(120)->get(...);
Если есть вероятность, что попытки потерпят неудачу, добавьте в цепочку вызовов метод retry()
$response = Http::retry(3, 100)->post(...);
The retry method accepts the maximum number of times the request should be attempted and
the number of milliseconds that Laravel should wait in between attempts


// status codes
$response->ok() : bool;                  // 200 OK
$response->created() : bool;             // 201 Created
$response->accepted() : bool;            // 202 Accepted
$response->noContent() : bool;           // 204 No Content
$response->movedPermanently() : bool;    // 301 Moved Permanently
$response->found() : bool;               // 302 Found
$response->badRequest() : bool;          // 400 Bad Request
$response->unauthorized() : bool;        // 401 Unauthorized
$response->paymentRequired() : bool;     // 402 Payment Required
$response->forbidden() : bool;           // 403 Forbidden
$response->notFound() : bool;            // 404 Not Found
$response->requestTimeout() : bool;      // 408 Request Timeout
$response->conflict() : bool;            // 409 Conflict
$response->unprocessableEntity() : bool; // 422 Unprocessable Entity
$response->tooManyRequests() : bool;     // 429 Too Many Requests
$response->serverError() : bool;         // 500 Internal Server Error

// Можно также определить функцию обратного вызова, которая будет запускаться при возникновении ошибки:
$response->onError(function (Response $response) {
    // обработка ошибки
});



*/