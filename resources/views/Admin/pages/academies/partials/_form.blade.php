@csrf
<div class="row">
    <div class="row">
        @foreach (\App\Services\TranslatableService::getTranslatableInputs(App\Models\Academies::class) as $name => $data)
            <div class="col-md-6 mb-3">
                <label for="{{$name}}" class="form-label">{{$name}}</label>
                <input type="text" id="{{$name}}" name="{{$name}}" maxlength="50" class="form-control"
                       value="@if ($name == 'commercial_name_en') {{old($name, isset($academies) ? $academies->getTranslation('commercial_name','en')  : '')}} @else {{old($name, isset($academies) ? $academies->getTranslation('commercial_name','ar')  : '')}} @endif"
                       placeholder="Enter {{$name}}" data-parsley-required-message="Please enter {{$name}}">
                @error($name)
                <span class="text-danger">*{{$message}}</span>
                @enderror
            </div>
        @endforeach
        <div class="col-md-6 mb-3">
            <label for="email">{{trans('admin.academies.email')}}</label>
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
            <select id="role" name="role" class="form-control">
                @foreach($roles as $role)
                    <option value="{{$role}}">{{$role}}</option>
                @endforeach
            </select>
            @error('role')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="trade_license_number">{{trans('admin.academies.trade_license_number')}}</label>
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
            <label for="national_id_number">{{trans('admin.academies.national_id_number')}}</label>
            <input type="text" name="national_id_number" value="{{isset($academies) ? $academies->national_id_number : old('national_id_number')}}" class="form-control" id="national_id_number" placeholder="{{trans('admin.academies.national_id_number')}}">
            @error('national_id_number')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="contract_number">{{trans('admin.academies.contract_number')}}</label>
            <input type="text" name="contract_number" value="{{isset($academies) ? $academies->contract_number : old('contract_number')}}" class="form-control" id="contract_number" placeholder="{{trans('admin.academies.national_id_number')}}">
            @error('contract_number')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="account_manager">{{trans('admin.academies.account_manager')}}</label>
            <input type="text" name="account_manager" value="{{isset($academies) ? $academies->account_manager : old('account_manager')}}" class="form-control" id="account_manager" placeholder="{{trans('admin.academies.national_id_number')}}">
            @error('account_manager')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <select class="select2-default form-select" name="sport_id[]" multiple>
                    <option value="">{{ trans('admin.academies.select_sport') }}</option>
                    @foreach($sports as $sport)
                        <option value="{{$sport->id}}" @selected(old('sport_id', isset($academies) ? in_array($sport->id, $academies->sports()->pluck('sport_id')->toArray()) : ''))>{{$sport->name}}</option>
                    @endforeach
           </select>
            @error('sport_id')
                <span class="text-danger" >{{$message}}</span>
            @enderror
        </div>

            <div class="col-md-6 mb-3">
                <label>{{trans('admin.academies.Select branch')}}</label>
                <select class="select2-default form-select" name="branch_to">
                    <option value="">{{ trans('admin.academies.academies') }}</option>
                    @foreach($allAcademies as $academy)
                        <option value="{{$academy->id}}"  @selected(old('branch_to', isset($academies) ? $academies->branch_to : '') == $academy->id) >{{$academy->commercial_name}}</option>
                    @endforeach
                </select>
                @error('branch_to')
                <span class="text-danger" >{{$message}}</span>
                @enderror
            </div>

        <div class="col-md-6 mb-3">
            <label for="is_registered">{{trans('admin.academies.is_registered')}}</label>
            <input type="checkbox" name="is_registered" @if(isset($academies) && $academies->is_registered) checked  @endif class="form-check" id="is_registered">
            @error('is_registered')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

    </div>
</div>
