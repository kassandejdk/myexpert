<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SparqlService
{
    // L'URL du endpoint
    protected $endpoint;

    public function __construct()
    {
        $this->endpoint = 'http://127.0.0.1:7200/repositories/ontologie';
    }

   
    public function query($sparqlQuery)
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/sparql-query',
            'Accept' => 'application/json'
        ])->send('POST', $this->endpoint, [
            'body' => $sparqlQuery
        ]);

        // Vérifier si la requête a réussi
        if ($response->failed()) {
            throw new \Exception('Erreur SPARQL : ' . $response->body());
        }

        return $response->json();
    }

    public function update($sparqlUpdate)
{
    $updateEndpoint = rtrim($this->endpoint, '/') . '/statements';

    $response = Http::withHeaders([
        'Content-Type' => 'application/sparql-update',
    ])->send('POST',  $updateEndpoint, [
        'body' => $sparqlUpdate
    ]);

    if ($response->failed()) {
        throw new \Exception('Erreur SPARQL UPDATE : ' . $response->body());
    }

    return true; // Succès
}

}