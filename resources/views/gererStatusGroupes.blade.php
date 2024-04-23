<x-master title="gerer Modules">
    <x-settings widthUser="100%" widthFormateur="100%" widthFiliere="100%" widthGroupe="99%" widthSemaine="100%" widthSalle="100%" widthModule="100%">
        <div class="container">
            <div class="row">
                <div style="width: 100%; height: 60vh; overflow-y: scroll; border: 1px solid #ccc; padding: 10px;">
                    <div class="table-responsive">
                            <!-- Display Groups Related to Formateur -->
                            <h6>GROUPES:</h6>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Formateur</th>
                                            <th>Module</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($FormateurGroupes->groupBy('formateur_id') as $formateurId => $groupes)
                                            @php
                                                $formateur = $groupes->first()->formateur;
                                            @endphp
                                            <tr>
                                                <td>{{ $formateur->name }}</td>
                                                <td>
                                                    @foreach ($groupes as $groupe)
                                                        <div class="d-flex" style="height: 3vh">
                                                            <div style="width:30vw">
                                                                {{ $groupe->groupe->nom_groupe }}
                                                            </div>
                                                            <form style="margin-left:20px" action="{{ route('formateurGroupe.delete', $groupe->id) }}" method="POST">

                                                                @csrf
                                                                @method('DELETE')
                                                                <button style="width: 85px;height:35px;" type="submit" onclick="return confirm('Voulez-Vous vraiment supprimer le groupe {{$groupe->groupe->nom_groupe}} de {{$formateur->name}}')" class="btn btn-danger">Delete</button>
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
