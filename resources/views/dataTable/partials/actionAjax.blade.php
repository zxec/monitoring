<div class="d-flex justify-content-around">
    @can($permissions['edit'])
        <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $data->id }}" data-original-title="Edit"
            class="edit btn btn-sm btn-success {{ $class['edit'] }}">
            <i class="bi bi-pencil-square"></i>
        </a>
    @endcan
    @can($permissions['delete'])
        <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $data->id }}" data-original-title="Delete"
            class="btn btn-sm btn-danger {{ $class['delete'] }}">
            <i class="bi bi-trash3-fill"></i>
        </a>
    @endcan
</div>
