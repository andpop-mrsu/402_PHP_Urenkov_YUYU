<?php

namespace yurau\Calculator;

use function cli\line;
use function cli\prompt;

class Controller
{
    public static function startGame()
    {
        line("Добро пожаловать в игру 'Калькулятор'!");
        $name = prompt("Введите ваше имя на английском");
        
        $expression = self::generateExpression();
        line("Выражение: " . $expression);
        $answer = prompt("Введите ответ");
        
        $result = self::calculateExpression($expression);
        
        if ((int)$answer === $result) {
            line("Правильно!");
        } else {
            line("Неверно. Правильный ответ: " . $result);
        }
    }
    
    private static function generateExpression(): string
    {
        $operators = ['+', '-', '*'];
        $expression = '';
        for ($i = 0; $i < 4; $i++) {
            $expression .= rand(1, 99);
            if ($i < 3) {
                $expression .= $operators[array_rand($operators)];
            }
        }
        return $expression;
    }
    
    private static function calculateExpression(string $expr): int
    {
        $result = 0;
        $current = '';
        $lastOp = '+';
        for ($i = 0; $i < strlen($expr); $i++) {
            $char = $expr[$i];
            if (is_numeric($char)) {
                $current .= $char;
            } else {
                $result = self::applyOperator($lastOp, $result, (int)$current);
                $lastOp = $char;
                $current = '';
            }
        }
        $result = self::applyOperator($lastOp, $result, (int)$current);
        return $result;
    }
    
    private static function applyOperator(string $op, int $a, int $b): int
    {
        switch ($op) {
            case '+': return $a + $b;
            case '-': return $a - $b;
            case '*': return $a * $b;
            default: return $a;
        }
    }
}