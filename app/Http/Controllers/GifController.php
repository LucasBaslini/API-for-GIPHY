<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class GifController extends Controller
{
    public $api_key;

    public function __construct() {
        $this->api_key = env('GIPHY_API_KEY');
    }
    public function search(Request $request)
    {
        try {
            $request->validate([
                'query' => 'required|string',
                'limit' => 'integer',
                'offset' => 'integer'
            ]);
        } catch (\Exception $e) {
            return response($e->getMessage(), 400);
        }
        $query = [
            'api_key' => $this->api_key,
            'q' => $request->get('query'),
            'limit' => $request->get('limit'),
            'offset' => $request->get('offset')
        ];
        $response = Http::withQueryParameters($query)->get('api.giphy.com/v1/gifs/search');

        if ($response['data'] != []) {
            $collection = collect();
            foreach ($response['data'] as $item) {
                $collection->push($item);
                return response($collection, 200);
            }
        } else {
            if ($response['meta']['status'] == 200) {
                return response('No se han encontrado GIFs con el nombre solicitado', 404);
            } else {
                return response($response['meta'], $response['meta']['status']);
            }
        }
    }

    public function get(Request $request)
    {
        //La consigna decia que ID debe ser numerico, pero no funcionaria ya que los id de giphy son strings. Hice la correccion a mi criterio
        try {
            $request->validate([
                'id' => 'required|string',
            ]);
        } catch (\Exception $e) {
            return response($e->getMessage(), 400);
        }

        $query = [
            'api_key' => $this->api_key,
        ];
        $response = Http::withQueryParameters($query)->get('api.giphy.com/v1/gifs/' . $request->get('id'));

        if($response['data'] != []){
            $data = json_encode([
                'Nombre' => $response['data']['title'],
                'Usuario' => $response['data']['username'],
                'Url' => $response['data']['url'],
                'Fecha de creacion' => $response['data']['import_datetime'],
                'Slug' => $response['data']['slug'],
            ]);
            return response($data, 200);
        } else {
            if ($response['meta']['status'] == 404) {
                return response('No se ha encontrado ningun GIF con el ID indicado', 404);
            } else {
                return response($response['meta'], $response['meta']['status']);
            }
        }

    }

    public function saveFav(Request $request)
    {
        try {
            $request->validate([
                'gif_id' => 'required|string',
                'user_id' => 'required|integer',
                'alias' => 'required|string'
            ]);
        } catch (\Exception $e) {
            return response($e->getMessage(), 400);
        }
        //verificar que el gif existe antes de agregarlo.
        $query = [
            'api_key' => $this->api_key,
        ];
        $response = Http::withQueryParameters($query)->get('api.giphy.com/v1/gifs/' . $request->get('gif_id'));

        if($response['data'] != []){
            DB::table('favorite_gif')->insert([
                'user_id' => $request->get('user_id'),
                'gif_id' => $request->get('gif_id'),
                'alias' => $request->get('alias')
            ]);

            return response('OK', 200);
        } else {
            if ($response['meta']['status'] == 404) {
                return response('No se ha encontrado ningun GIF con el ID indicado', 404);
            } else {
                return response($response['meta'], $response['meta']['status']);
            }
        }
    }

    public function getUserFavorites(){
        return auth()->user()->favorite_gifs_list;
    }
}
