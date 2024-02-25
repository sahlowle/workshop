<!-- BEGIN: Theme CSS-->
<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="{{ asset(mix('assets/vendor/fonts/boxicons.css')) }}" />

<!-- Core CSS -->
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/css/core.css')) }}" />
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/css/theme-default.css')) }}" />
<link rel="stylesheet" href="{{ asset(mix('assets/css/demo.css')) }}" />

<link rel="stylesheet" href="{{ asset(mix('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')) }}" />

{{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"> --}}

{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css"> --}}

{{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css"> --}}


<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@notifyCss


<!-- Vendor Styles -->
@yield('vendor-style')


<!-- Page Styles -->
@yield('page-style')


<style>
    .notify {
        z-index: 9999;
    }

    .form-check-input{
        width: 1.60rem;
        height: 1.60rem;
    }

    .dt-buttons{
        background-color: #697a8d;
    }

    .btn-show{
        color: #0d6efd;
        border-color: #0d6efd;
    }

    .btn-show:hover {
        background-color: #0d6efd;
        color: white;
    }

    .xdsoft_datetimepicker .xdsoft_timepicker {
      width: 10rem !important;
      font-size: 20rem !important;
    }
  
    .xdsoft_datetimepicker .xdsoft_timepicker .xdsoft_time_box >div >div{
      font-size: 22px !important;
    }

    .no-data {
        background-color: rgb(241, 239, 239);
        text-align: center; display: table-row;
    }

    .nav-align-top > .tab-content, .nav-align-right > .tab-content, .nav-align-bottom > .tab-content, .nav-align-left > .tab-content{
        background-color: unset;
    }

    .nav-pills .nav-link.active, .nav-pills .nav-link.active:hover, .nav-pills .nav-link.active:focus {
        background-color: unset;
        color: var(--themeColor);
        border-bottom: 5px solid;
        border-radius: unset;
        box-shadow: unset;
    }

    .btn-outline-danger:focus{
        color: #ff3e1d;
    border-color: #ff3e1d;
    background: transparent;
    }

    input[type='number'] {
    -moz-appearance:textfield;
}

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
}

</style>


