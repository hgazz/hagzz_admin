

<td>
    <div class="btn-group  mb-2 me-4" role="group">
        <button id="btndefault" type="button" class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ trans('admin.actions') }} <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></button>
        <div class="dropdown-menu" aria-labelledby="btndefault">
            <form method="POST" action="{{ route('admin.sport.updateStatus', $sport) }}"  class="">
                @csrf
                @method('PUT')

                <button class="btn bg-transparent">
                    @if($sport->status == 'active')
                        <span class="text-success">Active</span>
                    @else
                        <span class="text-danger">InActive</span>
                    @endif
                </button>
            </form>
            <a class="dropdown-item btn" href="{{ route('admin.sport.edit', $sport) }}">{{ trans('admin.edit') }}</a>
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <a class="dropdown-item show_confirm_two" href="javascript:void(0);" data-href="{{ route('admin.sport.delete', $sport) }}"  data-id="{{ $sport->id }}" data-name="TClass" >{{ trans('admin.delete') }}</a>
        </div>
    </div>
</td>
