@csrf
<div class="row">
    <div class="row">
        @foreach (\App\Services\TranslatableService::getTranslatableInputs(App\Models\Sport::class) as $name => $data)
            <div class="col-md-6 mb-3">
                <label for="{{$name}}" class="form-label">{{trans('admin.area.'.$name)}} <code>*</code></label>
                <input type="text" id="{{$name}}" name="{{$name}}" maxlength="50" class="form-control"
                       @php
                           $language = $name == 'name_en' ? 'en' : 'ar';
                           $defaultValue = isset($sport) ? $sport->getTranslation('name', $language) : '';
                       @endphp
                       value="{{ old($name, $defaultValue) }}"
                       placeholder="Enter {{$name}}" data-parsley-required-message="Please enter {{$name}}">
                @error($name)
                <span class="text-danger">*{{$message}}</span>
                @enderror
            </div>
        @endforeach

        <div class="col-md-6 mb-3">
            <label for="icon">{{trans('admin.sport.icon')}} <code>*</code></label>
            <input type="file" name="icon"  class="form-control">
            @error('icon')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
    </div>
</div>
