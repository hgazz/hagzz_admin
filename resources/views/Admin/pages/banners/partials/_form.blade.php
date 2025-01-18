
@csrf
<div class="row">
    <div class="profile-image">
        <div class="img-uploader-content">

            <input type="file" class="form-control" placeholder
                   name="image" accept="image/png, image/jpeg, image/gif"  onchange="previewImage(event)"/>
            <img id="imagePreview" src="{{isset($banner) ? $banner->logo: '#'}}" alt="Image Preview" width="400px" height="400px" class="mt-3 @if(isset($gallery)) 'd-block' @else 'd-block' @endif">

        </div>

    </div>
    <div class="col-sm-8 mx-auto">
        <select name="status" id="" class="form-control mt-2">
            <option value="">{{ trans('admin.academies.Status') }}</option>
            <option value="active" @selected(old('status', (isset($banner) ? $banner->status : '')) == 'active')>{{ trans('admin.academies.active') }}</option>
            <option value="inactive" @selected(old('status', (isset($banner) ? $banner->status : '')) == 'inactive')>{{ trans('admin.academies.inactive') }}</option>
        </select>
    </div>

        <div class="col-md-12 mb-3">
            <select class="form-select" name="country">
                <option value="">{{trans('admin.city.Select County')}}<code>*</code></option>
                <option value="eg"  @selected(old('country', isset($country) ? $country : '') == 'eg')>Egypt</option>
                <option value="qa"  @selected(old('country', isset($country) ? $country : '') == 'qa')>Qatar</option>
            </select>
            @error('country')
            <span class="text-danger">*{{$message}}</span>
            @enderror
        </div>
</div>

@push('js')
    <script>
        function previewImage(event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imagePreview = document.getElementById('imagePreview');
                    imagePreview.src = e.target.result;
                    imagePreview.classList.replace('d-none','d-block');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush
