<?php
/**
 * Created by PhpStorm.
 * User: Tan
 * Date: 8.04.2019
 * Time: 23:31
 */
namespace App\Command;

use App\Model\WordModel;
use App\Repository\GameRepository;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Input\InputInterface;

class GameCommand extends Command
{
    protected static $defaultName = 'app:game-start';

    private $game;

    private $helper;

    public function __construct()
    {
        $wordModel = new WordModel(['software', 'developer', 'testing', 'senior', 'engineer']);
        $this->game = new GameRepository($wordModel, 5);

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Welcome the word guess game');

        $this->helper = $this->getHelper('question');
        $question = new Question('Please enter a letter: ', '');
        do{
            $word = $this->helper->ask($input, $output, $question);
            try {
                if ($this->game->guess($word) ) {
                    $output->writeln(sprintf('Congrats, found a letter, %s', $this->game->lastResult()));
                } else {
                    $output->writeln(sprintf('Unfortunately not found, you have (%d) chance', $this->game->getChance()));
                }
            } catch (\InvalidArgumentException $e) {
                $output->writeln($e->getMessage());
            }
        } while($this->game->getStatus()->status === 1);

        $output->writeln($this->game->getStatus()->message);
    }
}