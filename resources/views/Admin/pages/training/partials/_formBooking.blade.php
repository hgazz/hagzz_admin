<div class="row g-4">
    <!-- STUDENT SELECTION OR NEW STUDENT -->
    <div class="col-lg-6 mb-3">
        <label for="academy_student_id" class="form-label fw-bold">
            <i class="fa-solid fa-user text-primary me-1"></i> الطالب أو العضو المسجل <code>*</code>
        </label>
        <select id="academy_student_id" name="academy_student_id" class="form-select">
            <option value="">-- اختر طالب مسجل مسبقاً (أو أسطر بيانات طالب جديد بالأسفل) --</option>
            @foreach($students as $student)
                <option value="{{ $student->id }}" @selected(old('academy_student_id') == $student->id)>
                    {{ $student->name }}{{ $student->phone ? ' — '.$student->phone : '' }}{{ $student->guardian_name ? ' — (ولي الأمر: '.$student->guardian_name.')' : '' }}
                </option>
            @endforeach
        </select>
        @error('academy_student_id')
            <span class="text-danger small">{{ $message }}</span>
        @enderror
    </div>

    <!-- TRAINING SELECTION -->
    <div class="col-lg-6 mb-3">
        <label for="training_id" class="form-label fw-bold">
            <i class="fa-solid fa-dumbbell text-primary me-1"></i> {{ trans('admin.training.training_name') }} <code>*</code>
        </label>
        <select id="training_id" name="training_id" class="form-select" required>
            <option value="">{{ trans('admin.academies.select_training') }}</option>
            @foreach($trainings as $training)
                <option value="{{ $training->id }}" data-price="{{ number_format((float)$training->price, 2, '.', '') }}" @selected(old('training_id') == $training->id)>
                    {{ $training->name }} — ({{ number_format((float)$training->price, 2) }})
                </option>
            @endforeach
        </select>
        @error('training_id')
            <span class="text-danger small">{{ $message }}</span>
        @enderror
    </div>

    <!-- NEW STUDENT FAST INPUTS (Shown if no student selected) -->
    <div id="new_student_fields" class="row g-3">
        <div class="col-md-6 mb-3">
            <label for="name" class="form-label fw-bold"><i class="fa-solid fa-signature text-secondary me-1"></i> اسم الطالب الجديد</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" placeholder="أدخل اسم الطالب الكامل">
            @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>
        <div class="col-md-6 mb-3">
            <label for="phone" class="form-label fw-bold"><i class="fa-solid fa-phone text-secondary me-1"></i> رقم الهاتف</label>
            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}" placeholder="أدخل رقم الجوال">
            @error('phone') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>
    </div>

    <!-- PRICING & PAYMENT BREAKDOWN -->
    @php($ar = app()->getLocale() === 'ar')
    <div class="col-md-4 mb-3">
        <label for="price_display" class="form-label fw-bold"><i class="fa-solid fa-money-bill-wave text-success me-1"></i> {{ $ar ? 'إجمالي سعر التدريب' : 'Total Price' }}</label>
        <input id="price_display" class="form-control bg-light fw-bold text-dark" type="number" step="0.01" readonly placeholder="0.00">
    </div>
    <div class="col-md-4 mb-3">
        <label for="paid_amount" class="form-label fw-bold"><i class="fa-solid fa-hand-holding-dollar text-primary me-1"></i> {{ $ar ? 'المبلغ المدفوع' : 'Paid Amount' }} <code>*</code></label>
        <input id="paid_amount" name="paid_amount" class="form-control fw-bold" type="number" min="0" step="0.01" value="{{ old('paid_amount', 0) }}" required>
        @error('paid_amount') <span class="text-danger small">{{ $message }}</span> @enderror
    </div>
    <div class="col-md-4 mb-3">
        <label for="remaining_amount" class="form-label fw-bold"><i class="fa-solid fa-scale-unbalanced text-danger me-1"></i> {{ $ar ? 'المبلغ المتبقي' : 'Remaining Amount' }}</label>
        <input id="remaining_amount" class="form-control bg-light fw-bold text-danger" type="number" step="0.01" readonly placeholder="0.00">
    </div>

    <!-- PAYMENT METHOD -->
    <div class="col-12 mb-3">
        <label class="form-label fw-bold"><i class="fa-solid fa-credit-card text-info me-1"></i> {{ trans('admin.payment_method') }} <code>*</code></label>
        <div class="d-flex flex-wrap gap-2 mt-2">
            @foreach(App\Helpers\PaymentMethodHelper::getMethodsForCountry('SA') as $pm)
                <label class="btn btn-outline-light border shadow-sm p-2 d-flex align-items-center gap-2">
                    <input type="radio" name="payment_method" value="{{ $pm['id'] }}" @checked(old('payment_method', 'cash') === $pm['id']) required>
                    <img src="{{ $pm['logo'] }}" alt="{{ $pm['name_ar'] }}" style="height: 26px; width: 50px; object-fit: contain;">
                    <span class="fw-bold text-dark small">{{ app()->getLocale() == 'ar' ? $pm['name_ar'] : $pm['name_en'] }}</span>
                </label>
            @endforeach
        </div>
    </div>
    <div class="col-md-6 mb-3 d-none" id="other_wrap">
        <label for="payment_method_other" class="form-label fw-bold">{{ trans('admin.payment_method_other') }}</label>
        <input id="payment_method_other" name="payment_method_other" class="form-control" value="{{ old('payment_method_other') }}">
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const trainingSelect = document.getElementById('training_id');
    const priceDisplay = document.getElementById('price_display');
    const paidInput = document.getElementById('paid_amount');
    const remainingInput = document.getElementById('remaining_amount');
    const studentSelect = document.getElementById('academy_student_id');
    const newStudentFields = document.getElementById('new_student_fields');
    const paymentMethodSelect = document.getElementById('payment_method');
    const otherWrap = document.getElementById('other_wrap');

    function updatePricing() {
        const selected = trainingSelect.options[trainingSelect.selectedIndex];
        const price = selected ? parseFloat(selected.getAttribute('data-price') || 0) : 0;
        priceDisplay.value = price.toFixed(2);
        
        const paid = parseFloat(paidInput.value || 0);
        const remaining = Math.max(0, price - paid);
        remainingInput.value = remaining.toFixed(2);
    }

    function toggleStudentFields() {
        if (studentSelect.value) {
            newStudentFields.classList.add('d-none');
        } else {
            newStudentFields.classList.remove('d-none');
        }
    }

    function toggleOtherPayment() {
        if (paymentMethodSelect.value === 'other') {
            otherWrap.classList.remove('d-none');
        } else {
            otherWrap.classList.add('d-none');
        }
    }

    trainingSelect.addEventListener('change', updatePricing);
    paidInput.addEventListener('input', updatePricing);
    studentSelect.addEventListener('change', toggleStudentFields);
    paymentMethodSelect.addEventListener('change', toggleOtherPayment);

    updatePricing();
    toggleStudentFields();
    toggleOtherPayment();
});
</script>
