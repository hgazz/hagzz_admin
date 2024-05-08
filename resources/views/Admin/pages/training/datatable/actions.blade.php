<div class="btn-sm btn-group" role="group" aria-label="Button group with nested dropdown">
    <div class="btn-group dropstart" role="group">
        <button id="btnGroupDrop1" type="button" class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            {{ trans('admin.actions') }}
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
        </button>
        <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
            <form action="{{route('admin.training.active',$training)}}" method="post" class="d-inline" id="updateStatus-{{ $training->id }}">
                @csrf @method('PUT')
            </form>
            <li class="mb-1">
                @if($training->active)
                    <a href="javascript:void(0)" onclick="document.getElementById('updateStatus-{{ $training->id }}').submit();" type="submit" class="text-success text-center fw-bold" title="{{ $training->active }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-square-fill m-2 fw-bold" viewBox="0 0 16 16">
                            <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm3.354 4.646L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708"/>
                        </svg>
                        {{ trans('admin.academies.make_inactive') }}
                    </a>
                @else
                    <a href="javascript:void(0)" onclick="document.getElementById('updateStatus-{{ $training->id }}').submit();" type="submit" class="text-danger text-center fw-bold" title="{{ $training->active }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-square m-2 fw-bold" viewBox="0 0 16 16">
                            <path d="M3 14.5A1.5 1.5 0 0 1 1.5 13V3A1.5 1.5 0 0 1 3 1.5h8a.5.5 0 0 1 0 1H3a.5.5 0 0 0-.5.5v10a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V8a.5.5 0 0 1 1 0v5a1.5 1.5 0 0 1-1.5 1.5z"/>
                            <path d="m8.354 10.354 7-7a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0"/>
                        </svg>
                        {{ trans('admin.academies.make_active') }}
                    </a>
                @endif
            </li>
            <li class="mb-1">
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <a href="{{ route('admin.training.createBooking', $training) }}" class="text-success text-center" title="{{ trans('admin.training.booking') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark-plus m-2 fw-bold" viewBox="0 0 16 16">
                        <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1z"/>
                        <path d="M8 4a.5.5 0 0 1 .5.5V6H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V7H6a.5.5 0 0 1 0-1h1.5V4.5A.5.5 0 0 1 8 4"/>
                    </svg>
                    {{ trans('admin.training.make_booking') }}
                </a>
            </li>
            @if($training->joins->count() == 0)
                <li class="mb-1">
                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                        <a class="text-danger text-center fw-bold show_confirm_two" href="javascript:void(0);" data-href="{{route('admin.trainings.delete', $training)}}"  data-id="{{ $training->id }}" data-name="Training">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill m-2 fw-bold" viewBox="0 0 16 16">
                                <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
                            </svg>
                            {{ trans('admin.delete') }}
                        </a>
                </li>
            @endif
        </ul>
    </div>
</div>


