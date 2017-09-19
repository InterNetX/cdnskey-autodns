<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DNSZone extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dns_zone';

    /**
     * These fields can be set on create.
     */
    protected $fillable = ['name', 'dns_server_id' ];

    /**
     * Get the DNS server associated with the DNS zone.
     */
    public function server()
    {
       return $this->hasOne('App\DNSServer', 'id', 'dns_server_id');
    }
}
