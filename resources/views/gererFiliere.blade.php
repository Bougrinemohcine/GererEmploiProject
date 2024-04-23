<x-master title="Filière">
    <x-settings widthUser="100%" widthFormateur="100%" widthFiliere="99%" widthGroupe="100%" widthSemaine="100%" widthSalle="100%">
        <div class="container">
            <div class="row">
                <div style="width: 100%; height: 60vh; overflow-y: scroll; border: 1px solid #ccc; padding: 10px;">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Niveau de formation</th>
                                    <th scope="col">Mode de formation</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($filieres as $filiere)
                                <tr>
                                    <th scope="row">{{$filiere->id}}</th>
                                    <td>{{$filiere->nom_filier}}</td>
                                    <td>{{$filiere->niveau_formation}}</td>
                                    <td>{{$filiere->mode_formation}}</td>
                                    <td>
                                        <div class="d-flex">
                                            <button type="button" class="btn btn-info me-2" data-toggle="modal" data-target="#updateModal{{$filiere->id}}">Update</button>
                                            <form action="{{route('deleteFiliere',$filiere->id)}}" method="post">
                                                @method('DELETE')
                                                @csrf
                                                <button onclick="return confirm('Voulez-vous vraiment supprimer cette filière?')" type="submit" class="btn btn-danger">Delete</button>
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
                    <a href="{{route('statusFilieres')}}" type="button" class="btn btn-info me-2">Status des Filieres</a> <br>
                        <!-- Button to open Add Groupe modal -->
                    <a class="btn btn-success col-md-12 ajouter">Ajouter Filière</a> {{--{{route('showAddSalle')}}--}}
                </div>
            </div>
        </div>
    </x-settings>
</x-master>

@foreach ($filieres as $filiere)
<div class="modal fade" id="updateModal{{$filiere->id}}" tabindex="-1" aria-labelledby="updateModalLabel{{$filiere->id}}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel{{$filiere->id}}">Update Filière</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('updateFiliere', $filiere->id)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nom_filier{{$filiere->id}}" class="form-label">Nom de filière</label>
                        <input type="text" class="form-control border" style="padding: 5px;" id="nom_filier{{$filiere->id}}" name="nom_filier" value="{{$filiere->nom_filier}}">
                    </div>
                    <select class="form-select border mb-3"  style="padding:5px" aria-label="Select niveau de formation" name="niveau_formation">
                       <option value="{{$filiere->niveau_formation}}">{{$filiere->niveau_formation}}</option>
                       <option value="TS">TECHNICIEN SPECIALISE</option>
                       <option value="T">TECHNICIEN</option>
                       <option value="Q">QUALIFICATION</option>
                       <option value="BP">BAC PRO</option>
                       <!-- Add options dynamically from your data source -->
                   </select>
                   <!-- Add select for mode de formation -->
                   <select class="form-select border me-2" style="padding:5px"  aria-label="Select mode de formation" name="mode_formation">
                       <option value="{{$filiere->mode_formation}}">{{$filiere->mode_formation}}</option>
                       <option value="FH">FORMATION HYBRIDE</option>
                       <option value="FR">FORMATION RESIDENTIELLE</option>
                       <option value="FPA">FORMATION PAR ALTERNANCE</option>
                       <!-- Add options dynamically from your data source -->
                   </select>
                </div>
                 <!-- Add select for niveau de formation -->
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

            // Append the provided HTML code to the parent container
            container.insertAdjacentHTML("afterend", `
                <form action="{{route('addFiliere')}}" method="POST" class="d-inline">
                    @csrf <!-- Include CSRF token for Laravel forms -->
                    <div class="input-group mb-3">
                        <input type="text" class="form-control border me-2" style="height: 40px; width: 200px; padding: 5px;" placeholder="Enter nom de filière" aria-label="Enter nom de filière" aria-describedby="name-addon" name="nom_filier">
                        <!-- Add select for niveau de formation -->
                        <select class="form-select border me-2" style="height: 40px; width: 200px; padding: 5px;" aria-label="Select niveau de formation" name="niveau_formation">
                            <option value="">Select niveau de formation</option>
                            <option value="TS">TECHNICIEN SPECIALISE</option>
                            <option value="T">TECHNICIEN</option>
                            <option value="Q">QUALIFICATION</option>
                            <option value="BP">BAC PRO</option>
                            <!-- Add options dynamically from your data source -->
                        </select>
                        <!-- Add select for mode de formation -->
                        <select class="form-select border me-2" style="height: 40px; width: 200px; padding: 5px;" aria-label="Select mode de formation" name="mode_formation">
                            <option value="">Select mode de formation</option>
                            <option value="FH">FORMATION HYBRIDE</option>
                            <option value="FR">FORMATION RESIDENTIELLE</option>
                            <option value="FPA">FORMATION PAR ALTERNANCE</option>
                            <!-- Add options dynamically from your data source -->
                        </select>
                        <button style="border-top-left-radius:5px;border-bottom-left-radius:5px" class="btn btn-success me-2" type="submit" id="button-addon2">Ajouter</button>
                        <button class="btn btn-danger" style="border-top-left-radius:5px;border-bottom-left-radius:5px;" type="button" id="cancelButton">Cancel</button>
                    </div>
                </form>
            `);


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
