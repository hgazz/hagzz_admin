@csrf
<div class="row">
    <div class="row">

        <div class="col-md-6 mb-3">
            <label for="keySelect">{{ trans('admin.setting.key') }}<code>*</code></label>
            <select class="form-select" id="keySelect" name="key">
                @foreach($keys as $key)
                    <option value="{{$key}}" @selected(old('key', isset($setting) ? $setting->key : '') == $key)>{{$key}}</option>
                @endforeach
            </select>
            @error('key')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="types">{{trans('admin.setting.type')}}<code>*</code></label>
            <select name="type" id="types" class="form-control" onchange="showDiv(this.value)">

            </select>
            @error('type')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="col-md-6 mb-3" style="display: none" id="imageDiv">
            <label for="icon">{{trans('admin.sport.icon')}}<code>*</code></label>
            <input type="file" name="image_value" class="form-control">
            @error('image_value')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="col-md-6 mb-3" id="textDiv">
            <label for="value">{{trans('admin.setting.value')}}<code>*</code></label>
            <input type="text" name="value" id="value"  value="{{isset($setting) && $setting->type == 'text' ? $setting->value : old('value')}}" class="form-control"  placeholder="value">
            @error('value')
            <span class="text-danger">{{$message}}</span>z
            @enderror
        </div>

        <div class="col-md-12 mb-3" style="display: none" id="textAreaDiv">
            <label for="body">{{ trans('admin.setting.value') }}<code>*</code></label>
            <textarea class="form-control @error('text_value') is-invalid fparsley-error parsley-error @enderror" id="body" name="text_value" rows="5">{!! isset($setting) && $setting->type == 'textarea' ? $setting->value : old('text_value') !!}</textarea>
            @error('text_value')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>
</div>

<script src="https://cdn.tiny.cloud/1/1x95in08jsivihseg2w5ae6dd0m41w3q5pn559acmpuam8r4/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    function showDiv(selectedValue) {
        let textDiv = document.getElementById("textDiv");
        let textAreaDiv = document.getElementById("textAreaDiv");
        let imageDiv = document.getElementById("imageDiv");

        if (selectedValue === "text") {
            textDiv.style.display = "block";
            imageDiv.style.display = "none";
            textAreaDiv.style.display = "none";
        } else if (selectedValue === "image") {
            textDiv.style.display = "none";
            imageDiv.style.display = "block";
            textAreaDiv.style.display = "none";
        } else if (selectedValue === "textarea") {
            textAreaDiv.style.display = "block";
            textDiv.style.display = "none";
            imageDiv.style.display = "none";
        }
    }

    // Call the showDiv function with the initial value when the page loads
    showDiv(document.getElementById("types").value);
</script>
<script>
    tinymce.init({
        selector: 'textarea#body',
    })
</script>
<script>
    var keySelect = document.getElementById('keySelect');
    var typesSelect = document.getElementById('types');
    let textDiv = document.getElementById("textDiv");
    let textAreaDiv = document.getElementById("textAreaDiv");
    let imageDiv = document.getElementById("imageDiv");
    document.addEventListener('DOMContentLoaded', function(){
        var key = keySelect.value;
        if(key === "about" || key === "terms" || key === "privacy"){
            typesSelect.innerHTML += `
                    <option value="textarea">textarea</option>
                `;
            textAreaDiv.style.display = "block";
            textDiv.style.display = "none";
            imageDiv.style.display = "none";
        }else if(key === "logo"){
            typesSelect.innerHTML += `
                    <option value="image">image</option>
                `;
            textAreaDiv.style.display = "none";
            textDiv.style.display = "none";
            imageDiv.style.display = "block";
        }else {

            typesSelect.innerHTML += `
                    <option text="text">text</option>
                `;
            textAreaDiv.style.display = "none";
            textDiv.style.display = "block";
            imageDiv.style.display = "none";
        }
    })

    keySelect.addEventListener('change', function(){
        let key = keySelect.value;
        if(key === "about" || key === "terms" || key === "privacy"){
            typesSelect.innerHTML += `
                    <option value="textarea" selected>textarea</option>
                `;
            textAreaDiv.style.display = "block";
            textDiv.style.display = "none";
            imageDiv.style.display = "none";
        }else if(key === "logo"){
            typesSelect.innerHTML += `
                    <option value="image" selected>image</option>
                `;
            textAreaDiv.style.display = "none";
            textDiv.style.display = "none";
            imageDiv.style.display = "block";
        }else {
            typesSelect.innerHTML += `
                    <option text="text" selected>text</option>
                `;
            textAreaDiv.style.display = "none";
            textDiv.style.display = "block";
            imageDiv.style.display = "none";
        }
    })
</script>

