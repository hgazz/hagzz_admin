@csrf
<div class="row">
    <div class="row">
        @foreach (\App\Services\TranslatableService::getTranslatableInputs(App\Models\Faq::class) as $name => $data)
            <div class="col-md-6 mb-3">
                <label for="{{$name}}" class="form-label">{{trans('admin.faq.'.$name)}}</label>
                <input type="text" id="{{$name}}" name="{{$name}}" maxlength="250" class="form-control"
                       @php
                           $language = $name == 'question_en' ? 'en' : 'ar';
                           $defaultValue = isset($faq) ? $faq->getTranslation('question', $language) : '';
                       @endphp
                       value="{{ old($name, $defaultValue) }}"
                       placeholder="Enter {{$name}}" data-parsley-required-message="Please enter {{$name}}">
                @error($name)
                <span class="text-danger">*{{$message}}</span>
                @enderror
            </div>
        @endforeach
        <div class="col-6">
            <label for="answer_en">{{trans('admin.faq.answer_en')}}</label>
            <textarea id="answer_en" name="answer_en" class="form-control">{{ old('answer_en', isset($faq) ? $faq->getTranslation('answer', 'en') : '') }}</textarea>
            @error('answer_en')
            <span class="text-danger">*{{$message}}</span>
            @enderror
        </div>
        <div class="col-6">
            <label for="answer_ar">{{trans('admin.faq.answer_ar')}}</label>
            <textarea id="answer_ar" name="answer_ar" class="form-control">{{ old('answer_ar', isset($faq) ? $faq->getTranslation('answer', 'ar') : '') }}</textarea>
            @error('answer_ar')
            <span class="text-danger">*{{$message}}</span>
            @enderror
        </div>
    </div>
</div>

