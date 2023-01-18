<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DataController extends AbstractController
{
    #[Route('/', name: 'SCORE')]
    public function showScore(): Response
    {
        $finalScore = $this->finalScore();

        return $this->render('data.html.twig', [
            'final_score' => $finalScore,
        ]);
    }

    public function getDataFromFile(): array
    {
        $file = file_get_contents('/home/noa/PhpstormProjects/AdventsOfCode/Day2/src/data.txt');

        return explode("\n", $file);
    }

    public function finalScore(): int
    {
        $file = $this->getDataFromFile();
        $array = [];
        $winner = [];
        $finalScore = 0;

        foreach ($file as $key => $data) {
            $array[$key] = preg_split("/\s/", $data);
            $winner[$key] = $this->rockPaperScissors($array[$key]);
            $calculate[$key] = $this->calculate($array[$key], $winner[$key]);
            $finalScore += $calculate[$key];
        }
        return $finalScore;
    }

    public function calculate(array $turn, string $score): int
    {
        $scoreByTurn = $this->scoreByTurn($turn);
        $scoreByRound = $this->scoreByRound($score);

        return $scoreByTurn + $scoreByRound;
    }

    public function rockPaperScissors(array $turn): string|null
    {
        if ($turn[0] === 'A') {
            return $this->resultRock($turn);
        } else if ($turn[0] === 'B') {
            return $this->resultPaper($turn);
        } else if ($turn[0] === 'C') {
            return $this->resultScissors($turn);
        } else {
            return null;
        }
    }

    public function resultRock(array $turn): string
    {
        if ($turn[0] == 'A' && $turn[1] == 'Z') {
            return 'Lost';
        } else if ($turn[0] == 'A' && $turn[1] == 'Y') {
            return 'Win';
        } else {
            return 'Draw';
        }
    }

    public function resultPaper(array $turn): string
    {
        if ($turn[0] == 'B' && $turn[1] == 'X') {
            return 'Lost';
        } else if ($turn[0] == 'B' && $turn[1] == 'Z') {
            return 'Win';
        } else {
            return 'Draw';
        }
    }

    public function resultScissors(array $turn): string
    {
        if ($turn[0] == 'C' && $turn[1] == 'Y') {
            return 'Lost';
        } else if ($turn[0] == 'C' && $turn[1] == 'X') {
            return 'Win';
        } else {
            return 'Draw';
        }
    }

    public function scoreByTurn(array $turn): int|null
    {
        if ($turn[1] === 'X') {
            return 1;
        } else if ($turn[1] === 'Y') {
            return 2;
        } else if ($turn[1] === 'Z') {
            return 3;
        } else {
            return null;
        }
    }

    public function scoreByRound(string $score): int|null
    {
        if ($score === 'Lost') {
            return 0;
        } else if ($score === 'Draw') {
            return 3;
        } else if ($score === 'Win') {
            return 6;
        } else {
            return null;
        }
    }
}