@csrf
<div class="row">
    <div class="row">
        <div class="form-group mb-4">
            <label for="exampleFormControlSelect1">Longitude</label>
            <input type="text" name="longitude" maxlength="50" class="form-control" value="{{isset($address) ? $address->longitude : old("longitude")}}">
            @error('longitude')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group mb-4">
            <label for="exampleFormControlSelect1">Latitude</label>
            <input type="text" name="latitude" maxlength="50" class="form-control" value="{{isset($address) ? $address->latitude : old("latitude")}}">
            @error('latitude')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

