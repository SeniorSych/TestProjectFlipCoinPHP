<?php

class Game
{
    protected $player1;
    protected $player2;
    protected $flips = 0;

    public function __construct(Player $player1, Player $player2)
    {
            $this->player1 = $player1;
            $this->player2 = $player2;
    }
    public function flip()
    {
        //Flip coin
        return rand(0, 1) ? "heads" : "tails";
    }
    public function gameStart()
    {
        echo <<<START
Game started.<br>
{$this->player1->name}'s win odds {$this->player1->checkOdds($this->player2)}<br>
{$this->player2->name}'s win odds {$this->player2->checkOdds($this->player1)}<br>

START;

        $this->playing();
    }
    public function playing()
    {
        while (true)
        {

            //if side1(heads) p1 get 1 point, p2 lose 1 point
            //if side2(tails) p1 lose 1 point, p2 get 1 point
            if ($this->flip() == "heads")
            {
                $this->player1->pointCounter($this->player2);
            }
            else
            {
                $this->player2->pointCounter($this->player1);
            }
            //if playerX have 0 point = game over
            if ($this->player1->checkBankrupt() || $this->player2->checkBankrupt())
            {
                return $this->gameOver();
            }
            $this->flips++;
        }

    }
    public function winCondition(): Player
    {
        if ($this->player1->points > $this->player2->points)
        {
            return $this->player1;
        }
        else return $this->player2;
        //or change whole 'if' block to
        //return $this->player1->points > $this->player2->points ? $this->player1 : $this->player2;
    }
    public function gameOver()
    {
        //Winner is player who has !=0 points
        echo <<<END
Game Over.<br>
{$this->player1->name}'s total points: {$this->player1->points}<br>
{$this->player2->name}'s total points: {$this->player2->points}<br>
Winner is {$this->winCondition()->name}<br>
Total flips: {$this->flips}
END;
    }
}
class Player
{
    public $name;
    public $points;

    public function __construct($name, $points)
    {
        $this->name = $name;
        $this->points = $points;
    }
    public function pointCounter(Player $player)
    {
        $this->points++;
        $player->points--;
    }
    public function checkBankrupt()
    {
        return $this->points == 0;
    }
    public function checkOdds(Player $player)
    {
        return round($this->points / ($this->points + $player->points), 2) * 100 . '%';
    }
}

$game = new Game (
    new Player ('Cassandra', 100),
    new Player ('Michael', 100)
);

$game->gameStart();































































