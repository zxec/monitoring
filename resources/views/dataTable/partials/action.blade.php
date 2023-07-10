<div class="d-flex justify-content-around">
    @can($permissions['edit'])
        <a href="{{ route($route['edit'], $data) }}"class="edit btn btn-sm btn-success">
            <i class="bi bi-pencil-square"></i>
        </a>
    @endcan
    @can($permissions['delete'])
        <form action="{{ route($route['delete'], $data) }}" method="POST">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-sm btn-danger">
                <i class="bi bi-trash3-fill"></i>
            </button>
        </form>
    @endcan
</div>
