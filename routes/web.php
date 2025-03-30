<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SparqlController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/accueil', [SparqlController::class, 'accueil'])->name('accueil');
Route::get('/sparql', [SparqlController::class, 'show_universite'])->name('sparql');
Route::get('/sparql/programme', [SparqlController::class, 'show_programme'])->name('voir.programme');
Route::get('/sparql/etudiant', [SparqlController::class, 'show_etudiant'])->name('voir.etudiant');
Route::get('/sparql/personnel', [SparqlController::class, 'show_personnel'])->name('voir.personnel');
Route::get('/sparql/enseignant/cours', [SparqlController::class, 'show_enseignant_cours'])->name('voir.enseignant_cours');
Route::get('/sparql/univ/programme', [SparqlController::class, 'show_univ_programme'])->name('voir.univ_programme');
Route::get('/sparql/programme/univ', [SparqlController::class, 'show_programme_univ'])->name('voir.programme_univ');
Route::get('/sparql/enseignant/universite', [SparqlController::class, 'show_enseignant_universite'])->name('voir.enseignant_universite');
Route::get('/sparql/enseignant/etudiant', [SparqlController::class, 'show_enseignant_etudiant'])->name('voir.enseignant_etudiant');


Route::post('/sparql/search', [SparqlController::class, 'search'])->name('sparql.search');
Route::post('/sparql/create', [SparqlController::class, 'store'])->name('sparql.create');
Route::post('/sparql/update', [SparqlController::class, 'store'])->name('sparql.update');
Route::post('/sparql/delete', [SparqlController::class, 'destroy'])->name('sparql.delete');




