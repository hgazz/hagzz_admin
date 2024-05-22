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

        .select2-selection {
            width: 100%;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
@endpush
@csrf
<input type="hidden" value="{{app()->getLocale()}}" id="local">
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
        <label for="first_name">{{trans('admin.academies.First Name')}}</label>
        <input id="first_name" type="text" class="formInput" placeholder="{{trans('admin.academies.First Name')}}" value="{{old('first_name',isset($academies) ? $academies->first_name : '')}}" oninput="this.className = ''" name="first_name">
    </div>
    @error('firs_name')
        <p class="text-danger">{{$message}}</p>
    @enderror
    <div class="mb-3">
        <label for="last_name">{{trans('admin.academies.Last Name')}}</label>
        <input id="last_name" type="text" class="formInput" placeholder="{{trans('admin.academies.Last Name')}}" value="{{old('last_name',isset($academies) ? $academies->last_name : '')}}" oninput="this.className = ''" name="last_name">
    </div>
    @error('last_name')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <div class="mb-3">
        <label for="role">{{ trans('admin.academies.role') }}</label>
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
        <label for="email">{{trans('admin.academies.email')}}</label>
        <input id="email" type="text" class="formInput" placeholder="{{trans('admin.academies.email')}}" value="{{old('email', isset($academies) ? $academies->email : '')}}" oninput="this.className = ''" name="email">
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
        <label for="phone">{{trans('admin.academies.phone')}}</label>
        <input id="phone" type="text" class="formInput" placeholder="{{trans('admin.academies.phone')}}" value="{{old('phone', isset($academies) ? $academies->phone : '')}}" oninput="this.className = ''" name="phone">
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
                <label for="{{ $name }}">{{trans("admin.academies.$name")}}</label>
                <input id="{{$name}}" type="text" class="formInput"  placeholder="{{trans("admin.academies.$name")}}" oninput="this.className = ''" name="{{$name}}"
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
    <div class="mb-3 d-flex flex-column align-items-start">
        <label for="sports">{{ trans('admin.sport.sport') }}</label>
        <div>
            <select class="js-example-basic-multiple w-100 form-select form-control formInput basic" name="sport_id[]" multiple id="sports">
                @foreach($sports as $sport)
                    <option value="{{$sport->id}}" @selected(old('sport_id',isset($academies) ? in_array($sport->id, $academies->sports()->pluck('sport_id')->toArray()): '') )>{{$sport->name}}</option>
                @endforeach
            </select>
        </div>
        @error('sport_id')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="academy">{{ trans('admin.academies.select_academy') }}</label>
        <select class="form-control  basic" name="branch_to" id="academy">
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
    <div class="mb-3">
        <label for="facebook">{{ trans('admin.academies.facebook') }}</label>
        <input id="facebook" type="text" class="form-control" placeholder="{{trans('admin.academies.facebook')}}" value="{{old('facebook',(isset($academies) ? $academies->facebook : ''))}}" oninput="" name="facebook">
    </div>
    @error('facebook')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <div class="mb-3">
        <label for="website">{{ trans('admin.academies.website') }}</label>
        <input id="website" type="url" class="form-control" placeholder="{{trans('admin.academies.website')}}" value="{{(old('website',isset($academies) ? $academies->website : ''))}}" oninput="" name="website">
    </div>
    @error('website')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <div class="mb-3">
        <label for="insta">{{trans('admin.academies.instagram')}}</label>
        <input id="insta" type="url" class="form-control" placeholder="{{trans('admin.academies.instagram')}}" value="{{(old('instagram', isset($academies) ? $academies->instagram : ''))}}" oninput="" name="instagram">
    </div>
    @error('instagram')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <div class="mb-3">
        <label for="linkedin">{{trans('admin.academies.linkedin')}}</label>
        <input id="linkedin" type="text" class="form-control" placeholder="{{trans('admin.academies.linkedin')}}" value="{{(old('linkedin', isset($academies) ? $academies->linkedin : ''))}}" oninput="" name="linkedin">
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
        <input type="text" class="formInput" placeholder="{{trans('admin.academies.full_name_arabic')}}" value="{{(old('name', isset($academies) ? $academies->name : ''))}}" oninput="this.className = ''" name="name">
    </div>
    @foreach(\App\Services\TranslatableService::getTranslatableInputs(App\Models\Academies::class) as $name => $data)
        @if($name == 'commercial_name_en' || $name == 'commercial_name_ar')
            <div class="mb-3">
                <label for="{{ $name }}">{{trans("admin.academies.$name")}}</label>
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
        <label for="trade_license_number">{{ trans('admin.academies.trade_license_number') }}</label>
        <input id="trade_license_number" type="number" class="formInput" value="{{(old('trade_license_number', isset($academies) ? $academies->trade_license_number : ''))}}" placeholder="{{trans('admin.academies.trade_license_number')}}" oninput="this.className = ''" name="trade_license_number">
    </div>
    @error('trade_license_number')
        <p class="text-danger">{{$message}}</p>
    @enderror
    <div class="mb-3">
        <label for="license_expire">{{ trans('admin.academies.trade_license_expire_date') }}</label>
        <input id="license_expire" type="date" class="formInput" placeholder="{{trans('admin.academies.trade_license_expire_date')}}" oninput="this.className = ''" value="{{(old('trade_license_expire_date', isset($academies) ? $academies->trade_license_expire_date : ''))}}" name="trade_license_expire_date">
    </div>
    @error('trade_license_expire_date')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <div class="mb-3">
        <label for="tax_number">{{ trans('admin.academies.tax_number') }}</label>
        <input id="tax_number" type="number" placeholder="{{trans('admin.academies.tax_number')}}" oninput="this.className = ''" value="{{(old('tax_number', isset($academies) ? $academies->tax_number : ''))}}" name="tax_number">
    </div>
    @error('tax_number')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <div class="mb-3">
        <label for="tax_percentage">{{trans('admin.academies.Tax percentage')}}</label>
        <input type="number" class="formInput" placeholder="{{trans('admin.academies.Tax percentage')}}" oninput="this.className = ''" value="{{(old('commission_percentage', isset($academies) ? $academies->commission_percentage : ''))}}" name="commission_percentage">
    </div>
    @error('commission_percentage')
    <p class="text-danger">{{$message}}</p>
    @enderror
</div>

<!-- step Four -->
<div class="step">
    <p class="text-center mb-4">{{trans('admin.academies.Billing Details')}}</p>
    <div class="mb-3">
        <label for="bank_account_type">{{trans('admin.academies.Bank account type')}}</label>
        <input id="bank_account_type" type="text" class="formInput" placeholder="{{trans('admin.academies.Bank account type')}}" oninput="this.className = ''" value="{{(old('bank_account_type', isset($academies) ? $academies->bank_account_type : ''))}}" name="bank_account_type">
    </div>
    @error('bank_account_type')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <div class="mb-3">
        <label for="bank_name">{{trans('admin.academies.Bank Name')}}</label>
        <input id="bank_name" type="text" class="formInput" placeholder="{{trans('admin.academies.Bank Name')}}" oninput="this.className = ''" value="{{(old('bank_name', isset($academies) ? $academies->bank_name : ''))}}" name="bank_name">
    </div>
    @error('bank_name')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <div class="mb-3">
        <label for="bank_account_number">{{trans('admin.academies.Bank account number')}}</label>
        <input id="beneficiary_name" type="text" class="formInput" placeholder="{{trans('admin.academies.Beneficiary Name')}}" oninput="this.className = ''" value="{{(old('beneficiary_name', isset($academies) ? $academies->beneficiary_name : ''))}}" name="beneficiary_name">
    </div>
    @error('beneficiary_name')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <div class="mb-3">
        <label for="bank_account_number">{{trans('admin.academies.Bank account number')}}</label>
        <input id="bank_account_number" type="text" class="formInput" placeholder="{{trans('admin.academies.Bank account number')}}" oninput="this.className = ''" value="{{(old('bank_account_number', isset($academies) ? $academies->bank_account_number : ''))}}" name="bank_account_number">
    </div>
    @error('bank_account_number')
    <p class="text-danger">{{$message}}</p>
    @enderror

</div>

<div class="step">
    <p class="text-center mb-4">{{trans('admin.academies.Contract Details')}}</p>
    <div class="mb-3">
        <label for="contract_date">{{ trans('admin.academies.Contract Data') }}</label>
        <input id="contract_date" type="date" class="formInput" placeholder="{{trans('admin.academies.Contract Data')}}" oninput="this.className = ''" value="{{(old('contract_date', isset($academies) ? $academies->contract_date : ''))}}" name="contract_date">
    </div>
    @error('contract_date')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <div class="mb-3">
        <label for="start_date">{{ trans('admin.academies.Start Date') }}</label>
        <input id="start_date" type="date" class="formInput" placeholder="{{trans('admin.academies.Start Date')}}" oninput="this.className = ''" value="{{(old('start_date', isset($academies) ? $academies->start_date : ''))}}" name="start_date">
    </div>
    @error('start_date')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <div class="mb-3">
        <label for="end_date">{{ trans('admin.academies.End Date') }}</label>
        <input id="end_date" type="date" class="formInput" placeholder="{{trans('admin.academies.End Date')}}" oninput="this.className = ''" value="{{(old('end_date', isset($academies) ? $academies->end_date : ''))}}" name="end_date">
    </div>
    @error('end_date')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <div class="mb-3">
        <label for="contract_number">{{ trans('admin.academies.Contract Number') }}</label>
        <input id="contract_number" type="number" class="formInput" placeholder="{{trans('admin.academies.Contract Number')}}" oninput="this.className = ''" value="{{(old('contract_number', isset($academies) ? $academies->contract_number : ''))}}" name="contract_number">
    </div>
    @error('contract_number')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <div class="mb-3">
        <label for="account_manager">{{trans('admin.academies.Account Manager')}}</label>
        <input id="account_manager" type="text" class="formInput" placeholder="{{trans('admin.academies.Account Manager')}}" oninput="this.className = ''" value="{{(old('account_manager',isset($academies) ? $academies->account_manager : ''))}}" name="account_manager">
    </div>
    @error('account_manager')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <div class="mb-3">
        <label for="image">{{trans('admin.academies.image')}}</label>
        <input id="image" type="file" class=" form-control" oninput="this.className = ''" name="image">
    </div>
    @error('image')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <label for="status">{{trans('admin.academies.Status')}}</label>
    <select class="form-control formInput basic" name="status" id="status">
        <option value="">{{trans('admin.academies.Status')}}</option>
        <option value="pending" {{( old('pending', $academies->status ?? '') == 'pending')   ? 'selected' : ''}} >{{ trans('admin.academies.pending') }}</option>
         <option value="active" {{( old('active', $academies->status ?? '') == 'active')   ? 'selected' : ''}}  >{{ trans('admin.academies.active') }}</option>
         <option value="inactive" {{( old('inactive', $academies->status ?? '') == 'inactive')   ? 'selected' : ''}} >{{ trans('admin.academies.inactive') }}</option>
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
