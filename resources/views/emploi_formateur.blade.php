@php
$jours = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'];
$seances_order = ['s1', 's2', 's3', 's4'];
$seanceorder = 's5'
@endphp
<x-master title="emplois_formateurs">
    
    <div style="max-height: auto; max-width: 100vw; border-radius: 10px; padding: 10px; font-size: small;margin-top:-45px">
            <form class="d-flex" action="{{route('emploi_formateur')}}" method="get">
                <select id="formateurSelect" name="formateur_id" class="form-select mb-3" aria-label="Default select example"  onchange="this.form.submit()">
                    <option value="">Choisissez un formateur</option>
                    @foreach($formateurs as $formateur)
                        <option value="{{$formateur->id}}" {{ $selectedFormateur && $selectedFormateur->id == $formateur->id ? 'selected' : '' }}>
                            {{$formateur->name}} {{$formateur->prenom}}
                        </option>
                    @endforeach
                </select>
                @if($selectedFormateur && $selectedFormateur->CDS == 'oui')
                    <select id="TypeEmploi" name="TypeEmploi" class="form-select mb-3 ms-2" aria-label="Default select example" onchange="this.form.submit()">
                        <option value="">Choisissez un Type</option>
                        <option value="CDJ" {{ 'CDJ' == $TypeEmploi ? 'selected' : '' }}>CDJ</option>
                        <option value="CDS" {{ 'CDS' == $TypeEmploi ? 'selected' : '' }}>CDS</option>
                    </select>
                @elseif($selectedFormateur && $selectedFormateur->CDS == 'non')
                    <select id="TypeEmploi" name="TypeEmploi" class="form-select mb-3 ms-2" aria-label="Default select example" onchange="this.form.submit()">
                        <option value="">Choisissez un Type</option>
                        <option value="CDJ" {{ 'CDJ' == $TypeEmploi ? 'selected' : '' }}>CDJ</option>
                    </select>
                @endif
            </form>
            <style>
                .s{
                    border-bottom: 1px solid black !important;
                }
                .export-hidden {
                        display: none;
                    }
            </style>

        <!-- Display the selected formateur's row -->
            @if($selectedFormateur)
                @if ($TypeEmploi == 'CDJ')
                    @include('includes.emploiCDJ_Formateur')
                    <button class="btn btn-success" onclick="ExportToExcel('xlsx')">Export to excel</button>
                @elseif ($TypeEmploi == 'CDS')
                    @include('includes.emploiCDS_Formateur')
                    <button class="btn btn-success" onclick="ExportToExcel('xlsx')">Export to excel</button>
                @else
                    @include('includes.emploiCDJ_Formateur')
                    @if($selectedFormateur && $selectedFormateur->CDS == 'oui')
                        @include('includes.emploiCDS_Formateur')
                    @endif
                    <button class="btn btn-success" onclick="ExportToExcel('xlsx')">Export to excel</button>
                @endif
            @endif
        </div>
</x-master>
<script>
    function ExportToExcel(type) {
        @if($selectedFormateur)
            var formateurName = "{{ $selectedFormateur->name }}";
            @if($TypeEmploi == 'CDJ')
                var eltCDJ = document.getElementById('emploiTable');
                var wbCDJ = XLSX.utils.table_to_book(eltCDJ, { sheet: "CDJ" });

                // Check if CDS table exists
                var eltCDS = document.getElementById('emploiTable1');
                if (eltCDS) {
                    var wbCDS = XLSX.utils.table_to_book(eltCDS, { sheet: "CDS" });

                    // Merge CDJ and CDS sheets into one workbook
                    var wb = XLSX.utils.book_new();
                    XLSX.utils.book_append_sheet(wb, wbCDJ.Sheets['CDJ'], 'CDJ');
                    XLSX.utils.book_append_sheet(wb, wbCDS.Sheets['CDS'], 'CDS');
                    XLSX.writeFile(wb, formateurName + '_CDJ_CDS.xlsx');
                } else {
                    // If CDS table doesn't exist, export only CDJ data
                    XLSX.writeFile(wbCDJ, formateurName + '_CDJ.xlsx');
                }
            @elseif($TypeEmploi == 'CDS' && $selectedFormateur->CDS == 'oui')
                var eltCDS = document.getElementById('emploiTable1');
                var wbCDS = XLSX.utils.table_to_book(eltCDS, { sheet: "CDS" });
                XLSX.writeFile(wbCDS, formateurName + '_CDS.xlsx');
            @else
                // If no employment type is selected and formateur has CDS, export both CDJ and CDS data
                var eltCDJ = document.getElementById('emploiTable');
                var wbCDJ = XLSX.utils.table_to_book(eltCDJ, { sheet: "CDJ" });

                var eltCDS = document.getElementById('emploiTable1');
                var wbCDS = XLSX.utils.table_to_book(eltCDS, { sheet: "CDS" });

                var wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, wbCDJ.Sheets['CDJ'], 'CDJ');
                XLSX.utils.book_append_sheet(wb, wbCDS.Sheets['CDS'], 'CDS');
                XLSX.writeFile(wb, formateurName + '_CDJ_CDS.xlsx');
            @endif
        @endif
    }
</script>
