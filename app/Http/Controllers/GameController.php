<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Game;
use App\Components\Tictactoe;
use App\Http\Requests\MoveRequest;

class GameController extends Controller
{
    /**
     * Starts a new game
     * 
     * @return type
     */
    public function start()
    {
        $tictactoe = new Tictactoe;
        $game = Game::create(['board' => $tictactoe->getBoard()]);
        return response()->json(['id' => $game->_id, 'board' => $game->board]);
    }
    
    /**
     * Make moves on a started board
     */
    public function move(MoveRequest $move, Game $game)
    {
        //dd(request()->all());
        $tictactoe = new Tictactoe($game->board);
        $tictactoe->nextIteration(request('row'), request('column'));
        
        $game->board = $tictactoe->getBoard();
        $game->save();
        
        return response()->json([
            'nextBotMove' => $tictactoe->getNextBotMove(),
            'gameFinished' => $tictactoe->isGameFinished(),
            'winner' => $tictactoe->getWinner()
        ]);
    }
}
