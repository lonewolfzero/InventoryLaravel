@extends('layouts.app')

@section('content')
<div class="main-body">
    <div class="page-wrapper">
    
        <!-- Page-header start -->
        <div class="page-header card">
            <div class="card-block">
                <h5 class="m-b-10">{{ __('Business Locations') }} </h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="ti-home"></i> {{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('Business Locations') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- Page-header end -->
        

        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-right">
                                <ul class="list-unstyled card-option">
                                    <li><i class="fa fa-chevron-left"></i></li>
                                    <li><i class="fa fa-window-maximize full-card"></i></li>
                                    <li><i class="fa fa-minus minimize-card"></i></li>
                                    <li><i class="fa fa-refresh reload-card"></i></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-block table-border-style">
                            @can('business.create_location')
                                <a href="{{ route('business.create_location') }}">
                                    <button class="btn btn-success btn-round btn-sm mb-2"><i class="ti-plus"></i>{{ __('Tambah') }}</button>
                                </a>
                            @endcan
                            <table class="table w-100" id="business-locations-table">
                                <thead>
                                    <tr>
                                        <th>{{ __('No') }}</th>
                                        <th>{{ __('Location ID') }}</th>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Country') }}</th>
                                        <th>{{ __('Full Address') }}</th>
                                        @php $permission = false; @endphp
                                        @canany(['business.update_location', 'business.delete_location'])
                                            @php $permission = true; @endphp
                                            <th>{{ __('Action') }}</th>
                                        @endcanany
                                    </tr>
                                </thead>
                            </table>
                            <div class="pull-right">
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
@include('partials.functions')
@include('partials.datatables')
<script>
    var permissions = "{{$permission}}";
    $(document).ready(function(){

        var businessLocationsTable = $('#business-locations-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('business.locations') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'location_id', name: 'location_id' },
                { data: 'name', name: 'name' },
                { data: 'country', name: 'country' },
                { data: 'full_address', name: 'full_address' },
                { data: 'actions', name: 'actions', orderable:false, searchable:false, visible: permissions }
            ],
        });

        businessLocationsTable.on('error', function () { 
            console.log('DataTables - Ajax Businness Locations Error ' );
            businessLocationsTable.ajax.reload();
        });
    });
</script>
@endpush 