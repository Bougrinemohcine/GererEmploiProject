<aside
        class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-light bg-opacity-50"
        id="sidenav-main">
        <div class="sidenav-header">
        @if($dates->isEmpty())
                 <input class="must_add_emploi" hidden>
        @endif
            <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
                aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand m-0" href="{{ route('afficher_ajouter_emploi') }}">
                <img src="{{ asset('assets/masterAssets/img/iconofppt.png') }}" class="navbar-brand-img h-100"
                    alt="main_logo">
                <span class="ms-1 font-weight-bold decoration-blue-950">Gérer l'emploi</span>
            </a>
        </div>
        <hr class="horizontal light mt-0 mb-2">
        <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
            <ul class="navbar-nav overflow-y-auto" id="myNavbar">
                <li class="nav-item">
                    <a class="nav-link text-white active bg-gradient-info"
                        href="{{ route('afficher_ajouter_emploi') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Nouveau Emploi</span>
                    </a>
                </li>
                <div class="mt-2 text-center px-3"> <!-- Add 'text-center' class here -->
                    <a href="{{ route('showBackUp') }}" class="btn  w-100 {{ $path == '/backup' ? 'active  bg-gradient-info w-100 ' : 'border border-info text-info' }}">Back Up</a>
                </div>

                <li class="nav-item">
                    <!-- emploi_formateurs -->
                    <a class="nav-link decoration-blue-950 text-info {{ $path == '/emplois_formateurs' ? 'active  bg-gradient-info text-white' : '' }} nav-link-routing" href="{{ route('emplois_formateurs') }}">
                        <div class="text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10 text-info"></i>
                        </div>
                        <span class="nav-link-text ms-1">Formateurs</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-info {{ $path == '/emplois_groupes' ? 'active  bg-gradient-info text-white' : '' }} nav-link-routing" href="{{ route('emplois_groupes') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10 text-info"></i>
                        </div>
                        <span class="nav-link-text ms-1 ">Groupes</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-info {{ $path == '/emplois_formateur' ? 'active  bg-gradient-info text-white' : '' }} nav-link-routing" href="{{ route('emploi_formateur') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10 text-info"></i>
                        </div>
                        <span class="nav-link-text ms-1 ">Par Fromateur</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-info {{ $path == '/emploi_groupe' ? 'active  bg-gradient-info text-white' : '' }} nav-link-routing" href="{{ route('emploi_groupe') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10 text-info"></i>
                        </div>
                        <span class="nav-link-text ms-1 ">Par Groupe</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-info {{ $path == '/emploi_filiere' ? 'active  bg-gradient-info text-white' : '' }} nav-link-routing" href="{{ route('emploi_filiere') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10 text-info"></i>
                        </div>
                        <span class="nav-link-text ms-1 ">Par Filiere</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-info {{ $path == '/salles' ? 'active  bg-gradient-info text-white' : '' }} nav-link-routing" href="{{ route('salles') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10 text-info"></i>
                        </div>
                        <span class="nav-link-text ms-1 ">Salles</span>
                    </a>
                </li>

                <hr class="horizontal light mt-0 mb-2">
                <div class="sidenav-footer  w-100">
                    <div class="mx-3">
                        <a class="btn btn-outline-info mt-1 w-100 text-info" href="{{route('valideExporter')}}" type="button ">Validé et Exporter</a>
                        <a class="btn text-white bg-info w-100" href="{{ route('gererUser') }}"
                            type="button">Settings</a>
                        <!-- Modal -->
                        {{--<x-modalSettings>
        MASTER CALL
      </x-modalSettings> --}}
                    </div>
                </div>
            </ul>
    </aside>
