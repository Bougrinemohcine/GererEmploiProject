
<x-master title="import">
    <x-settings widthUser="100%" widthFormateur="100%" widthFiliere="100%" widthGroupe="100%" widthSemaine="100%" widthSalle="100%" widthIMPORT="99%">

        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <form action="{{ route('UploedFileExcel') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                    <div style="width: 90%;" class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="file">Select File</label>
                                <div class="drop-container" id="dropcontainer">
                                    <input type="file" name="file" class="form-control-file" accept=".xlsx" />
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </div>
                    </div>
            </div>
        </form>


    </x-settings>

</x-master>


