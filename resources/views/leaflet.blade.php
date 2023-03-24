<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" /> -->
        <script src="https://kit.fontawesome.com/a94f3fd771.js" crossorigin="anonymous"></script>
        <link rel="icon" href="{{url('/images/hotel.png')}}" type="image/png" />
        <link rel="stylesheet" href="{{url('/css/bootstrap.min.css')}}" />
        <link rel="stylesheet" href="{{url('/css/leaflet.css')}}" />
        <link rel="stylesheet" href="{{url('/css/style.css')}}" />
        <script src="{{url('/js/leaflet.js')}}"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-easybutton@2/src/easy-button.css" />
        <script src="https://cdn.jsdelivr.net/npm/leaflet-easybutton@2/src/easy-button.js"></script>
        <title>Leaflet Map</title>
    </head>
    <body>
        <div class="container-fluid">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createHotelModel" id="buttonModal" hidden></button>
            <div class="modal fade" id="createHotelModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form method="post" action="{{route('create')}}">
                            @csrf
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Create Hotel</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" />
                                    @error('name')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Address</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" />
                                    @error('address')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" />
                                    @error('phone')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <input type="text" class="form-control" id="lat" name="lat" value="" hidden/>
                                <input type="text" class="form-control" id="lng" name="lng" value="" hidden/>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editHotelModel" id="updateButtonModal" hidden></button>
            <div class="modal fade" id="editHotelModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form method="post" action="" id="update_form">
                            @csrf
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Hotel</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control @error('update_name') is-invalid @enderror" id="update_name" name="update_name" value=""/>
                                    @error('update_name')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Address</label>
                                    <input type="text" class="form-control @error('update_address') is-invalid @enderror" id="update_address" name="update_address" value=""/>
                                    @error('update_address')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="text" class="form-control @error('update_phone') is-invalid @enderror" id="update_phone" name="update_phone" value=""/>
                                    @error('update_phone')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <input type="text" class="form-control" id="update_lat" name="update_lat" value="" hidden/>
                                <input type="text" class="form-control" id="update_lng" name="update_lng" value="" hidden/>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div id="map" style="height: 930px">
                <script type="text/javascript">
                    let hotels = <?php echo json_encode($hotels); ?>;
                    </script>
                <script type="text/javascript" src="{{url('/js/leaflet-script.js')}}"></script>
            </div>
        </div>
        <script src="{{url('/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{url('/js/script.js')}}"></script>
    </body>
</html>
