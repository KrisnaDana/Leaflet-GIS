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
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" class="form-control" name="toast_validation" value="Register failed."/>
                                <input type="hidden" class="form-control" name="register" value="register"/>
                                <button class="btn btn-primary" style="width:100%;" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createHotelModel" id="create_hotel_modal" hidden></button>
            <div class="modal fade" id="createHotelModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <form>
                            <div class="modal-header">
                                <h1 class="modal-title fs-3" id="exampleModalLabel">Create Hotel</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-header">
                                <div class="row">
                                    <div class="col-4">
                                        <button type="button" class="btn btn-outline-danger btn-sm">Hotel</button>
                                    </div>
                                    <div class="col-4">
                                        <button type="button" class="btn btn-outline-warning btn-sm">Room</button>
                                    </div>
                                    <div class="col-4">
                                        <button type="button" class="btn btn-outline-success btn-sm">Facility</button>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" id="create_hotel_name"/>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Address</label>
                                    <input type="text" class="form-control" id="create_hotel_address"/>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="text" class="form-control" id="create_hotel_phone"/>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Number of Rooms</label>
                                    <input type="text" class="form-control" id="create_hotel_room"/>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Hotel Star</label>
                                    <select class="form-select" id="create_hotel_star">
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
                                    <textarea class="form-control" id="create_hotel_description" rows="5"></textarea>
                                </div>
                                <input type="text" class="form-control" id="create_hotel_lat" hidden/>
                                <input type="text" class="form-control" id="create_hotel_lng" hidden/>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary" id="create_hotel_submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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
        @livewireScripts
    </body>
</html>
