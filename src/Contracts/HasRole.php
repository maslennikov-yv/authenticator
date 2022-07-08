<?php

namespace Maslennikov\Authorizator\Contracts;

interface HasRole
{

    public function getRole(): string;

    public function assignRole(string $slug): void;

    public function removeRole(): void;

}