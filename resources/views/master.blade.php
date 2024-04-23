@php
    use App\Models\emploi;
    $dates = emploi::all();
    $url = $_SERVER['REQUEST_URI'];
    $path = parse_url($url, PHP_URL_PATH);
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    {{-- file excel --}}
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.5/b-2.0.1/b-html5-2.0.1/datatables.min.css" />
    <script type="text/javascript"
        src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.5/b-2.0.1/b-html5-2.0.1/datatables.min.js"></script>
    {{-- file excel --}}

    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/masterAssets/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/masterAssets/img/favicon.png') }}">
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    <title>
        {{ $title }}
    </title>
    {{-- bootstrap --}}
    <!--     Fonts and icons     -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('assets/masterAssets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/masterAssets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assets/masterAssets/css/material-dashboard.css?v=3.1.0') }}"
        rel="stylesheet" />
    <!-- Nepcha Analytics (nepcha.com) -->
    <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
    <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>
    <Link rel="stylesheet" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}"></Link>
    <script src="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}"></script>

    <style>
        /* Custom CSS for buttons */
        .modal-content button {
            width: 200px;
            /* Adjust the width as needed */
            text-align: center;
        }
    *{
        scrollbar-width: thin;
        scrollbar-color: #ccc ;
    }
    * ::-webkit-scrollbar-track {
        background-color: transparent;
    }

    *::-webkit-scrollbar-corner {
        background-color: transparent;
    }
    .logout:hover a{
        color: #1a73e8;
        transition: all 0.3s ease;
    }
    .toggle-sidebar{
        display: none !important;
    }
    #toggleSidebarBtn{
        left: 235px;
        top: 50%;
        z-index: 1000;
        rotate: -180deg;
        box-shadow: none;
    }
    #toggleSidebarBtn {
    transition: left 0.3s ease; /* Add a transition effect to the left property */
}

    </style>

</head>
    <button id="toggleSidebarBtn" class="btn  m-0 position-absolute" ><i class="fs-3 fa-solid fa-arrow-left text-info"></i></button>
<body class="g-sidenav-show  bg-white-200">
    <aside
        class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-light bg-opacity-50"
        id="sidenav-main">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
                aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand m-0" href="{{ route('afficher_ajouter_emploi') }}">
                <img src="{{ asset('assets/masterAssets/img/iconofppt.png') }}" class="navbar-brand-img h-100"
                    alt="main_logo">
                <span class="ms-1 font-weight-bold decoration-blue-950">Gérer l'emploi</span>
                @if($dates->isEmpty())
                 <input class="must_add_emploi" hidden>
                @endif
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
                <hr class="horizontal light mt-0 mb-2">
                <div class="sidenav-footer  w-100">
                    <div class="mx-3">
                        <a class="btn btn-outline-info mt-1 w-100 text-info nav-link-routing" href="#" type="button " >Validé et Exporter</a>
                        <a class="btn text-white bg-info w-100" href="{{ route('gererUser') }}"
                            type="button">Settings</a>
                        <!-- Modal -->
                        {{-- <x-modalSettings>
        MASTER CALL
      </x-modalSettings> --}}
                    </div>
                </div>
            </ul>
    </aside>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg" >
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0  shadow-none border-radius-xl fixed-top w-100" id="navbarBlur"
            data-scroll="true" >
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <!-- <h6 class="font-weight-bolder mb-0"></h6> -->
                    <img src="{{ asset('assets/masterAssets/img/ofpptLogo.png') }}"
                        style="width: 70px;margin-left: 55vw;" alt="ofpptLogo">
                </nav>
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                    </div>
                    <ul class="navbar-nav  justify-content-end">
                        @auth
                            <li class="logout nav-item d-flex align-items-center">
                                <a onclick="return confirm('Voulez Vous Vraiment déconnecter?')"
                                    href="{{ route('logout') }}" class=" nav-link font-weight-bold d-flex justify-content-center align-items-center">
                                    <i class="fa-solid fa-right-from-bracket mx-1"></i>
                                    <span class="d-sm-inline d-none">Logout</span>
                                </a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->
        <div class="container-fluid">
            {{ $slot }}
        </div>
    </main>
    <!--   Core JS Files   -->
    <script src="{{ asset('assets/masterAssets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/masterAssets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/masterAssets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/masterAssets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/masterAssets/js/plugins/chartjs.min.js') }}"></script>
    <script src="{{asset('assets/bootstrap/jquery.min.js')}}"></script>
<script src="{{asset('assets/bootstrap/popper.min.js')}}"></script>
<script src="{{asset('assets/bootstrap/js/bootstrap.min.js')}}"></script>
        <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggleSidebarBtn = document.getElementById('toggleSidebarBtn');
    const sidebar = document.getElementById('sidenav-main');
    const mainContent = document.querySelector('.main-content');
    const divInsideMaster = document.querySelector('x-master > div');

    toggleSidebarBtn.addEventListener('click', function () {
        sidebar.classList.toggle('toggle-sidebar');
        if (sidebar.classList.contains('toggle-sidebar')) {
            toggleSidebarBtn.style.left = '-20px'; // Slide the button to the left when the sidebar is toggled
            mainContent.style.width = '100%'; // Expand the main content to full width when the sidebar is hidden
            divInsideMaster.style.width = '100%'; // Expand the div inside x-master to full width when the sidebar is hidden
            document.body.style.overflowY = 'hidden'; // Hide the body scrollbar
            document.body.style.overflowX = 'auto'; // Allow horizontal scrolling in the body
        } else {
            toggleSidebarBtn.style.left = '235px'; // Slide the button back to its original position
            mainContent.style.width = ''; // Reset the width of the main content to its default value
            divInsideMaster.style.width = ''; // Reset the width of the div inside x-master to its default value
            document.body.style.overflowY = 'auto'; // Allow scrolling in the body
            document.body.style.overflowX = 'hidden'; // Hide horizontal scrolling in the body
        }
    });
});

    </script>
    <script>
       const must_add_emloi = document.querySelector('.must_add_emploi');
        const nav_link_routing = document.querySelectorAll('.nav-link-routing');
        const alert_new_emploi=document.querySelector('.creer_emploi')
        if (must_add_emloi) {
            nav_link_routing.forEach((item)=>{
                item.addEventListener('click', function (e) {
                e.preventDefault();
                alert("vous devez creer une emploi d'abord")
            });
            })
        }
</script>
    <script src="{{ asset('assets/masterAssets/js/material-dashboard.min.js?v=3.1.0') }}"></script>
</body>

</html>

