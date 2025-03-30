<x-base>

    <!-- Personnel -->
    <div id="personnel" class="search-container">
        <h3>Recherchez un personnel</h3>
        <h6>NB: un personnel est soit un personnel appui ou un personnel enseignant</h6>
        <form method="POST" action="{{ route('sparql.search') }}" class="d-flex gap-3">
          @csrf
          <input type="hidden" name="category" value="personnel">
          <input type="text" name="query" class="form-control" placeholder="Nom du personnel">
          <button type="submit" class="btn btn-primary">Valider</button>
        </form>
    </div>

     <!-- Résultats -->
     @if(isset($results) && count($results) > 0)
     <div class="result-container">
         <h3 class="text-center mt-4">Résultats du personnel:</h3>
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