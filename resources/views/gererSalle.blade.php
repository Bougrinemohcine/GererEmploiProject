<x-master title="Salle">
    <x-settings widthUser="100%" widthFormateur="100%" widthFiliere="100%" widthGroupe="100%" widthSemaine="100%" widthSalle="99%">
        <div class="container">
            <div class="row">
                <div style="width: 100%; height: 60vh; overflow-y: scroll; border: 1px solid #ccc; padding: 10px;">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($salles as $salle)
                                <tr>
                                    <th scope="row">{{ $salle->id }}</th>
                                    <td>{{ $salle->nom_salle }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-info me-2" data-toggle="modal" data-target="#updateModal{{$salle->id}}">
                                                Update
                                            </button>
                                            <form action="{{ route('deleteSalle', $salle->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button onclick="return confirm('Voulez-vous vraiment supprimer cette salle?')" type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-12 text-center mt-3">
                    <!-- Button to trigger modal -->
                    <a  class="btn btn-success col-md-12 ajouter">Ajouter Salle</a>
                </div>
            </div>
        </div>
    </x-settings>
</x-master>

<!-- Modal -->
@foreach ($salles as $salle)
<div class="modal fade" id="updateModal{{ $salle->id }}" tabindex="-1" aria-labelledby="updateModalLabel{{ $salle->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel{{ $salle->id }}">Update Salle</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('updateSalle', $salle->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nomSalle" class="form-label">Nom Salle</label>
                        <input type="text" class="form-control border p-2" id="nomSalle" name="nom_salle" value="{{ $salle->nom_salle }}">
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
            // Hide the "Ajouter Formateur" button
            this.style.display = "none";

            // Get the parent container
            var container = document.querySelector(".col-md-12.text-center.mt-3");

            // Append the provided HTML code to the parent container
            container.insertAdjacentHTML("afterend", `
                <form action="{{ route('addSalle') }}" method="POST" class="d-inline">
                    @csrf <!-- Include CSRF token for Laravel forms -->
                    <div class="input-group mb-3">
                        <input type="text" class="form-control border me-2" style="height: 40px; width: 200px; padding: 5px;" placeholder="Enter name" aria-label="Enter name" aria-describedby="name-addon" name="nom_salle">
                        <button class="btn btn-success me-2" style="border-top-left-radius:5px;border-bottom-left-radius:5px;" type="submit" id="button-addon2">Ajouter</button>
                        <button class="btn btn-danger" style="border-top-left-radius:5px;border-bottom-left-radius:5px;" type="button" id="cancelButton">Cancel</button>
                    </div>
                </form>
            `);

            // Add event listener to the cancel button
            document.getElementById("cancelButton").addEventListener("click", function() {
                // Show the "Ajouter Formateur" button
                document.querySelector("a.ajouter").style.display = "block";
                // Remove the form
                this.parentNode.parentNode.remove(); // Remove the parent element of the cancel button (i.e., the form)
            });
        });
    });
</script>
