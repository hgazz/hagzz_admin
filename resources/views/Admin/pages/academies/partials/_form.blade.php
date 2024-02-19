@csrf
<div class="row">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="first_name">{{trans('admin.academies.first_name')}}</label>
            <input type="text" name="first_name" class="form-control" value="{{isset($academies) ? $academies->first_name : old('first_name')}}" id="first_name" placeholder="{{trans('admin.academies.first_name')}}">
            @error('first_name')
                <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="last_name">{{trans('admin.academies.last_name')}}</label>
            <input type="text" name="last_name" value="{{isset($academies) ? $academies->last_name : old('last_name')}}" class="form-control" id="last_name" placeholder="{{trans('admin.academies.last_name')}}">
            @error('last_name')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="last_name">{{trans('admin.academies.full_name_arabic')}}</label>
            <input type="text" name="full_name_arabic" value="{{isset($academies) ? $academies->full_name_arabic : old('full_name_arabic')}}" class="form-control" id="full_name_arabic" placeholder="{{trans('admin.academies.full_name_arabic')}}">
            @error('full_name_arabic')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="last_name">{{trans('admin.academies.email')}}</label>
            <input type="email" name="email" class="form-control" value="{{isset($academies) ? $academies->email : old('email')}}" id="email" placeholder="{{trans('admin.academies.email')}}">
            @error('email')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="phone">{{trans('admin.academies.phone')}}</label>
            <input type="tel" name="phone" class="form-control" value="{{isset($academies) ? $academies->phone : old('phone')}}" id="phone" placeholder="{{trans('admin.academies.phone')}}">
            @error('phone')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="password">{{trans('admin.academies.password')}}</label>
            <input type="password" name="password" class="form-control"  id="password" placeholder="{{trans('admin.academies.password')}}">
            @error('password')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="role">{{trans('admin.academies.role')}}</label>
            <select name="role" class="form-control">
                @foreach($roles as $role)
                    <option value="{{$role}}">{{$role}}</option>
                @endforeach
            </select>
            @error('role')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="commercial_name">{{trans('admin.academies.commercial_name')}}</label>
            <input type="commercial_name" value="{{isset($academies) ? $academies->commercial_name : old('commercial_name')}}" name="commercial_name" class="form-control" id="commercial_name" placeholder="{{trans('admin.academies.commercial_name')}}">
            @error('commercial_name')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="commercial_name">{{trans('admin.academies.trade_license_number')}}</label>
            <input type="text" name="trade_license_number" value="{{isset($academies) ? $academies->trade_license_number : old('trade_license_number')}}" class="form-control" id="trade_license_number" placeholder="{{trans('admin.academies.trade_license_number')}}">
            @error('trade_license_number')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="trade_license_expire_date">{{trans('admin.academies.trade_license_expire_date')}}</label>
            <input type="date" name="trade_license_expire_date" value="{{isset($academies) ? $academies->trade_license_expire_date : old('trade_license_expire_date')}}" class="form-control" id="trade_license_expire_date" placeholder="{{trans('admin.academies.trade_license_expire_date')}}">
            @error('trade_license_expire_date')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="tax_number">{{trans('admin.academies.tax_number')}}</label>
            <input type="text" name="tax_number" value="{{isset($academies) ? $academies->tax_number : old('tax_number')}}" class="form-control" id="tax_number" placeholder="{{trans('admin.academies.tax_number')}}">
            @error('tax_number')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="col-md-6 mb-3">
            <label for="percentage">{{trans('admin.academies.percentage')}}</label>
            <input type="text" name="percentage" value="{{isset($academies) ? $academies->percentage : old('percentage')}}" class="form-control" id="percentage" placeholder="{{trans('admin.academies.percentage')}}">
            @error('percentage')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="address">{{trans('admin.academies.address')}}</label>
            <input type="text" name="address" class="form-control" id="address" value="{{isset($academies) ? $academies->address : old('address')}}" placeholder="{{trans('admin.academies.address')}}">
            @error('address')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>


        <div class="col-md-6 mb-3">
            <label for="percentage">{{trans('admin.academies.national_id_number')}}</label>
            <input type="text" name="national_id_number" value="{{isset($academies) ? $academies->national_id_number : old('national_id_number')}}" class="form-control" id="national_id_number" placeholder="{{trans('admin.academies.national_id_number')}}">
            @error('national_id_number')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

    </div>
</div>
