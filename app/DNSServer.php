<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DNSServer extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dns_server';

    /**
     * These fields can be set on create.
     */
    protected $fillable = ['name', 'ip'];
}
