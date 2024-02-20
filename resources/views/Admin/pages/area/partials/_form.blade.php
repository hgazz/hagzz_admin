@csrf
<div class="row">
    <div class="row">
        @foreach (\App\Services\TranslatableService::getTranslatableInputs(App\Models\Area::class) as $name => $data)
            <div class="col-md-6 mb-3">
                <label for="{{$name}}" class="form-label">{{$name}}</label>
                <input type="text" id="{{$name}}" name="{{$name}}" maxlength="50" class="form-control"
                       value="@if ($name == 'name_en') {{old($name, isset($area) ? $area->getTranslation('name','en')  : '')}} @else {{old($name, isset($area) ? $area->getTranslation('name','ar')  : '')}} @endif"
                       placeholder="Enter {{$name}}" data-parsley-required-message="Please enter {{$name}}">
                @error($name)
                <span class="text-danger">*{{$message}}</span>
                @enderror
            </div>
        @endforeach
    </div>
    <div class="row">
        <div class="form-group mb-4">
            <label for="exampleFormControlSelect1">{{ trans('admin.area.city') }}</label>
            <select class="form-select" id="exampleFormControlSelect1" name="city_id">
                <option value="">{{ trans('admin.area.select_city') }}</option>
                @foreach($cities as $city)
                    <option value="{{ $city->id }}" @selected(old('city_id', isset($area) ? $area->city_id : '') == $city->id)>{{ $city->name }}</option>
                @endforeach
            </select>
            @error('city_id')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

