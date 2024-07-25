<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Laravel\Passport\Client;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use DatabaseMigrations;
    public function test_signup_in_api_should_be_filled_with_request()
    {
        $response = $this->post('api/auth/signup');

        $response->assertStatus(400);
    }

    public function test_correct_signup_and_login()
    {
        //corremos el seeder para setear las claves de passport
        $this->seed();
        $response = $this->post('api/auth/signup', ['email' => 'example@gmail.com', 'password' => 'secret']);
        $response->assertStatus(201)->assertSeeText('Usuario creado correctamente!');
        $response = $this->post('api/auth/login', ['email' => 'example@gmail.com', 'password' => 'secret']);
        $response->assertStatus(200)->assertJsonFragment(["token_type" => "Bearer"]);
    }

    public function test_incorrect_inputs_for_user()
    {
        $response = $this->post('api/auth/signup', ['email' => 'example@gmail.com', 'password' => 'secret']);
        $response->assertStatus(201)->assertSeeText('Usuario creado correctamente!');
        $response = $this->post('api/auth/login', ['email' => 'example@gmail.com', 'password' => 'not secret']);
        $response->assertStatus(401);
    }

    public function test_get_the_user_only_if_logged()
    {
        //corremos el seeder para setear las claves de passport
        $this->seed();

        $response = $this->post('api/auth/signup', ['email' => 'example@gmail.com', 'password' => 'secret']);
        $response->assertStatus(201)->assertSeeText('Usuario creado correctamente!');
        $get_token = $this->post('api/auth/login', ['email' => 'example@gmail.com', 'password' => 'secret']);
        $get_token->assertStatus(200);

        //esta ruta esta protegida, agregamos el token obtenido en la anterior solicitud
        $response = $this->withHeaders(['Authorization' => "Bearer " . $get_token['access_token']])->get('api/auth/user');

        $response->assertStatus(200);
        $response->assertJsonFragment([
            "email"=> "example@gmail.com",
        ]);
    }

    public function test_logout()
    {
        //corremos el seeder para setear las claves de passport
        $this->seed();
        $response = $this->post('api/auth/signup', ['email' => 'example@gmail.com', 'password' => 'secret']);
        $response->assertStatus(201)->assertSeeText('Usuario creado correctamente!');
        $get_token = $this->post('api/auth/login', ['email' => 'example@gmail.com', 'password' => 'secret']);
        $get_token->assertStatus(200);
        //esta ruta esta protegida, agregamos el token obtenido en la anterior solicitud
        $response = $this->withHeaders(['Authorization' => "Bearer " . $get_token['access_token']])->post('api/auth/logout');

        $response->assertStatus(200);
        $response->assertSeeText([
            'Sesion correctamente cerrada.'
        ]);
    }

    public function test_error_message_with_401_code()
    {
        //intentemos usar cualquier ruta protegida sin estar logueados
        $response = $this->get('api/auth/user');
        //la redireccion redireccion gestionada por el middleware. por lo tanto no puedo cambiar el proceso
        $response->assertStatus(302);
        $response->assertRedirectToRoute('login');
        //Probemos que la redireccion que implemente, devuelva el codigo y mensaje correctos
        $response = $this->get('api/unauthorized');
        $response->assertStatus(401);
        $response->assertSeeText([
            'No esta autorizado, por favor loguearse e intentar nuevamente'
        ]);
    }

}
