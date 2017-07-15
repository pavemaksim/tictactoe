<?php

namespace App\Components;

use Illuminate\Support\Facades\Log;

/**
 * Tictactoe game algorithm
 */
class Tictactoe implements MoveInterface
{   
    /**
     * Letter representing an empty square
     */
    const SQUARE_EMPTY_LETTER = '';
    
    /**
     * Letter representing an X team sign
     */
    const SQUARE_X_LETTER = 'X';
    
    /**
     * Letter representing an O team sign
     */
    const SQUARE_O_LETTER = 'O';
    
    /**     
     * 2 dimensional array representing playing board
     * 
     * @var array
     */
    protected $board;
    
    /**
     * Row and column id of next bot move
     * 
     * @var array
     */
    protected $nextBotMove;
    
    /**
     * Current winner
     * 
     * @var type 
     */
    protected $winner;
    
    /**
     * Constructor
     * 
     * @param array $board
     */
    public function __construct(array $board = null)
    {
        if (is_null($board)) {
            $board = $this->createBoard();
        }
        
        $this->setBoard($board);
    }
    
    /**
     * Board setter
     * 
     * @param array $board
     */
    public function setBoard(array $board)
    {
        $this->board = $board;
    }
    
    /**
     * Getter board
     */
    public function getBoard(): array
    {
        return $this->board;
    }
    
    /**
     * Current winner representation
     * 
     * @return string
     */
    public function getWinner() : string
    {
        return $this->winner;
    }
    
    /**
     * Set current winner
     * 
     * @param type $winner
     */
    public function setWinner($winner)
    {
        $this->winner = $winner;
    }
    
     /**
      * Setter nextBotMove
      * @param type $coordinates
      */
    public function setNextBotMove($coordinates = [-1, -1])
    {
        $this->nextBotMove = $coordinates;
    }
    
    /**
     * Getter next bot move
     * 
     * @return type
     */
    public function getNextBotMove()
    {
        return $this->nextBotMove;
    }
    
    /**
     * Creates a squared board with $size X $size blocks
     * 
     * @param int $size
     * @return array
     */
    public function createBoard(int $size = 3) : array
    {
        $arr = [];
        
        for ($i = 0; $i < $size; $i++) {
            $arr[$i] = array_fill(0, $size, self::SQUARE_EMPTY_LETTER);
        }
        
        return $arr;
    }
    
    /**
     * Whether a game is finished
     * 
     * @return bool
     */
    public function isGameFinished() : bool
    {
        if ($this->isGameWon() || $this->isBoardFull()) {
            return true;
        }
        return false;
    }
    
    /**
     * Whether a game is over due to somebody's victory
     * All columns, rows and 2 diagonals of the playing
     * $board are examined
     * 
     * @return boolean
     */
    public function isGameWon() : bool
    {
        $boardSize = count($this->board);
        
        $mainDiagonal =  array_map(function($row, $index){
            return $row[$index];
        }, $this->board, array_keys($this->board));
        
        if ($this->isLineWinning($mainDiagonal)) {
            return true;
        }
        
        $sideDiagonal =  array_map(function($row, $index) use ($boardSize) {
            return $row[$boardSize - $index - 1];
        }, $this->board, array_keys($this->board));
        
        if ($this->isLineWinning($sideDiagonal)) {
            return true;
        }
        
        for ($i = 0; $i < $boardSize; $i++) {
            if ($this->isLineWinning($this->board[$i]) ||
                $this->isLineWinning(array_column($this->board, $i))) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Whether a line is winning
     * 
     * @param array $line Array of square values
     * @return boolean
     */
    protected function isLineWinning(array $line) : bool
    {
        $uniqueValues = array_unique($line);
        if (count($uniqueValues) === 1 && $this->isSquareTaken($uniqueValues[0])) {
            $this->setWinner($uniqueValues[0]);
            return true;
        }
        return false;
    }
    
    /**
     * Whether passed value represents a taken square
     * 
     * @param mixed $squareValue
     * @return bool
     */
    protected function isSquareTaken($squareValue) : bool
    {
        return self::SQUARE_EMPTY_LETTER !== $squareValue;
    }
    
    /**
     * Next step of the game
     * 
     * @param type $rowId
     * @param type $columnId
     */
    public function nextIteration($rowId, $columnId)
    {
        $this->setNextBotMove();
        $this->setWinner(self::SQUARE_EMPTY_LETTER);
        
        $this->makePlayersMove($rowId, $columnId);
        if (!$this->isGameFinished()) {
            $this->makeMove($this->board);
        }
    }
    
    /**
     * Make players move
     * 
     * @param type $rowId
     * @param type $columnId
     * @throws TictactoeException
     */
    public function makePlayersMove($rowId, $columnId)
    {
        if ($this->board[$rowId][$columnId] === self::SQUARE_EMPTY_LETTER) {
            $this->board[$rowId][$columnId] = self::SQUARE_X_LETTER;
        } else {
            throw new TictactoeException("Square is already taken");
        }
    }
   
    /**
     * Bot algorithm that picks a random free square and places his mark there
     * Algo can be easily swapped with minimax or whatever you need
     * 
     * @param type $boardState
     * @param type $playerUnit
     * @return int
     */
    public function makeMove($boardState, $playerUnit = 'X')
    {
        $freeSquares = [];
        
        $boardSize = count($boardState);
        for ($i = 0; $i < $boardSize; $i++) {
            for ($j = 0; $j < $boardSize; $j++) {
                if ($boardState[$i][$j] === self::SQUARE_EMPTY_LETTER) {
                    $freeSquares[] = [$i, $j];
                }
            }
        }
        
        $randKey = array_rand($freeSquares);
        
        $i = $freeSquares[$randKey][0];
        $j = $freeSquares[$randKey][1];
        
        $boardState[$i][$j] = self::SQUARE_O_LETTER;
        $this->setNextBotMove([$i, $j]);
        
        $this->setBoard($boardState);
    }
    
    /**
     * Are all squares taken
     * 
     * @return bool
     */
    public function isBoardFull() : bool
    {
        $boardSize = count($this->board);
        for ($i = 0; $i < $boardSize; $i++) {
            for ($j = 0; $j < $boardSize; $j++) {
                if (!$this->isSquareTaken($this->board[$i][$j])) {
                    return false;
                }
            }
        }
        return true;
    }
}
