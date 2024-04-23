<x-master title="gerer Modules">
    <x-settings widthUser="100%" widthFormateur="100%" widthFiliere="100%" widthGroupe="100%" widthSemaine="100%" widthSalle="100%" widthModule="99%">
        <div class="container">
            <div class="row">
                <div style="width: 100%; height: 60vh; overflow-y: scroll; border: 1px solid #ccc; padding: 10px;">
                    <div class="table-responsive">
                            <!-- Display Groups Related to Formateur -->
                            <h6>MODULES:</h6>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Formateur</th>
                                            <th>Module</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($FormateurModules->groupBy('formateur_id') as $formateurId => $modules)
                                            @php
                                                $formateur = $modules->first()->formateur;
                                            @endphp
                                            <tr>
                                                <td>{{ $formateur->name }}</td>
                                                <td>
                                                    @foreach ($modules as $module)
                                                        <div class="d-flex" style="height: 3vh">
                                                            <div style="width:30vw">
                                                                {{ $module->module->nom_module }}
                                                            </div>
                                                            @if ($module->status === 'oui')
                                                                <form style="margin-left:20px" action="{{ route('formateurModule.changeStatus', $module->id) }}" method="POST">
                                                                    @csrf
                                                                    <button style="width: 110px;height:35px;" type="submit" class="btn btn-danger">Deactivate</button>
                                                                </form>
                                                            @else
                                                                <form style="margin-left:20px" action="{{ route('formateurModule.changeStatus', $module->id) }}" method="POST">
                                                                    @csrf
                                                                    <button style="width: 110px;height:35px;" type="submit" class="btn btn-success">Activate</button>
                                                                </form>
                                                            @endif
                                                            <form style="margin-left:20px" action="{{ route('formateurModule.delete', $module->id) }}" method="POST">

                                                                @csrf
                                                                @method('DELETE')
                                                                <button style="width: 85px;height:35px;" type="submit" onclick="return confirm('Voulez-Vous vraiment supprimer le module {{$module->module->nom_module}} de {{$formateur->name}}')" class="btn btn-danger">Delete</button>
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
