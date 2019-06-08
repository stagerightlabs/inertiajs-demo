<?php

namespace App\Concerns;

use App\Facades\Hashid;
use Illuminate\Database\Eloquent\Model;

/**
 * Add Hashid attribute methods to a Model
 */
trait HashidAttributes
{
    /**
     * Convert the model's primary key ID to a hashid
     *
     * @return string
     */
    public function getHashidAttribute()
    {
        return Hashid::encode($this->id);
    }

    /**
     * Use a hashid to lookup a model
     *
     * @param string $hashid
     * @return Model
     */
    public static function findByHashid($hashid)
    {
        return self::find(Hashid::decode($hashid));
    }

    /**
     * Use a hashid to lookup a model
     *
     * @param string $hashid
     * @return Model
     */
    public static function findByHashidOrFail($hashid)
    {
        return self::findOrFail(Hashid::decode($hashid));
    }
}
