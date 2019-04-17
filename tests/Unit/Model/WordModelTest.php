<?php
/**
 * Created by PhpStorm.
 * User: Tan
 * Date: 9.04.2019
 * Time: 19:49
 */

namespace App\Tests\Unit\Model;

use App\Model\WordModel;

use PHPUnit\Framework\TestCase;

class WordModelTest extends TestCase
{
    private $wordModel;
    private $words = ['message', 'software', 'developer'];

    public function setUp()
    {
        $this->wordModel = new WordModel($this->words);
    }

    public function testPickWord()
    {
        $word = $this->wordModel->pickWord();
        $this->assertContains($word, $this->words);
    }
}
