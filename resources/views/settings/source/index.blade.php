@extends('layouts.app')
@section('title','PCF - Source List')

@section('content')
<div id="wrapper">

    <!-- Sidebar -->
    @include('layouts.sidebar')
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            @include('layouts.navbar')
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Source List</h1>
                </div>

                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- DataTales Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <div class="row">
                                        @can('source_create')
                                        <div class="col-md-4 offset-md-8">
                                            <a href="{{ route('settings.source.create') }}" class="btn btn-primary float-right"><i class="fas fa-plus-circle"></i> Create New Source</a>
                                        </div>
                                        @endcan
                                    </div>
                                </div>
                            @if(auth()->user()->hasRole('Administrator') || auth()->user()->hasRole('Super Administrator'))
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped dt-responsive" id="source_dataTable" width="100%"
                                            cellspacing="0">
                                            <thead>
                                                <tr class="thead-dark">
                                                    <th>ID</th>
                                                    <th>Supplier</th>
                                                    <th>Item Code</th>
                                                    <th>Description</th>
                                                    <th>Unit Price</th>
                                                    <th>Currency Rate</th>
                                                    <th>Total Price (Php)</th>
                                                    <th>Item Group</th>
                                                    <th>UOM</th>
                                                    <th>Mandatory Peripherals</th>
                                                    <th>Cost Of Peripherals</th>
                                                    <th>Segment</th>
                                                    <th>Item Category</th>
                                                    <th>Standard Price</th>
                                                    <th>Profitability</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                            @if(auth()->user()->hasRole('PSR'))
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover dt-responsive" id="psrSource_dataTable" width="100%"
                                            cellspacing="0">
                                            <thead>
                                                <tr class="thead-dark">
                                                    <th>Supplier</th>
                                                    <th>Item Code</th>
                                                    <th>Description</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                            </div>
                        </div>
                    </div>
                    <!-- Content Row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->
        <!-- Modal Component -->
        @include('modals.source.edit')
        <!-- End of Modal Component -->
        <!-- Footer -->
        @include('layouts.footer')
        <!-- End of Footer -->
    </div>
    <!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->
@endsection

@section('scripts')
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            showCloseButton: true,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        $(function() {
            $('#psrSource_dataTable').DataTable({
                "stripeClasses": [],
                processing: true,
                serverSide: true,
                responsive: true,
                searchable: true,
                ordering: true,
                ajax: {
                    url: "{{ route('settings.source.psr_list') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                },
                columns: [
                    { data: 'supplier' },
                    { data: 'item_code' },
                    { data: 'description' },
                ],
            });
        });

        $(function() {
            $('#source_dataTable').DataTable({
                "stripeClasses": [],
                processing: true,
                serverSide: true,
                responsive: true,
                searchable: true,
                ordering: true,
                ajax: {
                    url: "{{ route('settings.source.full_list') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                },
                columns: [
                    { data: 'id' },
                    { data: 'supplier' },
                    { data: 'item_code' },
                    { data: 'description' },
                    { data: 'unit_price' },
                    { data: 'currency_rate' },
                    { data: 'tp_php' },
                    { data: 'item_group' },
                    { data: 'uom' },
                    { data: 'mandatory_peripherals' },
                    { data: 'cost_of_peripherals' },
                    { data: 'segment' },
                    { data: 'item_category' },
                    { data: 'standard_price' },
                    { data: 'profitability' },
                    { data: 'actions', orderable: false, searchable: false }
                ],
            });
        });

        let source_id;

        $('#source_dataTable').on('click', '.editSourceDetails', function (e) {
            e.preventDefault();
            source_id = $(this).data('id');
            if (source_id){
                $.ajax({
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/settings.source/get-details/source=' + source_id,
                    contentType: "application/json; charset=utf-8",
                    cache: false,
                    dataType: 'json',
                }).done(function(data) {
                    $('#editSourceModal').modal('show');
                    $('#edit_source_id').val(data.id);
                    $('#edit_supplier').val(data.supplier);
                    $('#edit_item_code').val(data.item_code);
                    $('#edit_description').val(data.description);
                    $('#edit_unit_price').val(data.unit_price);
                    $('#edit_currency_rate').val(data.currency_rate);
                    $('#edit_tp_php').val(data.tp_php);
                    $('#edit_item_group').val(data.item_group);
                    $('#edit_uom').val(data.uom);
                    $('#edit_mandatory_peripherals').val(data.mandatory_peripherals);
                    $('#edit_cost_of_peripherals').val(data.cost_of_peripherals);
                    $('#edit_segment').val(data.segment);
                    $('#edit_item_category').val(data.item_category);
                    $('#edit_standard_price').val(data.standard_price);
                    $('#edit_profitability').val(data.profitability);
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    Toast.fire({
                        icon: 'error',
                        title: 'Oops! Something went wrong.',
                        text: 'Please contact your system administrator.'
                    })
                });
            }
        })

        const edit_element = document.querySelectorAll('#edit_unit_price, #edit_currency_rate, #edit_cost_of_peripherals');
        edit_element.forEach(j => {
            j.addEventListener('input', function() {
                editCalculateTP();
                editCalculateStandardPrice();
            });
        });

        $("#edit_item_category").change(function(){
            editCalculateStandardPrice();
            document.getElementById("edit_item_category").value !== "MACHINE"
                ? document.getElementById("edit_profitability").value = "50%"
                : document.getElementById("edit_profitability").value = "30%"
        });

        function editCalculateTP()
        {
            const edit_unit_price = parseFloat(document.getElementById("edit_unit_price").value);
            const edit_currency_rate = parseFloat(document.getElementById("edit_currency_rate").value);

            (!isNaN(edit_unit_price) && !isNaN(edit_currency_rate))
                ? document.getElementById("edit_tp_php").value = (edit_unit_price * edit_currency_rate).toFixed(2)
                : document.getElementById("edit_tp_php").value = ''
        }


        function editCalculateStandardPrice()
        {
            const edit_currency_rate = document.getElementById("edit_currency_rate").value;
            const edit_tp_php = parseFloat(document.getElementById("edit_tp_php").value);
            const edit_cost_of_peripherals = parseFloat(document.getElementById("edit_cost_of_peripherals").value);
            const edit_item_category = document.getElementById("edit_item_category").value;

            const edit_standard_price = document.getElementById("edit_standard_price");

            if (edit_currency_rate == 1) {
                if (!isNaN(edit_cost_of_peripherals) && edit_item_category == "MACHINE") {
                    edit_standard_price.value = ((((edit_tp_php * 1.15) + edit_cost_of_peripherals) / (1 - 0.3)) * 1.12).toFixed(2)
                }
                else if (isNaN(edit_cost_of_peripherals) && edit_item_category == "MACHINE") {
                    edit_standard_price.value = ((((edit_tp_php * 1.15) + 0) / (1 - 0.3)) * 1.12).toFixed(2)
                }
                else if (!isNaN(edit_cost_of_peripherals) && edit_item_category !== "MACHINE") {
                    edit_standard_price.value = ((((tp_php * 1.15) + edit_cost_of_peripherals) / (1 - 0.5)) * 1.12).toFixed(2)
                }
                else if (isNaN(edit_cost_of_peripherals) && edit_item_category !== "MACHINE") {
                    edit_standard_price.value = ((((edit_tp_php * 1.15) + 0) / (1 - 0.5)) * 1.12).toFixed(2)
                }
            }
            else {
                if (!isNaN(edit_cost_of_peripherals) && edit_item_category == "MACHINE") {
                    edit_standard_price.value = ((((edit_tp_php * 1.3) + edit_cost_of_peripherals) / (1 - 0.3)) * 1.12).toFixed(2)
                }
                else if (isNaN(edit_cost_of_peripherals) && edit_item_category == "MACHINE") {
                    edit_standard_price.value = ((((edit_tp_php * 1.3) + 0) / (1 - 0.3)) * 1.12).toFixed(2)
                }
                else if (!isNaN(edit_cost_of_peripherals) && edit_item_category !== "MACHINE") {
                    edit_standard_price.value = ((((edit_tp_php * 1.3) + edit_cost_of_peripherals) / (1 - 0.5)) * 1.12).toFixed(2)
                }
                else if (isNaN(edit_cost_of_peripherals) && edit_item_category !== "MACHINE") {
                    edit_standard_price.value = ((((edit_tp_php * 1.3) + 0) / (1 - 0.5)) * 1.12).toFixed(2)
                }
            }
        }
    </script>

    <script>
        @if (count($errors) > 0)
            $('#editSourceModal').modal('show');
        @endif
    </script>
@endsection