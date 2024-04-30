<td class="text-center">
    <div class="action-btns d-flex">
        <a href="{{ route('admin.user.show', $user) }}" class="text-success me-2" data-toggle="tooltip"
           data-placement="top"
           title="{{ trans('admin.user.show') }}">

            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
        </a>



        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
        <a href="javascript:void(0)" data-href="{{ route('admin.user.delete', $user) }}"  data-id="{{ $user->id }}" data-name="Sport" type="submit"
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

