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
        @livewireStyles
        <title>Leaflet Map</title>
    </head>
    <body>
        <div>
            <nav class="navbar bg-success">
                <div class="container-fluid">
                    <a class="navbar-brand" href="{{route('index')}}">
                        <img src="{{url('images/hotel.png')}}" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
                        <span class="text-white">Hotel</span>
                    </a>
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



            <div class="modal fade" id="login_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form method="post" action="{{url('login')}}">
                            <div class="modal-header">
                                <h1 class="modal-title fs-4">Login</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="text" class="form-control" name="email" value="{{old('email')}}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password" required/>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" class="form-control" name="toast_validation" value="Login failed."/>
                                <input type="hidden" class="form-control" name="login" value="login"/>
                                <button class="btn btn-primary" style="width:100%;" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>



            <div class="modal fade" id="register_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form method="post" action="{{url('register')}}">
                            <div class="modal-header">
                                <h1 class="modal-title fs-4">Register</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{old('name')}}">
                                    @error('name')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{old('email')}}">
                                    @error('email')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"/>
                                    @error('password')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password Confirmation</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation"/>
                                    @error('password_confirmation')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <input type="hidden" class="form-control" name="toast_validation" value="Register failed."/>
                                <input type="hidden" class="form-control" name="register" value="register"/>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" style="width:100%;" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>



            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create_hotel_modal" id="create_hotel_button" hidden></button>
            <div class="modal fade" id="create_hotel_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <form method="post" action="" enctype="multipart/form-data">
                            <div class="modal-header">
                                <h1 class="modal-title fs-3" id="exampleModalLabel">Create Hotel</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{old('name')}}"/>
                                    @error('name')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Address</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{old('address')}}"/>
                                    @error('address')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{old('phone')}}"/>
                                    @error('phone')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{old('email')}}"/>
                                    @error('email')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Star</label>
                                    <select class="form-select" name="star">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3">{{old('description')}}</textarea>
                                    @error('description')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <input type="text" class="form-control" id="lat" name="lat" hidden/>
                                <input type="text" class="form-control" id="lng" name="lng" hidden/>
                                <input type="hidden" class="form-control" name="toast_validation" value="Create hotel failed."/>
                                <input type="hidden" class="form-control" name="create_hotel" value="create_hotel"/>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger col" data-bs-dismiss="modal">
                                    <span class="material-symbols-outlined">
                                        close
                                    </span>
                                </button>
                                <button type="submit" class="btn btn-primary col">
                                    <span class="material-symbols-outlined">
                                        done
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            @foreach($hotels as $hotel)
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#hotel_modal_{{$hotel->id}}" id="hotel_button_{{$hotel->id}}" hidden></button>
                <div class="modal fade" id="hotel_modal_{{$hotel->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-3" id="exampleModalLabel">Hotel</h1>
                                @if(!empty($user))
                                <div class="dropdown ms-2">
                                    <span class="material-symbols-outlined mt-2 text-primary" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        arrow_drop_down
                                    </span>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Edit</a></li>
                                        <li><a class="dropdown-item" href="#">Delete</a></li>
                                    </ul>
                                </div>
                                @endif
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="">
                                <ul class="nav nav-underline nav-fill">
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
                                <div id="hotel_image_{{$hotel->id}}" class="carousel slide mb-3" style="width:50%; margin-left: auto; margin-right: auto;">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                        <img src="https://cdn.britannica.com/96/115096-050-5AFDAF5D/Bellagio-Hotel-Casino-Las-Vegas.jpg" class="d-block w-100" alt="Image 1">
                                        @if(!empty($user))
                                        <div class="carousel-caption d-none d-md-block">
                                            <a href="/">Set as Thumbnail</a>
                                        </div>
                                        @endif
                                        </div>
                                        <div class="carousel-item">
                                        <img src="https://cdn.britannica.com/39/7139-050-A88818BB/Himalayan-chocolate-point.jpg" class="d-block w-100" alt="Image 2">
                                        </div>
                                        <div class="carousel-item">
                                        <img src="https://cdn.britannica.com/99/197999-050-D22B29F0/Leopard-cat.jpg" class="d-block w-100" alt="Image 3">
                                        </div>
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#hotel_image_{{$hotel->id}}" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
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
                                <div class="mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="text" class="form-control" value="{{$hotel->phone}}" disabled readonly/>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Number of Rooms</label>
                                    <input type="text" class="form-control" value="?" disabled readonly/>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Star</label>
                                    <input type="text" class="form-control" value="{{$hotel->star}}" disabled readonly/>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" rows="3" disabled readonly>{{$hotel->description}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="hotel_room_modal_{{$hotel->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-3" id="exampleModalLabel">Hotel</h1>
                                @if(!empty($user))
                                <div class="dropdown ms-2">
                                    <span class="material-symbols-outlined mt-2 text-primary" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        arrow_drop_down
                                    </span>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Edit</a></li>
                                        <li><a class="dropdown-item" href="#">Delete</a></li>
                                    </ul>
                                </div>
                                @endif
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="">
                                <ul class="nav nav-underline nav-fill">
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
                                <div class="card mb-3">
                                    <div class="row g-0">
                                        <div class="col-md-4">
                                        <img src="https://cdn.britannica.com/39/7139-050-A88818BB/Himalayan-chocolate-point.jpg" class="img-fluid rounded-start">
                                        </div>
                                        <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title">Card title</h5>
                                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                            <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mb-3">
                                    <div class="row g-0">
                                        <div class="col-md-4">
                                        <img src="https://cdn.britannica.com/99/197999-050-D22B29F0/Leopard-cat.jpg" class="img-fluid rounded-start">
                                        </div>
                                        <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title">Card title</h5>
                                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                            <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @foreach($rooms as $room)
                    @if($room->hotel_id == $room->id)
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#room_modal_{{$room->id}}" id="room_button_{{$room->id}}" hidden></button>
                        <div class="modal fade" id="room_modal_{{$room->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-3" id="exampleModalLabel">Hotel</h1>
                                        @if(!empty($user))
                                        <div class="dropdown ms-2">
                                            <span class="material-symbols-outlined mt-2 text-primary" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                arrow_drop_down
                                            </span>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#">Edit</a></li>
                                                <li><a class="dropdown-item" href="#">Delete</a></li>
                                            </ul>
                                        </div>
                                        @endif
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="">
                                        <ul class="nav nav-underline nav-fill">
                                            <li class="nav-item">
                                                <a class="nav-link active" aria-current="page" href="#">Hotel</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#">Room</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#">Facility</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Name</label>
                                            <input type="text" class="form-control" value="{{$hotel->name}}" disabled readonly/>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Address</label>
                                            <input type="text" class="form-control" value="{{$hotel->address}}" disabled readonly/>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Phone</label>
                                            <input type="text" class="form-control" value="{{$hotel->phone}}" disabled readonly/>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Number of Rooms</label>
                                            <input type="text" class="form-control" value="?" disabled readonly/>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Star</label>
                                            <input type="text" class="form-control" value="{{$hotel->star}}" disabled readonly/>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Description</label>
                                            <textarea class="form-control" rows="3" disabled readonly>{{$hotel->description}}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Image</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach

                <div class="modal fade" id="hotel_facility_modal_{{$hotel->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-3" id="exampleModalLabel">Hotel</h1>
                                @if(!empty($user))
                                <div class="dropdown ms-2">
                                    <span class="material-symbols-outlined mt-2 text-primary" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        arrow_drop_down
                                    </span>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Edit</a></li>
                                        <li><a class="dropdown-item" href="#">Delete</a></li>
                                    </ul>
                                </div>
                                @endif
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="">
                                <ul class="nav nav-underline nav-fill">
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
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" value="{{$hotel->name}}" disabled readonly/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach


            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editHotelModel" id="updateButtonModal" hidden></button>
            <div class="modal fade" id="editHotelModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form>
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Hotel</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" id="update_hotel_name"/>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Address</label>
                                    <input type="text" class="form-control" id="update_hotel_address"/>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="text" class="form-control" id="update_hotel_phone"/>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Number of Rooms</label>
                                    <input type="text" class="form-control" id="update_hotel_room"/>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Hotel Star</label>
                                    <select class="form-select" id="update_hotel_star">
                                        <option selected>Open this select menu</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" id="update_hotel_description" rows="5"></textarea>
                                </div>
                                <input type="text" class="form-control" id="update_hotel_id" hidden/>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary" id="update_hotel_submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div id="map" style="height: 892px">
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
        <script src="{{url('/js/script.js')}}"></script>
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
        @livewireScripts
    </body>
</html>
