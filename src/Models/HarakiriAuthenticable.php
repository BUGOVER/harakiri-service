<?php
declare(strict_types=1);

namespace HarakiriService\Models;

use HarakiriService\Traits\ModelExtraTrait;
use Illuminate\Foundation\Auth\User as Authenticable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class HarakiriAuthenticable
 * @package harakiri_repository_pattern\Repository\Models
 */
class HarakiriAuthenticable extends Authenticable implements JWTSubject
{
    use Notifiable, ModelExtraTrait;


    /**
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }
}
