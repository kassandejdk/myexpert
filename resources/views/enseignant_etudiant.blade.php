<x-base>
    <!-- Enseignant - Etudiant -->
    <div id="enseignant_etudiant" class="search-container">
        <h2>Recherchez un enseignant qui est à la fois étudiant</h2>
        <h6>Cette requete affiche les enseignants qui sont étudiants.</h6>
        <form method="POST" action="{{ route('sparql.search') }}" class="d-flex gap-3">
          @csrf
          <input type="hidden" name="category" value="enseignant_etudiant">
          <input type="text" name="query" class="form-control" placeholder="Nom d'un enseignant">
          <button type="submit" class="btn btn-primary">Valider</button>
        </form>
    </div>

    <!-- Résultats -->
    @if(isset($results) && count($results) > 0)
    <div class="result-container">
        <h3 class="text-center mt-4">Résultats enseignant-étudiant:</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Élément</th>
                </tr>
            </thead>
            <tbody>
                @foreach($results as $result)
                    <tr>
                        <td>
                            @if(is_array($result))
                                {{ implode(' - ', array_map(fn($item) => Str::afterLast($item, '#'), $result)) }} 
                            @else
                                {{ Str::afterLast($result, '#') }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
        <p class="text-center text-muted mt-3">Aucun résultat trouvé.</p>
    @endif

</x-base>