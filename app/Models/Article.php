<?php

namespace App\Models;

use Carbon\Carbon;

class Article
{
    private $id;
    private string $name;
    private Carbon $air_date;
    private string $episode;

    public function __construct($id, string $name, Carbon $air_date, string $episode)
    {
        $this->id = $id;
        $this->name = $name;
        $this->air_date = $air_date;
        $this->episode = $episode;
    }


    public function getId()
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }


    public function getAirDate(): Carbon
    {
        return $this->air_date;
    }


    public function getEpisode():string
    {
        return $this->episode;
    }
}