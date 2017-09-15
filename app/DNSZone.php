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
     * Get the server associated with the zone.
     */
    public function server()
    {
        return $this->hasOne('App\DNSServer');
    }
}
