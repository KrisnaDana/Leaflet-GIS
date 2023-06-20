<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />
        <script src="https://kit.fontawesome.com/a94f3fd771.js" crossorigin="anonymous"></script>
        <link rel="icon" href="{{url('/images/hotel.png')}}" type="image/png" />
        <!-- <link rel="stylesheet" href="{{url('/css/bootstrap.min.css')}}" /> -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <link rel="stylesheet" href="{{url('/css/leaflet.css')}}" />
        <link rel="stylesheet" href="{{url('/css/style.css')}}" />
        <script src="{{url('/js/leaflet.js')}}"></script>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-easybutton@2/src/easy-button.css" />
        <script src="https://cdn.jsdelivr.net/npm/leaflet-easybutton@2/src/easy-button.js"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.5.1/MarkerCluster.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.5.1/MarkerCluster.Default.css" /> 
        <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.5.1/leaflet.markercluster.js"></script>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,600,0,0" />

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
        @livewireStyles
        <title>Leaflet Map</title>
        <style>
            .form-control {
                border-radius: 0px;
            }

            .form-select {
                border-radius: 0px;
            }

            .modal-header {
                border-radius: 0px;
                background-color:#2C3345;
                color:white;
            }

            .modal-content {
                border-radius: 0px;
            }

            .btn-close {
                color: white;
                filter: invert(1) grayscale(100%) brightness(200%);
            }
            .dropdown-menu {
                border-radius: 0px;
            }
            .btn {
                border-radius: 0px;
            }

            span.required-form {
                color:red;
            }
        </style>
    </head>
    <body>
        <div>
            <nav class="navbar" style="background-color:#2C3345">
                <div class="container-fluid">
                    <a class="navbar-brand" data-bs-toggle="modal" data-bs-target="#hotel_list" type="button">
                        <img src="{{url('images/hotel.png')}}" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
                        <span class="text-white dropdown-toggle">Hotel</span>
                    </a>
                    <!-- <a type="button" class="navbar-brand mt-2 text-start" style="text-decoration:none" data-bs-toggle="modal" data-bs-target="#hotel_list">
                        <h6 class="text-white nav-link dropdown-toggle">Hotel List </h6>
                    </a> -->
                    @if(!empty($user))
                    <li class="d-flex nav-item dropdown text-white me-5">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{$user->name}}
                        </a>
                        <ul class="dropdown-menu">
                            <!-- <li><a class="dropdown-item" href="#">Profile</a></li> -->
                            <li><a class="dropdown-item" href="{{route('logout')}}">Logout</a></li>
                        </ul>
                    </li>
                    @else
                    <div class="d-flex">
                        <a type="button" class="me-3" href="{{route('index')}}" style="text-decoration:none" data-bs-toggle="modal" data-bs-target="#login_modal" id="login_button">
                            <h6 class="text-white">Login</h6>
                        </a>
                        <a type="button" class="me-3" href="{{route('index')}}" style="text-decoration:none" data-bs-toggle="modal" data-bs-target="#register_modal" id="register_button">
                            <h6 class="text-white">Register</h6>
                        </a>
                    </div>
                    @endif
                </div>
            </nav>



            @if(old('toast_validation'))
                <div class="position-fixed top-0 end-0 p-3" style="z-index: 20000; width:300px" id="toast">
                    <div class="align-items-center text-white bg-danger border-0 p-2" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">
                            {{old('toast_validation')}}
                            </div>
                            <button type="button" class="btn-close btn-close-white me-3 m-auto" aria-label="Close" id="closeToast"></button>
                        </div>
                    </div>
                </div>
                <script>
                    document.getElementById("closeToast").addEventListener("click", () => {
                        document.getElementById("toast").hidden = true;
                    });
                    setTimeout(function(){document.getElementById("toast").hidden = true;}, 10000);
                </script>
            @endif
            @if($toast_danger = Session::get('toast_danger'))
                <div class="position-fixed top-0 end-0 p-3" style="z-index: 20000; width:300px" id="toast">
                    <div class="align-items-center text-white bg-danger border-0 p-2" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">
                            {{$toast_danger}}
                            </div>
                            <button type="button" class="btn-close btn-close-white me-3 m-auto" aria-label="Close" id="closeToast"></button>
                        </div>
                    </div>
                </div>
                <script>
                    document.getElementById("closeToast").addEventListener("click", () => {
                        document.getElementById("toast").hidden = true;
                    });
                    setTimeout(function(){document.getElementById("toast").hidden = true;}, 10000);
                </script>
            @endif
            @if($toast_primary = Session::get('toast_primary'))
                <div class="position-fixed top-0 end-0 p-3" style="z-index: 20000; width:300px" id="toast">
                    <div class="align-items-center text-white bg-primary border-0 p-2" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">
                            {{$toast_primary}}
                            </div>
                            <button type="button" class="btn-close btn-close-white me-3 m-auto" aria-label="Close" id="closeToast"></button>
                        </div>
                    </div>
                </div>
                <script>
                    document.getElementById("closeToast").addEventListener("click", () => {
                        document.getElementById("toast").hidden = true;
                    });
                    setTimeout(function(){document.getElementById("toast").hidden = true;}, 10000);
                </script>
            @endif


            @if(empty($user))
            <div class="modal fade" id="login_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content rounded-0">
                        <form method="post" action="{{url('login')}}">
                            <div class="modal-header rounded-0 text-white" style="background-color:#2C3345">
                                <h1 class="modal-title fs-4">Login</h1>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Email<span class="required-form"> *</span></label>
                                    <input type="text" class="form-control rounded-0" name="email" value="{{old('email')}}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password<span class="required-form"> *</span></label>
                                    <input type="password" class="form-control rounded-0" name="password" required/>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" class="form-control" name="toast_validation" value="Login failed." required/>
                                <input type="hidden" class="form-control" name="login" value="login" required/>
                                <button class="btn btn-primary rounded-0" style="width:100%;" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>



            <div class="modal fade" id="register_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content rounded-0">
                        <form method="post" action="{{url('register')}}">
                            <div class="modal-header rounded-0 text-white" style="background-color:#2C3345">
                                <h1 class="modal-title fs-4">Register</h1>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Name<span class="required-form"> *</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{old('name')}}" required>
                                    @error('name')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email<span class="required-form"> *</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{old('email')}}" required>
                                    @error('email')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password<span class="required-form"> *</span></label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required/>
                                    @error('password')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password Confirmation<span class="required-form"> *</span></label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" required/>
                                    @error('password_confirmation')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <input type="hidden" class="form-control" name="toast_validation" value="Register failed." required/>
                                <input type="hidden" class="form-control" name="register" value="register" required/>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" style="width:100%;" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif


            <div class="modal fade" id="hotel_list" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-3" id="exampleModalLabel">Hotel List</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        
                        <div class="modal-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                    <th class="text-center" scope="col-1">No</th>
                                    <th scope="col-8">Name</th>
                                    <th scope="col-2" class="text-center">Star</th>
                                    <th class="text-center" scope="col-1">Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($hotels as $hotel)
                                        <tr>
                                            <td class="text-center">{{$loop->iteration}}</th>
                                            <td>{{$hotel->name}}</td>
                                            <td class="text-center">{{$hotel->star}}</td>
                                            <td class="text-center">
                                                <a type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#hotel_modal_{{$hotel->id}}" onclick="goToMarker('{{$hotel->id}}');">Detail</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            @if(!empty($user))
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create_hotel_modal" id="create_hotel_button" hidden></button>
            <div class="modal fade" id="create_hotel_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <form method="post" action="{{route('create-hotel')}}" enctype="multipart/form-data">
                            <div class="modal-header">
                                <h1 class="modal-title fs-3" id="exampleModalLabel">Create Hotel</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Name<span class="required-form"> *</span></label>
                                    @if(old('create_hotel'))
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{old('name')}}" required/>
                                        @error('name')
                                        <div class="invalid-feedback">{{$message}}</div>
                                        @enderror
                                    @else
                                        <input type="text" class="form-control" name="name" value="" required/>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Address<span class="required-form"> *</span></label>
                                    @if(old('create_hotel'))
                                        <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{old('address')}}" required/>
                                        @error('address')
                                        <div class="invalid-feedback">{{$message}}</div>
                                        @enderror
                                    @else
                                        <input type="text" class="form-control" name="address" value="" required/>
                                    @endif
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label">Email<span class="required-form"> *</span></label>
                                        @if(old('create_hotel'))
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{old('email')}}" required/>
                                            @error('email')
                                            <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        @else
                                            <input type="email" class="form-control" name="email" value="" required/>
                                        @endif
                                    </div>
                                    <div class="col-4">
                                        <label class="form-label">Phone<span class="required-form"> *</span></label>
                                        @if(old('create_hotel'))
                                            <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{old('phone')}}" required/>
                                            @error('phone')
                                            <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        @else
                                            <input type="text" class="form-control" name="phone" value="" required/>
                                        @endif
                                    </div>
                                    <div class="col-2">
                                        <label class="form-label">Star<span class="required-form"> *</span></label>
                                        <select class="form-select" name="star">
                                            <option value="1" selected>1</option>
                                            @if(old('create_hotel') && old('star') == "2")
                                                <option value="2" selected>2</option>
                                            @else
                                                <option value="2">2</option>
                                            @endif
                                            @if(old('create_hotel') && old('star') == "3")
                                                <option value="3" selected>3</option>
                                            @else
                                                <option value="3">3</option>
                                            @endif
                                            @if(old('create_hotel') && old('star') == "4")
                                                <option value="4" selected>4</option>
                                            @else
                                                <option value="4">4</option>
                                            @endif
                                            @if(old('create_hotel') && old('star') == "5")
                                                <option value="5" selected>5</option>
                                            @else
                                                <option value="5">5</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    @if(old('create_hotel'))
                                        <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3">{{old('description')}}</textarea>
                                        @error('description')
                                        <div class="invalid-feedback">{{$message}}</div>
                                        @enderror
                                    @else
                                        <textarea class="form-control" name="description" rows="3"></textarea>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Icon</label>
                                    @if(old('create_hotel'))
                                        <input class="form-control @error('icon') is-invalid @enderror" type="file" name="icon">
                                        @error('icon')
                                        <div class="invalid-feedback">{{$message}}</div>
                                        @enderror
                                    @else
                                        <input class="form-control" type="file" type="file" name="icon">
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Images<span class="required-form"> *</span></label>
                                    @if(old('create_hotel'))
                                        <input class="form-control @error('images.*') is-invalid @enderror" type="file" name="images[]" multiple required>
                                        @error('images.0')
                                        <div class="invalid-feedback">{{$message}}</div>
                                        @enderror
                                    @else
                                        <input class="form-control" type="file" name="images[]" multiple required>
                                    @endif
                                </div>
                                @if(old('create_hotel'))
                                    <input type="text" class="form-control" id="create_hotel_lat" name="lat" hidden value="{{old('lat')}}"/>
                                    <input type="text" class="form-control" id="create_hotel_lng" name="lng" hidden value="{{old('lng')}}"/>
                                @else
                                    <input type="text" class="form-control" id="create_hotel_lat" name="lat" hidden/>
                                    <input type="text" class="form-control" id="create_hotel_lng" name="lng" hidden/>
                                @endif
                                <input type="hidden" class="form-control" name="toast_validation" value="Create hotel failed."/>
                                <input type="hidden" class="form-control" name="create_hotel" value="create_hotel"/>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger col" data-bs-dismiss="modal">
                                    Cancel
                                </button>
                                <button type="submit" class="btn btn-primary col">
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif


            @foreach($hotels as $hotel)
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#hotel_modal_{{$hotel->id}}" id="hotel_button_{{$hotel->id}}" hidden></button>
                <div class="modal fade" id="hotel_modal_{{$hotel->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-3" id="exampleModalLabel">{{$hotel->name}}</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a type="button" class="nav-link active">Hotel</a>
                                    </li>
                                    <li class="nav-item">
                                        <a type="button" class="nav-link" data-bs-toggle="modal" data-bs-target="#hotel_room_modal_{{$hotel->id}}" id="hotel_room_button_{{$hotel->id}}">Room</a>
                                    </li>
                                    @if(!empty($user))
                                    <li class="nav-item">
                                        <a type="button" class="nav-link" data-bs-toggle="modal" data-bs-target="#hotel_facility_modal_{{$hotel->id}}">Facility</a>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                            <div class="modal-body">
                                @if(!empty($user))
                                    <div class="btn-group mb-4">
                                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            Option
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#edit_hotel_modal_{{$hotel->id}}" id="edit_hotel_button_{{$hotel->id}}">Edit</a></li>
                                            <li><a class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#delete_hotel_modal_{{$hotel->id}}">Delete</a></li>
                                        </ul>
                                    </div>
                                @endif
                                <div id="hotel_image_{{$hotel->id}}" class="carousel slide mb-3">
                                    <div class="carousel-inner">
                                        @foreach($images as $image)
                                            @if($image->type == "Hotel" && $image->hotel_id == $hotel->id)
                                                @if($image->is_thumbnail == 1 )
                                                    <div class="carousel-item active">
                                                        <img src="{{url('images/hotels/'.$image->filename)}}" class="d-block" style="max-height:1000px; width:100%; margin-left: auto; margin-right: auto;">
                                                    </div>
                                                @else
                                                    <div class="carousel-item">
                                                        <img src="{{url('images/hotels/'.$image->filename)}}" class="d-block" style="max-height:1000px; width:100%; margin-left: auto; margin-right: auto;">
                                                    </div>
                                                @endif
                                            @endif
                                        @endforeach
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#hotel_image_{{$hotel->id}}" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden text-primary">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#hotel_image_{{$hotel->id}}" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" value="{{$hotel->name}}" disabled readonly/>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Address</label>
                                    <input type="text" class="form-control" value="{{$hotel->address}}" disabled readonly/>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label">Email</label>
                                        <input type="text" class="form-control" value="{{$hotel->email}}" disabled readonly/>
                                    </div>
                                    <div class="col-4">
                                        <label class="form-label">Phone</label>
                                        <input type="text" class="form-control" value="{{$hotel->phone}}" disabled readonly/>
                                    </div>
                                    <div class="col-2">
                                        <label class="form-label">Star</label>
                                        <input type="text" class="form-control" value="{{$hotel->star}}" disabled readonly/>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" rows="3" disabled readonly>{{$hotel->description}}</textarea>
                                </div>
                                <div>
                                    <label class="form-label">Facility</label>
                                    <div style="display: flex; flex-wrap: wrap;">
                                    @foreach($facilities as $facility)
                                        @if($facility->hotel_id == $hotel->id && $facility->type == "Hotel")
                                            <div class="card me-3 mb-3 rounded-0" style="width:230px">
                                                <div class="">
                                                    <div class="card-img-top">
                                                        @php
                                                            $facility_images_check = 0;
                                                        @endphp
                                                        @foreach($images as $image)
                                                            @if($image->hotel_id == $hotel->id && $image->facility_id == $facility->id && $image->type == "Facility")
                                                                @php
                                                                    $facility_images_check = 1;
                                                                    break;
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                        @if($facility_images_check == 1)
                                                            <div id="hotel_facility_image_{{$facility->id}}" class="carousel slide">
                                                                <div class="carousel-inner">
                                                                    @foreach($images as $image)
                                                                        @if($image->hotel_id == $hotel->id && $image->facility_id == $facility->id && $image->type == "Facility")
                                                                            @if($image->is_thumbnail == 1)
                                                                                <div class="carousel-item active">
                                                                                    <img src="{{url('images/facilities/'.$image->filename)}}" class="d-block" style="max-height:225px; width:100%; margin-left: auto; margin-right: auto;">
                                                                                </div>
                                                                            @else
                                                                                <div class="carousel-item">
                                                                                    <img src="{{url('images/facilities/'.$image->filename)}}" class="d-block" style="max-height:225px; width:100%; margin-left: auto; margin-right: auto;">
                                                                                </div>
                                                                            @endif
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                                <button class="carousel-control-prev" type="button" data-bs-target="#hotel_facility_image_{{$facility->id}}" data-bs-slide="prev">
                                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                                    <span class="visually-hidden">Previous</span>
                                                                </button>
                                                                <button class="carousel-control-next" type="button" data-bs-target="#hotel_facility_image_{{$facility->id}}" data-bs-slide="next">
                                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                                    <span class="visually-hidden">Next</span>
                                                                </button>
                                                            </div>
                                                        @else
                                                            <img src="{{url('images/no_image.jpg')}}" style="max-height:225px; width:100%; margin-left: auto; margin-right: auto;">
                                                        @endif
                                                    </div>
                                                    <div class="card-body">
                                                        <p class="card-text">
                                                            @if($facility->count == 0)
                                                                {{$facility->name}}
                                                            @else
                                                                {{$facility->count}} {{$facility->name}}
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if(!empty($user))
                <div class="modal fade" id="edit_hotel_modal_{{$hotel->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                        <div class="modal-content">
                            <form class="modal-content" method="post" action="{{route('edit-hotel', ['id' => $hotel->id])}}" enctype="multipart/form-data">
                                @method('put')
                                <div class="modal-header">
                                    <h1 class="modal-title fs-3" id="exampleModalLabel">{{$hotel->name}}</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item">
                                            <a type="button" class="nav-link active">Hotel</a>
                                        </li>
                                        <li class="nav-item">
                                            <a type="button" class="nav-link" data-bs-toggle="modal" data-bs-target="#hotel_room_modal_{{$hotel->id}}" id="hotel_room_button_{{$hotel->id}}">Room</a>
                                        </li>
                                        <li class="nav-item">
                                            <a type="button" class="nav-link" data-bs-toggle="modal" data-bs-target="#hotel_facility_modal_{{$hotel->id}}">Facility</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="modal-body">
                                    <div class="text-center mb-3">
                                        @foreach($images as $image)
                                            @if($image->type == "Hotel" && $image->hotel_id == $hotel->id)
                                                @if($image->is_thumbnail == 1 )
                                                <img src="{{url('images/hotels/'.$image->filename)}}" style="max-height:1000px; width:100%;">
                                                @endif
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Name<span class="required-form"> *</span></label>
                                        @if(old('edit_hotel'))
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{old('name')}}" required/>
                                            @error('name')
                                            <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        @else
                                            <input type="text" class="form-control" name="name" value="{{$hotel->name}}" required/>
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Address<span class="required-form"> *</span></label>
                                        @if(old('edit_hotel'))
                                            <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{old('address')}}" required/>
                                            @error('address')
                                            <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        @else
                                            <input type="text" class="form-control" name="address" value="{{$hotel->address}}" required/>
                                        @endif
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <label class="form-label">Email<span class="required-form"> *</span></label>
                                            @if(old('edit_hotel'))
                                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{old('email')}}" required/>
                                                @error('email')
                                                <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                            @else
                                                <input type="email" class="form-control" name="email" value="{{$hotel->email}}" required/>
                                            @endif
                                        </div>
                                        <div class="col-4">
                                            <label class="form-label">Phone<span class="required-form"> *</span></label>
                                            @if(old('edit_hotel'))
                                                <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{old('phone')}}" required/>
                                                @error('phone')
                                                <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                            @else
                                                <input type="text" class="form-control" name="phone" value="{{$hotel->phone}}" required/>
                                            @endif
                                        </div>
                                        <div class="col-2">
                                            <label class="form-label">Star<span class="required-form"> *</span></label>
                                            <select class="form-select" name="star">
                                                @if((old('edit_hotel') && old('star') == "1") || $hotel->star == 1)
                                                    <option value="1" selected>1</option>
                                                @else
                                                    <option value="1">1</option>
                                                @endif
                                                @if((old('edit_hotel') && old('star') == "2") || $hotel->star == 2)
                                                    <option value="2" selected>2</option>
                                                @else
                                                    <option value="2">2</option>
                                                @endif
                                                @if((old('edit_hotel') && old('star') == "3") || $hotel->star == 3)
                                                    <option value="3" selected>3</option>
                                                @else
                                                    <option value="3">3</option>
                                                @endif
                                                @if((old('edit_hotel') && old('star') == "4") || $hotel->star == 4)
                                                    <option value="4" selected>4</option>
                                                @else
                                                    <option value="4">4</option>
                                                @endif
                                                @if((old('edit_hotel') && old('star') == "5") || $hotel->star == 5)
                                                    <option value="5" selected>5</option>
                                                @else
                                                    <option value="5">5</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        @if(old('edit_hotel'))
                                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3">{{old('description')}}</textarea>
                                            @error('description')
                                            <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        @else
                                            <textarea class="form-control" name="description" rows="3">{{$hotel->description}}</textarea>
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Icon</label>
                                        @if(old('edit_hotel'))
                                            <input class="form-control @error('icon') is-invalid @enderror" type="file" name="icon">
                                            @error('icon')
                                            <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        @else
                                            <input class="form-control" type="file" type="file" name="icon">
                                        @endif
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label">Images</label>
                                        @if(old('edit_hotel'))
                                            <input class="form-control @error('images.*') is-invalid @enderror" type="file" name="images[]" multiple>
                                            @error('images.0')
                                            <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        @else
                                            <input class="form-control" type="file" name="images[]" multiple>
                                        @endif
                                    </div>
                                    <div style="display: flex; flex-wrap: wrap;" class="mb-3">
                                        @foreach($images as $image)
                                            @if($image->type == "Hotel" && $image->hotel_id == $hotel->id)
                                                <div class="card mb-2 me-2" style="border: none !important;">
                                                    <img src="{{url('images/hotels/'.$image->filename)}}" style="height:200px; max-width:400px;" class="" alt="{{$image->filename}}">
                                                    <div class="card-img-overlay">
                                                        <a href="{{route('thumbnail-image-hotel', ['id' => $hotel->id, 'image_id' => $image->id])}}" type="button" class="btn btn-primary p-1 material-symbols-outlined">account_box</a>
                                                        <a href="{{route('delete-image-hotel', ['id' => $hotel->id, 'image_id' => $image->id])}}" type="button" class="btn btn-danger p-1 material-symbols-outlined">delete</a>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <input type="hidden" class="form-control" name="toast_validation" value="Edit hotel failed." required/>
                                    <input type="hidden" class="form-control" name="edit_hotel" value="{{$hotel->id}}" required/>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger col" data-bs-toggle="modal" data-bs-target="#hotel_modal_{{$hotel->id}}">
                                        Back
                                    </button>
                                    <button type="submit" class="btn btn-primary col">
                                        Submit
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit_hotel_location_modal_{{$hotel->id}}" id="edit_hotel_location_button_{{$hotel->id}}" hidden></button>
                <div class="modal fade" id="edit_hotel_location_modal_{{$hotel->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form method="post" action="{{route('edit-hotel-location', ['id' => $hotel->id])}}">
                                @method('patch')
                                <input type="text" hidden class="form-control" id="edit_hotel_location_lat_{{$hotel->id}}" name="lat" value="{{$hotel->lat}}" readonly/>
                                <input type="text" hidden class="form-control" id="edit_hotel_location_lng_{{$hotel->id}}" name="lng" value="{{$hotel->lng}}" readonly/>
                                <div class="modal-header">
                                    <h1 class="modal-title fs-3" id="exampleModalLabel">{{$hotel->name}}</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <h5 class="lead">Are you sure want to move hotel location: {{$hotel->name}}?</h5>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary col">
                                        Yes
                                   </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <script>
                    $('#edit_hotel_location_modal_{{$hotel->id}}').on('hidden.bs.modal', function () { 
                        window.location.reload();
                    });
                    
                </script>

                <div class="modal fade" id="delete_hotel_modal_{{$hotel->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form method="post" action="{{route('delete-hotel', ['id' => $hotel->id])}}">
                                @method('delete')
                                <div class="modal-header">
                                    <h1 class="modal-title fs-3" id="exampleModalLabel">{{$hotel->name}}</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <h5 class="lead">Are you sure want to delete hotel: {{$hotel->name}}?</h5>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger col" data-bs-toggle="modal" data-bs-target="#hotel_modal_{{$hotel->id}}">
                                        Back
                                    </button>
                                    <button type="submit" class="btn btn-primary col">
                                        Submit
                                   </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endif

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#hotel_room_modal_{{$hotel->id}}" id="room_button_{{$hotel->id}}" hidden></button>

                @if(empty($user))


                    <div class="modal fade" id="hotel_room_modal_{{$hotel->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-3" id="exampleModalLabel">{{$hotel->name}}</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item">
                                            <a type="button" class="nav-link" data-bs-toggle="modal" data-bs-target="#hotel_modal_{{$hotel->id}}">Hotel</a>
                                        </li>
                                        <li class="nav-item">
                                            <a type="button" class="nav-link active">Room</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="modal-body">
                                    @foreach($rooms as $room)
                                        @if($room->hotel_id == $hotel->id)
                                            <div class="card mb-3 rounded-0">
                                                <div class="row g-0">
                                                    <div class="col-md-4">
                                                        @foreach($images as $image)
                                                            @if($image->hotel_id == $hotel->id && $image->room_id == $room->id && $image->type == "Room" && $image->is_thumbnail == "1")
                                                            <img src="{{url('images/rooms/'.$image->filename)}}" class="img-fluid rounded-0 h-100">
                                                            @break
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                    <div class="col-md-8">
                                                    <div class="card-body">
                                                        <div class="d-flex flex-wrap">
                                                            <a href="" data-bs-toggle="modal" data-bs-target="#read_room_modal_{{$room->id}}" id="read_room_button_{{$room->id}}"><h4 class="card-title">{{$room->name}}</h4></a>
                                                            @if(!empty($user))
                                                            <div class="dropdown ms-2">
                                                                <span class="material-symbols-outlined mt-1 text-dark" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    arrow_drop_down
                                                                </span>
                                                                <ul class="dropdown-menu">
                                                                    <li><a class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#edit_room_modal_{{$room->id}}" id="edit_room_button_{{$room->id}}">Edit</a></li>
                                                                    <li><a class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#delete_room_modal_{{$room->id}}">Delete</a></li>
                                                                </ul>
                                                            </div>
                                                            @endif
                                                        </div>
                                                        
                                                        @if(!empty($room->description))
                                                        <p class="card-text mb-0 text-secondary">{{Str::limit($room->description, 500)}}</p>
                                                        @endif
                                                        <hr>
                                                        <div class="row">
                                                            <div class="col-5">
                                                                <h5 class="card-title mb-1" style="color:salmon"><strong>Rp{{number_format($room->price , 0, ',', '.')}}</strong><small>/night</small></h5>
                                                                <small class="badge rounded-pill text-bg-success text-white">{{$room->count}} Rooms Available</small>
                                                            </div>
                                                            <div class="col-7">
                                                                <div class="d-flex flex-wrap">
                                                                    @foreach($room_facilities as $room_facility)
                                                                        @if($room_facility->room_id == $room->id)
                                                                            @if($room_facility->facility->count == 0)
                                                                                <p class="mb-0 me-2"><span class="material-symbols-outlined text-success">done</span><small class="text-body-secondary" style="vertical-align: top">{{$room_facility->facility->name}}</small></p>
                                                                            @else
                                                                                <p class="mb-0 me-2"><span class="material-symbols-outlined text-success">done</span><small class="text-body-secondary" style="vertical-align: top">{{$room_facility->facility->count." ".$room_facility->facility->name}}</small></p>
                                                                            @endif
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    @foreach($rooms as $room)
                        @if($room->hotel_id == $hotel->id)


                            <div class="modal fade" id="read_room_modal_{{$room->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-3" id="exampleModalLabel">{{$hotel->name}}</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="">
                                            <ul class="nav nav-tabs">
                                                <li class="nav-item">
                                                    <a type="button" class="nav-link" data-bs-toggle="modal" data-bs-target="#hotel_modal_{{$hotel->id}}">Hotel</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a type="button" class="nav-link active">Room</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="modal-body">
                                            <div id="room_image_{{$room->id}}" class="carousel slide mb-3">
                                                <div class="carousel-inner">
                                                    @foreach($images as $image)
                                                        @if($image->hotel_id == $hotel->id && $image->room_id == $room->id && $image->type == "Room")
                                                            @if($image->is_thumbnail == 1)
                                                                <div class="carousel-item active">
                                                                    <img src="{{url('images/rooms/'.$image->filename)}}" class="d-block" style="max-height:1000px; width:100%; margin-left: auto; margin-right: auto;">
                                                                </div>
                                                            @else
                                                                <div class="carousel-item">
                                                                    <img src="{{url('images/rooms/'.$image->filename)}}" class="d-block" style="max-height:1000px; width:100%; margin-left: auto; margin-right: auto;">
                                                                </div>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                </div>
                                                <button class="carousel-control-prev" type="button" data-bs-target="#room_image_{{$room->id}}" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Previous</span>
                                                </button>
                                                <button class="carousel-control-next" type="button" data-bs-target="#room_image_{{$room->id}}" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Next</span>
                                                </button>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Name</label>
                                                <input type="text" class="form-control" value="{{$room->name}}" disabled readonly/>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Price</label>
                                                <input type="text" class="form-control" value="Rp{{number_format($room->price , 0, ',', '.')}}" disabled readonly/>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Count</label>
                                                <input type="text" class="form-control" value="{{$room->count}}" disabled readonly/>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Description</label>
                                                <textarea class="form-control" rows="3" disabled readonly>{{$room->description}}</textarea>
                                            </div>
                                            <div>
                                                <label class="form-label">Facility</label>
                                                <div style="display: flex; flex-wrap: wrap;">
                                                @foreach($room_facilities as $room_facility)
                                                    @if($room_facility->room_id == $room->id)
                                                        <div class="card me-3 mb-3 rounded-0" style="width:230px">
                                                            <div class="">
                                                                <div class="card-img-top">
                                                                    @php
                                                                        $facility_images_check = 0;
                                                                    @endphp
                                                                    @foreach($images as $image)
                                                                        @if($image->hotel_id == $hotel->id && $image->facility_id == $room_facility->facility_id && $image->type == "Facility")
                                                                            @php
                                                                                $facility_images_check = 1;
                                                                                break;
                                                                            @endphp
                                                                        @endif
                                                                    @endforeach
                                                                    @if($facility_images_check == 1)
                                                                        <div id="room_facility_image_{{$room->id}}_{{$room_facility->facility_id}}" class="carousel slide">
                                                                            <div class="carousel-inner">
                                                                                @foreach($images as $image)
                                                                                    @if($image->hotel_id == $hotel->id && $image->facility_id == $room_facility->facility_id && $image->type == "Facility")
                                                                                        @if($image->is_thumbnail == 1)
                                                                                            <div class="carousel-item active">
                                                                                                <img src="{{url('images/facilities/'.$image->filename)}}" class="d-block" style="max-height:225px; width:100%; margin-left: auto; margin-right: auto;">
                                                                                            </div>
                                                                                        @else
                                                                                            <div class="carousel-item">
                                                                                                <img src="{{url('images/facilities/'.$image->filename)}}" class="d-block" style="max-height:225px; width:100%; margin-left: auto; margin-right: auto;">
                                                                                            </div>
                                                                                        @endif
                                                                                    @endif
                                                                                @endforeach
                                                                            </div>
                                                                            <button class="carousel-control-prev" type="button" data-bs-target="#room_facility_image_{{$room->id}}_{{$room_facility->facility_id}}" data-bs-slide="prev">
                                                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                                                <span class="visually-hidden">Previous</span>
                                                                            </button>
                                                                            <button class="carousel-control-next" type="button" data-bs-target="#room_facility_image_{{$room->id}}_{{$room_facility->facility_id}}" data-bs-slide="next">
                                                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                                                <span class="visually-hidden">Next</span>
                                                                            </button>
                                                                        </div>
                                                                    @else
                                                                        <img src="{{url('images/no_image.jpg')}}" style="max-height:225px; width:100%; margin-left: auto; margin-right: auto;">
                                                                    @endif
                                                                </div>
                                                                <div class="card-body">
                                                                    <p class="card-text">
                                                                        @if($room_facility->facility->count == 0)
                                                                            {{$room_facility->facility->name}}
                                                                        @else
                                                                            {{$room_facility->facility->count}} {{$room_facility->facility->name}}
                                                                        @endif
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger col" data-bs-toggle="modal" data-bs-target="#hotel_room_modal_{{$hotel->id}}">
                                                Back
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif

                @if(!empty($user))


                <div class="modal fade" id="hotel_room_modal_{{$hotel->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-3" id="exampleModalLabel">{{$hotel->name}}</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a type="button" class="nav-link" data-bs-toggle="modal" data-bs-target="#hotel_modal_{{$hotel->id}}">Hotel</a>
                                    </li>
                                    <li class="nav-item">
                                        <a type="button" class="nav-link active">Room</a>
                                    </li>
                                    <li class="nav-item">
                                        <a type="button" class="nav-link" data-bs-toggle="modal" data-bs-target="#hotel_facility_modal_{{$hotel->id}}">Facility</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="modal-body">
                            <a type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#create_room_modal_{{$hotel->id}}" id="create_room_button_{{$hotel->id}}">Create</a>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                        <th class="text-center" scope="col-1">No</th>
                                        <th scope="col-8">Name</th>
                                        <th class="text-center" scope="col-1">Count</th>
                                        <th scope="col-1" class="text-center">Price</th>
                                        <th class="text-center" scope="col-1">Option</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach($rooms as $room)
                                            @if($room->hotel_id == $hotel->id)
                                                <tr>
                                                    <td class="text-center">{{$i}}</th>
                                                    <td>{{$room->name}}</td>
                                                    <td class="text-center">{{$room->count}}</td>
                                                    <td>Rp{{number_format($room->price , 0, ',', '.')}}</td>
                                                    <td class="text-center">
                                                        <div class="dropdown ms-2">
                                                            <span class="material-symbols-outlined mt-1 text-dark" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                more_vert
                                                            </span>
                                                            <ul class="dropdown-menu">
                                                                <li><a type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#read_room_modal_{{$room->id}}" id="read_room_button_{{$room->id}}">Detail</a></li>
                                                                <li><a class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#edit_room_modal_{{$room->id}}" id="edit_room_button_{{$room->id}}">Edit</a></li>
                                                                <li><a class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#delete_room_modal_{{$room->id}}">Delete</a></li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @php
                                                    $i++;
                                                @endphp
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="create_room_modal_{{$hotel->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                        <div class="modal-content">
                            <form class="modal-content" method="post" action="{{route('create-room', ['id' => $hotel->id])}}" enctype="multipart/form-data">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-3" id="exampleModalLabel">{{$hotel->name}}</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item">
                                            <a type="button" class="nav-link" data-bs-toggle="modal" data-bs-target="#hotel_modal_{{$hotel->id}}">Hotel</a>
                                        </li>
                                        <li class="nav-item">
                                            <a type="button" class="nav-link active">Room</a>
                                        </li>
                                        <li class="nav-item">
                                            <a type="button" class="nav-link" data-bs-toggle="modal" data-bs-target="#hotel_facility_modal_{{$hotel->id}}">Facility</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Name<span class="required-form"> *</span></label>
                                        @if(old('create_room') == $hotel->id)
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{old('name')}}" required/>
                                            @error('name')
                                            <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        @else
                                            <input type="text" class="form-control" name="name" value="" required/>
                                        @endif
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <label class="form-label">Price<span class="required-form"> *</span></label>
                                            @if(old('create_room') == $hotel->id)
                                                <div class="input-group rounded-0">
                                                    <span class="input-group-text rounded-0">Rp</span>
                                                    <input type="number" class="form-control @error('price') is-invalid @enderror" name="price" value="{{old('price')}}" required>
                                                    @error('price')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                    @enderror
                                                </div>
                                            @else
                                                <div class="input-group rounded-0">
                                                    <span class="input-group-text rounded-0">Rp</span>
                                                    <input type="number" class="form-control" name="price" value="" placeholder="Price per night" required>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label">Count<span class="required-form"> *</span></label>
                                            @if(old('create_room') == $hotel->id)
                                                <input type="number" class="form-control @error('count') is-invalid @enderror" name="count" value="{{old('count')}}" required/>
                                                @error('count')
                                                <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                            @else
                                                <input type="number" class="form-control" name="count" value="" required/>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        @if(old('create_room') == $hotel->id)
                                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3">{{old('description')}}</textarea>
                                            @error('description')
                                            <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        @else
                                            <textarea class="form-control" name="description" rows="3"></textarea>
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        @php
                                            $old_facilities = [];
                                            if(!empty(old('facilities_counter'))){
                                                for($i = 0; $i < old('facilities_counter'); $i++){
                                                    array_push($old_facilities, old('facilities.'.$i));
                                                }
                                            }
                                            if(old('create_room')){
                                                $old_create_room = old('create_room');
                                            }else{
                                                $old_create_room = 0;
                                            }
                                            $exist = false;
                                            foreach($facilities as $facility){
                                                if($facility->hotel_id == $hotel->id && $facility->type == 'Room'){
                                                    $exist = true;
                                                    break;
                                                }
                                            }
                                        @endphp
                                        @livewire('room-facility', ['facilities' => $facilities, 'hotel_id' => $hotel->id, 'exist' => $exist, 'old_create_room' => $old_create_room, 'crud' => 'create', 'old_facilities' => $old_facilities, 'old_count' => count($old_facilities), 'facilities_count' => 0], key($hotel->id))
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Images<span class="required-form"> *</span></label>
                                        @if(old('create_room') == $hotel->id)
                                            <input class="form-control @error('images.*') is-invalid @enderror" type="file" name="images[]" multiple required>
                                            @error('images.0')
                                            <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        @else
                                            <input class="form-control" type="file" name="images[]" multiple required>
                                        @endif
                                    </div>
                                    <input type="hidden" class="form-control" name="toast_validation" value="Create room failed." required/>
                                    <input type="hidden" class="form-control" name="create_room" value="{{$hotel->id}}" required/>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger col" data-bs-toggle="modal" data-bs-target="#hotel_room_modal_{{$hotel->id}}">
                                        Back
                                    </button>
                                    <button type="submit" class="btn btn-primary col">
                                        Submit
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                @foreach($rooms as $room)
                    @if($room->hotel_id == $hotel->id)


                        <div class="modal fade" id="read_room_modal_{{$room->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-3" id="exampleModalLabel">{{$hotel->name}}</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a type="button" class="nav-link" data-bs-toggle="modal" data-bs-target="#hotel_modal_{{$hotel->id}}">Hotel</a>
                                            </li>
                                            <li class="nav-item">
                                                <a type="button" class="nav-link active">Room</a>
                                            </li>
                                            <li class="nav-item">
                                                <a type="button" class="nav-link" data-bs-toggle="modal" data-bs-target="#hotel_facility_modal_{{$hotel->id}}">Facility</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="modal-body">
                                        <div id="room_image_{{$room->id}}" class="carousel slide mb-3">
                                            <div class="carousel-inner">
                                                @foreach($images as $image)
                                                    @if($image->hotel_id == $hotel->id && $image->room_id == $room->id && $image->type == "Room")
                                                        @if($image->is_thumbnail == 1)
                                                            <div class="carousel-item active">
                                                                <img src="{{url('images/rooms/'.$image->filename)}}" class="d-block" style="max-height:1000px; width:100%; margin-left: auto; margin-right: auto;">
                                                            </div>
                                                        @else
                                                            <div class="carousel-item">
                                                                <img src="{{url('images/rooms/'.$image->filename)}}" class="d-block" style="max-height:1000px; width:100%; margin-left: auto; margin-right: auto;">
                                                            </div>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </div>
                                            <button class="carousel-control-prev" type="button" data-bs-target="#room_image_{{$room->id}}" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#room_image_{{$room->id}}" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Name</label>
                                            <input type="text" class="form-control" value="{{$room->name}}" disabled readonly/>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Price</label>
                                            <input type="text" class="form-control" value="Rp{{number_format($room->price , 0, ',', '.')}}" disabled readonly/>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Count</label>
                                            <input type="text" class="form-control" value="{{$room->count}}" disabled readonly/>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Description</label>
                                            <textarea class="form-control" rows="3" disabled readonly>{{$room->description}}</textarea>
                                        </div>
                                        <div>
                                            <label class="form-label">Facility</label>
                                            <div style="display: flex; flex-wrap: wrap;">
                                            @foreach($room_facilities as $room_facility)
                                                @if($room_facility->room_id == $room->id)
                                                    <div class="card me-3 mb-3 rounded-0" style="width:230px">
                                                        <div class="">
                                                            <div class="card-img-top">
                                                                @php
                                                                    $facility_images_check = 0;
                                                                @endphp
                                                                @foreach($images as $image)
                                                                    @if($image->hotel_id == $hotel->id && $image->facility_id == $room_facility->facility_id && $image->type == "Facility")
                                                                        @php
                                                                            $facility_images_check = 1;
                                                                            break;
                                                                        @endphp
                                                                    @endif
                                                                @endforeach
                                                                @if($facility_images_check == 1)
                                                                    <div id="room_facility_image_{{$room->id}}_{{$room_facility->facility_id}}" class="carousel slide">
                                                                        <div class="carousel-inner">
                                                                            @foreach($images as $image)
                                                                                @if($image->hotel_id == $hotel->id && $image->facility_id == $room_facility->facility_id && $image->type == "Facility")
                                                                                    @if($image->is_thumbnail == 1)
                                                                                        <div class="carousel-item active">
                                                                                            <img src="{{url('images/facilities/'.$image->filename)}}" class="d-block" style="max-height:225px; width:100%; margin-left: auto; margin-right: auto;">
                                                                                        </div>
                                                                                    @else
                                                                                        <div class="carousel-item">
                                                                                            <img src="{{url('images/facilities/'.$image->filename)}}" class="d-block" style="max-height:225px; width:100%; margin-left: auto; margin-right: auto;">
                                                                                        </div>
                                                                                    @endif
                                                                                @endif
                                                                            @endforeach
                                                                        </div>
                                                                        <button class="carousel-control-prev" type="button" data-bs-target="#room_facility_image_{{$room->id}}_{{$room_facility->facility_id}}" data-bs-slide="prev">
                                                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                                            <span class="visually-hidden">Previous</span>
                                                                        </button>
                                                                        <button class="carousel-control-next" type="button" data-bs-target="#room_facility_image_{{$room->id}}_{{$room_facility->facility_id}}" data-bs-slide="next">
                                                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                                            <span class="visually-hidden">Next</span>
                                                                        </button>
                                                                    </div>
                                                                @else
                                                                    <img src="{{url('images/no_image.jpg')}}" style="max-height:225px; width:100%; margin-left: auto; margin-right: auto;">
                                                                @endif
                                                            </div>
                                                            <div class="card-body">
                                                                <p class="card-text">
                                                                    @if($room_facility->facility->count == 0)
                                                                        {{$room_facility->facility->name}}
                                                                    @else
                                                                        {{$room_facility->facility->count}} {{$room_facility->facility->name}}
                                                                    @endif
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger col" data-bs-toggle="modal" data-bs-target="#hotel_room_modal_{{$hotel->id}}">
                                            Back
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="modal fade" id="edit_room_modal_{{$room->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                                <div class="modal-content">
                                    <form class="modal-content" method="post" action="{{route('edit-room', ['id' => $room->id])}}" enctype="multipart/form-data">
                                        @method('put')
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-3" id="exampleModalLabel">{{$hotel->name}}</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="">
                                            <ul class="nav nav-tabs">
                                                <li class="nav-item">
                                                    <a type="button" class="nav-link" data-bs-toggle="modal" data-bs-target="#hotel_modal_{{$hotel->id}}">Hotel</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a type="button" class="nav-link active">Room</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a type="button" class="nav-link" data-bs-toggle="modal" data-bs-target="#hotel_facility_modal_{{$hotel->id}}">Facility</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="modal-body">
                                            <div class="text-center mb-3">
                                                @foreach($images as $image)
                                                    @if($image->type == "Room" && $image->room_id == $room->id)
                                                        @if($image->is_thumbnail == 1 )
                                                        <img src="{{url('images/rooms/'.$image->filename)}}" style="max-height:1000px; width:100%;">
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Name<span class="required-form"> *</span></label>
                                                @if(old('edit_room') == $room->id)
                                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{old('name')}}" required/>
                                                    @error('name')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                    @enderror
                                                @else
                                                    <input type="text" class="form-control" name="name" value="{{$hotel->name}}" required/>
                                                @endif
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-6">
                                                    <label class="form-label">Price<span class="required-form"> *</span></label>
                                                    @if(old('edit_room') == $room->id)
                                                        <div class="input-group rounded-0">
                                                            <span class="input-group-text rounded-0">Rp</span>
                                                            <input type="number" class="form-control @error('price') is-invalid @enderror" name="price" value="{{old('price')}}" required>
                                                            @error('price')
                                                            <div class="invalid-feedback">{{$message}}</div>
                                                            @enderror
                                                        </div>
                                                    @else
                                                        <div class="input-group rounded-0">
                                                            <span class="input-group-text rounded-0">Rp</span>
                                                            <input type="number" class="form-control" name="price" value="{{$room->price}}" placeholder="Price per night" required>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label">Count<span class="required-form"> *</span></label>
                                                    @if(old('edit_room') == $room->id)
                                                        <input type="number" class="form-control @error('count') is-invalid @enderror" name="count" value="{{old('count')}}" required/>
                                                        @error('count')
                                                        <div class="invalid-feedback">{{$message}}</div>
                                                        @enderror
                                                    @else
                                                        <input type="number" class="form-control" name="count" value="{{$room->count}}" required/>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Description</label>
                                                @if(old('edit_room') == $room->id)
                                                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3">{{old('description')}}</textarea>
                                                    @error('description')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                    @enderror
                                                @else
                                                    <textarea class="form-control" name="description" rows="3">{{$room->description}}</textarea>
                                                @endif
                                            </div>
                                            <div class="mb-3">
                                                @php
                                                    $old_facilities = [];
                                                    if(!empty(old('facilities_counter'))){
                                                        for($i = 0; $i < old('facilities_counter'); $i++){
                                                            array_push($old_facilities, old('facilities.'.$i));
                                                        }
                                                    }
                                                    if(old('edit_room')){
                                                        $old_edit_room = old('edit_room');
                                                    }else{
                                                        $old_edit_room = 0;
                                                    }
                                                    $exist = false;
                                                    foreach($facilities as $facility){
                                                        if($facility->hotel_id == $hotel->id && $facility->type == 'Room'){
                                                            $exist = true;
                                                            break;
                                                        }
                                                    }
                                                    $room_facilities_data = [];
                                                    foreach($room_facilities as $room_facility){
                                                        if($room_facility->room_id == $room->id){
                                                            array_push($room_facilities_data, $room_facility->facility_id);
                                                        }
                                                    }
                                                @endphp
                                                @livewire('room-facility', ['facilities' => $facilities, 'hotel_id' => $hotel->id, 'exist' => $exist, 'old_edit_room' => $old_edit_room, 'crud' => 'edit', 'old_facilities' => $old_facilities, 'old_count' => count($old_facilities), 'facilities_count' => 0, 'room_facilities_data' => $room_facilities_data, 'count_room_facilities_data' => count($room_facilities_data)], key($room->id*-1))
                                            </div>
                                            <div class="mb-4">
                                                <label class="form-label">Images</label>
                                                @if(old('edit_room') == $room->id)
                                                    <input class="form-control @error('images.*') is-invalid @enderror" type="file" name="images[]" multiple>
                                                    @error('images.0')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                    @enderror
                                                @else
                                                    <input class="form-control" type="file" name="images[]" multiple>
                                                @endif
                                            </div>
                                            <div style="display: flex; flex-wrap: wrap;" class="mb-3">
                                                @foreach($images as $image)
                                                    @if($image->type == "Room" && $image->room_id == $room->id)
                                                        <div class="card mb-2 me-2" style="border: none !important;">
                                                            <img src="{{url('images/rooms/'.$image->filename)}}" style="height:200px; max-width:400px;" class="" alt="{{$image->filename}}">
                                                            <div class="card-img-overlay">
                                                                <a href="{{route('thumbnail-image-room', ['id' => $room->id, 'image_id' => $image->id])}}" type="button" class="btn btn-primary p-1 material-symbols-outlined">account_box</a>
                                                                <a href="{{route('delete-image-room', ['id' => $room->id, 'image_id' => $image->id])}}" type="button" class="btn btn-danger p-1 material-symbols-outlined">delete</a>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                            <input type="hidden" class="form-control" name="toast_validation" value="Edit room failed." required/>
                                            <input type="hidden" class="form-control" name="edit_room" value="{{$room->id}}" required/>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger col" data-bs-toggle="modal" data-bs-target="#hotel_room_modal_{{$hotel->id}}">
                                                Back
                                            </button>
                                            <button type="submit" class="btn btn-primary col">
                                                Submit
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                        <div class="modal fade" id="delete_room_modal_{{$room->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form method="post" action="{{route('delete-room', ['id' => $room->id, 'hotel_id' => $hotel->id])}}">
                                        @method('delete')
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-3" id="exampleModalLabel">{{$hotel->name}}</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <h5 class="lead">Are you sure want to delete room: {{$room->name}}?</h5>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger col" data-bs-toggle="modal" data-bs-target="#hotel_room_modal_{{$hotel->id}}">
                                                Back
                                            </button>
                                            <button type="submit" class="btn btn-primary col">
                                                Submit
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
                @endif

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#hotel_facility_modal_{{$hotel->id}}" id="facility_button_{{$hotel->id}}" hidden></button>

                @if(!empty($user))


                <div class="modal fade" id="hotel_facility_modal_{{$hotel->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-3" id="exampleModalLabel">{{$hotel->name}}</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a type="button" class="nav-link" data-bs-toggle="modal" data-bs-target="#hotel_modal_{{$hotel->id}}">Hotel</a>
                                    </li>
                                    <li class="nav-item">
                                        <a type="button" class="nav-link" data-bs-toggle="modal" data-bs-target="#hotel_room_modal_{{$hotel->id}}">Room</a>
                                    </li>
                                    <li class="nav-item">
                                        <a type="button" class="nav-link active">Facility</a>
                                    </li>
                                </ul>
                            </div>
                            
                            <div class="modal-body">
                                <a type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#create_facility_modal_{{$hotel->id}}" id="create_facility_button_{{$hotel->id}}">Create</a>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                        <th class="text-center" scope="col-1">No</th>
                                        <th scope="col-8">Name</th>
                                        <th class="text-center" scope="col-1">Count</th>
                                        <th scope="col-1" class="text-center">Type</th>
                                        <th class="text-center" scope="col-1">Option</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach($facilities as $facility)
                                            @if($facility->hotel_id == $hotel->id)
                                                <tr>
                                                    <td class="text-center">{{$i}}</th>
                                                    <td>{{$facility->name}}</td>
                                                    @if($facility->count == 0)
                                                        <td class="text-center">-</td>
                                                    @else
                                                        <td class="text-center">{{$facility->count}}</td>
                                                    @endif
                                                    <td class="text-center">{{$facility->type}}</td>
                                                    <td class="text-center">
                                                        <div class="dropdown ms-2">
                                                            <span class="material-symbols-outlined mt-1 text-dark" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                more_vert
                                                            </span>
                                                            <ul class="dropdown-menu">
                                                                <li><a type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#read_facility_modal_{{$facility->id}}" id="read_facility_button_{{$facility->id}}">Detail</a></li>
                                                                @if(!empty($user))
                                                                <li><a type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit_facility_modal_{{$facility->id}}" id="edit_facility_button_{{$facility->id}}">Edit</a></li>
                                                                <li><a type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#delete_facility_modal_{{$facility->id}}">Delete</a></li>
                                                                @endif
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @php
                                                    $i++;
                                                @endphp
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            
                
                <div class="modal fade" id="create_facility_modal_{{$hotel->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                        <div class="modal-content">
                            <form method="post" action="{{route('create-facility', ['id' => $hotel->id])}}" enctype="multipart/form-data">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-3" id="exampleModalLabel">{{$hotel->name}}</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item">
                                            <a type="button" class="nav-link" data-bs-toggle="modal" data-bs-target="#hotel_modal_{{$hotel->id}}">Hotel</a>
                                        </li>
                                        <li class="nav-item">
                                            <a type="button" class="nav-link" data-bs-toggle="modal" data-bs-target="#hotel_room_modal_{{$hotel->id}}">Room</a>
                                        </li>
                                        <li class="nav-item">
                                            <a type="button" class="nav-link active">Facility</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Name<span class="required-form"> *</span></label>
                                        @if(old('create_facility') == $hotel->id)
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{old('name')}}" required/>
                                            @error('name')
                                            <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        @else
                                            <input type="text" class="form-control" name="name" value="" required/>
                                        @endif
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <label class="form-label">Count<span class="required-form"> *</span></label>
                                            @if(old('create_facility') == $hotel->id)
                                                <input type="number" class="form-control @error('count') is-invalid @enderror" name="count" value="{{old('count')}}" placeholder="If uncountable fill with 0" required/>
                                                @error('count')
                                                <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                            @else
                                                <input type="number" class="form-control" name="count" value="" placeholder="If uncountable fill with 0" required/>
                                            @endif
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label">Type<span class="required-form"> *</span></label>
                                            <select class="form-select" name="type">
                                                @if(old('create_facility') == $hotel->id && old('type') == "Room")
                                                    <option value="Hotel">Hotel</option>
                                                    <option value="Room" selected>Room</option>
                                                @else
                                                    <option value="Hotel" selected>Hotel</option>
                                                    <option value="Room">Room</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Images</label>
                                        @if(old('create_facility') == $hotel->id)
                                            <input class="form-control @error('images.*') is-invalid @enderror" type="file" name="images[]" multiple>
                                            @error('images.0')
                                            <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        @else
                                            <input class="form-control" type="file" name="images[]" multiple>
                                        @endif
                                    </div>
                                    <input type="hidden" class="form-control" name="toast_validation" value="Create facility failed." required/>
                                    <input type="hidden" class="form-control" name="create_facility" value="{{$hotel->id}}" required/>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger col" data-bs-toggle="modal" data-bs-target="#hotel_facility_modal_{{$hotel->id}}">
                                        Back
                                    </button>
                                    <button type="submit" class="btn btn-primary col">
                                        Submit
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            

                @foreach($facilities as $facility)
                    @if($facility->hotel_id == $hotel->id)


                        <div class="modal fade" id="read_facility_modal_{{$facility->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-3" id="exampleModalLabel">{{$hotel->name}}</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a type="button" class="nav-link" data-bs-toggle="modal" data-bs-target="#hotel_modal_{{$hotel->id}}">Hotel</a>
                                            </li>
                                            <li class="nav-item">
                                                <a type="button" class="nav-link" data-bs-toggle="modal" data-bs-target="#hotel_room_modal_{{$hotel->id}}">Room</a>
                                            </li>
                                            <li class="nav-item">
                                                <a type="button" class="nav-link active">Facility</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="modal-body">
                                        @php
                                            $facility_images_check = 0;
                                        @endphp
                                        @foreach($images as $image)
                                            @if($image->hotel_id == $hotel->id && $image->facility_id == $facility->id && $image->type == "Facility")
                                                @php
                                                    $facility_images_check = 1;
                                                    break;
                                                @endphp
                                            @endif
                                        @endforeach
                                        @if($facility_images_check == 1)
                                        <div id="facility_image_{{$facility->id}}" class="carousel slide mb-3">
                                            <div class="carousel-inner">
                                                @foreach($images as $image)
                                                    @if($image->hotel_id == $hotel->id && $image->facility_id == $facility->id && $image->type == "Facility")
                                                        @if($image->is_thumbnail == 1)
                                                            <div class="carousel-item active">
                                                                <img src="{{url('images/facilities/'.$image->filename)}}" class="d-block" style="max-height:1000px; width:100%; margin-left: auto; margin-right: auto;">
                                                            </div>
                                                        @else
                                                            <div class="carousel-item">
                                                                <img src="{{url('images/facilities/'.$image->filename)}}" class="d-block" style="max-height:1000px; width:100%; margin-left: auto; margin-right: auto;">
                                                            </div>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </div>
                                            <button class="carousel-control-prev" type="button" data-bs-target="#facility_image_{{$facility->id}}" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#facility_image_{{$facility->id}}" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>
                                        </div>
                                        @endif
                                        <div class="mb-3">
                                            <label class="form-label">Name</span></label>
                                            <input type="text" class="form-control" value="{{$facility->name}}" disabled readonly/>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <label class="form-label">Count</span></label>
                                                @if($facility->count == 0)
                                                    <input type="text" class="form-control" value="-" disabled readonly/>
                                                @else
                                                    <input type="text" class="form-control" value="{{$facility->count}}" disabled readonly/>
                                                @endif
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label">Type</span></label>
                                                <input type="text" class="form-control" value="{{$facility->type}}" disabled readonly/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger col" data-bs-toggle="modal" data-bs-target="#hotel_facility_modal_{{$hotel->id}}">
                                            Back
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="modal fade" id="edit_facility_modal_{{$facility->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                                <div class="modal-content">
                                    <form class="modal-content" method="post" action="{{route('edit-facility', ['id' => $facility->id])}}" enctype="multipart/form-data">
                                        @method('put')
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-3" id="exampleModalLabel">{{$hotel->name}}</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="">
                                            <ul class="nav nav-tabs">
                                                <li class="nav-item">
                                                    <a type="button" class="nav-link" data-bs-toggle="modal" data-bs-target="#hotel_modal_{{$hotel->id}}">Hotel</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a type="button" class="nav-link" data-bs-toggle="modal" data-bs-target="#hotel_room_modal_{{$hotel->id}}">Room</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a type="button" class="nav-link active">Facility</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="modal-body">
                                            @foreach($images as $image)
                                                @if($image->type == "Facility" && $image->facility_id == $facility->id)
                                                    @if($image->is_thumbnail == 1 )
                                                        <div class="text-center mb-3">
                                                            <img src="{{url('images/facilities/'.$image->filename)}}" style="max-height:1000px; width:100%;">
                                                        </div>
                                                    @endif
                                                @endif
                                            @endforeach
                                            <div class="mb-3">
                                                <label class="form-label">Name<span class="required-form"> *</span></label>
                                                @if(old('edit_facility') == $facility->id)
                                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{old('name')}}" required/>
                                                    @error('name')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                    @enderror
                                                @else
                                                    <input type="text" class="form-control" name="name" value="{{$facility->name}}" required/>
                                                @endif
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-6">
                                                    <label class="form-label">Count<span class="required-form"> *</span></label>
                                                    @if(old('edit_facility') == $facility->id)
                                                        <input type="number" class="form-control @error('count') is-invalid @enderror" name="count" value="{{old('count')}}" placeholder="If uncountable fill with 0" required/>
                                                        @error('count')
                                                        <div class="invalid-feedback">{{$message}}</div>
                                                        @enderror
                                                    @else
                                                        <input type="number" class="form-control" name="count" value="{{$facility->count}}" placeholder="If uncountable fill with 0" required/>
                                                    @endif
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label">Type<span class="required-form"> *</span></label>
                                                    <select class="form-select" name="type">
                                                        @if(old('edit_facility') == $facility->id && old('type') == "Hotel")
                                                            <option value="Hotel" selected>Hotel</option>
                                                            <option value="Room">Room</option>
                                                        @elseif((old('edit_facility') == $facility->id && old('type') == "Room") || $facility->type == "Room")
                                                            <option value="Hotel">Hotel</option>
                                                            <option value="Room" selected>Room</option>
                                                        @else
                                                            <option value="Hotel" selected>Hotel</option>
                                                            <option value="Room">Room</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Images</label>
                                                @if(old('edit_facility') == $hotel->id)
                                                    <input class="form-control @error('images.*') is-invalid @enderror" type="file" name="images[]" multiple>
                                                    @error('images.0')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                    @enderror
                                                @else
                                                    <input class="form-control" type="file" name="images[]" multiple>
                                                @endif
                                            </div>
                                            <div style="display: flex; flex-wrap: wrap;" class="mb-3">
                                                @foreach($images as $image)
                                                    @if($image->type == "Facility" && $image->facility_id == $facility->id)
                                                        <div class="card mb-2 me-2" style="border: none !important;">
                                                            <img src="{{url('images/facilities/'.$image->filename)}}" style="height:200px; max-width:400px;" class="" alt="{{$image->filename}}">
                                                            <div class="card-img-overlay">
                                                                <a href="{{route('thumbnail-image-facility', ['id' => $facility->id, 'image_id' => $image->id])}}" type="button" class="btn btn-primary p-1 material-symbols-outlined">account_box</a>
                                                                <a href="{{route('delete-image-facility', ['id' => $facility->id, 'image_id' => $image->id])}}" type="button" class="btn btn-danger p-1 material-symbols-outlined">delete</a>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                            <input type="hidden" class="form-control" name="toast_validation" value="Edit facility failed." required/>
                                            <input type="hidden" class="form-control" name="edit_facility" value="{{$facility->id}}" required/>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger col" data-bs-toggle="modal" data-bs-target="#hotel_facility_modal_{{$hotel->id}}">
                                                Back
                                            </button>
                                            <button type="submit" class="btn btn-primary col">
                                                Submit
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                        <div class="modal fade" id="delete_facility_modal_{{$facility->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form method="post" action="{{route('delete-facility', ['id' => $facility->id, 'hotel_id' => $hotel->id])}}">
                                        @method('delete')
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-3" id="exampleModalLabel">{{$hotel->name}}</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                @if($facility->count == 0)
                                                    <h5 class="lead">Are you sure want to delete facility: {{$facility->name}}?</h5>
                                                @else
                                                    <h5 class="lead">Are you sure want to delete facility: {{$facility->count}} {{$facility->name}}?</h5>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger col" data-bs-toggle="modal" data-bs-target="#hotel_facility_modal_{{$hotel->id}}">
                                                Back
                                            </button>
                                            <button type="submit" class="btn btn-primary col">
                                                Submit
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
                @endif


            @endforeach
            <div id="map" style="height: 886px">
                <script type="text/javascript">
                    let hotels = <?php echo json_encode($hotels); ?>;
                    let api_url = <?php echo json_encode(route('api_url')); ?>;
                    let user = <?php echo (!empty($user->name)) ? json_encode($user->name) : 0;  ?>;
                    </script>
                <script type="text/javascript" src="{{url('/js/leaflet-script.js')}}"></script>
            </div>
        </div>
        <!-- <script src="{{url('/js/bootstrap.bundle.min.js')}}"></script> -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        @if(!empty(old('login')) || Session::get('show_login'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById("login_button").click();
            });
        </script>
        @endif
        @if(!empty(old('register')))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById("register_button").click();
            });
        </script>
        @endif
        @if(!empty(old('create_hotel')))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById("create_hotel_button").click();
            });
        </script>
        @endif
        @if(!empty(old('edit_hotel')))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById("edit_hotel_button_{{old('edit_hotel')}}").click();
            });
        </script>
        @endif
        @if($edit_hotel = Session::get('edit_hotel'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById("edit_hotel_button_{{$edit_hotel}}").click();
            });
        </script>
        @endif
        @if($thumbnail_image_hotel = Session::get('thumbnail_image_hotel'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById("edit_hotel_button_{{$thumbnail_image_hotel}}").click();
            });
        </script>
        @endif
        @if($delete_image_hotel = Session::get('delete_image_hotel'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById("edit_hotel_button_{{$delete_image_hotel}}").click();
            });
        </script>
        @endif
        @if(!empty(old('create_room')))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById("create_room_button_{{old('create_room')}}").click();
            });
        </script>
        @endif
        @if($create_room = Session::get('create_room'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById("room_button_{{$create_room}}").click();
            });
        </script>
        @endif
        @if(!empty(old('edit_room')))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById("edit_room_button_{{old('edit_room')}}").click();
            });
        </script>
        @endif
        @if($edit_room = Session::get('edit_room'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById("edit_room_button_{{$edit_room}}").click();
            });
        </script>
        @endif
        @if($thumbnail_image_room = Session::get('thumbnail_image_room'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById("edit_room_button_{{$thumbnail_image_room}}").click();
            });
        </script>
        @endif
        @if($delete_image_room = Session::get('delete_image_room'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById("edit_room_button_{{$delete_image_room}}").click();
            });
        </script>
        @endif
        @if($delete_room = Session::get('delete_room'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById("room_button_{{$delete_room}}").click();
            });
        </script>
        @endif
        @if(!empty(old('create_facility')))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById("create_facility_button_{{old('create_facility')}}").click();
            });
        </script>
        @endif
        @if($create_facility = Session::get('create_facility'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById("facility_button_{{$create_facility}}").click();
            });
        </script>
        @endif
        @if(!empty(old('edit_facility')))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById("edit_facility_button_{{old('edit_facility')}}").click();
            });
        </script>
        @endif
        @if($edit_facility = Session::get('edit_facility'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById("edit_facility_button_{{$edit_facility}}").click();
            });
        </script>
        @endif
        @if($thumbnail_image_facility = Session::get('thumbnail_image_facility'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById("edit_facility_button_{{$thumbnail_image_facility}}").click();
            });
        </script>
        @endif
        @if($delete_image_facility = Session::get('delete_image_facility'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById("edit_facility_button_{{$delete_image_facility}}").click();
            });
        </script>
        @endif
        @if($delete_facility = Session::get('delete_facility'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById("facility_button_{{$delete_facility}}").click();
            });
        </script>
        @endif
        @livewireScripts
    </body>
</html>
