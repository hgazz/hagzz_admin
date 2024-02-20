

@csrf
<div class="row">
    <div class="row">

        <div class="col-md-6 mb-3">
            <label for="icon">{{trans('admin.setting.key')}}</label>
            <input type="text" name="key" value="{{isset($setting) ? $setting->key : old('key')}}"  class="form-control"  placeholder="key">
            @error('key')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="role">{{trans('admin.setting.type')}}</label>
            <select name="type" id="selectInput" class="form-control" onchange="showDiv()">
                @foreach($types as $type)
                    <option value="{{$type}}"  @selected(old('type', isset($setting) ? $setting->type : '') == $type)>{{$type}}</option>
                @endforeach
            </select>
            @error('type')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="col-md-6 mb-3" style="display: none" id="imageDiv">
            <label for="icon">{{trans('admin.sport.icon')}}</label>
            <input type="file" name="value" class="form-control">
            @error('value')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="col-md-6 mb-3" id="textDiv">
            <label for="icon">{{trans('admin.setting.value')}}</label>
            <input type="text" name="value" name="key" value="{{isset($setting) && $setting->type == 'text' ? $setting->value : old('value')}}" class="form-control"  placeholder="value">
            @error('value')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
    </div>
</div>

<script>

    function showDiv() {
        var selectOption = document.getElementById("selectInput");
        var textDiv = document.getElementById("textDiv");
        var imageDiv = document.getElementById("imageDiv");

        if (selectOption.value === "text") {
            textDiv.style.display = "block";
            imageDiv.style.display = "none";
        } else if (selectOption.value === "image") {
            textDiv.style.display = "none";
            imageDiv.style.display = "block";
        }
    }
    showDiv()
</script>

