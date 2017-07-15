<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GameTest extends TestCase
{
    /**
     * Test game start
     *
     * @return void
     */
    public function testStartGame()
    {
        $response = $this->json('POST', '/api/game/start');

        $data = $response->getData();
        
        $response->assertStatus(200);
        $this->assertObjectHasAttribute('id', $data);
        $this->assertObjectHasAttribute('board', $data);
        
        return $data->id;
    }
       
    /**
     * Game with provided ID not found
     */
    public function testWrongGame()
    {
        $gameId = '123456';
        $response = $this->json('POST', "/api/game/{$gameId}/move",  ['row' => 1, 'column' => 1]);
        $response->assertStatus(404);
    }
    
    /**
     * Make a good move
     * 
     * @depends testStartGame
     */
    public function testGoodMove($gameId)
    {
        $response = $this->json('POST', "/api/game/{$gameId}/move",  ['row' => 1, 'column' => 1]);
        $response->assertStatus(200);
        
        return $gameId;
    }
    
    /**
     * Make a bad move - the square is already taken
     * 
     * @depends testGoodMove
     */
    public function testSquareTaken($gameId)
    {
        $response = $this->json('POST', "/api/game/{$gameId}/move",  ['row' => 1, 'column' => 1]);
        $response->assertStatus(400);
    }
    
    /**
     * Make a bad move - square with invalid, greater range
     * 
     * @depends testGoodMove
     */
    public function testInvalidGreaterRange($gameId)
    {
        $response = $this->json('POST', "/api/game/{$gameId}/move",  ['row' => 100, 'column' => 100]);
        $response->assertStatus(422);
    }
    
    /**
     * Make a bad move - square with invalid, lower range
     * 
     * @depends testGoodMove
     */
    public function testInvalidLowerRange($gameId)
    {
        $response = $this->json('POST', "/api/game/{$gameId}/move",  ['row' => -1, 'column' => -1]);
        $response->assertStatus(422);
    }
}

