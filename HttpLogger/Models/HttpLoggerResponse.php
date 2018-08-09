<?php

namespace Modules\HttpLogger\Models;

use Illuminate\Database\Eloquent\Model;

class HttpLoggerResponse extends Model
{
    protected $fillable = ['*'];

    protected $table = 'http_logger_response';

    public function createResponse($response, $uuid)
    {
        $this->uuid = $uuid;
        $this->headers = json_encode($response->headers->all());
        $this->content = $response->getContent();
        $this->statusCode = $response->getStatusCode();
        $this->save();

        return $this;
    }
}
