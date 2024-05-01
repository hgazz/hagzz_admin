

<td>
    <div class="btn-group  mb-2 me-4" role="group">

        <button id="btndefault" type="button" class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ trans('admin.actions') }} <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></button>
        <div class="dropdown-menu" aria-labelledby="btndefault">
            <form method="POST" action="{{ route('admin.academies.updateStatus', $academies) }}" id="updateStatus" class="me-1 d-inline">
                @csrf
                @method('PUT')

                <button type="submit" class="btn bg-transparent text-{{ $academies->status == 'active' ? 'success' : 'danger' }}" title="{{ $academies->status }}">
                    @if($academies->status == 'active')
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="9" y1="9" x2="15" y2="15"></line><line x1="15" y1="9" x2="9" y2="15"></line></svg>
                    @endif
                </button>
            </form>
            <a href="{{route('admin.academies.show',$academies)}}" class="text-primary" data-toggle="tooltip"
               data-placement="top"
               title="{{ trans('admin.academies.show') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
            </a>
            <a class="d-block btn btn-primary" href="{{ route('admin.academies.edit', $academies) }}}">{{ trans('admin.edit') }}</a>
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <a class="d-block show_confirm_two my-2 btn btn-danger" href="javascript:void(0);" data-href="{{ route('admin.academies.delete', $academies) }}"  data-id="{{ $academies->id }}" data-name="Coach">{{ trans('admin.delete') }}</a>
        </div>
    </div>
</td>
