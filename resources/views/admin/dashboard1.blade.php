@extends('admin.layouts.app')

@section('content')
@push('head')
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">

<link rel="stylesheet" href="{{ asset('admin/assets/vendors/simple-datatables/style.css') }}">
<link rel="stylesheet" href="{{ asset('admin/assets/vendors/fontawesome/all.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/primeng/9.0.6/resources/components/toast/toast.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer">
    
< link rel = "stylesheet" href = "https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"integrity = "sha384-Gn5384xqQ1aoWXA+<script src=https: //code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
</script>
<link rel="stylesheet" href="{{ asset('css/card.css') }}">
@endpush

{{-- Alerts --}}
@if (session('success'))
<div class="alert alert-{{ session('class') ?: 'danger' }}">
    {{ session('message') }}
</div>
@endif
@if (session('danger'))
<div class="alert alert-{{ session('class') ?: 'danger' }}">
    {{ session('message') }}
</div>

@endif
<div class="page-heading">
    <h3> Dashboard</h3>
    <p>Welcome To Oji Product Management</p>
</div>


@push('script')

<script src="{{ asset('admin/assets/vendors/simple-datatables/simple-datatables.js') }}"></script>

<script src="{{ asset('admin/assets/vendors/fontawesome/all.min.js') }}"></script>



@endpush
@endsection