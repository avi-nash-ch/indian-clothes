@extends('admin.layouts.master')

@section('content')
<div class="content-wrapper" style="min-height: 1345.31px;">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-7">
                    <h1>Setting</h1>
                </div>
                <div class="col-sm-5">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i
                                    class="nav-icon fa fa-dashboard"></i> &nbsp;&nbsp;Home</a></li>
                        <li class="breadcrumb-item active">Setting</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-12">

                    <div class="card card-primary card-outline">
                        <form action={{route('setting.update', $setting->id)}} method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="password-vertical">Contact Us </label>
                                            <textarea name="contact_us" id="contact_us"
                                                class="form-control">{{ $setting->contact_us }}</textarea>
                                            @error('contact_us')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <label for="password-vertical">Terms And Condition</label>
                                            <textarea name="terms_and_condition" id="terms_and_condition"
                                                class="form-control">{{ $setting->terms_and_condition }}</textarea>
                                            @error('terms_and_condition')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <label for="password-vertical">Refund</label>
                                            <textarea name="refund" id="refund"
                                                class="form-control">{{ $setting->refund }}</textarea>
                                            @error('refund')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <label for="password-vertical">Cancellation</label>
                                            <textarea name="cancellation" id="cancellation"
                                                class="form-control">{{ $setting->cancellation }}</textarea>
                                            @error('cancellation')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <label for="password-vertical">Privacy Policy</label>
                                            <textarea name="privacy_policy" id="privacy_policy"
                                                class="form-control">{{ $setting->privacy_policy }}</textarea>
                                            @error('privacy_policy')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <label for="password-vertical">Delivery Note </label>
                                            <textarea name="delivery_note" id="delivery_note"
                                                class="form-control">{{ $setting->delivery_note }}</textarea>
                                            @error('delivery_note')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <label for="password-vertical">Address </label>
                                            <textarea name="address" id="address"
                                                class="form-control">{{ $setting->address }}</textarea>
                                            @error('address')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>



                                        <div class="col-md-6 mt-3">
                                            <label for="amount">Minimum Amount (INR)<span
                                                    class="text-danger">*</span></label>
                                            <input type="number" class="form-control" id="amount" name="amount" required
                                                value="{{ old('amount', $setting->amount) }}"
                                                placeholder="Enter Minimum Amount">
                                            @error('amount')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mt-3">
                                            <label for="delivery_charge">Delivery Charge (INR) <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" class="form-control" id="delivery_charge"
                                                name="delivery_charge" required
                                                value="{{ old('delivery_charge', $setting->delivery_charge) }}"
                                                placeholder="Enter Delivery Charge">
                                            @error('delivery_charge')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mt-3">
                                            <label for="start_time">Delivery Start Time</label>
                                            <input type="time" class="form-control" id="start_time" name="start_time"
                                                value="{{ old('start_time', $setting->start_time) }}"
                                                placeholder="Enter Delivery Start Time">
                                            @error('start_time')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mt-3">
                                            <label for="end_time">Delivery End Time</label>
                                            <input type="time" class="form-control" id="end_time" name="end_time"
                                                value="{{ old('end_time', $setting->end_time) }}"
                                                placeholder="Enter Delivery End Time">
                                            @error('end_time')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>


                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{route('admin.dashboard')}}" class="btn btn-primary">Return</a>

                            </div>
                        </form>
                    </div>

                </div>
            </div>

        </div>
    </section>

</div>
@endsection

@section('scripts')
<!-- <script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
<script>
document.querySelectorAll(
    '#contact_us, #terms_and_condition, #delivery_note, #address, #refund, #cancellation, #privacy_policy').forEach(
    function(element) {
        ClassicEditor
            .create(element)
            .catch(function(error) {
                console.error(error);
            });
    });
</script> -->
<script src="https://cdn.ckeditor.com/ckeditor5/34.0.0/classic/ckeditor.js"></script>
<script>
   document.querySelectorAll(
    '#contact_us, #terms_and_condition, #delivery_note, #address, #refund, #cancellation, #privacy_policy').forEach(
    function(element) {
        ClassicEditor
            .create(element, {
                ckfinder: {
                    uploadUrl: "{{ route('ckeditor.upload').'?_token='.csrf_token() }}"
                }
            })
            .catch(function(error) {
                console.error(error);
            });
    });

</script>
@stop