@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .password-toggle-eye {
            position: absolute;
            right: 15px;
            top: 70%;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
@endpush
@csrf
<input type="hidden" value="{{app()->getLocale()}}" id="local">
<div class="row">
    <div class="row">
        @foreach (\App\Services\TranslatableService::getTranslatableInputs(App\Models\Academies::class) as $name => $data)
            <div class="col-md-6 mb-3">
                <label for="{{$name}}" class="form-label">{{trans('admin.academies.'.$name)}}</label>
                <input type="text" id="{{$name}}" name="{{$name}}" maxlength="50" class="form-control"
                       @php
                           $language = $name == 'commercial_name_en' ? 'en' : 'ar';
                           $defaultValue = isset($academies) ? $academies->getTranslation('commercial_name', $language) : '';
                       @endphp
                       value="{{ old($name, $defaultValue) }}"
                       placeholder="{{trans('admin.academies.'.$name)}}" data-parsley-required-message="Please enter {{$name}}">
                @error($name)
                <span class="text-danger">*{{$message}}</span>
                @enderror
            </div>
        @endforeach
        <div class="col-md-6 mb-3">
            <label for="email">{{trans('admin.academies.email')}} <code>{{ trans('admin.academies.email_hint') }}</code></label>
            <input type="email" name="email" class="form-control"
                   value="{{isset($academies) ? $academies->email : old('email')}}" id="email"
                   placeholder="{{trans('admin.academies.email')}}">
            @error('email')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="phone">{{trans('admin.academies.phone')}}</label>
            <input type="text" name="phone" class="form-control"
                   value="{{isset($academies) ? $academies->phone : old('phone')}}" id="phone"
                   placeholder="{{trans('admin.academies.phone')}}">
            @error('phone')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="col-md-6 mb-3 position-relative">
            <label for="password">{{trans('admin.academies.password')}}</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="{{trans('admin.academies.password')}}">
            <span class="password-toggle-eye" onclick="togglePasswordVisibility()">
                <i class="fa fa-eye" id="toggleEye"></i>
            </span>
            @error('password')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="role">{{trans('admin.academies.role')}}</label>
            <select id="role" name="role" class="form-control">
                @foreach($roles as $role)
                    <option value="{{$role}}" @selected(old('role', isset($academies) ? $academies->role : '') == $role)>{{$role}}</option>
                @endforeach
            </select>
            @error('role')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="trade_license_number">{{trans('admin.academies.trade_license_number')}}</label>
            <input type="text" name="trade_license_number"
                   value="{{isset($academies) ? $academies->trade_license_number : old('trade_license_number')}}"
                   class="form-control" id="trade_license_number"
                   placeholder="{{trans('admin.academies.trade_license_number')}}">
            @error('trade_license_number')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="trade_license_expire_date">{{trans('admin.academies.trade_license_expire_date')}}</label>
            <input type="date" name="trade_license_expire_date"
                   value="{{isset($academies) ? $academies->trade_license_expire_date : old('trade_license_expire_date')}}"
                   class="form-control" id="trade_license_expire_date"
                   placeholder="{{trans('admin.academies.trade_license_expire_date')}}">
            @error('trade_license_expire_date')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="tax_number">{{trans('admin.academies.tax_number')}}</label>
            <input type="text" name="tax_number"
                   value="{{isset($academies) ? $academies->tax_number : old('tax_number')}}" class="form-control"
                   id="tax_number" placeholder="{{trans('admin.academies.tax_number')}}">
            @error('tax_number')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="col-md-6 mb-3">
            <label for="percentage">{{trans('admin.academies.percentage')}}</label>
            <input type="text" name="percentage"
                   value="{{isset($academies) ? $academies->percentage : old('percentage')}}" class="form-control"
                   id="percentage" placeholder="{{trans('admin.academies.percentage')}}">
            @error('percentage')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="country">{{ trans('admin.country.country') }}</label>
            <select class="form-select" id="country" name="country_id">
                <option value="0">{{ trans('admin.city.Select County') }}</option>
                @foreach($countries as $country)
                    <option
                        value="{{ $country->id }}" @selected(old('country_id', isset($academies) ? $academies->country_id : '') == $country->id)>{{ $country->name }}</option>
                @endforeach
            </select>
            @error('country_id')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="city">{{ trans('admin.city.city') }}</label>
            <select class="form-select citySelected" id="city" name="city_id">
                <input type="hidden" value="{{old('city_id', isset($academies) ? $academies->city_id : '')}}"
                       id="select_city_id">
            </select>
            @error('city_id')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="areaSelect">{{ trans('admin.area.area') }}</label>
            <select class="form-select" id="areaSelect" name="area_id">
                <input type="hidden" value="{{old('city_id', isset($academies) ? $academies->area_id : '')}}"
                       id="select_area_id">
            </select>
            @error('area_id')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="address">{{trans('admin.academies.address')}}</label>
            <input type="text" name="address" class="form-control" id="address"
                   value="{{isset($academies) ? $academies->address : old('address')}}"
                   placeholder="{{trans('admin.academies.address')}}">
            @error('address')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>


        <div class="col-md-6 mb-3">
            <label for="national_id_number">{{trans('admin.academies.national_id_number')}}</label>
            <input type="text" name="national_id_number"
                   value="{{isset($academies) ? $academies->national_id_number : old('national_id_number')}}"
                   class="form-control" id="national_id_number"
                   placeholder="{{trans('admin.academies.national_id_number')}}">
            @error('national_id_number')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="contract_number">{{trans('admin.academies.contract_number')}}</label>
            <input type="text" name="contract_number"
                   value="{{isset($academies) ? $academies->contract_number : old('contract_number')}}"
                   class="form-control" id="contract_number"
                   placeholder="{{trans('admin.academies.national_id_number')}}">
            @error('contract_number')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="account_manager">{{trans('admin.academies.account_manager')}}</label>
            <input type="text" name="account_manager"
                   value="{{isset($academies) ? $academies->account_manager : old('account_manager')}}"
                   class="form-control" id="account_manager"
                   placeholder="{{trans('admin.academies.national_id_number')}}">
            @error('account_manager')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="sports">{{trans('admin.academies.select_sport')}}</label>
            <select class="js-example-basic-multiple form-select" name="sport_id[]" multiple id="sports">
                @foreach($sports as $sport)
                    <option
                        value="{{$sport->id}}" @selected(old('sport_id', isset($academies) ? in_array($sport->id, $academies->sports()->pluck('sport_id')->toArray()) : ''))>{{$sport->name}}</option>
                @endforeach
            </select>
            @error('sport_id')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label>{{trans('admin.academies.Select branch')}}</label>
            <select class="select2-default form-select" name="branch_to">
                <option value="">{{ trans('admin.academies.select_academy') }}</option>
                @foreach($allAcademies as $academy)
                    <option
                        value="{{$academy->id}}" @selected(old('branch_to', isset($academies) ? $academies->branch_to : '') == $academy->id) >{{$academy->commercial_name}}</option>
                @endforeach
            </select>
            @error('branch_to')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="is_registered">{{trans('admin.academies.is_registered')}}</label>
            <input type="checkbox" name="is_registered" @if(isset($academies) && $academies->is_registered) checked
                   @endif class="form-check" id="is_registered">
            @error('is_registered')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

    </div>
</div>
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2({
                placeholder: "{{ trans('admin.academies.select_sport') }}"
            });
        });
    </script>
    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("password");
            var toggleEye = document.getElementById("toggleEye");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleEye.classList.remove("fa-eye");
                toggleEye.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                toggleEye.classList.remove("fa-eye-slash");
                toggleEye.classList.add("fa-eye");
            }
        }
    </script>
@endpush
