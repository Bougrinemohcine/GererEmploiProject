@php
    $jours = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'];
    $part_of_day = ['Matin', 'A.Midi'];
    $seances_order = ['s1', 's2', 's3', 's4'];
@endphp
<style>
    td {
        cursor: pointer;
    }
</style>
<table class="table border border-dark ">
    <thead>
        <tr>
            <th rowspan="3" class="border border-info bg-grey text-black">Formateur</th>
            @foreach ($jours as $jour)
                <th colspan="4" class="border border-info text-black">{{ $jour }}</th>
            @endforeach
        </tr>
        <tr>
            @foreach ($jours as $jour)
                @foreach ($part_of_day as $part)
                    <th colspan="2" class="border border-info text-black">{{ $part }}</th>
                @endforeach
            @endforeach
        </tr>
        <tr>
            @foreach ($jours as $jour)
                <th class="border border-info text-black">s1</th>
                <th class="border border-info text-black">s2</th>
                <th class="border border-info text-black">s3</th>
                <th class="border border-info text-black">s4</th>
            @endforeach
        </tr>
    </thead>
    <tbody class="border border-info">
        @foreach ($formateurs as $formateur)
            <tr>
                <td class="border border-info fs-5 text-black font-weight-bold">{{ $formateur->name }}</td>
                @foreach ($jours as $jour)
                    @foreach ($seances_order as $seance_order)
                        @php
                            $seance = $seances->first(function ($item) use ($jour, $seance_order, $formateur) {
                                return $item->day === $jour &&
                                    $item->order_seance === $seance_order &&
                                    $item->id_formateur == $formateur->id;
                            });
                        @endphp
                        @php
                            $modalId_update = $jour . '' . $seance_order . '' . $formateur->id . '_' . 'update';
                            $modalId_ajouter = $jour . '' . $seance_order . '' . $formateur->id . '_' . 'ajouter';
                        @endphp
                        @if ($seance)
                            <td  class="cellule text-info border border-info" id="#{{ $modalId_update }}"
                                style="background-color: {{ $seance ? 'white' : '' }}; text-align:center;"
                                data-toggle="modal" data-target="#{{ $modalId_update }}">
                                <span>{{ $seance->groupe->nom_groupe }}</span> <br>
                                <span>{{ $seance->type_seance }}</span> <br>
                                <span>{{ $seance->salle->nom_salle }}</span>
                            </td>
                        @else
                            <!-- Button trigger modal -->
                        <td  class="cellule text-info border border-info" data-toggle="modal" data-target="#{{$modalId_ajouter}}">
                        </td>
                        @endif
                         <!-- Modal -->
                       <!-- form_qui_ajouter_un_seance -->
<div class="modal fade" id="{{ $modalId_ajouter }}" tabindex="-1"aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $seance_order }}</h1>
                <button type="button" class="btn-close" data-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('ajouter_seance') }}" method="post">
                    @csrf
                    <input class="day" name="day" type="text" hidden value="{{ $jour }}">
                    <input name="id_emploi" type="text" hidden value="{{ $id_emploi }}">
                    <input class="order_seance" name="order_seance" type="text" hidden
                        value="{{ $seance_order }}">
                    <input name="id_formateur" type="text" hidden
                        value="{{ $formateur->id }}">
                    <select class="form-select schoolYearSelect" style="margin-bottom:10px;"
                        aria-label="Default select example">
                        <option selected value="">choisissez une année</option>
                        <option value="1">Premier cycle</option>
                        <option value="2">Deuxième cycle</option>
                        <option value="3">Troisième cycle</option>
                    </select>
                    <!-- HTML code: Add filiere select -->
                    <select class="form-select filiereSelect" style="margin-bottom:10px;"
                        aria-label="Default select example">
                        <option selected value="">Choose a filiere</option>
                        @foreach ($filieres as $filier)
                            <option value="{{ $filier->id }}">{{ $filier->nom_filier }}
                            </option>
                        @endforeach
                    </select>

                    <select name="id_groupe" class="form-select groupSelect"
                        style="margin-bottom:10px;" aria-label="Default select example">
                        <option selected value="">choisissez un groupe</option>
                        @foreach ($groupes as $groupe)
                            @php
                                $groupe_deja_occupe = $groupe->seance
                                    ->where('id_emploi', $id_emploi)
                                    ->where('day', $jour)
                                    ->where('order_seance', $seance_order);
                                $groupe_has_no_seance = $groupe->seance->isEmpty();
                            @endphp
                            @if ($groupe_deja_occupe->count() == 0 || $groupe_has_no_seance)
                                <option value="{{ $groupe->id }}">
                                    {{ $groupe->nom_groupe }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                    <select name="id_salle" class="form-select" style="margin-bottom:10px;"
                        aria-label="Default select example">
                        <option selected value="">choisissez la salle</option>
                        @foreach ($salles as $salle)
                            @php
                                $salle_occupe = $salle->seance
                                    ->where('id_emploi', '==', $id_emploi)
                                    ->where('day', '==', $jour)
                                    ->where('order_seance', '==', $seance_order);
                                $salle_has_no_seance = $salle->seance->isEmpty();
                            @endphp
                            @if ($salle_occupe->count() === 0 || $salle_has_no_seance)
                                <option value="{{ $salle->id }}">{{ $salle->nom_salle }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                    <select name="type_seance" class="form-select" style="margin-bottom:10px;"
                        aria-label="Default select example">
                        <option selected value="">choisissez le type de la seance</option>
                        <option value="presentielle">presentielle</option>
                        <option value="team">team</option>
                        <option value="efm">efm</option>
                    </select>
                    <button type="submit" class="btn btn-primary">ajouter seance</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--form_qui_update-->
@if($seance)
    <div class="modal fade" id="{{ $modalId_update }}" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $seance_order }}
                    </h1>
                    <button type="button" class="btn-close" data-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('modifier_seance') }}" method="post">
                        @csrf
                        <input type="text" name="seance_id" value="{{ $seance->id }}"
                            hidden>
                        <select name="id_groupe" class="form-select"
                            style="margin-bottom:10px;" aria-label="Default select example">
                            <option selected value="{{ $seance->groupe->id }}">
                                {{ $seance->groupe->nom_groupe }}</option>
                            @foreach ($groupes as $groupe)
                                @php
                                    $groupe_deja_occupe = $groupe->seance
                                        ->where('id_emploi', '==', $id_emploi)
                                        ->where('day', '==', $jour)
                                        ->where('order_seance', '==', $seance_order);
                                    $groupe_has_no_seance = $groupe->seance->isEmpty();
                                @endphp
                                @if ($groupe_deja_occupe->count() == 0 || $groupe_has_no_seance)
                                    <option value="{{ $groupe->id }}">
                                        {{ $groupe->nom_groupe }}</option>
                                @endif
                            @endforeach
                        </select>
                        <select name="id_salle" class="form-select"
                            style="margin-bottom:10px;" aria-label="Default select example">
                            <option selected value="{{ $seance->salle->id }}">
                                {{ $seance->salle->nom_salle }}</option>
                            @foreach ($salles as $salle)
                                @php
                                    $salle_occupe = $salle->seance
                                        ->where('id_emploi', '==', $id_emploi)
                                        ->where('day', '==', $jour)
                                        ->where('order_seance', '==', $seance_order);
                                    $salle_has_no_seance = $salle->seance->isEmpty();
                                @endphp
                                @if ($salle_occupe->count() === 0 || $salle_has_no_seance)
                                    <option value="{{ $salle->id }}">
                                        {{ $salle->nom_salle }}</option>
                                @endif
                            @endforeach
                        </select>
                        <select name="type_seance" class="form-select"
                            style="margin-bottom:10px;" aria-label="Default select example">
                            <option value="presentielle">presentielle</option>
                            <option value="team">team</option>
                            <option value="efm">efm</option>
                        </select>
                        <button type="submit" class="btn btn-success">update</button>
                    </form>
                    <form action="{{ route('supprimer_seance') }}" method="post">
                        @csrf
                        <input type="text" name="seance_id" value="{{ $seance->id }}"
                            hidden>
                        <button type="submit" class="btn btn-danger">supprimer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif
                    @endforeach
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
