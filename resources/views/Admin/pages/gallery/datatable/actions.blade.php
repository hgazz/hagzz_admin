<div class="btn-sm btn-group" role="group" aria-label="Button group with nested dropdown">
    <div class="btn-group dropstart" role="group">
        <button id="btnGroupDrop1" type="button" class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            {{ trans('admin.actions') }}
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
        </button>
        <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
            <li class="mb-1">
                <form method="POST" action="{{ route('admin.gallery.active',$gallery->id) }}" id="updateStatus-{{ $gallery->id }}">
                    @csrf
                    @method('PUT')
                </form>
                @if($gallery->active)
                    <a href="javascript:void(0)" onclick="document.getElementById('updateStatus-{{ $gallery->id }}').submit();" type="submit" class="text-success text-center fw-bold" title="{{ $gallery->active ? trans('admin.training.Active') : trans('admin.training.InActive') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-square-fill m-2 fw-bold" viewBox="0 0 16 16">
                            <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm3.354 4.646L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708"/>
                        </svg>
                        {{ trans('admin.academies.make_inactive') }}
                    </a>
                @else
                    <a href="javascript:void(0)" onclick="document.getElementById('updateStatus-{{ $gallery->id }}').submit();" type="submit" class="text-danger text-center fw-bold" title="{{ $gallery->active ? trans('admin.training.Active') : trans('admin.training.InActive') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-square m-2 fw-bold" viewBox="0 0 16 16">
                            <path d="M3 14.5A1.5 1.5 0 0 1 1.5 13V3A1.5 1.5 0 0 1 3 1.5h8a.5.5 0 0 1 0 1H3a.5.5 0 0 0-.5.5v10a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V8a.5.5 0 0 1 1 0v5a1.5 1.5 0 0 1-1.5 1.5z"/>
                            <path d="m8.354 10.354 7-7a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0"/>
                        </svg>
                        {{ trans('admin.academies.make_active') }}
                    </a>
                @endif
            </li>
        </ul>
    </div>
</div>

