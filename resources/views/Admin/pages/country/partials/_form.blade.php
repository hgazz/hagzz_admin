@csrf
<div class="row">
    <div class="row">
        @foreach (\App\Services\TranslatableService::getTranslatableInputs(App\Models\Country::class) as $name => $data)
            <div class="col-md-6 mb-3">
                <label for="{{$name}}" class="form-label">{{trans('admin.area.'.$name)}}</label>
                <input type="text" id="{{$name}}" name="{{$name}}" maxlength="50" class="form-control"
                       @php
                           $language = $name == 'name_en' ? 'en' : 'ar';
                           $defaultValue = isset($country) ? $country->getTranslation('name', $language) : '';
                       @endphp
                       value="{{ old($name, $defaultValue) }}"
                       placeholder="Enter {{$name}}" data-parsley-required-message="Please enter {{$name}}">
                @error($name)
                <span class="text-danger">*{{$message}}</span>
                @enderror
            </div>
        @endforeach
    </div>
</div>

