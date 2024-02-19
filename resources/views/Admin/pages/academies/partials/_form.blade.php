<div class="row">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="first_name">{{trans('admin.academies.first_name')}}</label>
            <input type="text" name="first_name" class="form-control" id="first_name" placeholder="{{trans('admin.academies.enter_first_name')}}">
            @error('first_name')
                <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="last_name">{{trans('admin.academies.last_name')}}</label>
            <input type="text" name="last_name" class="form-control" id="last_name" placeholder="{{trans('admin.academies.enter_last_name')}}">
            @error('last_name')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="last_name">{{trans('admin.academies.full_name_arabic')}}</label>
            <input type="text" name="full_name_arabic" class="form-control" id="full_name_arabic" placeholder="{{trans('admin.academies.full_name_arabic')}}">
            @error('full_name_arabic')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

    </div>
</div>
