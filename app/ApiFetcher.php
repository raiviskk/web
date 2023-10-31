<?php

namespace App;


use App\Models\Article;
use App\Models\ArticlesCollection;
use Carbon\Carbon;
use GuzzleHttp\Client;

class ApiFetcher
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function fetchEpisodesFromApi(): ArticlesCollection
    {
        $response = $this->client->get('https://rickandmortyapi.com/api/episode');
        $data = json_decode($response->getBody());

        $collection = new ArticlesCollection();

        foreach ($data->results as $result) {
            $id = $result->id;
            $name = $result->name;
            $air_date = Carbon::parse($result->air_date);
            $episode = $result->episode;

            $collection->add(new Article($id, $name, $air_date, $episode));
        }

        return $collection;
    }
}
