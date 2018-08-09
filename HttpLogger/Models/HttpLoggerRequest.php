<?php

namespace Modules\HttpLogger\Models;

use Illuminate\Database\Eloquent\Model;

class HttpLoggerRequest extends Model
{
    protected $fillable = ['*'];

    protected $table = 'http_logger_request';

    public function createRequest($request)
    {
        $this->uuid = \Ramsey\Uuid\Uuid::uuid1();
        $this->input = json_encode($request->input());
        $this->query = json_encode($request->query());
        $this->server = json_encode($request->server());
        $this->files = ''; // need Jovi
        $this->cookies = json_encode($request->cookie());
        $this->headers = json_encode($request->headers->all());
        $this->save();

        return $this;
    }
}
