@extends('layouts.adminlte.app')

@section('content')
    <style>
        .card-body,
        .card-footer {
            padding: 20px !important
        }
    </style>
    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle" src="{{ session('avatar') ?? (session('image') && file_exists('files/users/' . session('image')) ? asset('files/users/' . session('image')) : asset('media/img/no-user.png')) }}" alt="User profile picture">
                    </div>

                    <h3 class="profile-username text-center">{{ session('name') }}</h3>

                    <p class="text-muted text-center">{{ session('user_type') }}</p>


                    {{-- <a href="#" class="btn btn-primary btn-block"><b>Update Foto</b></a> --}}
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        {{-- <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a></li> --}}
                        <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Update Profile</a></li>
                    </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="timeline">
                            <!-- The timeline -->
                            <div class="timeline timeline-inverse">
                                <!-- timeline time label -->
                                <div class="time-label">
                                    <span class="bg-danger">
                                        10 Feb. 2014
                                    </span>
                                </div>
                                <!-- /.timeline-label -->
                                <!-- timeline item -->
                                <div>
                                    <i class="fas fa-envelope bg-primary"></i>

                                    <div class="timeline-item">
                                        <span class="time"><i class="far fa-clock"></i> 12:05</span>

                                        <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                                        <div class="timeline-body">
                                            Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                                            weebly ning heekya handango imeem plugg dopplr jibjab, movity
                                            jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                                            quora plaxo ideeli hulu weebly balihoo...
                                        </div>
                                        <div class="timeline-footer">
                                            <a href="#" class="btn btn-primary btn-sm">Read more</a>
                                            <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- END timeline item -->
                                <!-- timeline item -->
                                <div>
                                    <i class="fas fa-user bg-info"></i>

                                    <div class="timeline-item">
                                        <span class="time"><i class="far fa-clock"></i> 5 mins ago</span>

                                        <h3 class="timeline-header border-0"><a href="#">Sarah Young</a> accepted your friend request
                                        </h3>
                                    </div>
                                </div>
                                <!-- END timeline item -->
                                <!-- timeline item -->
                                <div>
                                    <i class="fas fa-comments bg-warning"></i>

                                    <div class="timeline-item">
                                        <span class="time"><i class="far fa-clock"></i> 27 mins ago</span>

                                        <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

                                        <div class="timeline-body">
                                            Take me to your leader!
                                            Switzerland is small and neutral!
                                            We are more like Germany, ambitious and misunderstood!
                                        </div>
                                        <div class="timeline-footer">
                                            <a href="#" class="btn btn-warning btn-flat btn-sm">View comment</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- END timeline item -->
                                <!-- timeline time label -->
                                <div class="time-label">
                                    <span class="bg-success">
                                        3 Jan. 2014
                                    </span>
                                </div>
                                <!-- /.timeline-label -->
                                <!-- timeline item -->
                                <div>
                                    <i class="fas fa-camera bg-purple"></i>

                                    <div class="timeline-item">
                                        <span class="time"><i class="far fa-clock"></i> 2 days ago</span>

                                        <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

                                        <div class="timeline-body">
                                            <img src="https://placehold.it/150x100" alt="...">
                                            <img src="https://placehold.it/150x100" alt="...">
                                            <img src="https://placehold.it/150x100" alt="...">
                                            <img src="https://placehold.it/150x100" alt="...">
                                        </div>
                                    </div>
                                </div>
                                <!-- END timeline item -->
                                <div>
                                    <i class="far fa-clock bg-gray"></i>
                                </div>
                            </div>
                        </div>
                        <!-- /.tab-pane -->

                        <div class="tab-pane active" id="settings">
                            <form id="form-data" class="form-horizontal">
                                @csrf
                                <div class="form-group row">
                                    <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-6">
                                        <input type="email" class="form-control" id="inputEmail" placeholder="Email" value="{{ $user->email }}" disabled>
                                        <span class="invalid-feedback"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="name" class="form-control" name="name" id="inputName" placeholder="Name" value="{{ $user->name }}">
                                        <span class="invalid-feedback"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="password" class="col-sm-2 col-form-label">Password</label>
                                    <div class="col-sm-4">
                                        <input type="password" name="password" class="form-control" id="password">
                                        <span class="invalid-feedback"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="password2" class="col-sm-2 col-form-label">Verify Password</label>
                                    <div class="col-sm-4">
                                        <input type="password" name="password2" class="form-control" id="password2">
                                        <span class="invalid-feedback"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button type="submit" class="btn btn-danger btnSave"><i class="fa fa-save"></i> Update</button>
                                    </div>
                                </div>
                            </form>

                            <script>
                                $('.btnSave').click(function() {
                                    $('.btnSave').attr('disabled', true).html('menyimpan...');
                                    $('.is-invalid').removeClass('is-invalid');
                                    $('.invalid-feedback').empty();

                                    var formData = $('#form-data').serialize();
                                    $.ajax({
                                        data: formData,
                                        url: "{{ route('profile.update', session('user_id')) }}",
                                        type: "PUT",
                                        dataType: 'json',
                                        success: function(data) {
                                            if (data.status) {
                                                alert('Data Profile berhasil diupdate');
                                            } else {
                                                for (var i = 0; i < data.error_string.length; i++) {
                                                    if (data.error_string[i]) {
                                                        $('[name="' + data.inputerror[i] + '"]').addClass('is-invalid').next(
                                                            '.invalid-feedback').html(
                                                            data.error_string[i]);
                                                    }
                                                }
                                            }
                                            $('.btnSave').attr('disabled', false).html('<i class="fa fa-save"></i> Update');
                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                            alert(errorThrown);
                                            $('.btnSave').attr('disabled', false).html('<i class="fa fa-save"></i> Update');

                                        }
                                    });
                                });
                            </script>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
@endsection
