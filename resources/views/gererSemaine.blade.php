<x-master title="Formateur">
    <x-settings widthUser="100%" widthFormateur="100%" widthFiliere="100%" widthGroupe="100%" widthSemaine="99%" widthSalle="100%">
        <div class="container">
            <div class="row">
                <div style="width: 100%; height: 60vh; overflow-y: scroll; border: 1px solid #ccc; padding: 10px;">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Date Debut</th>
                                <th scope="col">Date Fin</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($emplois as $emploi)
                            <tr>
                                <td>{{$emploi->id}}</td>
                                <td>{{$emploi->date_debu}}</td>
                                <td>{{$emploi->date_fin}}</td>
                                <td>
                                    <div class="d-flex">
                                        <a href="#" type="button" class="btn btn-info me-2">Confirmer</a>{{--{{route('showUpdateFormateur',$emploi->id)}}--}}
                                        <form action="{{route('deleteSemaine')}}" method="post">{{--{{route('deleteFormateur',$emploi->id)}}--}}
                                            @csrf
                                            <input type="text" value="{{$emploi->id}}" name="id"hidden>
                                            <button onclick="return confirm('Voulez Vous vraiment Supprimer cette semaine?')" type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </x-settings>
</x-master>
