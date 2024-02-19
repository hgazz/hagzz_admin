@csrf
<div class="row">
    <div class="row">
        @foreach (\App\Services\TranslatableService::getTranslatableInputs(App\Models\Sport::class) as $name => $data)
            <div class="col-md-6 mb-3">
                <label for="{{$name}}" class="form-label">{{$name}}</label>
                <input type="text" id="{{$name}}" name="{{$name}}" maxlength="50" class="form-control"
                       value="@if ($name == 'name_en') {{old($name, $sport?->getTranslation('name','en')  ?? '')}} @else {{old($name, $sport?->getTranslation('name','ar')  ?? '')}} @endif"
                       placeholder="Enter {{$name}}" data-parsley-required-message="Please enter {{$name}}">
                @error($name)
                <span class="text-danger">*{{$message}}</span>
                @enderror
            </div>
        @endforeach
            <div class="col-md-6 mb-3">
                <label for="role">{{trans('admin.sport.level')}}</label>
                <select name="level" class="form-control">
                    @foreach($roles as $role)
                        <option value="{{$role}}">{{$role}}</option>
                    @endforeach
                </select>
                @error('level')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

        <div class="col-md-6 mb-3">
            <label for="icon">{{trans('admin.sport.icon')}}</label>
            <input type="file" name="icon"  class="form-control">
            @error('icon')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

    </div>
</div>
