<div class="row">
    <div class="col-md-6 mb-3">
        <label for="training_id">{{trans('admin.training.training_name')}} <code>*</code></label>
        <input type="text" name="training" class="form-control"
               value="{{ $training->name }}" id="training_id"
               placeholder="{{$training->name}}" readonly>
        @error('training_id')
        <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="price">{{trans('admin.training.price')}} <code>*</code></label>
        <input type="text" name="price" class="form-control"
               value="{{ $training->price }}" id="price"
               placeholder="{{$training->price}}" readonly>
        @error('price')
        <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="name">{{trans('admin.user.name')}} <code>*</code></label>
        <input type="text" name="name" class="form-control"
               value="{{ old('name') }}" id="phone"
               placeholder="{{trans('admin.user.name')}}">
        @error('name')
        <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="gender">{{trans('admin.user.gender')}} <code>*</code></label>
        <select id="gender" name="gender" class="form-control">
            <option value="">{{ trans('admin.user.select_gender') }}</option>
            <option value="male" @selected(old('gender') == 'male' )>{{ trans('admin.user.male') }}</option>
            <option value="female" @selected(old('gender') == 'female' )>{{ trans('admin.user.female') }}</option>
        </select>
        @error('gender')
        <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="country_code">{{trans('admin.city.country_code')}} <code>*</code></label>
        <input type="text" name="country_code" class="form-control"
                   value="{{ old('country_code') }}" id="country_code"
                   placeholder="{{trans('admin.city.country_code')}}">
        @error('country_code')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="phone">{{trans('admin.user.phone')}} <code>*</code></label>
        <input type="text" name="phone" class="form-control"
               value="{{ old('phone') }}" id="phone"
               placeholder="{{trans('admin.academies.phone')}}">
        @error('phone')
        <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="country">{{ trans('admin.country.country') }} <code>*</code></label>
        <select class="form-select" id="country" name="country_id">
            <option value="">{{ trans('admin.city.Select County') }}</option>
            @foreach($countries as $country)
                <option
                    value="{{ $country->id }}" @selected(old('country_id'))>{{ $country->name }}</option>
            @endforeach
        </select>
        @error('country_id')
        <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="city">{{ trans('admin.city.city') }} <code>*</code></label>
        <select class="form-select citySelected" id="city" name="city_id">
            @if(old('city_id'))
                <option value="{{ old('city_id') }}" selected>
                    {{ old('city_name') }} <!-- Provide city name dynamically from controller if needed -->
                </option>
            @endif
        </select>
        @error('city_id')
        <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="area">{{ trans('admin.area.area') }} <code>*</code></label>
        <select class="form-select" id="area" name="area_id">
            @if(old('area_id'))
                <option value="{{ old('area_id') }}" selected>
                    {{ old('area_name') }} <!-- Provide city name dynamically from controller if needed -->
                </option>
            @endif
        </select>
        @error('area_id')
        <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-md-12 mb-3">
        <label for="phone">{{trans('admin.user.birth_date')}} <code>*</code></label>
        <input type="date" name="birth_date" class="form-control"
               value="{{ old('birth_date') }}"
               id="phone"
               max="{{ date('Y-m-d', strtotime('-2 years')) }}"
               placeholder="{{trans('admin.academies.birth_date')}}">
        @error('birth_date')
        <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
</div>
