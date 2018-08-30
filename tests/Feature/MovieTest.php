<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MovieTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response=$this->json('GET', '/api/movie/6');
        $response->assertSuccessful()
        ->assertJson([
            'idPelicula'=>6,
            'idUser'=>2,
        ]);
        
    }
    public function testEstructure()
    {
        $response=$this->json('GET', '/api/movie/6');
        $response->assertSuccessful()
        ->$response->assertJsonStructure([
            'idPelicula','idUser','anio',
        ]);
        
    }
}
