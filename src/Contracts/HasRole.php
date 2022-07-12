<?php

namespace Maslennikov\Authorizator\Contracts;

interface HasRole
{

    public function getRole(): string;

    public function assignRole(string $slug): static;

    public function removeRole(): static;

}