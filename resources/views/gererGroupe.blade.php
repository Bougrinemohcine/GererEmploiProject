<x-master title="Formateur">
    <x-settings widthUser="100%" widthFormateur="100%" widthFiliere="100%" widthGroupe="99%" widthSemaine="100%" widthSalle="100%">
        <style>
            /* Modal Styles */
            .modal {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 9999;
            }

            .modal-dialog {
                position: relative;
                top: 50%;
                transform: translateY(-50%);
                max-width: 600px;
                margin: 0 auto;
                background-color: #fff;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
                height: 70.5vh; /* Set modal height to 60vh */
                overflow-y: auto; /* Add overflow-y to enable scrolling if content exceeds height */
            }

            .modal-header {
                padding: 15px;
                border-bottom: 1px solid #ccc;
                background-color: #f8f9fa;
                border-radius: 8px 8px 0 0;
            }

            .modal-body {
                padding: 20px;
            }

            .modal-title {
                margin: 0;
            }

            .modal-content button {
                width: 100%;
                text-align: center;
            }
        </style>

        <div class="container">
            <div class="row">
                <div style="width: 100%; height: 60vh; overflow-y: scroll; border: 1px solid #ccc; padding: 10px;">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Mode formation</th>
                                <th scope="col">Niveau</th>
                                <th scope="col">Filière</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($groupes as $groupe)
                                <tr>
                                    <th scope="row">{{ $groupe->id }}</th>
                                    <td>{{ $groupe->nom_groupe }}</td>
                                    <td>{{ $groupe->Mode_de_formation }}</td>
                                    <td>{{ $groupe->Niveau }}</td>
                                    <td>{{ $groupe->filiere->nom_filier }}</td>
                                    <td>
                                        <div class="d-flex">
                                            @if ($groupe->stage === 'non')
                                                <form action="{{ route('groupe.changeStage', $groupe->id) }}" method="POST">
                                                @csrf
                                                    <button  type="submit" class="btn btn-success me-2">STAGE</button>
                                                    </form>
                                            @else
                                                <form action="{{ route('groupe.changeStage', $groupe->id) }}" method="POST">
                                                @csrf
                                                    <button  type="submit" class="btn btn-danger me-2">NOSTAGE</button>
                                                    </form>
                                            @endif
                                            <button onclick="openUpdateModal({{ $groupe->id }}, '{{ $groupe->nom_groupe }}', '{{ $groupe->Mode_de_formation }}', '{{ $groupe->Niveau }}', {{ $groupe->filiere->id }})" type="button" class="btn btn-info me-2 open-update-modal">Update</button>
                                            <form action="{{ route('deleteGroupe') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $groupe->id }}">
                                                <button onclick="return confirm('Voulez Vous vraiment Supprimer ce groupe?')" type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12 text-center mt-3">
                    <a href="{{route('statusGroupes')}}" type="button" class="btn btn-info me-2">Status des Groupes</a> <br>
                    <!-- Button to open Add Groupe modal -->
                    <button id="openAddGroupeModalButton" type="button" style="width: 100%" class="btn btn-success">
                        Ajouter Groupe
                    </button>
                </div>

                <!-- Add Groupe Modal -->
                <div id="addGroupeModal" class="modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h1 class="modal-title fs-5">Ajouter un groupe</h1>
                                <button id="closeAddGroupeModalButton" class="btn-close" aria-label="Close"></button>
                            </div>
                            <!-- Modal Body -->
                            <form id="addGroupeForm" class="modal-body" action="{{ route('addGroupe') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="nomGroupe" class="form-label">Nom Groupe</label>
                                    <input type="text" name="nom_groupe" class="form-control border" id="nomGroupe" aria-describedby="emailHelp" placeholder="Enter le nom du groupe">
                                </div>
                                <div class="mb-3">
                                    <label for="modeFormation" class="form-label">Mode de Formation</label>
                                    <select name="Mode_de_formation" class="form-select border" id="modeFormation" aria-label="Default select example">
                                        <option value="CDJ">CDJ</option>
                                        <option value="CDS">CDS</option>
                                    </select>

                                </div>
                                <div class="mb-3">
                                    <label for="niveau" class="form-label">Niveau</label>
                                    <input type="text" name="Niveau" class="form-control border" id="niveau" aria-describedby="emailHelp" placeholder="Enter le niveau">
                                </div>
                                <div class="mb-3">
                                    <label for="filiere" class="form-label">Filière</label>
                                    <select name="filiere_id" class="form-select border" id="filiere" aria-label="Default select example">
                                        <option selected>Choisissez la filière</option>
                                        @foreach($filieres as $filiere)
                                            <option value="{{ $filiere->id }}">{{ $filiere->nom_filier }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-info">Save</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Update Groupe Modal -->
                <div id="updateGroupeModal" class="modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h1 class="modal-title fs-5">Modifier un groupe</h1>
                                <button id="closeUpdateGroupeModalButton" class="btn-close" aria-label="Close"></button>
                            </div>
                            <!-- Modal Body -->
                            <form id="updateGroupeForm" class="modal-body" action="{{ route('updateGroupe', ['groupe' => ':id']) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <input type="hidden" name="id" id="updateGroupeId">
                                    <label for="updateNomGroupe" class="form-label">Nom Groupe</label>
                                    <input type="text" name="nom_groupe" class="form-control border" id="updateNomGroupe" aria-describedby="emailHelp" placeholder="Enter le nom du groupe">
                                </div>
                                <div class="mb-3">
                                    <label for="updateModeFormation" class="form-label">Mode de Formation</label>
                                    <select name="Mode_de_formation" class="form-select border" id="updateModeFormation" aria-label="Default select example">
                                        <option value="CDJ">CDJ</option>
                                        <option value="CDS">CDS</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="updateNiveau" class="form-label">Niveau</label>
                                    <input type="text" name="Niveau" class="form-control border" id="updateNiveau" aria-describedby="emailHelp" placeholder="Enter le niveau">
                                </div>
                                <div class="mb-3">
                                    <label for="updateFiliere" class="form-label">Filière</label>
                                    <select name="filiere_id" class="form-select border" id="updateFiliere" aria-label="Default select example">
                                        <option selected>Choisissez la filière</option>
                                        @foreach($filieres as $filiere)
                                            <option value="{{ $filiere->id }}">{{ $filiere->nom_filier }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="d-flex">
                                    <button type="submit" class="btn btn-info" style="width: 48%;margin-right:4%">Save</button>
                                    <button id="closeUpdateGroupeModalButton" style="width: 48%" class="btn btn-danger" aria-label="Close">close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


<script>
        document.addEventListener("DOMContentLoaded", function() {
            // Code for opening and closing the Add Groupe Modal
            const openAddGroupeModalButton = document.getElementById("openAddGroupeModalButton");
            const closeAddGroupeModalButton = document.getElementById("closeAddGroupeModalButton");
            const addGroupeModal = document.getElementById("addGroupeModal");

            openAddGroupeModalButton.addEventListener("click", function() {
                addGroupeModal.style.display = "block";
            });

            closeAddGroupeModalButton.addEventListener("click", function() {
                addGroupeModal.style.display = "none";
            });

            window.addEventListener("click", function(event) {
                if (event.target === addGroupeModal) {
                    addGroupeModal.style.display = "none";
                }
            });

            // Code for opening and closing the Update Groupe Modal
            const openUpdateGroupeModalButtons = document.querySelectorAll(".open-update-modal");
            const closeUpdateGroupeModalButton = document.getElementById("closeUpdateGroupeModalButton");
            const updateGroupeModal = document.getElementById("updateGroupeModal");

            openUpdateGroupeModalButtons.forEach(function(button) {
                button.addEventListener("click", function() {
                    updateGroupeModal.style.display = "block";
                });
            });

            closeUpdateGroupeModalButton.addEventListener("click", function() {
                updateGroupeModal.style.display = "none";
            });

            window.addEventListener("click", function(event) {
                if (event.target === updateGroupeModal && !updateGroupeModal.contains(event.target)) {
                    // Check if the click target is outside the modal
                    updateGroupeModal.style.display = "none";
                }
            });
        });

        function openUpdateModal(id, nom_groupe, Mode_de_formation, Niveau, filiere_id) {
            document.getElementById('updateGroupeId').value = id;
            document.getElementById('updateNomGroupe').value = nom_groupe;
            document.getElementById('updateModeFormation').value = Mode_de_formation;
            document.getElementById('updateNiveau').value = Niveau;
            document.getElementById('updateFiliere').value = filiere_id;
            document.getElementById('updateGroupeModal').style.display = "block";

            // Set the form action URL dynamically with the group ID
            document.getElementById('updateGroupeForm').action = "{{ route('updateGroupe', ['groupe' => ':id']) }}".replace(':id', id);
        }
</script>

    </x-settings>
</x-master>
