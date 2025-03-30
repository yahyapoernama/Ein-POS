<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.layouts.meta')

    @include('admin.layouts.styles')
</head>

<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->
    <!-- [ Sidebar Menu ] start -->
    @include('admin.layouts.sidebar')
    <!-- [ Sidebar Menu ] end -->
    <!-- [ Header Topbar ] start -->
    @include('admin.layouts.header')
    <!-- [ Header ] end -->

    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pc-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12 px-3 d-flex align-items-start justify-content-between ">
                            @if (isset($headerTitle))
                                <div class="page-header-title">
                                    <h1 class="m-b-10">{{ $headerTitle }}</h1>
                                </div>
                            @endif
                            @if (isset($breadcrumbs) && count($breadcrumbs) > 0)
                                <ul class="breadcrumb">
                                    @foreach ($breadcrumbs as $breadcrumb)
                                        @if ($breadcrumb['url'])
                                            <li class="breadcrumb-item"><a
                                                    href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['name'] }}</a></li>
                                        @else
                                            <li class="breadcrumb-item" aria-current="page">{{ $breadcrumb['name'] }}
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        @if (isset($headerSubtitle))
                            <div class="col-md-12 px-3">
                                <p>
                                    {{ $headerSubtitle }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            @yield('content')
            <!-- [ Main Content ] end -->
        </div>
    </div>
    @include('admin.layouts.footer')

    @include('admin.layouts.scripts')
</body>
<!-- [Body] end -->

</html>
