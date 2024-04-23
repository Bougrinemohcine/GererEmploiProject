<x-master title="Assign Modules to Formateur">
    <x-settings widthUser="100%" widthFormateur="100%" widthFiliere="100%" widthGroupe="100%" widthSemaine="100%" widthSalle="100%" widthFM="99%">
        <div class="container">
            <div>

                <a class="btn btn-success" href="{{route('GroupeModule')}}">Modules to Groupe</a>
                <a class="btn btn-info" href="{{route('FormateurGroupe')}}">Groupes to Formateur</a>
                <a class="btn btn-info" href="{{route('FormateurModule')}}">Modules to Formateur</a>
                <a class="btn btn-info" href="{{route('FormateurFiliere')}}">Filieres to Formateur</a>

            </div>
            <div id="modulesGroupesForm">
                <!-- Your Modules Groupes Form Here -->
                <div class="row">
                    <div class="col-md-10 offset-md-1">
                        <div class="card mt-5">
                            <div class="card-body text-center"> <!-- Added text-center class -->
                                <h5 class="card-title">Modules to Groupe</h5>
                                <form action="{{route('assignGroupesModules')}}" method="POST">
                                @csrf
                                    <div class="d-flex justify-content-center"> <!-- Added justify-content-center class -->
                                        <div class="mb-3 mx-auto" style="width: 150px;">
                                            <label for="filiereGroupe" class="form-label">Select Filière</label>
                                            <select class="form-select" name="filiereGroupe" id="filiereGroupe">
                                                <option value="">Select a Filiere</option>
                                                @foreach ($filieres as $filiere)
                                                    <option value="{{$filiere->id}}">{{$filiere->nom_filier}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 mx-auto" style="width: 150px;">
                                            <label for="NiveauGroupe" class="form-label">Select Niveau</label>
                                            <select class="form-select" name="NiveauGroupe" id="NiveauGroupe">
                                                <option value="">Select a Niveau</option>
                                                @foreach ($niveaux as $niveau)
                                                    <option value="{{$niveau}}">{{$niveau}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 mx-auto" style="width: 150px;">
                                            <label for="groupeModule" class="form-label">Select Groupe</label>
                                            <select class="form-select" name="groupeModule" id="groupeModule">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-check form-check-inline mb-3" style="width: 500px;">
                                        @foreach ($modules as $module)
                                            <input name="moduleGroupe[]" class="form-check-input" type="checkbox" id="inlineCheckbox{{$module->id}}" value="{{$module->id}}">
                                            <label class="form-check-label" for="inlineCheckbox{{$module->id}}">{{$module->nom_module}}</label>
                                        @endforeach

                                    </div>
                                    <br>

                                    <button type="submit" class="btn btn-success">Enregistrer</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    var groupesData = {!! json_encode($groupes) !!};
                    var GroupeModules = {!! json_encode($GroupeModules) !!};

                    function updateGroupes() {
                        var filiereId = document.getElementById('filiereGroupe').value;
                        var niveau = document.getElementById('NiveauGroupe').value;
                        var groupeSelect = document.getElementById('groupeModule');
                        var groupeId = groupeSelect.value;
                        console.log(groupeId)

                        // Store the currently selected groupe name
                        var selectedGroupeName = groupeSelect.options[groupeSelect.selectedIndex]?.textContent || '';

                        // Clear existing options
                        groupeSelect.innerHTML = '<option value="'+groupeId+'">' + (selectedGroupeName || 'Select a group') + '</option>';

                        // Filter groupes based on filiere and/or niveau, excluding the currently selected groupe
                        var filteredGroupes = groupesData.filter(function(groupe) {
                            return groupe.id != groupeId && (!filiereId || groupe.filiere_id == filiereId) && (!niveau || groupe.Niveau == niveau);
                        });

                        // Populate the groupe select options
                        filteredGroupes.forEach(function(groupe) {
                            var option = document.createElement('option');
                            option.value = groupe.id;
                            option.textContent = groupe.nom_groupe;
                            groupeSelect.appendChild(option);
                        });

                        // Populate module checkboxes based on selected groupe
                        var moduleCheckboxes = document.querySelectorAll('[name="moduleGroupe[]"]');
                        moduleCheckboxes.forEach(function(checkbox) {
                            checkbox.checked = false; // Uncheck all checkboxes
                        });

                        var relatedModules = GroupeModules.filter(function(groupeModule) {
                            return groupeModule.groupe_id == groupeId;
                        });

                        relatedModules.forEach(function(groupeModule) {
                            var checkbox = document.getElementById('inlineCheckbox' + groupeModule.module_id);
                            if (checkbox) {
                                checkbox.checked = true; // Check checkboxes related to selected groupe
                            }
                        });
                    }

                    document.getElementById('filiereGroupe').addEventListener('change', updateGroupes);
                    document.getElementById('NiveauGroupe').addEventListener('change', updateGroupes);
                    document.getElementById('groupeModule').addEventListener('change', updateGroupes);

                    // Initial population of groupes based on filiere and niveau
                    updateGroupes();

                </script>
            </div>
        </div>

    </x-settings>
</x-master>
