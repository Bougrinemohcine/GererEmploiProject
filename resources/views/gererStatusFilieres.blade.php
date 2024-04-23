<x-master title="gerer Modules">
    <x-settings widthUser="100%" widthFormateur="100%" widthFiliere="99%" widthGroupe="100%" widthSemaine="100%" widthSalle="100%" widthModule="100%">
        <div class="container">
            <div class="row">
                <div style="width: 100%; height: 60vh; overflow-y: scroll; border: 1px solid #ccc; padding: 10px;">
                    <div class="table-responsive">
                            <!-- Display Groups Related to Formateur -->
                            <h6>FILIERES:</h6>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Formateur</th>
                                            <th>FILIERE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($FormateurFilieres->groupBy('formateur_id') as $filieres)
                                        @php
                                            $formateur = $filieres->first()->formateur;
                                        @endphp
                                        <tr>
                                            <td>{{ $formateur->name }}</td>
                                            <td>
                                                @foreach ($filieres as $filiere)
                                                    <div class="d-flex" style="height: 3vh">
                                                        <div style="width:30vw">
                                                            {{ $filiere->filiere->nom_filier }}
                                                        </div>
                                                        <form style="margin-left:20px" action="{{ route('formateurFiliere.delete', $filiere->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button style="width: 85px;height:35px;" type="submit" onclick="return confirm('Voulez-Vous vraiment supprimer la filière {{$filiere->filiere->nom_filier}}   {{$filiere->id}} de {{$formateur->name}}')" class="btn btn-danger">Delete</button>
                                                        </form>

                                                    </div>
                                                    <br>
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                    </div>

                </div>

            </div>
        </div>
    </x-settings>
</x-master>
