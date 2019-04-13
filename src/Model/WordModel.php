<?php
/**
 * Created by PhpStorm.
 * User: Tan
 * Date: 8.04.2019
 * Time: 21:49
 */
declare(strict_types = 1);

namespace App\Model;

class WordModel
{
    private $words = [];

    public function __construct(array $words)
    {
        $this->words = $words;
    }

    public function pickWord(): string
    {
        $rand = mt_rand(0, count($this->words) - 1);

        return strtolower($this->words[$rand]);
    }
}