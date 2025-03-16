@extends('layouts.app', ['title' => 'Dashboard - Admin'])

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-300">
    <div class="container-xxl">
        <!--Card User Data table  -->
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Muzakki Details</h4>
                        </div><!--end col-->
                    </div><!--end row-->
                </div><!--end card-header-->
                <div class="card-body pt-0">
                    <div class="table-responsive table-responsive-sm" id="donatur-table">
                        @include('admin.donatur._data_table')
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div><!-- container -->
</main>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        function loadDonaturs() {
            $.ajax({
                url: "{{ route('admin.donatur.index') }}",
                type: "GET",
                dataType: "html",
                success: function (data) {
                    $("#donatur-table").html($(data).find("#donatur-table").html());
                },
                error: function () {
                    alert("Gagal mengambil data!");
                }
            });
        }

        loadDonaturs();
    });
</script>
@endsection
