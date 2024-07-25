<?php

namespace Tests\Feature;

use App\Http\Controllers\GifController;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GifFeatureTest extends TestCase
{
    use DatabaseMigrations;
    public function test_search_gifs()
    {
        //corremos el seeder para setear las claves de passport
        $this->seed();
        $response = $this->post('api/auth/signup', ['email' => 'example@gmail.com', 'password' => 'secret']);
        $response->assertStatus(201)->assertSeeText('Usuario creado correctamente!');
        $response_with_token = $this->post('api/auth/login', ['email' => 'example@gmail.com', 'password' => 'secret']);
        $response_with_token->assertStatus(200);

        $token = $response_with_token['access_token'];

        //ahora probemos la busqueda de gifs

        $response = $this->withHeaders(['Authorization' => "Bearer " . $token])->post('api/search', ['query' => 'cats']);
        $response->assertStatus(200);
        $response->assertJsonFragment(['type' => 'gif', 'is_sticker' => 0]);
        //si no los encuentra...
        $response = $this->withHeaders(['Authorization' => "Bearer " . $token])->post('api/search', ['query' => 'awdaasdsa']);
        $response->assertStatus(404);
        $response->assertSeeText('No se han encontrado GIFs con el nombre solicitado');
        //si el request esta mal por la validacion
        $response = $this->withHeaders(['Authorization' => "Bearer " . $token])->post('api/search');
        $response->assertStatus(400);
        $response->assertSeeText('The query field is required');

    }

    public function test_obtain_specific_gif()
    {
        //corremos el seeder para setear las claves de passport
        $this->seed();
        $response = $this->post('api/auth/signup', ['email' => 'example@gmail.com', 'password' => 'secret']);
        $response->assertStatus(201)->assertSeeText('Usuario creado correctamente!');
        $response_with_token = $this->post('api/auth/login', ['email' => 'example@gmail.com', 'password' => 'secret']);
        $response_with_token->assertStatus(200);

        $token = $response_with_token['access_token'];

        //ahora probemos la obtencion de gif
        $response = $this->withHeaders(['Authorization' => "Bearer " . $token])->post('api/get', ['id' => 'MDJ9IbxxvDUQM']);
        $response->assertStatus(200);
        $response->assertJsonIsObject();
        //si no lo encuentra...
        $response = $this->withHeaders(['Authorization' => "Bearer " . $token])->post('api/get', ['id' => 'awdaasdsa']);
        $response->assertStatus(404);
        $response->assertSeeText('No se ha encontrado ningun GIF con el ID indicado');
        //si el request esta mal
        $response = $this->withHeaders(['Authorization' => "Bearer " . $token])->post('api/get');
        $response->assertStatus(400);
        $response->assertSeeText('The id field is required');
    }

    public function test_save_gif_to_user_favs()
    {
        //corremos el seeder para setear las claves de passport
        $this->seed();
        $response = $this->post('api/auth/signup', ['email' => 'example@gmail.com', 'password' => 'secret']);
        $response->assertStatus(201)->assertSeeText('Usuario creado correctamente!');
        $response_with_token = $this->post('api/auth/login', ['email' => 'example@gmail.com', 'password' => 'secret']);
        $response_with_token->assertStatus(200);

        $token = $response_with_token['access_token'];

        //ahora probemos guardar el gif
        $response = $this->withHeaders(['Authorization' => "Bearer " . $token])->post('api/save-fav', ['gif_id' => 'MDJ9IbxxvDUQM', 'user_id' => 1, 'alias' => 'nuevogif']);
        $response->assertStatus(200);
        $response->assertSeeText('OK');
        //si no lo encuentra...
        $response = $this->withHeaders(['Authorization' => "Bearer " . $token])->post('api/save-fav', ['gif_id' => 'asdasdads', 'user_id' => 1, 'alias' => 'nuevogif']);
        $response->assertStatus(404);
        $response->assertSeeText('No se ha encontrado ningun GIF con el ID indicado');
        //si el request esta mal
        $response = $this->withHeaders(['Authorization' => "Bearer " . $token])->post('api/save-fav', ['user_id' => 1, 'alias' => 'nuevogif']);
        $response->assertStatus(400);
        $response->assertSeeText('The gif id field is required');

        $this->assertDatabaseCount('favorite_gif', 1);

        //de paso, veamos si el endpoint de gifs favoritos funciona

        $response = $this->withHeaders(['Authorization' => "Bearer " . $token])->get('api/user-favs');
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => 1,
            'user_id' => 1,
            'alias' => 'nuevogif'
        ]);
    }
}
