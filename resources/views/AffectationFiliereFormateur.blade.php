<x-master title="Assign Filières to Formateur">
    <x-settings widthUser="100%" widthFormateur="100%" widthFiliere="100%" widthGroupe="100%" widthSemaine="100%" widthSalle="100%" widthFM="99%">
        <div class="container">
            <div>
                <a class="btn btn-info" href="{{ route('GroupeModule') }}">Modules to Groupe</a>
                <a class="btn btn-info" href="{{ route('FormateurGroupe') }}">Groupes to Formateur</a>
                <a class="btn btn-info" href="{{ route('FormateurModule') }}">Modules to Formateur</a>
                <a class="btn btn-success" href="{{ route('FormateurFiliere') }}">Filieres to Formateur</a>
            </div>
            <div id="formateurFiliereForm">
                <!-- Form to assign filières to formateur -->
                <div class="row">
                    <div class="col-md-10 offset-md-1">
                        <div class="card mt-5">
                            <div class="card-body text-center">
                                <h5 class="card-title">Filières to Formateur</h5>
                                <form action="{{ route('assignFilieresFormateur') }}" method="POST" id="assignFiliereForm">
                                    @csrf
                                    <div class="d-flex justify-content-center">
                                        <div class="mb-3 mx-auto" style="width: 150px;">
                                            <label for="formateurFiliere" class="form-label">Formateur</label>
                                            <select class="form-select" name="formateur_id" id="formateurFiliere">
                                                <option value="">Select a Formateur</option>
                                                @foreach ($formateurs as $formateur)
                                                    <option value="{{ $formateur->id }}">{{ $formateur->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 mx-auto" style="max-height: 300px; overflow-y: scroll;">
                                        <label class="form-label">Filières</label>
                                        <div id="filiereCheckboxes">
                                            @foreach ($filieres as $filiere)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="filiereFiliere[]" id="filiere_{{ $filiere->id }}" value="{{ $filiere->id }}">
                                                    <label class="form-check-label" for="filiere_{{ $filiere->id }}">{{ $filiere->nom_filier }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <br>
                                    <button type="submit" class="btn btn-success">Enregistrer</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- JavaScript to update filières based on selected formateur -->
                <script>
                    var formateurFilieresData = {!! json_encode($FiliereFormateurs) !!};

                    function updateFormateurFilieres() {
                        var formateurId = document.getElementById('formateurFiliere').value;
                        var filiereCheckboxes = document.querySelectorAll('input[name="filiereFiliere[]"]');
                        filiereCheckboxes.forEach(function(checkbox) {
                            var filiereId = parseInt(checkbox.value);
                            var isRelated = formateurFilieresData.some(function(formateurFiliere) {
                                return formateurFiliere.formateur_id == formateurId && formateurFiliere.filiere_id == filiereId;
                            });
                            checkbox.checked = isRelated;
                        });
                    }

                    document.getElementById('formateurFiliere').addEventListener('change', updateFormateurFilieres);

                    // Initial population of formateur filières
                    updateFormateurFilieres();
                </script>
            </div>
        </div>
    </x-settings>
</x-master>
