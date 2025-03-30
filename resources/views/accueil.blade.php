<x-base>

    <!-- Résultats -->
    @if(isset($results) && count($results) > 0)
    <div class="result-container">
        <h3 class="text-center mt-4">Affichage des éléments existants :</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Instance</th>
                    <th>Classe(s) associée(s)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($results as $result)
                    <tr>
                        <td>{{ $result['instance'] }}</td>
                        <td>{{ is_array($result['classes']) ? implode(' - ', $result['classes']) : $result['classes'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <p class="text-center text-muted mt-3">Aucun résultat trouvé.</p>
@endif



</x-base>