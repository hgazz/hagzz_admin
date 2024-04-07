@csrf
<div class="row">
    <div class="row">
        @foreach (\App\Services\TranslatableService::getTranslatableInputs(App\Models\City::class) as $name => $data)
            <div class="col-md-6 mb-3">
                <label for="{{$name}}" class="form-label">{{trans('admin.area.'.$name)}}</label>
                <input type="text" id="{{$name}}" name="{{$name}}" maxlength="50" class="form-control"
                       @php
                           $language = $name == 'name_en' ? 'en' : 'ar';
                           $defaultValue = isset($city) ? $city->getTranslation('name', $language) : '';
                       @endphp
                       value="{{ old($name, $defaultValue) }}"
                       placeholder="Enter {{$name}}" data-parsley-required-message="Please enter {{$name}}">
                @error($name)
                <span class="text-danger">*{{$message}}</span>
                @enderror
            </div>
        @endforeach
    </div>

    <div class="row">
        <div class="col-md-12 mb-3">
            <select class="form-select" name="country_id">
                <option value="">{{trans('admin.city.Select County')}}</option>
                @foreach($countries as $country)
                    <option value="{{$country->id}}"  @selected(old('city_id', isset($city) ? $city->country_id : '') == $country->id)>{{$country->name}}</option>
                @endforeach
            </select>
            @error('country_id')
            <span class="text-danger">*{{$message}}</span>
            @enderror
        </div>
    </div>
</div>

