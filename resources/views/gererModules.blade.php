<x-master title="gerer Modules">
    <x-settings widthUser="100%" widthFormateur="100%" widthFiliere="100%" widthGroupe="100%" widthSemaine="100%" widthSalle="100%" widthModule="99%">
        <div class="container">
            <div class="row">
                <div style="width: 100%; height: 60vh; overflow-y: scroll; border: 1px solid #ccc; padding: 10px;">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">nom</th>
                                    <th scope="col">intitule</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($modules as $module)
                                <tr>
                                    <th scope="row">{{$module->id}}</th>
                                    <td >{{$module->nom_module}}</td>
                                    <td>{{$module->intitule}}</td>
                                    <td>
                                        <div class="d-flex">
                                            <button type="button" class="btn btn-info me-2" data-toggle="modal" data-target="#updateModal{{$module->id}}">Update</button>
                                            <form action="{{route('deleteModule',$module->id)}}" method="post">
                                                @method('DELETE')
                                                @csrf
                                                <button onclick="return confirm('Voulez-vous vraiment supprimer ce Module?')" type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-12 text-center mt-3"> <!-- Added Bootstrap classes for centering -->
                    <a href="{{route('statusModules')}}" type="button" class="btn btn-info me-2">Status des Modules</a>
                    <a class="btn btn-success col-md-12 ajouter">Ajouter Module</a>
                </div>
            </div>
        </div>
    </x-settings>
</x-master>
@foreach ($modules as $module)
    <div class="modal fade" id="updateModal{{$module->id}}" tabindex="-1" aria-labelledby="updateModalLabel{{$module->id}}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel{{$module->id}}">Update Module</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('updateModule', $module->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nom_module{{$module->id}}" class="form-label">Nom de Module</label>
                            <input type="text" class="form-control border" style="padding: 5px;" id="nom_module{{$module->id}}" name="nom_module" value="{{$module->nom_module}}">
                        </div>
                        <div class="mb-3">
                            <label for="intitule{{$module->id}}" class="form-label">intitule</label>
                            <input type="text" class="form-control border" style="padding: 5px;" id="intitule{{$module->id}}" name="intitule" value="{{$module->intitule}}">
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
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelector("a.ajouter").addEventListener("click", function(event) {
            event.preventDefault(); // Prevent the default action of the link
            // Hide the "Ajouter Filière" button
            this.style.display = "none";

            // Get the parent container
            var container = document.querySelector(".col-md-12.text-center.mt-3");
            // var formateursOptions = '';
            // @foreach($formateurs as $formateur)
            //     formateursOptions += '<option value="{{ $formateur->id }}">{{ $formateur->name }}</option>';
            // @endforeach

            // Append the provided HTML code to the parent container
            container.insertAdjacentHTML("afterend", `
                <form action="{{route('addModule')}}" method="POST" class="d-inline">
                    @csrf <!-- Include CSRF token for Laravel forms -->
                    <div class="input-group mb-3">
                        <input type="text" class="form-control border me-2" style="height: 40px; width: 200px; padding: 5px;" placeholder="Enter nom de Module" aria-label="Enter nom de module" aria-describedby="name-addon" name="nom_module">
                        <input type="text" class="form-control border me-2" style="height: 40px; width: 200px; padding: 5px;" placeholder="Enter Intitule" aria-label="Enter Intitule" aria-describedby="name-addon" name="intitule">
                        <!-- Add select for niveau de formation -->

                            <!-- Add options dynamically from your data source -->
                        <button style="border-top-left-radius:5px;border-bottom-left-radius:5px; margin:5px" class="btn btn-success me-2" type="submit" id="button-addon2">Ajouter</button>
                        <button class="btn btn-danger" style="border-radius:5px; margin:5px" type="button" id="cancelButton">Cancel</button>
                    </div>
                </form>
            `);

            // <select class="form-select border me-2" style="height: 40px; width: 200px; padding: 5px;" aria-label="Select niveau de formation" name="formateur_id">
            //                 <option value="">Select un formateur</option>
            //                 ${formateursOptions}
            //             </select>
            // Add event listener to the cancel button
            document.getElementById("cancelButton").addEventListener("click", function() {
                // Show the "Ajouter Filière" button
                document.querySelector("a.ajouter").style.display = "block";
                // Remove the form
                this.parentNode.parentNode.remove(); // Remove the parent element of the cancel button (i.e., the form)
            });
        });
    });

</script>
