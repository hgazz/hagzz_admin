<div class="row">
    <div class="col-md-6 mb-3">
        <label for="training_id">{{trans('admin.training.training_name')}}</label>
        <input type="text" name="training" class="form-control"
               value="{{ $training->name }}" id="training_id"
               placeholder="{{$training->name}}" readonly>
        @error('training_id')
        <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="price">{{trans('admin.training.price')}}</label>
        <input type="text" name="price" class="form-control"
               value="{{ $training->price }}" id="price"
               placeholder="{{$training->price}}" readonly>
        @error('price')
        <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="name">{{trans('admin.user.name')}}</label>
        <input type="text" name="name" class="form-control"
               value="{{ old('name') }}" id="phone"
               placeholder="{{trans('admin.user.name')}}">
        @error('name')
        <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="phone">{{trans('admin.user.phone')}}</label>
        <input type="text" name="phone" class="form-control"
               value="{{ old('phone') }}" id="phone"
               placeholder="{{trans('admin.academies.phone')}}">
        @error('phone')
        <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="gender">{{trans('admin.user.gender')}}</label>
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
        <label for="country">{{ trans('admin.country.country') }}</label>
        <select class="form-select" id="country" name="country_id">
            <option value="0">{{ trans('admin.city.Select County') }}</option>
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
        <label for="city">{{ trans('admin.city.city') }}</label>
        <select class="form-select citySelected" id="city" name="city_id">

        </select>
        @error('city_id')
        <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="area">{{ trans('admin.area.area') }}</label>
        <select class="form-select" id="area" name="area_id">

        </select>
        @error('area_id')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>
