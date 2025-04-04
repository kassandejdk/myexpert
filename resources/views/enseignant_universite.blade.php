<x-base>
    <!-- Enseignant - Université -->
    <div id="enseignant_universite" class="search-container">
        <h2>Recherchez un enseignant et ses universités</h2>
        <form method="POST" action="{{ route('sparql.search') }}" class="d-flex gap-3">
          @csrf
          <input type="hidden" name="category" value="enseignant_universite">
          <input type="text" name="query" class="form-control" placeholder="Nom de l'enseignant">
          <button type="submit" class="btn btn-primary">Valider</button>
        </form>
    </div>
  
      <!-- Résultats -->
      @if(isset($results) && count($results) > 0)
      <div class="result-container">
          <h3 class="text-center mt-4">Résultats enseignant-université:</h3>
          <table class="table table-striped">
              <thead>
                  <tr>
                      <th>Élément</th>
                      <th>Actions</th>
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
                          <td>
                              <!-- Bouton Modifier -->
                              <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $loop->index }}">
                                  Modifier
                              </button>
                              <!-- Bouton Supprimer -->
                              
                              <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $loop->index }}">
                                  Supprimer
                              </button>
                          </td>
                      </tr>
  
                      <!-- Modal de confirmation de suppression -->
                      <div class="modal fade" id="deleteModal{{ $loop->index }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $loop->index }}" aria-hidden="true">
                          <div class="modal-dialog">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h5 class="modal-title" id="deleteModalLabel{{ $loop->index }}">Confirmer la suppression</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                      Êtes-vous sûr de vouloir supprimer cette université ?
                                  </div>
                                  <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                      <form action="{{ route('sparql.delete') }}" method="POST" style="display:inline;">
                                          @csrf
                                          <input type="hidden" name="universiteNom" value="{{ is_array($result) ? implode('_', $result) : $result }}">
                                          <button type="submit" class="btn btn-danger">Confirmer</button>
                                      </form>
                                  </div>
                              </div>
                          </div>
                      </div>
  
                      <!-- Modal de modification -->
                      <div class="modal fade" id="editModal{{ $loop->index }}" tabindex="-1" aria-labelledby="editModalLabel{{ $loop->index }}" aria-hidden="true">
                          <div class="modal-dialog">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h5 class="modal-title" id="editModalLabel{{ $loop->index }}">Modifier l'université</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                      <form action="{{ route('sparql.update') }}" method="POST">
                                          @csrf
                                          <div class="mb-3">
                                              <label for="universiteNom" class="form-label">Nom de l'université</label>
                                              <input type="text" class="form-control" id="universiteNom" name="universiteNom" 
                                                  value="{{ is_array($result) ? implode('_', $result) : $result }}" required>
                                          </div>
                                          <button type="submit" class="btn btn-primary">Modifier</button>
                                      </form>
                                  </div>
                              </div>
                          </div>
                      </div>
                      
                  @endforeach
              </tbody>
          </table>
      </div>
      @else
          <p class="text-center text-muted mt-3">Aucun résultat trouvé.</p>
      @endif

</x-base>