<?php
/**
 * Created by PhpStorm.
 * User: Tan
 * Date: 14.04.2019
 * Time: 00:26
 */

namespace App\Repository;

interface GameRepositoryInterface
{
    public function getChance(): int;
    public function guess(string $word): bool;
    public function getStatus(): \stdClass;
    public function lastResult(): string;
    public function getWord(): string;
}