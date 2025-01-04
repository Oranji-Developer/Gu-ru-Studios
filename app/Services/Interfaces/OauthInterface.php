<?php

namespace App\Services\Interfaces;

interface OauthInterface
{
    public function handleProviderCallback(): bool;
}
