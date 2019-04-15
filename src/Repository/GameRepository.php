<?php
/**
 * Created by PhpStorm.
 * User: Tan
 * Date: 8.04.2019
 * Time: 22:28
 */
declare(strict_types = 1);

namespace App\Repository;

use App\Model\WordModel;

class GameRepository implements GameRepositoryInterface
{
    private $chance = 5;
    private $wordModel;
    private $word;
    private $choosed = [];
    private $founded = [];

    public function __construct(WordModel $wordModel, int $chance = 11)
    {
        $this->wordModel = $wordModel;
        $this->word = $this->wordModel->pickWord();
        $this->setChance($chance);
    }

    private function setChance(int $chance)
    {
        $this->chance = $chance;
    }

    public function getChance(): int
    {
        return $this->chance;
    }

    public function guess(string $word): bool
    {
        if (strlen($word) <> 1) {
            throw new \InvalidArgumentException('Enter just a letter');
        }

        $word = strtolower($word);

        if (array_key_exists($word, $this->choosed)) {
            throw new \InvalidArgumentException('You entered that word before');
        }

        $this->choosed[$word] = $word;
        $indexes = $this->getIndexes($word);

        if (empty($indexes)) {
            $this->chance--;

            return false;
        }

        foreach($indexes as $index => $word){
            $this->founded[$index] = $word;
        }

        return true;
    }

    private function getIndexes(string $word): array
    {
        $tempArr = [];
        $length = $this->length();
        for($i=0;$i<$length;$i++){
            if ($word === $this->word{$i}) {
                $tempArr[$i] = $word;
            }
        }

        return $tempArr;
    }

    public function getStatus(): \stdClass
    {
        if (count($this->founded) === $this->length()) {
            $result = [
                'message' => 'You win',
                'status' => 2
            ];
        }
        else if ($this->chance === 0) {
            $result = [
                'message' => 'You Lost',
                'status' => 0
            ];
        }
        else {
            $result = [
                'message' => 'Continue',
                'status' => 1
            ];
        }

        return (object) $result;
    }

    public function lastResult(): string
    {
        $string = '';
        $length = $this->length();
        for($i=0;$i<$length;$i++) {
            if (array_key_exists($i, $this->founded)) {
                $string .= $this->founded[$i];
                continue;
            }

            $string .= '_';
        }

        return $string;
    }

    public function getWord(): string
    {
        return $this->word;
    }

    private function length(): int
    {
        return strlen($this->word);
    }
}