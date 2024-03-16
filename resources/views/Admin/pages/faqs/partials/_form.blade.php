@csrf
<div class="row">
    <div class="row">
        @foreach (\App\Services\TranslatableService::getTranslatableInputs(App\Models\Faq::class) as $name => $data)
            <div class="col-md-6 mb-3">
                <label for="{{$name}}" class="form-label">{{trans('admin.faq.'.$name)}}</label>
                <input type="text" id="{{$name}}" name="{{$name}}" maxlength="50" class="form-control"
                       value=" @if ($name == 'question_en') {{old($name, isset($faq) ? $faq->getTranslation('question','en')  : '')}} @elseif($name == 'answer_en') {{old($name, isset($faq) ? $faq->getTranslation('answer','en')  : '')}} @elseif($name == 'answer_ar') {{old($name, isset($faq) ? $faq->getTranslation('answer','ar')  : '')}} @else {{old($name, isset($faq) ? $faq->getTranslation('question','ar')  : '')}} @endif "
                       placeholder="Enter {{$name}}" data-parsley-required-message="Please enter {{$name}}">
                @error($name)
                <span class="text-danger">*{{$message}}</span>
                @enderror
            </div>
        @endforeach
    </div>
</div>

