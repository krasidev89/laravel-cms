<div class="btn-group btn-group-sm" role="group">
    @can('manage_system')
        @if ($user->trashed())
            <a href="{{ route('backend.users.restore', ['user' => $user->id]) }}" class="btn dt-bt-restore" data-dt-toggle="tooltip" data-placement="top" title="{{ __('Restore') }}">
                <i class="fas fa-trash-restore text-success"></i>
            </a>
            <a href="{{ route('backend.users.force-delete', ['user' => $user->id]) }}" class="btn dt-bt-delete" data-dt-toggle="tooltip" data-placement="top" title="{{ __('Force delete') }}">
                <i class="fas fa-trash text-danger"></i>
            </a>
        @else
            <a href="{{ route('backend.users.edit', ['user' => $user->id]) }}" class="btn" data-dt-toggle="tooltip" data-placement="top" title="{{ __('Edit') }}">
                <i class="fas fa-edit text-primary"></i>
            </a>
            @if (!$user->is_admin)
            <a href="{{ route('backend.users.destroy', ['user' => $user->id]) }}" class="btn dt-bt-delete" data-dt-toggle="tooltip" data-placement="top" title="{{ __('Delete') }}">
                <i class="fas fa-trash text-warning"></i>
            </a>
            @endif
        @endif
    @endcan
</div>
