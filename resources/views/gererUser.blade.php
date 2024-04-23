<x-master title="gerer User">
    <x-settings widthUser="99%" widthFormateur="100%" widthFiliere="100%" widthGroupe="100%" widthSemaine="100%" widthSalle="100%">
        <div class="container mt-5">
            <!-- Single Row for Table and Form -->
            <div class="row justify-content-center align-items-center">
                <!-- Table Column -->
                <div class="col-md-6">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{Auth()->user()->name}}</td>
                                    <td>{{Auth()->user()->email}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- End Table Column -->

                <!-- Form Column -->
                <div class="col-md-6" style="border: 2px solid #ced4da; border-radius: 5px;">
                    <form action="{{route('updateUser',Auth()->user()->id)}}" method="post" style="padding: 20px;">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{Auth()->user()->name}}" style="border: none; border-bottom: 2px solid #ced4da;">
                        </div>
                        <div class="text-danger">
                            @error('name')
                                {{$message}}
                            @enderror

                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" id="email" name="email" value="{{Auth()->user()->email}}" style="border: none; border-bottom: 2px solid #ced4da;">
                        </div>
                        <div class="text-danger">

                            @error('email')
                                {{$message}}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" style="border: none; border-bottom: 2px solid #ced4da;">
                        </div>
                        <div class="text-danger">
                            @error('password')
                                {{$message}}
                            @enderror
                        </div>
                        <div class="form-group mb-2">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="password_confirmation" style="border: none; border-bottom: 2px solid #ced4da;">
                        </div>
                        <button type="submit" class="btn btn-info">Update</button>
                    </form>
                </div>
                <!-- End Form Column -->
            </div>
            <!-- End Single Row for Table and Form -->
        </div>
    </x-settings>
</x-master>
