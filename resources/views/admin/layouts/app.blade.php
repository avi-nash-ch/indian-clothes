@include('admin.partial.head')

@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif

<style>
    div.timer {
        border:1px #666666 solid;
        width:190px;
        height:50px;
        line-height:50px;
        font-size:36px;
        font-family:"Courier New", Courier, monospace;
        text-align:center;
        margin:5px;
    }
</style>
<div id="app">
    @include('admin.partial.sidemenu')
    <div id="main">
        <header class="mb-3">
  
        </header>

        @yield('content')

        @include('admin.partial.footer')
        @stack('script-admin')
    </div>
</div>
@include('admin.partial.script')