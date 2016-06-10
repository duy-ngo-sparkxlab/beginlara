@include('admin.partials.header')
<div class="wrapper">
    @include('admin.partials.topbar')
    @include('admin.partials.sidebar')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{ preg_replace('/([a-z0-9])?([A-Z])/','$1 $2',str_replace('Controller','',explode("@",class_basename(app('request')->route()->getAction()['controller']))[0])) }}
                <small>Optional description</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
                <li class="active">Here</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            @if (Session::has('message'))
                    <div class="callout callout-success">
                        <h4>Successfully!</h4>
                        <p>{{ Session::get('message') }}</p>
                    </div>
            @endif

            @yield('content')
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    {{-- footer --}}
    @include('admin.partials.footer')
</div>
@include('admin.partials.javascripts')

@yield('javascript')
</body>
</html>


