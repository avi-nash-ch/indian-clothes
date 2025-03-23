@extends('front.layouts.app')

@section('content')
    {{-- <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>

    <!------ Include the above in your HEAD tag ---------->

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css"> --}}


    <div class="container">
        <br><br>
        <div class="row">
            <div class="col-sm-6 reg-6-pd-r">
                <img src="{{ asset('images/regimg.png') }}" style="height: 600px;position:relative;" class="img-fluid">
                <h1 class="reg-welcome">WELCOME</h1>
                <p class="text-center reg-p">Oji Product Management</p>
            </div>


            <div class="col-sm-6 reg-6-pd-l">
                <div class="card bg-light">
                    <article class="card-body">
                        <h2 class=" text-center text-danger ">Create Account</h2>
                        <p class="text-center ">Get started with your free account</p>

                        <!-- Start form here -->

                        <form method="POST" class="reg-input" action="{{ route('register') }}">
                            @csrf
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text reg-icon"> <i class="fa fa-user"></i> </span>
                                </div>
                                <input name="name" class="form-control reg-input" id="name" placeholder="Enter Name"
                                    type="text" required="">
                            </div> <!-- form-group// -->

                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text reg-icon"> <i class="fa fa-phone"></i> </span>
                                </div>
                                <input name="mobile_no" class="form-control reg-input" id="phoneNumber"
                                    placeholder="Mobile number" type="text" required="">
                            </div> <!-- form-group// -->
                            <div id="moble_result"></div>

                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text reg-icon"> <i class="fa fa-envelope"></i> </span>
                                </div>
                                <input name="email_id" class="form-control reg-input" id="email"
                                    placeholder="Email address" type="email" required=""
                                    style=" background-color: #fff !important;">
                            </div> <!-- form-group// -->
                            <div id="email_result"></div>

                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text reg-icon"> <i class="fa fa-lock"></i> </span>
                                </div>
                                <input class="form-control reg-input" name="password" id="password"
                                    placeholder="Create password" type="password" required="">
                            </div><!-- form-group// -->

                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text reg-icon"> <i class="fas fa-edit"
                                            style="color: #c9cbcd;"></i> </span>
                                </div>
                                <input name="address" class="form-control reg-input" id="address"
                                    placeholder="Enter Address" type="text" required="">
                            </div> <!-- form-group// -->

                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text reg-icon"> <i class="fa fa-building"></i> </span>
                                </div>
                                <select class="form-control reg-input" name="role" id="user_type" required="">
                                    <option value="4" selected="">Shoper</option>
                                    <option value="1">Factory</option>
                                    <option value="3">Distributor</option>
                                    <option value="5">Company</option>
                                    <option value="2">Salesman</option>
                                </select>
                            </div> <!-- form-group end.// -->

                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text reg-icon"> <i class="far fa-sticky-note"
                                            style="color: #c9cbcd;"></i> </span>
                                </div>
                                <input name="description" class="form-control reg-input" id="description"
                                    placeholder="Description" type="text" required="">
                            </div> <!-- form-group// -->

                            <div class="form-group">
                                <button type="submit" id="Submit" class="btn btn-primary btn-block"> Create Account
                                </button>
                            </div> <!-- form-group// -->
                            <p class="text-center">Have an account? <a href="{{ route('login') }}">Log In</a> </p>
                        </form>

                        <!-- End form here -->
                    </article>
                </div> <!-- card.// -->
            </div>
        </div>




        <!-- style="background-image:url(https://www.hamarabanda.com/ojiproductmanagement/dist/img/ojiBg.jpg);background-size: cover; background-repeat:no-repeat; background-position:center center ;" -->



    </div>
    <!--container end.//-->

    <br><br>

@endsection


@section('scripts')
    <script>
        $('#phoneNumber').inputmask("9999999999");
    </script>
    <script>
        $(document).ready(function() {
            $('#email').keyup(function() {
                var email = $('#email').val();
                if (email != '') {
                    $.ajax({
                        url: "{{route('checkEmail')}}",
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            email: email
                        },
                        success: function(data) {
                            $('#email_result').html(data);
                        }
                    });
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#phoneNumber').keyup(function() {
                var mobile = $('#phoneNumber').val();
                console.log(mobile)
                if (mobile != '') {
                    $.ajax({
                        url: "{{ route('checkMobileNumber') }}",
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            mobile: mobile
                        },
                        success: function(data) {
                            $('#moble_result').html(data);
                        }

                    });
                }
            });
        });
    </script>

    <script>
        $("#Submit").click(function() {

            var name = $('#name').val();
            var mobile = $('#phoneNumber').val();
            var email = $('#email').val()
            var password = $('#password').val();
            var address = $('#address').val();
            var user_type = $('#user_type').val();
            var description = $('#description').val();

            if (name != "" || mobile != "" || email != "" || password != "" || address != "" || user_type != "" ||
                description != "") {
                swal({
                    title: "Good job!",
                    text: "You clicked the button!",
                    icon: "success",
                    button: "Successfully Register",
                });
            }
        });
    </script>
@stop

<!-- script for check email is exit via ajax -->
