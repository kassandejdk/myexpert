<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\SparqlService;

class SparqlController extends Controller
{
    
    public function store(Request $request)
{
    $nomUniversite = trim($request->input('universiteNom'));
    if (empty($nomUniversite)) {
        return back()->with('error', 'Le nom de l’université est requis.');
    }

    $universiteURI = str_replace(' ', '_', $nomUniversite);

    // Requête SPARQL INSERT
    $sparqlInsert = "
        PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
        PREFIX tp3-SBC: <http://www.semanticweb.org/kassande/ontologies/2025/0/tp3-SBC#>

        INSERT DATA {
            tp3-SBC:$universiteURI rdf:type tp3-SBC:Universite .
        }
    ";

    try {
        $this->sparqlService->update($sparqlInsert);
        return back()->with('success', 'Université ajoutée avec succès.');
    } catch (\Exception $e) {
        return back()->with('error', 'Erreur lors de l’ajout de l’université.');
    }
}


    protected $sparqlService;

    public function __construct(SparqlService $sparqlService)
    {
        $this->sparqlService = $sparqlService;
    }

    /**
     * Afficher les universites au clic du bouton universite.
     */
    public function show_universite()
    {
        return view('universite');
        // $sparqlQuery = "PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
        //     PREFIX tp3-SBC: <http://www.semanticweb.org/kassande/ontologies/2025/0/tp3-SBC#>

        //     SELECT ?universite
        //     WHERE {
        //     ?universite rdf:type tp3-SBC:Universite .
        //     }";

        // $results = $this->sparqlService->query($sparqlQuery);
        // // dd($results);

        // // Vérifier si "bindings" existe
        // if (!isset($results['results']['bindings'])) {
        //     return view('sparql_results', ['results' => []]);
        // }

        // $formattedResults = array_map(fn($row) => $row['universite']['value'],  $results['results']['bindings']);

        // return view('universite', ['results' => $formattedResults]);
    }

    /**
     * Afficher les universites au clic du bouton programme.
     */
    public function show_programme()
    {
        return view('programme');
    }

    public function show_etudiant()
    {
        return view('etudiant');
    }

    public function show_personnel()
    {
        return view('personnel');
    }

    public function show_enseignant_cours(){
        return view('enseignant_cours');
    }

    public function show_univ_programme(){
        return view('univ_programme');
    }

    public function show_programme_univ(){
        return view('programme_univ');
    }

    public function show_enseignant_universite(){
        return view('enseignant_universite');
    }

    public function show_enseignant_etudiant(){
        return view('enseignant_etudiant');
    }

    public function accueil(){

        $sparqlQuery = "PREFIX swrla: <http://swrl.stanford.edu/ontologies/3.3/swrla.owl#>
        PREFIX xsd: <http://www.w3.org/2001/XMLSchema#>
        PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
        PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
        PREFIX owl: <http://www.w3.org/2002/07/owl#>
        PREFIX tp3-SBC: <http://www.semanticweb.org/kassande/ontologies/2025/0/tp3-SBC#>
        PREFIX webprotege: <http://webprotege.stanford.edu/>

        SELECT DISTINCT ?instance 
            (SUBSTR(STR(?type), STRLEN(str(<http://www.semanticweb.org/kassande/ontologies/2025/0/tp3-SBC#>)) + 1) AS ?className)
        WHERE { 
        ?instance rdf:type ?type .
        
        FILTER (!isBlank(?instance))  # Exclure les nœuds anonymes
        FILTER (?type != rdfs:Class && ?type != owl:Class)  # Exclure les classes
        FILTER (?type != rdf:Property)  # Exclure les propriétés
        FILTER (?type != rdf:nil && ?type != rdf:XMLLiteral && ?type != xsd:nonNegativeInteger && ?type != xsd:string)  # Exclure les types non pertinents
        FILTER (?instance NOT IN (
            rdfs:subPropertyOf, rdfs:subClassOf, owl:equivalentProperty, owl:equivalentClass, owl:inverseOf,
            rdf:nil, rdf:XMLLiteral, owl:differentFrom, xsd:nonNegativeInteger, xsd:string, rdf:_1,
            <http://www.semanticweb.org/kassande/ontologies/2025/0/tp3-SBC>, swrla:isRuleEnabled,
            tp3-SBC:concerneEtudiant, tp3-SBC:concerneProgramme, tp3-SBC:contient, tp3-SBC:dansUniversite,
            tp3-SBC:enseigneDans, tp3-SBC:estInscrit, tp3-SBC:estOffertPar, tp3-SBC:inscritDans, 
            tp3-SBC:offre, tp3-SBC:rattacherA, tp3-SBC:travailleDans, tp3-SBC:genre, 
            tp3-SBC:x, tp3-SBC:uni, tp3-SBC:y, 
            webprotege:RomyfyCZ96jr78b6mEY3oH, webprotege:RBIDx1ERRUTLFAuQNHDNNTg, webprotege:RDxSa4VaZMT81oAclbzW7sD
        ))
        FILTER (REGEX(STR(?type), '^http://www.semanticweb.org/kassande/ontologies/2025/0/tp3-SBC#'))  
        }";

        $results = $this->sparqlService->query($sparqlQuery);
        // dd($results);
        if (!isset($results['results']['bindings'])) {
            return view('accueil', ['results' => []]);
        }

        // Formatage des résultats (Instance -> Classe(s))
        $formattedResults = [];
        foreach ($results['results']['bindings'] as $row) {
            $instance = Str::afterLast($row['instance']['value'], '#'); 
            $classes = isset($row['className']['value']) ? $row['className']['value'] : '';
            $formattedResults[] = ['instance' => $instance, 'classes' => $classes];
        }
        // dd($formattedResults);
        return view('accueil', ['results' => $formattedResults]);
    }



    public function search(Request $request)
{
    $category = $request->input('category');
    $searchTerm = $request->input('query'); 

    $sparqlQuery = "";

    switch ($category) {

        case 'accueil':
            $sparqlQuery = "PREFIX swrla: <http://swrl.stanford.edu/ontologies/3.3/swrla.owl#>
            PREFIX xsd: <http://www.w3.org/2001/XMLSchema#>
            PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
            PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
            PREFIX owl: <http://www.w3.org/2002/07/owl#>
            PREFIX tp3-SBC: <http://www.semanticweb.org/kassande/ontologies/2025/0/tp3-SBC#>
            PREFIX webprotege: <http://webprotege.stanford.edu/>

            SELECT DISTINCT ?instance 
                (SUBSTR(STR(?type), STRLEN(str(<http://www.semanticweb.org/kassande/ontologies/2025/0/tp3-SBC#>)) + 1) AS ?className)
            WHERE { 
            ?instance rdf:type ?type .
            
            FILTER (!isBlank(?instance))  # Exclure les nœuds anonymes
            FILTER (?type != rdfs:Class && ?type != owl:Class)  # Exclure les classes
            FILTER (?type != rdf:Property)  # Exclure les propriétés
            FILTER (?type != rdf:nil && ?type != rdf:XMLLiteral && ?type != xsd:nonNegativeInteger && ?type != xsd:string)  # Exclure les types non pertinents
            FILTER (?instance NOT IN (
                rdfs:subPropertyOf, rdfs:subClassOf, owl:equivalentProperty, owl:equivalentClass, owl:inverseOf,
                rdf:nil, rdf:XMLLiteral, owl:differentFrom, xsd:nonNegativeInteger, xsd:string, rdf:_1,
                <http://www.semanticweb.org/kassande/ontologies/2025/0/tp3-SBC>, swrla:isRuleEnabled,
                tp3-SBC:concerneEtudiant, tp3-SBC:concerneProgramme, tp3-SBC:contient, tp3-SBC:dansUniversite,
                tp3-SBC:enseigneDans, tp3-SBC:estInscrit, tp3-SBC:estOffertPar, tp3-SBC:inscritDans, 
                tp3-SBC:offre, tp3-SBC:rattacherA, tp3-SBC:travailleDans, tp3-SBC:genre, 
                tp3-SBC:x, tp3-SBC:uni, tp3-SBC:y, 
                webprotege:RomyfyCZ96jr78b6mEY3oH, webprotege:RBIDx1ERRUTLFAuQNHDNNTg, webprotege:RDxSa4VaZMT81oAclbzW7sD
            ))
            FILTER (REGEX(STR(?type), '^http://www.semanticweb.org/kassande/ontologies/2025/0/tp3-SBC#'))  
            }";
            break;

        case 'universite':
            
            $sparqlQuery = "PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                PREFIX tp3-SBC: <http://www.semanticweb.org/kassande/ontologies/2025/0/tp3-SBC#>
                SELECT ?universite
                WHERE {
                    ?universite rdf:type tp3-SBC:Universite .
                    FILTER(CONTAINS(LCASE(STR(?universite)), LCASE('$searchTerm')))
                }";
            break;


        case 'etudiant':
                $sparqlQuery = "PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                    PREFIX tp3-SBC: <http://www.semanticweb.org/kassande/ontologies/2025/0/tp3-SBC#>
                    SELECT ?etudiant
                    WHERE {
                        ?etudiant rdf:type tp3-SBC:Etudiant .
                        FILTER(CONTAINS(LCASE(STR(?etudiant)), LCASE('$searchTerm')))
                    }";
                break;
        
        case 'programme':
                    $sparqlQuery = "PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                        PREFIX tp3-SBC: <http://www.semanticweb.org/kassande/ontologies/2025/0/tp3-SBC#>
                        SELECT ?programme
                        WHERE {
                            ?programme rdf:type tp3-SBC:Programme .
                            FILTER(CONTAINS(LCASE(STR(?programme)), LCASE('$searchTerm')))
                        }";
                    break;
        case 'programme_univ':
            $sparqlQuery = "PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                PREFIX tp3-SBC: <http://www.semanticweb.org/kassande/ontologies/2025/0/tp3-SBC#>
                SELECT ?universite ?programme
                WHERE {
                    ?universite tp3-SBC:offre ?programme .
                    FILTER(CONTAINS(LCASE(STR(?programme)), LCASE('$searchTerm')))
                }";
            break;
        case 'univ_programme':
            $sparqlQuery="
                PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                PREFIX tp3-SBC: <http://www.semanticweb.org/kassande/ontologies/2025/0/tp3-SBC#>

                SELECT ?universite ?programme
                WHERE {
                    ?universite tp3-SBC:offre ?programme .
                    FILTER(CONTAINS(LCASE(STR(?universite)), LCASE('$searchTerm')))
                }
            ";
            break;
            // dd("j'arrive icii");
        case 'enseignant_universite':
            $sparqlQuery = "PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                PREFIX tp3-SBC: <http://www.semanticweb.org/kassande/ontologies/2025/0/tp3-SBC#>
                SELECT ?enseignant ?universite
                WHERE {
                    ?enseignant a tp3-SBC:PersonnelEnseignant .
                    ?enseignant tp3-SBC:dansUniversite ?universite .
                    FILTER(CONTAINS(LCASE(STR(?enseignant)), LCASE('$searchTerm')))
                }";
            break;
        case 'enseignant_cours':
                $sparqlQuery = "PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                    PREFIX tp3-SBC: <http://www.semanticweb.org/kassande/ontologies/2025/0/tp3-SBC#>
                    SELECT ?enseignant ?universite
                    WHERE {
                        ?enseignant tp3-SBC:enseigneDans ?universite .
                        FILTER(CONTAINS(LCASE(STR(?enseignant)), LCASE('$searchTerm')))
                    }";
                break;

        case 'programme-':
            $sparqlQuery = "PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                PREFIX tp3-SBC: <http://www.semanticweb.org/kassande/ontologies/2025/0/tp3-SBC#>
                SELECT ?programme
                WHERE {
                    ?universite tp3-SBC:offreProgramme ?programme .
                    FILTER(CONTAINS(LCASE(STR(?universite)), LCASE('$searchTerm')))
                }";
            break;

        case 'enseignant_etudiant':
            $sparqlQuery = "PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                PREFIX tp3-SBC: <http://www.semanticweb.org/kassande/ontologies/2025/0/tp3-SBC#>
                SELECT ?personne 
                WHERE {
                    ?personne a tp3-SBC:PersonnelEnseignant .
                    ?personne a tp3-SBC:Etudiant .
                    FILTER(CONTAINS(LCASE(STR(?personne)), LCASE('$searchTerm')))
                }";
            break;

        case 'personnel':
            $sparqlQuery = "PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
            PREFIX tp3-SBC: <http://www.semanticweb.org/kassande/ontologies/2025/0/tp3-SBC#>

            SELECT ?personnel ?universite
            WHERE {
                { ?personnel rdf:type tp3-SBC:PersonnelEnseignant . }
                UNION
                { ?personnel rdf:type tp3-SBC:PersonnelAppui . }
                                
                FILTER(CONTAINS(LCASE(STR(?personnel)), LCASE('$searchTerm')))
            }
            ";
            break;

        default:
            return back()->with('error', 'Type de recherche non valide.');
    }

    $results = $this->sparqlService->query($sparqlQuery);

    // Formater les résultats si "bindings" existe
    $formattedResults = [];
    if (isset($results['results']['bindings'])) {
        foreach ($results['results']['bindings'] as $row) {
            $formattedResults[] = array_map(fn($item) => $item['value'], $row);
        }
    }
    // dd($formattedResults);
    return view($category,['results' => $formattedResults, 'category' => $category]);
   
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(Request $request)
{
    $nomUniversite = trim($request->input('universiteNom'));
    if (empty($nomUniversite)) {
        return back()->with('error', 'Le nom de l’université est requis.');
    };

    $positionHashtag = strrpos($nomUniversite, '#'); 

    $nom = substr($nomUniversite, $positionHashtag + 1);
    $sparqlDelete = "
        PREFIX tp3-SBC: <http://www.semanticweb.org/kassande/ontologies/2025/0/tp3-SBC#>
        DELETE WHERE { 
            tp3-SBC:$nom ?p ?o .
        }
    ";

    try {
        $this->sparqlService->update($sparqlDelete);
        return back()->with('success', 'Université supprimée avec succès.');
    } catch (\Exception $e) {
        return back()->with('error', 'Erreur lors de la suppression de l’université.');
    }
}

    
}
