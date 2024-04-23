@php
$jours=['lundi','mardi','mercredi','jeudi','vendredi','samedi'];
$part_of_day=['Matin','A.Midi'];
$seances_order=['s1','s2','s3','s4'];
@endphp
<style>
    td{
        cursor: pointer;
    }
</style>
<table class="table border border-info">
    <thead>
        <tr >
            <th rowspan="3" class="border border-info text-black">Groupe</th>
            @foreach($jours as $jour)
                <th colspan="4" class="border border-info text-black">{{$jour}}</th>
            @endforeach
        </tr>
        <tr>
            @foreach ($jours as $jour)
                @foreach($part_of_day as $part)
                    <th colspan="2" class="border border-info text-black">{{$part}}</th>
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
    <tbody>
        @foreach ($groupes as $groupe)
            <tr>
                <td class="border border-info fs-5 text-black font-weight-bold">{{ $groupe->nom_groupe }}</td>
                @foreach ($jours as $jour)
                    @foreach ($seances_order as $seance_order)
                        @php
                            $seance = $seances->first(function($item) use ($jour, $seance_order, $groupe) {
                                return $item->day === $jour && $item->order_seance === $seance_order && $item->id_groupe == $groupe->id;
                            });
                        @endphp
                        @php
                            $modalId_update = $jour.'_'. $seance_order . '_' .$groupe->id.'_'."update";
                            $modalId_ajouter = $jour.'_'. $seance_order . '_' .$groupe->id.'_'."ajouter";
                        @endphp
                        @if($seance)
                            <td class="cellule text-info border border-info" id="#{{$modalId_update}}" style="background-color: {{ $seance ? 'white' : '' }}; text-align:center;" data-toggle="modal" data-target="#{{$modalId_update}}">
                                <span>{{ $seance->formateur->name }} {{ $seance->formateur->prenom }}</span> <br>
                                <span>{{ $seance->type_seance }}</span> <br>
                                <span>{{ $seance->salle->nom_salle }}</span>
                            </td>
                        @else
                            <td class="cellule text-info border border-info" id="#{{$modalId_ajouter}}" style="background-color: {{ $seance ? 'white' : '' }}; text-align:center;" data-toggle="modal" data-target="#{{$modalId_ajouter}}">
                            </td>
                        @endif
                        @include('includes.modalGroupeSeance')
                    @endforeach
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const main = document.querySelector('.main-content');

    // Check if scroll position is stored in localStorage
    const storedScrollPosition = JSON.parse(localStorage.getItem('scrollPosition'));

    // Scroll to the stored position if available
    if (storedScrollPosition) {
        main.scrollTo(storedScrollPosition.x, storedScrollPosition.y);
    }

    // Store scroll position when the scroll event occurs
    main.addEventListener('scroll', function () {
        const scrollPosition = {
            x: main.scrollLeft,
            y: main.scrollTop
        };
        localStorage.setItem('scrollPosition', JSON.stringify(scrollPosition));
    });
});
</script>
