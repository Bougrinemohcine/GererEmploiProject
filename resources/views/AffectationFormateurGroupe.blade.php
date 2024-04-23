<x-master title="Assign Modules to Formateur">
    <x-settings widthUser="100%" widthFormateur="100%" widthFiliere="100%" widthGroupe="100%" widthSemaine="100%" widthSalle="100%" widthFM="99%">
        <div class="container">
            <div>
                <a class="btn btn-info" href="{{ route('GroupeModule') }}">Modules to Groupe</a>
                <a class="btn btn-success" href="{{ route('FormateurGroupe') }}">Groupes to Formateur</a>
                <a class="btn btn-info" href="{{ route('FormateurModule') }}">Modules to Formateur</a>
                <a class="btn btn-info" href="{{route('FormateurFiliere')}}">Filieres to Formateur</a>
            </div>
            <div id="formateurGroupesForm">
                <div class="row">
                    <div class="col-md-10 offset-md-1">
                        <div class="card mt-5">
                            <div class="card-body">
                                <h5 class="card-title">Groupes to Formateur</h5>
                                <form action="{{ route('assignGroupes') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="formateur" class="form-label">Select Formateur</label>
                                        <select class="form-select" id="formateur" name="formateur_id">
                                            <option value="">Select a Formateur</option>
                                            @foreach($formateurs as $formateur)
                                                <option value="{{ $formateur->id }}">{{ $formateur->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="d-flex">
                                        <div class="mb-3 mx-auto" style="width: 150px;">
                                            <label for="filiere" class="form-label">Select Filière</label>
                                            <select class="form-select" name="filiere" id="filiere">
                                                <option value="">Select a Filiere</option>
                                                @foreach ($filieres as $filiere)
                                                    <option value="{{ $filiere->id }}">{{ $filiere->nom_filier }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 mx-auto" style="width: 150px;">
                                            <label for="niveau" class="form-label">Select Niveau</label>
                                            <select class="form-select" name="niveau" id="niveau">
                                                <option value="">Select a Niveau</option>
                                                @foreach ($niveaux as $niveau)
                                                    <option value="{{ $niveau }}">{{ $niveau }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Select Groupes</label><br>
                                        <div id="groupes-checkboxes">
                                            <!-- Checkboxes will be dynamically populated based on the selected filiere -->
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success">Enregistrer</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    // Function to update groupes based on filiere and niveau
                    function updateGroupes() {
                        var filiereId = document.getElementById('filiere').value;
                        var niveau = document.getElementById('niveau').value;
                        var groupesCheckboxes = document.getElementById('groupes-checkboxes');
                        var formateurGroupesData = @json($formateurGroupes);

                        var formateurDropdown = document.getElementById('formateur');
                        var formateurId = formateurDropdown.value;
                        var formateurGroupes = formateurGroupesData.filter(function(formateurGroupe) {
                            return formateurGroupe.formateur_id == formateurId;
                        });

                        groupesCheckboxes.innerHTML = ''; // Clear existing checkboxes

                        // Filter groupes based on the selected filiere and/or niveau
                        if (filiereId && niveau) {
                            // If both filiere and niveau are selected
                            filteredGroupes = groupesData.filter(function(groupe) {
                                return groupe.filiere_id == filiereId && groupe.Niveau == niveau;
                            });
                        } else if (filiereId) {
                            // If only filiere is selected
                            filteredGroupes = groupesData.filter(function(groupe) {
                                return groupe.filiere_id == filiereId;
                            });
                        } else if (niveau) {
                            // If only niveau is selected
                            filteredGroupes = groupesData.filter(function(groupe) {
                                return groupe.Niveau == niveau;
                            });
                        } else {
                            // If neither filiere nor niveau is selected
                            filteredGroupes = [];
                        }

                        // Populate the groupes checkboxes
                        filteredGroupes.forEach(function(groupe) {
                            var checkboxDiv = document.createElement('div');
                            checkboxDiv.classList.add('form-check', 'form-check-inline');

                            var checkbox = document.createElement('input');
                            checkbox.classList.add('form-check-input');
                            checkbox.type = 'checkbox';
                            checkbox.name = 'groupes[]';
                            checkbox.value = groupe.id;
                            checkbox.id = 'groupe' + groupe.id;
                            // checkbox.checked =
                            var isGroupeSelected = formateurGroupes.some(function(formateurGroupe) {
                                return formateurGroupe.groupe_id === groupe.id;
                            });
                            console.log(isGroupeSelected)

                            checkbox.checked = isGroupeSelected;

                            var label = document.createElement('label');
                            label.classList.add('form-check-label');
                            label.setAttribute('for', 'groupe' + groupe.id);
                            label.textContent = groupe.nom_groupe;

                            checkboxDiv.appendChild(checkbox);
                            checkboxDiv.appendChild(label);
                            groupesCheckboxes.appendChild(checkboxDiv);
                        });
                    }

                    // Add event listeners to both filiere and niveau dropdowns
                    document.getElementById('filiere').addEventListener('change', updateGroupes);
                    document.getElementById('niveau').addEventListener('change', updateGroupes);
                    document.getElementById('formateur').addEventListener('change', updateGroupes);

                    // Initial population of groupes based on filiere and niveau
                    updateGroupes();
                </script>

            </div>
        </div>
    </x-settings>
    <script>
        var groupesData = {!! json_encode($groupes) !!};
        var FormateurModules = {!! json_encode($FormateurModules) !!};
        document.getElementById('formateurSelected').addEventListener('change', function() {
            var formateurId = this.value;
            var modules = document.querySelectorAll('input[name="modules[]"]');

            // Uncheck all checkboxes
            modules.forEach(function(module) {
                module.checked = false;
            });

            // Check checkboxes for modules associated with the selected formateur
            FormateurModules.filter(function(fm) {
                return fm.formateur_id == formateurId;
            }).forEach(function(fm) {
                var moduleId = fm.module_id;
                var checkbox = document.querySelector('input[name="modules[]"][value="' + moduleId + '"]');
                if (checkbox) {
                    checkbox.checked = true;
                }
            });
        });

        function updateGroupes() {
            var filiereId = document.getElementById('filiereA').value;
            var niveau = document.getElementById('niveauA').value;
            var groupeSelect = document.getElementById('groupeA');

            // Clear existing options
            groupeSelect.innerHTML = '<option value="">Select a Groupe</option>';

            // Filter groupes based on filiere and/or niveau
            var filteredGroupes = groupesData.filter(function(groupe) {
                return (!filiereId || groupe.filiere_id == filiereId) && (!niveau || groupe.Niveau == niveau);
            });

            // Populate the groupe select options
            filteredGroupes.forEach(function(groupe) {
                var option = document.createElement('option');
                option.value = groupe.id;
                option.textContent = groupe.nom_groupe;
                groupeSelect.appendChild(option);
            });
        }

        document.getElementById('filiereA').addEventListener('change', updateGroupes);
        document.getElementById('niveauA').addEventListener('change', updateGroupes);

        // Initial population of groupes based on filiere and niveau
        updateGroupes();

        function checkFormateurModules(formateurId) {
            var modules = document.querySelectorAll('input[name="modules[]"]');

            // Uncheck all checkboxes
            modules.forEach(function(module) {
                module.checked = false;
            });

            // Check checkboxes for modules associated with the selected formateur
            FormateurModules.filter(function(fm) {
                return fm.formateur_id == formateurId;
            }).forEach(function(fm) {
                var moduleId = fm.module_id;
                var checkbox = document.querySelector('input[name="modules[]"][value="' + moduleId + '"]');
                if (checkbox) {
                    checkbox.checked = true;
                }
            });
        }

        document.getElementById('formateurSelected').addEventListener('change', function() {
            var formateurId = this.value;
            checkFormateurModules(formateurId);
        });

        // Call the function initially if a formateur is already selected
        var initialFormateurId = document.getElementById('formateurSelected').value;
        if (initialFormateurId) {
            checkFormateurModules(initialFormateurId);
        }

        document.getElementById('groupeA').addEventListener('change', function() {
            var groupeId = this.value;
            var modulesContainer = document.getElementById('modules-container');

            // Clear existing modules
            modulesContainer.innerHTML = '';

            if (groupeId) {
                // Fetch modules for the selected groupe using AJAX
                fetch('/get-modules/' + groupeId)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(function(module) {
                            var moduleLabel = document.createElement('label');
                            moduleLabel.textContent = module.module.nom_module; // Set the module name

                            var moduleInput = document.createElement('input');
                            moduleInput.type = 'checkbox';
                            moduleInput.name = 'modules[]';
                            moduleInput.value = module.module.id;

                            var moduleDiv = document.createElement('div');
                            moduleDiv.classList.add('form-check', 'form-check-inline');
                            moduleDiv.appendChild(moduleInput);
                            moduleDiv.appendChild(moduleLabel);

                            modulesContainer.appendChild(moduleDiv);

                            // Check checkboxes for modules associated with the selected formateur
                            var formateurId = document.getElementById('formateurSelected').value;
                            checkFormateurModules(formateurId);
                        });
                    });
            } else {
                // Fetch all modules if no groupe is selected
                fetch('/get-all-modules')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        data.forEach(function(module) {
                            var moduleLabel = document.createElement('label');
                            moduleLabel.textContent = module.nom_module; // Set the module name

                            var moduleInput = document.createElement('input');
                            moduleInput.type = 'checkbox';
                            moduleInput.name = 'modules[]';
                            moduleInput.value = module.id;

                            var moduleDiv = document.createElement('div');
                            moduleDiv.classList.add('form-check', 'form-check-inline');
                            moduleDiv.appendChild(moduleInput);
                            moduleDiv.appendChild(moduleLabel);

                            modulesContainer.appendChild(moduleDiv);
                        });

                        // Check checkboxes for modules associated with the selected formateur
                        var formateurId = document.getElementById('formateurSelected').value;
                        checkFormateurModules(formateurId);
                    });
            }
        });
    </script>
</x-master>
