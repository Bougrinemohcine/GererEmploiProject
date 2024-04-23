<x-master title="Formateur">
    <x-settings widthUser="100%" widthFormateur="99%" widthFiliere="100%" widthGroupe="100%" widthSemaine="100%" widthSalle="100%">
        <div class="container">
            <div class="row">
                <div style="width: 100%; height: 60vh; overflow-y: scroll; border: 1px solid #ccc; padding: 10px;">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Prenom</th>
                                <th scope="col">Status</th>
                                <th scope="col">CDS</th>
                                <th scope="col">Actions</th>
                                <th scope="col">M & G</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($formateurs as $formateur)
                            <tr>
                                <th scope="row">{{$formateur->id}}</th>
                                <td>{{$formateur->name}}</td>
                                <td>{{$formateur->prenom}}</td>
                                <td>
                                    @if ($formateur->status === 'oui')
                                        <form action="{{ route('formateur.changeStatus', $formateur->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-danger">Deactivate</button>
                                        </form>
                                    @else
                                        <form action="{{ route('formateur.changeStatus', $formateur->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success">Activate</button>
                                        </form>
                                    @endif
                                </td>
                                <td>
                                    @if ($formateur->CDS === 'oui')
                                        <form action="{{ route('formateur.changeCDS', $formateur->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success">OUI</button>
                                        </form>
                                    @else
                                        <form action="{{ route('formateur.changeCDS', $formateur->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-danger">NON</button>
                                        </form>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <button type="button" class="btn btn-info me-2" data-toggle="modal" data-target="#updateModal{{$formateur->id}}">Update</button>
                                        <form action="{{route('deleteFormateur',$formateur->id)}}" method="post">
                                            @method('DELETE')
                                            @csrf
                                            <button onclick="return confirm('Voulez Vous vraiment Supprimer ce formateur?')" type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#ModalMG{{$formateur->id}}">M & G & F</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12 text-center mt-3 "> <!-- Added Bootstrap classes for centering -->
                    <a class="btn btn-success col-md-12 ajouter">Ajouter Formateur</a>
                </div>
            </div>
        </div>
    </x-settings>
</x-master>

<!-- Modal for show Modules & Groupe for a formateur -->
@foreach ($formateurs as $formateur)
<div class="modal fade" id="ModalMG{{$formateur->id}}" tabindex="-1" aria-labelledby="ModalLabel{{$formateur->id}}" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 60%;">
        <div class="modal-content" style="max-height: 95%; overflow-y: auto;">
            <div class="modal-header">
                <!-- Modal title -->
                <h5 class="modal-title" id="ModalLabel{{$formateur->id}}">Formateur Details ( {{$formateur->name}} )</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="max-height: 650px;">
                <!-- Display Groups Related to Formateur -->
                <h6>Groups:</h6>
                <div style="border: 1px solid grey; border-radius:5px" >
                    <div style="max-height: 300px; overflow-y: auto;">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Filière</th>
                                    <th>Groupe</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $printedFilieres = [];
                                @endphp
                                @foreach ($FormateurGroupes->where('formateur_id', $formateur->id) as $FormateurGroupe)
                                    @php
                                        $filiereId = $FormateurGroupe->groupe->filiere->id;
                                    @endphp
                                    @if (!in_array($filiereId, $printedFilieres))
                                        <tr>
                                            <td>
                                                {{ $FormateurGroupe->groupe->filiere->nom_filier }}
                                            </td>
                                            <td>
                                                @foreach ($FormateurGroupes->where('formateur_id', $formateur->id)->where('groupe.filiere.id', $filiereId) as $subGroupe)
                                                    <div class="d-flex" style="margin-bottom: -20px">
                                                        {{ $subGroupe->groupe->nom_groupe }}
                                                        <form action="{{ route('formateurGroupe.delete', $subGroupe->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button style="font-size:10px;width:60px;height:25px;padding:0px;margin-left:10px" type="submit" onclick="return confirm('Voulez-Vous vraiment supprimer {{$subGroupe->groupe->nom_groupe}} de {{$subGroupe->formateur->name}}')" class="btn btn-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                    <br>
                                                @endforeach
                                            </td>
                                        </tr>
                                        @php
                                            $printedFilieres[] = $filiereId;
                                        @endphp
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Display Modules Related to Formateur -->
                <h6>Modules:</h6>
                <div style="border: 1px solid grey; border-radius:5px" >
                    <div style="max-height: 250px; overflow-y: auto;">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($FormateurModules->where('formateur_id', $formateur->id) as $formateurModule)
                                    <tr>
                                        <td>{{ $formateurModule->module->nom_module }}</td>
                                        <td>
                                            @if ($formateurModule->status === 'oui')
                                                <form action="{{ route('formateurModule.changeStatus', $formateurModule->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">Deactivate</button>
                                                </form>
                                            @else
                                                <form action="{{ route('formateurModule.changeStatus', $formateurModule->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success">Activate</button>
                                                </form>
                                            @endif
                                        </td>
                                        <td> <!-- Added this column for delete button -->
                                            <form action="{{ route('formateurModule.delete', $formateurModule->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Voulez-Vous vraiment supprimer {{$formateurModule->module->nom_module}} de {{$formateurModule->formateur->name}}')" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <h6>Filieres : </h6>
                <div style="border: 1px solid grey; border-radius:5px; margin-bottom:10px;">
                    <div style="max-height: 230px; overflow-y: auto;">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Formateur</th>
                                    <th>FILIERE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $firstIteration = true;
                                @endphp
                                @foreach ($FormateurFilieres->where('formateur_id', $formateur->id) as $FF)
                                    <tr>
                                        <td>
                                            @if ($firstIteration)
                                                {{ $formateur->name }}
                                                @php
                                                    $firstIteration = false;
                                                @endphp
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex" style="height: 3vh">
                                                <div style="width:30vw">
                                                    {{ $FF->filiere->nom_filier }}
                                                </div>
                                                <form style="margin-left:20px" action="{{ route('formateurFiliere.delete', $FF->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button style="width: 85px;height:35px;" type="submit" onclick="return confirm('Voulez-Vous vraiment supprimer la filière {{$FF->filiere->nom_filier}} de {{$formateur->name}}')" class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
                                            <br>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

@endforeach
<!-- Modal for updating a formateur -->
@foreach ($formateurs as $formateur)
    <div class="modal fade" id="updateModal{{$formateur->id}}" tabindex="-1" aria-labelledby="updateModalLabel{{$formateur->id}}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel{{$formateur->id}}">Update Formateur</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('updateFormateur', $formateur->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name{{$formateur->id}}" class="form-label">Name</label>
                            <input type="text" class="form-control border" style="padding: 5px;" id="name{{$formateur->id}}" name="name" value="{{$formateur->name}}">
                        </div>
                        <div class="mb-3">
                            <label for="prenom{{$formateur->id}}" class="form-label">Prenom</label>
                            <input type="text" class="form-control border" style="padding: 5px;" id="prenom{{$formateur->id}}" name="prenom" value="{{$formateur->prenom}}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelector("a.ajouter").addEventListener("click", function (event) {
            event.preventDefault(); // Prevent the default action of the link
            // Hide the "Ajouter Formateur" button
            this.style.display = "none";

            // Get the parent container
            var container = document.querySelector(".col-md-12.text-center.mt-3");

            // Append the provided HTML code to the parent container
            container.insertAdjacentHTML("afterend", `
                <form action="{{route('addFormateur')}}" method="POST" class="d-inline">
                    @csrf <!-- Include CSRF token for Laravel forms -->
                    <div class="input-group mb-3">
                        <input type="text" class="form-control border me-2" style="height: 40px; width: 200px; padding: 5px;" placeholder="Enter name" aria-label="Enter name" aria-describedby="name-addon" name="name">
                        <input type="text" class="form-control border me-2" style="height: 40px; width: 200px; padding: 5px;border-top-left-radius:5px;border-bottom-left-radius:5px" placeholder="Enter prenom" aria-label="Enter prenom" aria-describedby="prenom-addon" name="prenom">
                        <button class="btn btn-success me-2" style="border-top-left-radius:5px;border-bottom-left-radius:5px;" type="submit" id="button-addon2">Ajouter</button>
                        <button class="btn btn-danger" style="border-top-left-radius:5px;border-bottom-left-radius:5px;" type="button" id="cancelButton">Cancel</button>
                    </div>
                </form>
            `);

            // Add event listener to the cancel button
            document.getElementById("cancelButton").addEventListener("click", function () {
                // Show the "Ajouter Formateur" button
                document.querySelector("a.ajouter").style.display = "block";
                // Remove the form
                this.parentNode.parentNode.remove(); // Remove the parent element of the cancel button (i.e., the form)
            });
        });
    });

</script>
