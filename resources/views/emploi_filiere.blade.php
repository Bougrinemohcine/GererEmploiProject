<x-master title="emplois_groupes">
    <style>
            .s {
                border-bottom: 1px solid black !important;
            }

            .d {
                border-bottom: 4px solid #344767 !important;

            }

            tr.cc td:nth-last-child(-n+4) {
                border-left: none !important;
                border-right: none !important;
            }

            .v {
                border-right: 4px solid #344767 !important;
            }

            .no-left-right-border {
                border-left: none !important;
                border-right: none !important;
            }
        </style>
    @php
        $seances_order = ['s1','s2','s3','s4'];
        $seanceorder = 's5';
        $jours = ['lundi','mardi','mercredi','jeudi','vendredi','samedi'];
        if ($selectTypeEmploi) {
            # code...
            $filiere = $filieres->where('id', $selectTypeEmploi)->pluck('nom_filier')->first();

        } else {
            # code...
            $filiere = 'myEmploi';
        }
    @endphp

    <div style="overflow-x: auto; overflow-y: auto; max-height: 85vh;border-radius:10px">
        <form id="filiereForm" action="{{ route('emploi_filiere') }}" method="get">

            <select id="selectTypeEmploi" name="TypeEmploi" class="form-select" style="margin-bottom: 10px;" onchange="this.form.submit()">
                <option value="">Choose a Type</option>
                    <option value="CDJ" {{'CDJ' == $selectTypeEmploi ? 'selected' : ''}}>CDJ</option>
                    <option value="CDS" {{'CDS' == $selectTypeEmploi ? 'selected' : ''}}>CDS</option>
            </select>

            <select id="selectFiliere" name="filiere_id" class="form-select" style="margin-bottom: 10px;" onchange="this.form.submit()">
                <option value="">Choose a filiere</option>
                @foreach($filieres as $filiere)
                    <option value="{{$filiere->id}}" {{$filiere->id == $selectedFiliereId ? 'selected' : ''}}>{{$filiere->nom_filier}}</option>
                @endforeach
            </select>

            <select id="selectNiveau" name="niveau" class="form-select" style="margin-bottom: 10px;" onchange="this.form.submit()">
                <option value="">Choose a niveau</option>
                @foreach($niveaux as $niveau)
                    <option value="{{$niveau}}" {{$niveau == $selectedNiveauId ? 'selected' : ''}}>{{$niveau}}</option>
                @endforeach
            </select>
        </form>
        <style>
            .s{
                border-bottom: 1px solid black !important;
            }
            .d{
                border-bottom:  4px solid #344767 !important;

            }
        </style>
    </div>

        @if ($selectedFiliereId)
            @if ($selectTypeEmploi == 'CDJ')
                @include('includes.emploiCDJ_Filiere')
                <button class="btn btn-success" onclick="ExportToExcel('xlsx')">Export to excel</button>
            @elseif ($selectTypeEmploi == 'CDS')
                    @include('includes.emploiCDS_Filiere')
                    <button class="btn btn-success" onclick="ExportToExcel('xlsx')">Export to excel</button>
            @else
                    @include('includes.emploiCDJ_Filiere')
                @if ($groupes->where('Mode_de_formation','CDS')->isNotEmpty())
                    @include('includes.emploiCDS_Filiere')
                @endif
                <button class="btn btn-success" onclick="ExportToExcel('xlsx')">Export to excel</button>
            @endif
        @endif
</x-master>

<script>
    function ExportToExcel(type) {
        var elt = document.getElementById('emploiTable');
        var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
        XLSX.writeFile(wb, 'CDJ(Filiere).xlsx');

        var elt1 = document.getElementById('emploiTable1');
        var wb1 = XLSX.utils.table_to_book(elt1, { sheet: "sheet1" });
        XLSX.writeFile(wb1, 'CDS(Filiere).xlsx');
    }
    document.addEventListener('DOMContentLoaded', function() {
        const main = document.querySelector('.main-content');

        // Check if scroll position is stored in localStorage
        const storedScrollPosition = JSON.parse(localStorage.getItem('scrollPosition'));

        // Scroll to the stored position
        if (storedScrollPosition) {
            main.scrollTo(storedScrollPosition.x, storedScrollPosition.y);
        }

        // Store scroll position when the scroll event occurs
        main.addEventListener('scroll', function() {
            const scrollPosition = {
                x: main.scrollLeft,
                y: main.scrollTop
            };
            localStorage.setItem('scrollPosition', JSON.stringify(scrollPosition));
        });
    });
</script>
