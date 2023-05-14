<div>
    <label class="form-label">Facilities 
        <span><button type="button" class="btn btn-sm" wire:click="increment"><i class="fa fa-plus text-primary"></i></button></span>
        <span><button type="button" class="btn btn-sm" wire:click="decrement"><i class="fa fa-minus text-danger"></i></button></span>
    </label>
    @if($exist == true)
        @if($crud == "create")
            @if($old_create_room == $hotel_id)
                @for($i = 0; $i < $old_count; $i++)
                    <select class="form-control mb-3" name="facilities[]">
                        @foreach($facilities as $facility)
                            @if($facility->hotel_id == $hotel_id && $facility->type == "Room")
                                @if($facility->id == $old_facilities[$i])
                                    @if($facility->count == 0)
                                        <option selected value="{{$facility->id}}">{{$facility->name}}</option>
                                    @else
                                        <option selected value="{{$facility->id}}">{{$facility->count}} {{$facility->name}}</option>
                                    @endif
                                @else
                                    @if($facility->count == 0)
                                        <option value="{{$facility->id}}">{{$facility->name}}</option>
                                    @else
                                        <option value="{{$facility->id}}">{{$facility->count}} {{$facility->name}}</option>
                                    @endif
                                @endif
                            @endif
                        @endforeach
                    </select>
                @endfor
            @endif
            @for($i = 0; $i < $count; $i++)
                <select class="form-control mb-3" name="facilities[]">
                    @foreach($facilities as $facility)
                        @if($facility->hotel_id == $hotel_id && $facility->type == "Room")
                            @if($facility->count == 0)
                                <option value="{{$facility->id}}">{{$facility->name}}</option>
                            @else
                                <option value="{{$facility->id}}">{{$facility->count}} {{$facility->name}}</option>
                            @endif
                        @endif
                    @endforeach
                </select>
            @endfor
            <input type="hidden" name="facilities_counter" value="{{$count+$old_count}}">
        @endif
        @if($crud == "edit")
            @if($count_room_facilities_data > 0)
                @foreach($room_facilities_data as $r)
                    <select class="form-control mb-3" name="facilities[]">
                        @foreach($facilities as $facility)
                            @if($facility->hotel_id == $hotel_id && $facility->type == "Room")
                                @if($r == $facility->id)
                                    @if($facility->count == 0)
                                        <option selected value="{{$facility->id}}">{{$facility->name}}</option>
                                    @else
                                        <option selected value="{{$facility->id}}">{{$facility->count}} {{$facility->name}}</option>
                                    @endif
                                @else
                                    @if($facility->count == 0)
                                        <option value="{{$facility->id}}">{{$facility->name}}</option>
                                    @else
                                        <option value="{{$facility->id}}">{{$facility->count}} {{$facility->name}}</option>
                                    @endif
                                @endif
                            @endif
                        @endforeach
                    </select>
                @endforeach
            @endif
            @if($old_edit_room == $hotel_id)
                @for($i = 0; $i < $old_count; $i++)
                    <select class="form-control mb-3" name="facilities[]">
                        @foreach($facilities as $facility)
                            @if($facility->hotel_id == $hotel_id && $facility->type == "Room")
                                @if($facility->id == $old_facilities[$i])
                                    @if($facility->count == 0)
                                        <option selected value="{{$facility->id}}">{{$facility->name}}</option>
                                    @else
                                        <option selected value="{{$facility->id}}">{{$facility->count}} {{$facility->name}}</option>
                                    @endif
                                @else
                                    @if($facility->count == 0)
                                        <option value="{{$facility->id}}">{{$facility->name}}</option>
                                    @else
                                        <option selected value="{{$facility->id}}">{{$facility->count}} {{$facility->name}}</option>
                                    @endif
                                @endif
                            @endif
                        @endforeach
                    </select>
                @endfor
            @endif
            @for($i = 0; $i < $count; $i++)
                <select class="form-control mb-3" name="facilities[]">
                    @foreach($facilities as $facility)
                        @if($facility->hotel_id == $hotel_id && $facility->type == "Room")
                            @if($facility->count == 0)
                                <option value="{{$facility->id}}">{{$facility->name}}</option>
                            @else
                                <option value="{{$facility->id}}">{{$facility->count}} {{$facility->name}}</option>
                            @endif
                        @endif
                    @endforeach
                </select>
            @endfor
            @if($old_count>0)
            <input type="hidden" name="facilities_counter" value="{{$count+$old_count}}">
            @else
            <input type="hidden" name="facilities_counter" value="{{$count+$count_room_facilities_data}}">
            @endif
        @endif
    @else
        <br>
        <label class="form-label text-danger">Facilities for room not added yet!</label>
    @endif
</div>
