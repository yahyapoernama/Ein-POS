@props(['id' => null, 'columns' => [], 'darkThead' => true])

<div class="datatable-wrapper position-relative">
    <div class="datatable-overlay"></div>
    <table class="table table-bordered table-hover datatable" {{ $id ? "id=$id" : '' }}>
        <thead class="{{ $darkThead ? 'thead-dark' : '' }}">
            <tr>
                @foreach ($columns as $column)
                    <th>{{ $column }}</th>
                @endforeach
            </tr>
        </thead>
    </table>
</div>
