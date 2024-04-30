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
<!-- start step indicators -->
<div class="form-header d-flex mb-4">
    <span class="stepIndicator">{{trans('admin.academies.Basic Information')}}</span>
    <span class="stepIndicator">{{trans('admin.academies.Partner Details')}}</span>
    <span class="stepIndicator">{{trans('admin.academies.Legal & Tax Details')}}</span>
    <span class="stepIndicator">{{trans('admin.academies.Billing Details')}}</span>
    <span class="stepIndicator">{{trans('admin.academies.Contract Details')}}</span>
</div>
<!-- end step indicators -->

<!-- step one -->
<div class="step">
    <p class="text-center mb-4">{{trans('admin.academies.Basic Information')}}</p>
    <div class="mb-3">
        <input type="text" class="formInput" placeholder="{{trans('admin.academies.First Name')}}" value="{{(isset($academies) ? $academies->first_name : '')}}" oninput="this.className = ''" name="first_name">
    </div>
    @error('firs_name')
        <p class="text-danger">{{$message}}</p>
    @enderror
    <div class="mb-3">
        <input type="text" class="formInput" placeholder="{{trans('admin.academies.Last Name')}}" value="{{(isset($academies) ? $academies->last_name : '')}}" oninput="this.className = ''" name="last_name">
    </div>
    @error('last_name')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <div class="mb-3">
        <select id="role" name="role" class="form-control formInput basic">
            @foreach($roles as $role)
                <option value="{{$role}}" @selected(old('role', isset($academies) ? $academies->role : '') == $role)>{{$role}}</option>
            @endforeach
        </select>
        @error('role')
        <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
    <div class="mb-3">
        <input type="text" class="formInput" placeholder="{{trans('admin.academies.email')}}" value="{{(isset($academies) ? $academies->email : '')}}" oninput="this.className = ''" name="email">
    </div>
    @error('email')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <div class="mb-3 position-relative">
        <label for="password">{{trans('admin.academies.password')}}</label>
        <input type="password" name="password" class="@if(isset($academies)) form-control @else formInput @endif" id="password" placeholder="{{trans('admin.academies.password')}}">
        <span class="password-toggle-eye" onclick="togglePasswordVisibility()">
                <i class="fa fa-eye" id="toggleEye"></i>
            </span>
        @error('password')
        <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
    <div class="mb-3">
        <input type="text" class="formInput" placeholder="{{trans('admin.academies.phone')}}" value="{{(isset($academies) ? $academies->phone : '')}}" oninput="this.className = ''" name="phone">
    </div>
    @error('phone')
    <p class="text-danger">{{$message}}</p>
    @enderror
</div>

<!-- step two -->
<div class="step">
    <p class="text-center mb-4">{{trans('admin.academies.Partner Details')}}</p>
    @foreach(\App\Services\TranslatableService::getTranslatableInputs(App\Models\Academies::class) as $name => $data)
       @if($name == 'app_name_en' || $name == 'app_name_ar')
            <div class="mb-3">
                <input type="text" class="formInput"  placeholder="{{trans("admin.academies.$name")}}" oninput="this.className = ''" name="{{$name}}"
                       @php
                           $language = $name == 'app_name_en' ? 'en' : 'ar';
                           $defaultValue = isset($academies) ? $academies->getTranslation('app_name', $language) : '';
                       @endphp
                       value="{{ old($name, $defaultValue) }}"
                >
            </div>
            @error($name)
            <p class="text-danger">{{$message}}</p>
            @enderror
       @endif

    @endforeach
    <div class="mb-3">
        <select class="form-control formInput basic" name="sport_id[]" multiple id="sports">
            @foreach($sports as $sport)
                <option
                    value="{{$sport->id}}" @selected(old('sport_id', isset($academies) ? in_array($sport->id, $academies->sports()->pluck('sport_id')->toArray()) : ''))>{{$sport->name}}</option>
            @endforeach
        </select>
        @error('sport_id')
        <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
    @error('sports')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <div class="mb-3">
        <select class="form-control  basic" name="branch_to">
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
    @error('branch_to')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <div class="mb-3">
        <input type="text" class="form-control" placeholder="{{trans('admin.academies.facebook')}}" value="{{(isset($academies) ? $academies->facebook : '')}}" oninput="" name="facebook">
    </div>
    @error('facebook')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <div class="mb-3">
        <input type="text" class="form-control" placeholder="{{trans('admin.academies.website')}}" value="{{(isset($academies) ? $academies->website : '')}}" oninput="" name="website">
    </div>
    @error('website')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <div class="mb-3">
        <input type="text" class="form-control" placeholder="{{trans('admin.academies.instagram')}}" value="{{(isset($academies) ? $academies->instagram : '')}}" oninput="" name="instagram">
    </div>
    @error('instagram')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <div class="mb-3">
        <input type="text" class="form-control" placeholder="{{trans('admin.academies.linkedin')}}" value="{{(isset($academies) ? $academies->linkedin : '')}}" oninput="" name="linkedin">
    </div>
    @error('linkedin')
    <p class="text-danger">{{$message}}</p>
    @enderror
</div>

<!-- step three -->
<div class="step">
    <p class="text-center mb-4">{{trans('admin.academies.Legal & Tax Details')}}</p>
    <div class="mb-3">
        <span class="">{{trans('admin.academies.full_name_arabic')}}</span>
        <input type="text" class="formInput" placeholder="{{trans('admin.academies.full_name_arabic')}}" value="{{(isset($academies) ? $academies->name : '')}}" oninput="this.className = ''" name="name">
    </div>
    @foreach(\App\Services\TranslatableService::getTranslatableInputs(App\Models\Academies::class) as $name => $data)
        @if($name == 'commercial_name_en' || $name == 'commercial_name_ar')
            <div class="mb-3">
                <input type="text" class="formInput" placeholder="{{trans("admin.academies.$name")}}" oninput="this.className = ''" name="{{$name}}"
                       @php
                           $language = $name == 'commercial_name_en' ? 'en' : 'ar';
                           $defaultValue = isset($academies) ? $academies->getTranslation('commercial_name', $language) : '';
                       @endphp
                       value="{{ old($name, $defaultValue) }}"
                >
            </div>

            @error($name)
            <p class="text-danger">{{$message}}</p>
            @enderror
        @endif

    @endforeach
    <div class="mb-3">
        <input type="number" class="formInput" value="{{(isset($academies) ? $academies->trade_license_number : '')}}" placeholder="{{trans('admin.academies.trade_license_number')}}" oninput="this.className = ''" name="trade_license_number">
    </div>
    @error('trade_license_number')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <div class="mb-3">
        <input type="date" class="formInput" placeholder="{{trans('admin.academies.trade_license_expire_date')}}" oninput="this.className = ''" value="{{(isset($academies) ? $academies->trade_license_expire_date : '')}}" name="trade_license_expire_date">
    </div>
    @error('trade_license_expire_date')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <div class="mb-3">
        <input type="number" class="formInput" placeholder="{{trans('admin.academies.tax_number')}}" oninput="this.className = ''" value="{{(isset($academies) ? $academies->tax_number : '')}}" name="tax_number">
    </div>
    @error('tax_number')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <div class="mb-3">
        <input type="number" class="formInput" placeholder="{{trans('admin.academies.Tax percentage')}}" oninput="this.className = ''" value="{{(isset($academies) ? $academies->commission_percentage : '')}}" name="commission_percentage">
    </div>
    @error('commission_percentage')
    <p class="text-danger">{{$message}}</p>
    @enderror
</div>

<!-- step Four -->
<div class="step">
    <p class="text-center mb-4">{{trans('admin.academies.Billing Details')}}</p>
    <div class="mb-3">
        <input type="text" class="formInput" placeholder="{{trans('admin.academies.Bank account type')}}" oninput="this.className = ''" value="{{(isset($academies) ? $academies->bank_account_type : '')}}" name="bank_account_type">
    </div>
    @error('bank_account_type')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <div class="mb-3">
        <input type="text" class="formInput" placeholder="{{trans('admin.academies.Bank Name')}}" oninput="this.className = ''" value="{{(isset($academies) ? $academies->bank_name : '')}}" name="bank_name">
    </div>
    @error('bank_name')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <div class="mb-3">
        <input type="text" class="formInput" placeholder="{{trans('admin.academies.Beneficiary Name')}}" oninput="this.className = ''" value="{{(isset($academies) ? $academies->beneficiary_name : '')}}" name="beneficiary_name">
    </div>
    @error('beneficiary_name')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <div class="mb-3">
        <input type="text" class="formInput" placeholder="{{trans('admin.academies.Bank account number')}}" oninput="this.className = ''" value="{{(isset($academies) ? $academies->bank_account_number : '')}}" name="bank_account_number">
    </div>
    @error('bank_account_number')
    <p class="text-danger">{{$message}}</p>
    @enderror

</div>

<div class="step">
    <p class="text-center mb-4">{{trans('admin.academies.Contract Details')}}</p>
    <div class="mb-3">
        <input type="date" class="formInput" placeholder="{{trans('admin.academies.Contract Data')}}" oninput="this.className = ''" value="{{(isset($academies) ? $academies->contract_date : '')}}" name="contract_date">
    </div>
    @error('contract_date')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <div class="mb-3">
        <input type="date" class="formInput" placeholder="{{trans('admin.academies.Start Date')}}" oninput="this.className = ''" value="{{(isset($academies) ? $academies->start_date : '')}}" name="start_date">
    </div>
    @error('start_date')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <div class="mb-3">
        <input type="date" class="formInput" placeholder="{{trans('admin.academies.End Date')}}" oninput="this.className = ''" value="{{(isset($academies) ? $academies->end_date : '')}}" name="end_date">
    </div>
    @error('end_date')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <div class="mb-3">
        <input type="number" class="formInput" placeholder="{{trans('admin.academies.Contract Number')}}" oninput="this.className = ''" value="{{(isset($academies) ? $academies->contract_number : '')}}" name="contract_number">
    </div>
    @error('contract_number')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <div class="mb-3">
        <input type="text" class="formInput" placeholder="{{trans('admin.academies.Account Manager')}}" oninput="this.className = ''" value="{{(isset($academies) ? $academies->account_manager : '')}}" name="account_manager">
    </div>
    @error('account_manager')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <div class="mb-3">
        <input type="file" class=" form-control" oninput="this.className = ''" name="image">
    </div>
    @error('image')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <select class="form-control formInput basic" name="status">
        <option value="">{{trans('admin.academies.Status')}}</option>
        <option value="pending" {{( old('pending', $academies->status ?? '') == 'pending')   ? 'selected' : ''}} >Pending</option>
         <option value="active" {{( old('active', $academies->status ?? '') == 'active')   ? 'selected' : ''}}  >Active</option>
         <option value="inactive" {{( old('inactive', $academies->status ?? '') == 'inactive')   ? 'selected' : ''}} >inactive</option>
    </select>
    @error('status')
    <span class="text-danger">{{$message}}</span>
    @enderror

</div>

<!-- start previous / next buttons -->
<div class="form-footer d-flex">
    <button type="button" id="prevBtn" onclick="nextPrev(-1)">{{trans('admin.academies.Previous')}}</button>
    <button type="button" id="nextBtn" onclick="nextPrev(1)">{{trans('admin.academies.Next')}}</button>
</div>
<!-- end previous / next buttons -->
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
