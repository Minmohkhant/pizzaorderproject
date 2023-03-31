@extends('admin.layouts.master')

@section('title','Category List')

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                            <div class="table-responsive table-responsive-data2">
                                <h3> Total - {{ count($users) }}</h3>
                                <table class="table table-data2 text-center">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Gender</th>
                                            <th>Phone</th>
                                            <th>Address</th>
                                            <th>Role</th>
                                        </tr>
                                    </thead>
                                    <tbody id="dataTable">
                                            @foreach ($users as $u)
                                                <tr>
                                                    <td class="col-2">
                                                        @if ($u->image == null)
                                                            @if ($u->gender == 'male' )
                                                            <img src="{{ asset('image/default_user.png') }}" class="img-thumbnail shadow-sm">
                                                            @else
                                                            <img src="{{ asset('image/female_default.png') }}" class="img-thumbnail shadow-sm">
                                                            @endif
                                                        @else
                                                            <img src="{{ asset('storage/' .$u->image) }}" class="img-thumbnail shadow-sm"/>
                                                        @endif
                                                    </td>
                                                    <input type="hidden" id="userId" value="{{ $u->id }}">
                                                    <td>{{ $u->name }}</td>
                                                    <td>{{ $u->email }}</td>
                                                    <td>{{ $u->gender }}</td>
                                                    <td>{{ $u->phone }}</td>
                                                    <td>{{ $u->address }}</td>
                                                    <td>
                                                        <select class="form-control statusChange">
                                                            <option value="user" @if($u->role == 'user') selected @endif()>User</option>
                                                            <option value="admin" @if($u->role == 'admin') selected @endif()>Admin</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            @endforeach
                                    </tbody>
                                </table>
                                <div class="mt-5">
                                    {{ $users->links() }}
                                </div>
                            </div>
                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection

@section('scriptSection')
    <script>
        $(document).ready(function(){
            //change user role
            $('.statusChange').change(function(){
                $currentStatus = $(this).val();
                $parentNode = $(this).parents("tr");
                $userId = $parentNode.find('#userId').val();

                $data = {
                    'userId' : $userId,
                    'role' : $currentStatus,
                };


                $.ajax({
                    type : 'get',
                    url : '/user/change/role',
                    data : $data,
                    dataType : 'json',
                })

                location.reload();
            })
        })
    </script>
@endsection

