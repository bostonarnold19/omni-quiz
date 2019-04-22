@extends('layouts.dashmix')
@section('content')
<div class="content">
    <br>
    <br>
    <div class="block block-rounded block-bordered">
        <div class="block-header block-header-default">
            <h1>Import</h1>
        </div>
        <div class="block-content block-content-full">

            <form id="save-form" method="POST" action="{{ route('import') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-sm-12">
                        <label>Type</label>
                        <select name="type" class="form-control">
                            <option>Student</option>
                            <option>Questions</option>
                        </select>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-sm-12">
                        <label>CSV File</label><br>
                        <input type="file" name="csv_file"  class="form-control" accept=".csv" required>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-sm-12">
                        <button type="submit" class="btn">Begin Import!</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
@section('styles')
<link rel="stylesheet" href="{{ asset('themes/dashmix/assets/js/plugins/datatables/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" href="{{ asset('themes/dashmix/assets/js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css') }}">
@endsection
@section('scripts')
<script src="{{ asset('themes/dashmix/assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('themes/dashmix/assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script >

</script>
@endsection
