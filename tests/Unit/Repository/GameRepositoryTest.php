<?php
/**
 * Created by PhpStorm.
 * User: Tan
 * Date: 9.04.2019
 * Time: 22:30
 */

namespace App\Tests\Unit\Repository;

use App\Model\WordModel;
use App\Repository\GameRepository;

use PHPUnit\Framework\TestCase;

class GameRepositoryTest extends TestCase
{
    private $game;
    private $words = ['software'];

    public function setUp()
    {
        $wordModel = new WordModel($this->words);
        $this->game = new GameRepository($wordModel, 2);
    }

    public function testStatusWin()
    {
        $word = $this->game->getWord();
        for($i=0;$i<strlen($word);$i++) {
            $this->game->guess($word{$i});
        }
        $this->assertEquals(2, $this->game->getStatus()->status);
    }

    public function testStatusContinue()
    {
        $this->assertEquals(1, $this->game->getStatus()->status);
    }

    public function testStatusLost()
    {
        $word = 'XQZW';
        for($i=0;$i<=$this->game->getChance();$i++) {
            $this->game->guess($word{$i});
        }
        $this->assertEquals(0, $this->game->getStatus()->status);
    }

    public function testLastResult()
    {
        $word = $this->game->getWord();
        $expected = str_repeat('_', strlen($word));

        $this->assertEquals($expected, $this->game->lastResult());
    }

    public function testGuess()
    {
        $this->assertTrue($this->game->guess('s'));

        $this->assertFalse($this->game->guess('d'));
    }

    public function testGuessMinMaxException()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->game->guess('');
    }

    public function testGuessChoosedException()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->game->guess('d');
        $this->game->guess('d');
    }

    public function testGetWord()
    {
        $this->assertEquals('software', $this->game->getWord());
    }

    public function testGetChance()
    {
        $this->assertEquals(2, $this->game->getChance());
    }
}
