<td class="text-center">
    <div class="action-btns d-flex">
        <a href="{{ route('admin.sport.edit', $sport) }}" class="text-warning me-2" data-toggle="tooltip"
           data-placement="top"
           title="{{ trans('admin.academies.edit') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2">
                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
            </svg>
        </a>

        <form method="POST" action="{{ route('admin.sport.updateStatus', $sport) }}"  class="ms-2">
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

        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
        <a href="javascript:void(0)" data-href="{{ route('admin.sport.delete', $sport) }}"  data-id="{{ $sport->id }}" data-name="Sport" type="submit"
           class="text-danger show_confirm_two" style="border: none;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                 class="feather feather-trash-2">
                <polyline points="3 6 5 6 21 6"></polyline>
                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                <line x1="10" y1="11" x2="10" y2="17"></line>
                <line x1="14" y1="11" x2="14" y2="17"></line>
            </svg>
        </a>



    </div>
</td>
