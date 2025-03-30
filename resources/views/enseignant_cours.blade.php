<x-base>
    <!-- Enseignant - Cours -->
    <div id="enseignant_cours" class="search-container">
        <h2>Recherchez les cours qu'enseignent un enseignant </h2>
        <form method="POST" action="{{ route('sparql.search') }}" class="d-flex gap-3">
          @csrf
          <input type="hidden" name="category" value="enseignant_cours">
          <input type="text" name="query" class="form-control" placeholder="Nom de l'enseignant">
          <button type="submit" class="btn btn-primary">Valider</button>
        </form>
    </div>


    <!-- Résultats -->
    @if(isset($results) && count($results) > 0)
    <div class="result-container">
        <h4 class="text-center mt-4">Résultats des enseignant-cours:</h4>
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