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
                                <input type="hidden" class="form-control" name="toast_validation" value="Login failed." required/>
                                <input type="hidden" class="form-control" name="login" value="login" required/>
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
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{old('name')}}" required>
                                    @error('name')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{old('email')}}" required>
                                    @error('email')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required/>
                                    @error('password')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password Confirmation</label>
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



            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create_hotel_modal" id="create_hotel_button" hidden></button>
            <div class="modal fade" id="create_hotel_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                    <div class="modal-content">
                        <form method="post" action="{{route('create-hotel')}}" enctype="multipart/form-data">
                            <div class="modal-header">
                                <h1 class="modal-title fs-3" id="exampleModalLabel">Create Hotel</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
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
                                    <label class="form-label">Address</label>
                                    @if(old('create_hotel'))
                                        <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{old('address')}}" required/>
                                        @error('address')
                                        <div class="invalid-feedback">{{$message}}</div>
                                        @enderror
                                    @else
                                        <input type="text" class="form-control" name="address" value="" required/>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Phone</label>
                                    @if(old('create_hotel'))
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{old('phone')}}" required/>
                                        @error('phone')
                                        <div class="invalid-feedback">{{$message}}</div>
                                        @enderror
                                    @else
                                        <input type="text" class="form-control" name="phone" value="" required/>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    @if(old('create_hotel'))
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{old('email')}}" required/>
                                        @error('email')
                                        <div class="invalid-feedback">{{$message}}</div>
                                        @enderror
                                    @else
                                        <input type="email" class="form-control" name="email" value="" required/>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Star</label>
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
                                    <label class="form-label">Images</label>
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
                    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-3" id="exampleModalLabel">Hotel</h1>
                                @if(!empty($user))
                                <div class="dropdown ms-2">
                                    <span class="material-symbols-outlined mt-2 text-dark" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        arrow_drop_down
                                    </span>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#edit_hotel_modal_{{$hotel->id}}" id="edit_hotel_button_{{$hotel->id}}">Edit</a></li>
                                        <li><a class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#delete_hotel_modal_{{$hotel->id}}">Delete</a></li>
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
                                        @foreach($images as $image)
                                            @if($image->type == "Hotel" && $image->hotel_id == $hotel->id)
                                                @if($image->is_thumbnail == 1 )
                                                    <div class="carousel-item active">
                                                        <img src="{{url('images/hotels/'.$image->filename)}}" class="d-block w-100">
                                                    </div>
                                                @else
                                                    <div class="carousel-item">
                                                        <img src="{{url('images/hotels/'.$image->filename)}}" class="d-block w-100">
                                                    </div>
                                                @endif
                                            @endif
                                        @endforeach
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
                                    <label class="form-label">Star</label>
                                    <input type="text" class="form-control" value="{{$hotel->star}}" disabled readonly/>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" rows="3" disabled readonly>{{$hotel->description}}</textarea>
                                </div>
                                <div>
                                    <label class="form-label">Facility</label>
                                    @foreach($facilities as $facility)
                                        @if($facility->hotel_id == $hotel->id && $facility->type == "Hotel")
                                            @if($facility->count == 0)
                                                <input type="text" class="form-control mb-3" value="{{$facility->name}}" disabled readonly/>
                                            @else
                                                <input type="text" class="form-control mb-3" value="{{$facility->count}} {{$facility->name}}" disabled readonly/>
                                            @endif
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="edit_hotel_modal_{{$hotel->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                        <div class="modal-content">
                            <form class="modal-content" method="post" action="{{route('edit-hotel', ['id' => $hotel->id])}}" enctype="multipart/form-data">
                                @method('put')
                                <div class="modal-header">
                                    <h1 class="modal-title fs-3" id="exampleModalLabel">Hotel</h1>
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
                                    <div id="edit_hotel_image_{{$hotel->id}}" class="carousel slide mb-3" style="width:50%; margin-left: auto; margin-right: auto;">
                                        <div class="carousel-inner">
                                            @foreach($images as $image)
                                                @if($image->type == "Hotel" && $image->hotel_id == $hotel->id)
                                                    @if($image->is_thumbnail == 1 )
                                                        <div class="carousel-item active">
                                                            <img src="{{url('images/hotels/'.$image->filename)}}" class="d-block w-100">
                                                        </div>
                                                    @else
                                                        <div class="carousel-item">
                                                            <img src="{{url('images/hotels/'.$image->filename)}}" class="d-block w-100">
                                                        </div>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </div>
                                        <button class="carousel-control-prev" type="button" data-bs-target="#edit_hotel_image_{{$hotel->id}}" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#edit_hotel_image_{{$hotel->id}}" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Name</label>
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
                                        <label class="form-label">Address</label>
                                        @if(old('edit_hotel'))
                                            <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{old('address')}}" required/>
                                            @error('address')
                                            <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        @else
                                            <input type="text" class="form-control" name="address" value="{{$hotel->address}}" required/>
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Phone</label>
                                        @if(old('edit_hotel'))
                                            <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{old('phone')}}" required/>
                                            @error('phone')
                                            <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        @else
                                            <input type="text" class="form-control" name="phone" value="{{$hotel->phone}}" required/>
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        @if(old('edit_hotel'))
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{old('email')}}" required/>
                                            @error('email')
                                            <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        @else
                                            <input type="email" class="form-control" name="email" value="{{$hotel->email}}" required/>
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Star</label>
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
                                    <input type="hidden" class="form-control" name="toast_validation" value="Edit hotel failed." required/>
                                    <input type="hidden" class="form-control" name="edit_hotel" value="{{$hotel->id}}" required/>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger col" data-bs-toggle="modal" data-bs-target="#hotel_modal_{{$hotel->id}}">
                                        <span class="material-symbols-outlined">
                                            arrow_back
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


                <div hidden>
                    <form method="post" action="{{route('edit-hotel-location', ['id' => $hotel->id])}}">
                        @method('patch')
                        <input type="text" class="form-control" id="edit_hotel_location_lat_{{$hotel->id}}" name="lat" value="{{$hotel->lat}}" readonly/>
                        <input type="text" class="form-control" id="edit_hotel_location_lng_{{$hotel->id}}" name="lng" value="{{$hotel->lng}}" readonly/>
                        <button type="submit" class="btn btn-primary" id="edit_hotel_location_button_{{$hotel->id}}"></button>
                    </form>
                </div>


                <div class="modal fade" id="delete_hotel_modal_{{$hotel->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form method="post" action="{{route('delete-hotel', ['id' => $hotel->id])}}">
                                @method('delete')
                                <div class="modal-header">
                                    <h1 class="modal-title fs-3" id="exampleModalLabel">Hotel</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <h5 class="lead">Are you sure want to delete hotel: {{$hotel->name}}?</h5>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger col" data-bs-toggle="modal" data-bs-target="#hotel_modal_{{$hotel->id}}">
                                        <span class="material-symbols-outlined">
                                            arrow_back
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

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#hotel_room_modal_{{$hotel->id}}" id="room_button_{{$hotel->id}}" hidden></button>
                <div class="modal fade" id="hotel_room_modal_{{$hotel->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-3" id="exampleModalLabel">Room</h1>
                                @if(!empty($user))
                                <div class="dropdown ms-2">
                                    <span class="material-symbols-outlined mt-2 text-dark" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        arrow_drop_down
                                    </span>
                                    <ul class="dropdown-menu">
                                        <li><a type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#create_room_modal_{{$hotel->id}}" id="create_room_button_{{$hotel->id}}">Create</a></li>
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
                                @foreach($rooms as $room)
                                    @if($room->hotel_id == $hotel->id)
                                        <div class="card mb-3">
                                            <div class="row g-0">
                                                <div class="col-md-4">
                                                    @foreach($images as $image)
                                                        @if($image->hotel_id == $hotel->id && $image->room_id == $room->id && $image->type == "Room" && $image->is_thumbnail == "1")
                                                        <img src="{{url('images/rooms/'.$image->filename)}}" class="img-fluid rounded-start">
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


                <div class="modal fade" id="create_room_modal_{{$hotel->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <form method="post" action="{{route('create-room', ['id' => $hotel->id])}}" enctype="multipart/form-data">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-3" id="exampleModalLabel">Room</h1>
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
                                    <div class="mb-3">
                                        <label class="form-label">Name</label>
                                        @if(old('create_room') == $hotel->id)
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{old('name')}}" required/>
                                            @error('name')
                                            <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        @else
                                            <input type="text" class="form-control" name="name" value="" required/>
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Price</label>
                                        @if(old('create_room') == $hotel->id)
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="number" class="form-control @error('price') is-invalid @enderror" name="price" value="{{old('price')}}" required>
                                                @error('price')
                                                <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                            </div>
                                        @else
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="number" class="form-control" name="price" value="" placeholder="Price per night" required>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Count</label>
                                        @if(old('create_room') == $hotel->id)
                                            <input type="number" class="form-control @error('count') is-invalid @enderror" name="count" value="{{old('count')}}" required/>
                                            @error('count')
                                            <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        @else
                                            <input type="number" class="form-control" name="count" value="" required/>
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        @if(old('create_room'))
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
                                                if($facility->hotel_id == $hotel->id){
                                                    $exist = true;
                                                    break;
                                                }
                                            }
                                        @endphp
                                        @livewire('room-facility', ['facilities' => $facilities, 'hotel_id' => $hotel->id, 'exist' => $exist, 'old_create_room' => $old_create_room, 'crud' => 'create', 'old_facilities' => $old_facilities, 'old_count' => count($old_facilities), 'facilities_count' => 0], key($hotel->id))
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Images</label>
                                        @if(old('create_room'))
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
                                        <span class="material-symbols-outlined">
                                            arrow_back
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


                @foreach($rooms as $room)
                    @if($room->hotel_id == $hotel->id)


                        <div class="modal fade" id="read_room_modal_{{$room->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-3" id="exampleModalLabel">Room</h1>
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
                                        <div id="room_image_{{$room->id}}" class="carousel slide mb-3" style="width:50%; margin-left: auto; margin-right: auto;">
                                            <div class="carousel-inner">
                                                @foreach($images as $image)
                                                    @if($image->hotel_id == $hotel->id && $image->room_id == $room->id && $image->type == "Room")
                                                        @if($image->is_thumbnail == 1)
                                                            <div class="carousel-item active">
                                                                <img src="{{url('images/rooms/'.$image->filename)}}" class="d-block w-100">
                                                            </div>
                                                        @else
                                                            <div class="carousel-item">
                                                                <img src="{{url('images/rooms/'.$image->filename)}}" class="d-block w-100">
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
                                            @foreach($room_facilities as $room_facility)
                                                @if($room_facility->room_id == $room->id)
                                                    @if($room_facility->facility->count == 0)
                                                        <input type="text" class="form-control mb-3" value="{{$room_facility->facility->name}}" disabled readonly/>
                                                    @else
                                                        <input type="text" class="form-control mb-3" value="{{$room_facility->facility->count}} {{$room_facility->facility->name}}" disabled readonly/>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger col" data-bs-toggle="modal" data-bs-target="#hotel_room_modal_{{$hotel->id}}">
                                            <span class="material-symbols-outlined">
                                                arrow_back
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="modal fade" id="delete_room_modal_{{$room->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form method="post" action="{{route('delete-room', ['id' => $room->id, 'hotel_id' => $hotel->id])}}">
                                        @method('delete')
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-3" id="exampleModalLabel">Room</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <h5 class="lead">Are you sure want to delete room: {{$room->name}}?</h5>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger col" data-bs-toggle="modal" data-bs-target="#hotel_room_modal_{{$hotel->id}}">
                                                <span class="material-symbols-outlined">
                                                    arrow_back
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
                    @endif
                @endforeach

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#hotel_facility_modal_{{$hotel->id}}" id="facility_button_{{$hotel->id}}" hidden></button>
                <div class="modal fade" id="hotel_facility_modal_{{$hotel->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-3" id="exampleModalLabel">Facility</h1>
                                @if(!empty($user))
                                <div class="dropdown ms-2">
                                    <span class="material-symbols-outlined mt-2 text-dark" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        arrow_drop_down
                                    </span>
                                    <ul class="dropdown-menu">
                                        <li><a type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#create_facility_modal_{{$hotel->id}}" id="create_facility_button_{{$hotel->id}}">Create</a></li>
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
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                        <th class="text-center" scope="col-1">No</th>
                                        <th scope="col-8">Name</th>
                                        <th class="text-center" scope="col-1">Count</th>
                                        <th scope="col-1">Type</th>
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
                                                    <th class="text-center" scope="row">{{$i}}</th>
                                                    <td>{{$facility->name}}</td>
                                                    @if($facility->count == 0)
                                                        <td class="text-center">-</td>
                                                    @else
                                                        <td class="text-center">{{$facility->count}}</td>
                                                    @endif
                                                    <td>{{$facility->type}}</td>
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
                            <form method="post" action="{{route('create-facility', ['id' => $hotel->id])}}">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-3" id="exampleModalLabel">Facility</h1>
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
                                        @if(old('create_facility') == $hotel->id)
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{old('name')}}" required/>
                                            @error('name')
                                            <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        @else
                                            <input type="text" class="form-control" name="name" value="" required/>
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Count</label>
                                        @if(old('create_facility') == $hotel->id)
                                            <input type="number" class="form-control @error('count') is-invalid @enderror" name="count" value="{{old('count')}}" placeholder="If uncountable fill with 0" required/>
                                            @error('count')
                                            <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        @else
                                            <input type="number" class="form-control" name="count" value="" placeholder="If uncountable fill with 0" required/>
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Type</label>
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
                                    <input type="hidden" class="form-control" name="toast_validation" value="Create facility failed." required/>
                                    <input type="hidden" class="form-control" name="create_facility" value="{{$hotel->id}}" required/>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger col" data-bs-toggle="modal" data-bs-target="#hotel_facility_modal_{{$hotel->id}}">
                                        <span class="material-symbols-outlined">
                                            arrow_back
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
            

                @foreach($facilities as $facility)
                    @if($facility->hotel_id == $hotel->id)


                        <div class="modal fade" id="read_facility_modal_{{$facility->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-3" id="exampleModalLabel">Facility</h1>
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
                                            <input type="text" class="form-control" value="{{$facility->name}}" disabled readonly/>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Count</label>
                                            @if($facility->count == 0)
                                                <input type="text" class="form-control" value="-" disabled readonly/>
                                            @else
                                                <input type="text" class="form-control" value="{{$facility->count}}" disabled readonly/>
                                            @endif
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Type</label>
                                            <input type="text" class="form-control" value="{{$facility->type}}" disabled readonly/>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger col" data-bs-toggle="modal" data-bs-target="#hotel_facility_modal_{{$hotel->id}}">
                                            <span class="material-symbols-outlined">
                                                arrow_back
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="edit_facility_modal_{{$facility->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                                <div class="modal-content">
                                    <form method="post" action="{{route('edit-facility', ['id' => $facility->id, 'hotel_id' => $hotel->id])}}">
                                        @method('put')
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-3" id="exampleModalLabel">Facility</h1>
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
                                                @if(old('edit_facility') == $hotel->id)
                                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{old('name')}}" required/>
                                                    @error('name')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                    @enderror
                                                @else
                                                    <input type="text" class="form-control" name="name" value="{{$facility->name}}" required/>
                                                @endif
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Count</label>
                                                @if(old('edit_facility') == $hotel->id)
                                                    <input type="number" class="form-control @error('count') is-invalid @enderror" name="count" value="{{old('count')}}" placeholder="If uncountable fill with 0" required/>
                                                    @error('count')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                    @enderror
                                                @else
                                                    <input type="number" class="form-control" name="count" value="{{$facility->count}}" placeholder="If uncountable fill with 0" required/>
                                                @endif
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Type</label>
                                                <select class="form-select" name="type">
                                                    @if(old('edit_facility') == $hotel->id && old('type') == "Hotel")
                                                        <option value="Hotel" selected>Hotel</option>
                                                        <option value="Room">Room</option>
                                                    @elseif((old('edit_facility') == $hotel->id && old('type') == "Room") || $facility->type == "Room")
                                                        <option value="Hotel">Hotel</option>
                                                        <option value="Room" selected>Room</option>
                                                    @else
                                                        <option value="Hotel" selected>Hotel</option>
                                                        <option value="Room">Room</option>
                                                    @endif
                                                </select>
                                            </div>
                                            <input type="hidden" class="form-control" name="toast_validation" value="Edit facility failed." required/>
                                            <input type="hidden" class="form-control" name="edit_facility" value="{{$facility->id}}" required/>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger col" data-bs-toggle="modal" data-bs-target="#hotel_facility_modal_{{$hotel->id}}">
                                                <span class="material-symbols-outlined">
                                                    arrow_back
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


                        <div class="modal fade" id="delete_facility_modal_{{$facility->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form method="post" action="{{route('delete-facility', ['id' => $facility->id, 'hotel_id' => $hotel->id])}}">
                                        @method('delete')
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-3" id="exampleModalLabel">Facility</h1>
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
                                                <span class="material-symbols-outlined">
                                                    arrow_back
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
                    @endif
                @endforeach


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
        @if(!empty(old('create_hotel')))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById("create_hotel_button").click();
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
        @if(!empty(old('create_facility')))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById("create_facility_button_{{old('create_facility')}}").click();
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
        @if($edit_room = Session::get('edit_room'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById("edit_room_button_{{$edit_room}}").click();
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
        @if($create_facility = Session::get('create_facility'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById("facility_button_{{$create_facility}}").click();
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
