<x-master title="emplois_formateurs">
    @php
            $jours = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'];
            $seances_order = ['s1', 's2', 's3', 's4'];
            $seanceorder = 's5';
    @endphp
    <style>
        /* Custom styles for the table */
        .custom-table {
            color: black;
        }

        .custom-table th,
        .custom-table td {
            border: 1px solid black;
            color: black;
        }
    </style>

    <div class="row">
        <div class="col-md-4">
            <form id="dateForm" action="{{ route('backup') }}" method="get" class="mb-3">
                <label for="selected_date" class="form-label">Select Date:</label>
                <select name="selected_date" id="selected_date" class="form-select border border-dark p-2 cursor-pointer" onchange="this.form.submit()">
                    @foreach ($emplois as $emploi)
                        <option value="{{ $emploi->date_debu }}" {{ $selectedDate === $emploi->date_debu ? 'selected' : '' }}>
                            {{ $emploi->date_debu }}
                        </option>
                    @endforeach
                </select>
                <!-- Add hidden input to hold the selectedType value -->
                <input type="hidden" name="selected_type" value="{{ $selectedType }}">
                <input type="hidden" name="selected_cdj_cds" value="{{ $selectedCDJ }}">
            </form>
        </div>

        <div class="col-md-4">
            <form id="typeForm" action="{{ route('backup') }}" method="GET">
                <label for="selected_type" class="form-label">Select Type:</label>
                <select name="selected_type" id="selected_type" class="form-select border border-dark p-2 cursor-pointer pr-1" onchange="this.form.submit()">
                    <option value="emploi_formateur" {{ $selectedType === 'emploi_formateur' ? 'selected' : '' }}>Emploi Formateur</option>
                    <option value="emploi_groupe" {{ $selectedType === 'emploi_groupe' ? 'selected' : '' }}>Emploi Groupe</option>
                </select>
                <!-- Pass the selected date as a hidden input -->
                <input type="hidden" name="selected_date" value="{{ $selectedDate }}">
                <input type="hidden" name="selected_cdj_cds" value="{{ $selectedCDJ }}">
            </form>
        </div>
        <div class="col-md-4">
            <form id="cdjCdsForm" action="{{ route('backup') }}" method="get" class="mb-3">
                <label for="selected_cdj_cds" class="form-label">Select CDJ or CDS:</label>
                <select name="selected_cdj_cds" id="selected_cdj_cds" class="form-select border border-dark p-2 cursor-pointer pr-1" onchange="this.form.submit()">
                    <option value="CDJ" {{ $selectedCDJ === 'CDJ' ? 'selected' : '' }}>CDJ</option>
                    <option value="CDS" {{ $selectedCDJ === 'CDS' ? 'selected' : '' }}>CDS</option>
                </select>
                <input type="hidden" name="selected_date" value="{{ $selectedDate }}">
                <input type="hidden" name="selected_type" value="{{ $selectedType }}">
            </form>
        </div>
    </div>


        <div>
            @if ($selectedType === 'emploi_formateur')
                @if ($selectedCDJ === 'CDJ')
                    <table class="table border border-info ">
                        <thead>
                            <tr>
                                <th rowspan="2" class="border border-info bg-grey text-black">Formateur</th>
                                @foreach ($jours as $jour)
                                    <th colspan="4" class="border border-info text-black">{{ $jour }}</th>
                                @endforeach
                            </tr>
                            <tr>
                                @foreach ($jours as $jour)
                                    @foreach ($seances_order as $seance_order)
                                            @php
                                                if ($seance_order == 's1') {
                                                    $order_seance = '8H30 à 10H45';
                                                }elseif ($seance_order == 's2') {
                                                    $order_seance = '11H00 à 13H30';
                                                }elseif ($seance_order == 's3') {
                                                    $order_seance = '13H30 à 16H00';
                                                }elseif ($seance_order == 's4') {
                                                    $order_seance = '16H00 à 18H30';
                                                }
                                            @endphp
                                        <th rowspan="2" class="border border-info fs-7 text-black">{{$order_seance}}</th>
                                    @endforeach
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
                                            @if ($seance)
                                                <td class="cellule text-info border border-info"
                                                    style="background-color: {{ $seance ? 'white' : '' }}; text-align:center;">
                                                    <span>{{ $seance->groupe->nom_groupe }}</span> <br>
                                                    <span>{{ $seance->type_seance }}</span> <br>
                                                    @if ($seance->salle)
                                                        <span>{{ $seance->salle->nom_salle }}</span>
                                                    @else
                                                        <span>SALLE</span>
                                                    @endif
                                                </td>
                                            @else
                                                <td class="cellule border border-info"
                                                    style="background-color: {{ $seance ? 'white' : '' }}; text-align:center;">
                                                </td>
                                            @endif
                                            <!-- form_qui_ajouter_un_seance -->
                                        @endforeach
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @elseif ( $selectedCDJ === 'CDS')
                    <table class="table border border-info ">
                        <thead>
                            <tr>
                                <th rowspan="2" class="border border-info bg-grey text-black">Formateur</th>
                                @foreach ($jours as $jour)
                                    <th colspan="1" class="border border-info text-black">{{ $jour }}</th>
                                @endforeach
                            </tr>

                            <tr>
                                @foreach ($jours as $jour)
                                    @php
                                        if ($seanceorder == 's5') {
                                            $order_seance = '19H00 à 21H00';
                                        }
                                    @endphp
                                    <th rowspan="2" class="border border-info fs-7 text-black">{{$order_seance}}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="border border-info">
                            @foreach ($formateurs->where('CDS','oui') as $formateur)
                                <tr>
                                    <td class="border border-info fs-5 text-black font-weight-bold">{{ $formateur->name }}</td>
                                    @foreach ($jours as $jour)
                                            @php
                                                $seance = $seances->first(function ($item) use ($jour, $order_seance, $formateur) {
                                                    return $item->day === $jour &&
                                                        $item->order_seance === $order_seance &&
                                                        $item->id_formateur == $formateur->id;
                                                });
                                            @endphp
                                            @if ($seance)
                                                <td class="cellule text-info border border-info"
                                                    style="background-color: {{ $seance ? 'white' : '' }}; text-align:center;">
                                                    <span>{{ $seance->groupe->nom_groupe }}</span> <br>
                                                    <span>{{ $seance->type_seance }}</span> <br>
                                                    @if ($seance->salle)
                                                        <span>{{ $seance->salle->nom_salle }}</span>
                                                    @else
                                                        <span>SALLE</span>
                                                    @endif
                                                </td>
                                            @else
                                                <td class="cellule border border-info"
                                                    style="background-color: {{ $seance ? 'white' : '' }}; text-align:center;">
                                                </td>
                                            @endif
                                            <!-- form_qui_ajouter_un_seance -->
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            @elseif ($selectedType === 'emploi_groupe')
                @if ($selectedCDJ === 'CDJ')
                    <table class="table border border-info">
                        <thead>
                            <tr >
                                <th rowspan="2" class="border border-info text-black">Groupe</th>
                                @foreach($jours as $jour)
                                    <th colspan="4" class="border border-info text-black">{{$jour}}</th>
                                @endforeach
                            </tr>
                            <tr>
                                @foreach ($jours as $jour)
                                    @foreach ($seances_order as $seance_order)
                                        @php
                                            if ($seance_order == 's1') {
                                                $order_seance = '8H30 à 10H45';
                                            }elseif ($seance_order == 's2') {
                                                $order_seance = '11H00 à 13H30';
                                            }elseif ($seance_order == 's3') {
                                                $order_seance = '13H30 à 16H00';
                                            }elseif ($seance_order == 's4') {
                                                $order_seance = '16H00 à 18H30';
                                            }
                                        @endphp
                                        <th rowspan="2" class="border border-info fs-7 text-black">{{$order_seance}}</th>
                                    @endforeach
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($groupes->where('Mode_de_formation','CDS') as $groupe)
                                <tr>
                                    <td class="border border-info fs-5 text-black font-weight-bold">{{ $groupe->nom_groupe }}</td>
                                    @foreach ($jours as $jour)
                                        @foreach ($seances_order as $seance_order)
                                            @php
                                                $seance = $seances->first(function($item) use ($jour, $seance_order, $groupe) {
                                                    return $item->day === $jour && $item->order_seance === $seance_order && $item->id_groupe == $groupe->id;
                                                });
                                            @endphp
                                            @if($seance)
                                                <td class="cellule text-info border border-info" style="background-color: {{ $seance ? 'white' : '' }}; text-align:center;">
                                                    <span>{{ $seance->formateur->name }} </span>
                                                    {{-- <span>{{ $seance->type_seance }}</span> <br> --}}
                                                    @if ($seance->salle)
                                                        / <span>{{ $seance->salle->nom_salle }}</span>
                                                    @endif
                                                    @if ($seance->type_seance == 'team')
                                                    / <span>FAD</span>
                                                    @endif
                                                </td>
                                            @else
                                                <td class="cellule text-info border border-info" style="background-color: {{ $seance ? 'white' : '' }}; text-align:center;">
                                                </td>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @elseif ($selectedCDJ === 'CDS')
                    <table class="table border border-info">
                        <thead>
                            <tr >
                                <th rowspan="2" class="border border-info text-black">Groupe</th>
                                @foreach($jours as $jour)
                                    <th colspan="1" class="border border-info text-black">{{$jour}}</th>
                                @endforeach
                            </tr>
                            <tr>
                                @foreach ($jours as $jour)
                                    @php
                                        if ($seanceorder == 's5') {
                                            $order_seance = '19H00 à 21H00';
                                        }
                                    @endphp
                                    <th rowspan="2" class="border border-info fs-7 text-black">{{$order_seance}}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($groupes->where('Mode_de_formation','CDS') as $groupe)
                                <tr>
                                    <td class="border border-info fs-5 text-black font-weight-bold">{{ $groupe->nom_groupe }}</td>
                                    @foreach ($jours as $jour)
                                            @php
                                                $seance = $seances->first(function($item) use ($jour, $order_seance, $groupe) {
                                                    return $item->day === $jour && $item->order_seance === $order_seance && $item->id_groupe == $groupe->id;
                                                });
                                            @endphp

                                            @if($seance)
                                                <td class="cellule text-info border border-info" style="background-color: {{ $seance ? 'white' : '' }}; text-align:center;">
                                                    <span>{{ $seance->formateur->name }} </span>
                                                    {{-- <span>{{ $seance->type_seance }}</span> <br> --}}
                                                    @if ($seance->salle)
                                                        / <span>{{ $seance->salle->nom_salle }}</span>
                                                    @endif
                                                    @if ($seance->type_seance == 'team')
                                                    / <span>FAD</span>
                                                    @endif
                                                </td>
                                            @else
                                                <td class="cellule text-info border border-info" style="background-color: {{ $seance ? 'white' : '' }}; text-align:center;">
                                                </td>
                                            @endif
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            @endif
        </div>
</x-master>
