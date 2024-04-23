@props(['widthUser','widthFormateur','widthFiliere','widthGroupe','widthSemaine','widthSalle','widthModule','widthFM','widthIMPORT'])
<div class="container" style="background-color: white; border-radius: 13px">
    <div class="row p-3">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="sidebar align-items-center">
                <!-- Sidebar content on the left -->
                <ul class="list-group border-0 d-flex justify-content-center">
                    @php
                        $buttons = [
                            ['route' => 'gererUser', 'name' => 'changerPass', 'text' => 'Changer le mot de passe', 'width' => $widthUser ?? '100%'],
                            ['route' => 'showGereFormateur', 'name' => 'GererFormarteurs', 'text' => 'Gérer les formateurs', 'width' => $widthFormateur ?? '100%'],
                            ['route' => 'gererFiliere', 'name' => 'GererFilieres', 'text' => 'Gérer les filières', 'width' => $widthFiliere ?? '100%'],
                            ['route' => 'gererGroupe', 'name' => 'GererGroupes', 'text' => 'Gérer les groupes', 'width' => $widthGroupe ?? '100%'],
                            ['route' => 'gererSemaine', 'name' => 'GererSemaines', 'text' => 'Gérer les semaines', 'width' => $widthSemaine ?? '100%'],
                            ['route' => 'gererSalle', 'name' => 'GererSalles', 'text' => 'Gérer les salles', 'width' => $widthSalle ?? '100%'],
                            ['route' => 'gererModule', 'name' => 'GererModules', 'text' => 'Gérer les modules', 'width' => $widthModule ?? '100%'],
                            ['route' => 'GroupeModule', 'name' => 'GererFormateurModules', 'text' => 'Gérer les Affectations', 'width' => $widthFM ?? '100%'],
                            ['route' => 'importView', 'name' => 'importView', 'text' => 'IMPORT DATA', 'width' => $widthIMPORT ?? '100%'],

                        ];
                    @endphp
                    @foreach ($buttons as $button)
                        <li class="list-group-item border-0">
                            <a href="{{ route($button['route']) }}" type="button" class="btn btn-dark" name="{{ $button['name'] }}"
                               style="width: {{ $button['width'] }}; {{ $button['width'] === '99%' ? 'background-color: #1A73E8; color: white;' : '' }}">
                                {{ $button['text'] }}
                            </a>
                        </li>
                    @endforeach
                    {{-- <li class="list-group-item border-0">
                        <button type="button" class="btn btn-danger" name="Reinistialiser" style="width: 100%;">Réinitialiser</button>
                    </li> --}}
                    <!-- Add more buttons or content as needed -->
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <!-- Main content on the right -->
            <div class="d-flex" style="height: 70vh;">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
