<x-master title="salles">
    <!-- Add a select dropdown for CDJ and CDS -->
    @php
    $seances_order = ['s1','s2','s3','s4'];
    $seanceorder = 's5';
    $jours = ['lundi','mardi','mercredi','jeudi','vendredi','samedi'];
    @endphp
 <select id="tableSelector" style="padding: 8px 12px; font-size: 16px; border: 2px solid #ccc; border-radius: 5px; background-color: #f9f9f9;">
    <option value="cdj">CDJ</option>
    <option value="cds">CDS</option>
</select>


    <!-- Wrap each table with a div and give them unique IDs -->
    <div id="cdjTable" style="display: none;">
        <table class="table border border-dark border-4">
            <!-- CDJ Table content -->
            <tr>
                <th class="text-black border-4" style="text-align:center" colspan="2">HEURE</th>
                @foreach ($seances_order as $seance_order)
                    <th rowspan="2" class="border border-dark bg-grey text-black border-4">{{$seance_order}}</th>
                @endforeach
            </tr>
            <tr>
                <th class="border border-dark bg-grey text-black border-4">JOUR</th>
                <th class="border border-dark bg-grey text-black border-4">SALLES</th>
            </tr>
            <!-- Loop through the days -->
            @foreach($jours as $jour)
                <!-- Loop through the rooms -->
                @php
                    $sallesCount = count($salles);
                    $firstsalles = $salles->first();
                @endphp
                @foreach($salles as $salle)
                    <tr>
                        <!-- For the first room of each day, add the rowspan for the room cell -->
                        @if($salle->id === $firstsalles->id && $loop->first)
                            <td rowspan="{{ $sallesCount }}" class="border border-dark bg-grey text-black border-4">{{ $jour }}</td>
                        @endif
                        <td rowspan="1" class="border border-dark bg-grey text-black border-4">{{ $salle['nom_salle'] }}</td>

                        @foreach ($seances_order as $seance_order)
                            @php
                                $seances_filtered = $seances->filter(function($item) use ($jour, $seance_order, $salle) {
                                    return $item->day === $jour && $item->order_seance === $seance_order && $item->id_salle == $salle->id;
                                });
                            @endphp

                            <!-- Check if there are sessions for the current criteria -->
                            @if ($seances_filtered->isNotEmpty())
                                <!-- Get the first session to display formateur and groups -->
                                @php
                                    $seance = $seances_filtered->first();
                                @endphp
                                <td class="v cellule text-black border border-dark" style="background-color: white; text-align:center;">
                                    <span>{{ $seance->formateur->name }}</span> <br>
                                    @foreach ($seances_filtered as $seance_group)
                                        <span>{{ $seance_group->groupe->nom_groupe }} </span>
                                    @endforeach
                                </td>
                            @else
                                <!-- If no sessions for the current criteria, display empty cell -->
                                <td class="v cellule text-black border border-dark" style="background-color: white; text-align:center;"></td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            @endforeach
        </table>

    </div>

    <div id="cdsTable" style="display: none;">
        <table class="table border border-dark border-4">
            <!-- CDS Table content -->
            <tr>
                <th class="text-black border-4" style="text-align:center" colspan="2">HEURE</th>
                <th rowspan="2" class="border border-dark bg-grey text-black border-4">{{$seanceorder}}</th>
            </tr>
            <tr>
                <th class="border border-dark bg-grey text-black border-4">JOUR</th>
                <th class="border border-dark bg-grey text-black border-4">GROUPE</th>
            </tr>
            <!-- Loop through the days -->
            @foreach($jours as $jour)
            <!-- Loop through the groups -->
                @php
                $sallesCount = count($salles);
                $firstSalle = $salles->first();
                @endphp
                @foreach($salles as  $salle)
                    <tr>
                        <!-- For the first group of each day, add the rowspan for the day cell -->
                        @if($salle->id === $firstSalle->id)
                        <td rowspan="{{ $sallesCount }}" class="border border-dark bg-grey text-black border-4">{{ $jour }}</td>
                        @endif
                        <td rowspan="1" class="border border-dark bg-grey text-black border-4">{{ $salle['nom_salle'] }}</td>

                        @php
                            $seances_filtered = $seances->filter(function($item) use ($jour, $seanceorder, $salle) {
                                return $item->day === $jour && $item->order_seance === $seanceorder && $item->id_salle == $salle->id;
                            });
                        @endphp

                        <!-- Check if there are sessions for the current criteria -->
                        @if ($seances_filtered->isNotEmpty())
                            <!-- Get the first session to display formateur and groups -->
                            @php
                                $seance = $seances_filtered->first();
                            @endphp
                            <td class="v cellule text-black border border-dark" style="background-color: white; text-align:center;">
                                <span>{{ $seance->formateur->name }}</span> <br>
                                @foreach ($seances_filtered as $seance_group)
                                    <span>{{ $seance_group->groupe->nom_groupe }} </span>
                                @endforeach
                            </td>
                        @else
                            <!-- If no sessions for the current criteria, display empty cell -->
                            <td class="v cellule text-black border border-dark" style="background-color: white; text-align:center;"></td>
                        @endif
                    </tr>
                @endforeach
            @endforeach
        </table>
    </div>

    <!-- Your PHP and HTML code continues... -->

</x-master>

<!-- Include jQuery library -->
<!-- Include jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- JavaScript/jQuery code to show/hide tables based on selection -->
<script>
    $(document).ready(function(){
        // Show CDJ table by default
        $('#cdjTable').show();
        $('#cdsTable').hide();

        // Change event for table selector
        $('#tableSelector').change(function(){
            var selectedOption = $(this).val();
            if(selectedOption === 'cdj') {
                $('#cdjTable').show();
                $('#cdsTable').hide();
            } else if(selectedOption === 'cds') {
                $('#cdjTable').hide();
                $('#cdsTable').show();
            }
        });
    });
</script>
