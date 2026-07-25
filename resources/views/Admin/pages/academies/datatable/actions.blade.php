<div class="dropdown d-inline-block">
    <button class="btn btn-sm btn-outline-primary dropdown-toggle fw-bold px-3 py-1 d-inline-flex align-items-center gap-1 shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fa-solid fa-gears fs-6"></i>
        <span>{{ trans('admin.actions') }}</span>
        <i class="fa-solid fa-chevron-down ms-1" style="font-size: 10px;"></i>
    </button>
    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 py-2" style="min-width: 170px; z-index: 1050;">
        <li>
            <a class="dropdown-item d-flex align-items-center gap-2 py-2 text-primary fw-semibold" href="{{ route('admin.academies.show', $academies) }}">
                <i class="fa-solid fa-eye text-primary"></i>
                <span>{{ trans('admin.academies.show') }}</span>
            </a>
        </li>
        <li>
            <a class="dropdown-item d-flex align-items-center gap-2 py-2 text-warning fw-semibold" href="{{ route('admin.academies.edit', $academies) }}">
                <i class="fa-solid fa-pen-to-square text-warning"></i>
                <span>{{ trans('admin.edit') }}</span>
            </a>
        </li>
        <li><hr class="dropdown-divider my-1"></li>
        <li>
            <form method="POST" action="{{ route('admin.academies.updateStatus', $academies) }}" id="updateStatus-{{ $academies->id }}" class="d-none">
                @csrf
                @method('PUT')
            </form>
            @if($academies->status == 'active')
                <a class="dropdown-item d-flex align-items-center gap-2 py-2 text-secondary fw-semibold" href="javascript:void(0)" onclick="document.getElementById('updateStatus-{{ $academies->id }}').submit();">
                    <i class="fa-solid fa-ban text-secondary"></i>
                    <span>{{ trans('admin.academies.make_inactive') }}</span>
                </a>
            @else
                <a class="dropdown-item d-flex align-items-center gap-2 py-2 text-success fw-semibold" href="javascript:void(0)" onclick="document.getElementById('updateStatus-{{ $academies->id }}').submit();">
                    <i class="fa-solid fa-circle-check text-success"></i>
                    <span>{{ trans('admin.academies.make_active') }}</span>
                </a>
            @endif
        </li>
        <li><hr class="dropdown-divider my-1"></li>
        <li>
            <a class="dropdown-item d-flex align-items-center gap-2 py-2 text-danger fw-semibold show_confirm_two" href="javascript:void(0);" data-href="{{ route('admin.academies.delete') }}" data-id="{{ $academies->id }}" data-name="Academies">
                <i class="fa-solid fa-trash-can text-danger"></i>
                <span>{{ trans('admin.delete') }}</span>
            </a>
        </li>
    </ul>
</div>
