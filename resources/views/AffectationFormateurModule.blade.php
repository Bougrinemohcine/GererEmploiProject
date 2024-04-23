<x-master title="Assign Modules to Formateur">
    <x-settings widthUser="100%" widthFormateur="100%" widthFiliere="100%" widthGroupe="100%" widthSemaine="100%" widthSalle="100%" widthFM="99%">

        <div class="container">
            <div>

                <a class="btn btn-info" href="{{route('GroupeModule')}}">Modules to Groupe</a>
                <a class="btn btn-info" href="{{route('FormateurGroupe')}}">Groupes to Formateur</a>
                <a class="btn btn-success" href="{{route('FormateurModule')}}">Modules to Formateur</a>
                <a class="btn btn-info" href="{{route('FormateurFiliere')}}">Filieres to Formateur</a>

            </div>
            <div id="formateurModulesForm">
                <div class="row">
                    <div class="col-md-10 offset-md-1">
                        <div class="card ">
                            <div class="card-body">
                                <h5 class="card-title">Modules to Formateur</h5>
                                <form action="{{route('assignModules')}}" method="POST">

                                    @csrf
                                    <div class="mb-3">
                                        <label for="formateur" class="form-label">Select Formateur</label>
                                        <select class="form-select" id="formateurSelected" name="formateur_id">
                                            @foreach($formateurs as $formateur)
                                                <option value="{{ $formateur->id }}">{{ $formateur->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="filiereA" class="form-label">Select Filiere</label>
                                        <select class="form-select" id="filiereA" name="filiere">
                                            <option value="">Select a filiere</option>
                                            @foreach($filieres as $filiere)
                                                <option value="{{ $filiere->id }}">{{ $filiere->nom_filier }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="niveauA" class="form-label">Select Niveau</label>
                                        <select class="form-select" id="niveauA" name="niveau">
                                            <option value="">Select a Niveau</option>
                                            @foreach($niveaux as $niveau)
                                                <option value="{{ $niveau }}">{{ $niveau }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="groupeA" class="form-label">Select Groupe</label>
                                        <select class="form-select" id="groupeA" name="groupe">
                                        </select>
                                    </div>
                                    <div class="mb-3" id="modules-container">
                                        <label class="form-label">Select Modules</label><br>
                                        @foreach($modules as $module)
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="moduleA{{ $module->id }}" name="modules[]" value="{{ $module->id }}">
                                                <label class="form-check-label" for="module{{ $module->id }}">{{ $module->nom_module }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="submit" class="btn btn-success">Enregistrer</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


            </div>


            <script>
                        var groupesData = {!! json_encode($groupes) !!};
                        var FormateurModules ={!! json_encode($FormateurModules) !!}
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


        </div>

    </x-settings>
</x-master>
