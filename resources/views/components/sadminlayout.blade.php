<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="">
    {{-- <link rel="manifest" href="manifest.webmanifest"> --}}
    <link rel="icon" href="{{ asset('images/favicon.ico') }}">
    <title>{{ $title }}</title>
    <!-- Vendors Style-->
    <link rel="stylesheet" href="{{ asset('assets/custom/css/vendors_css.css') }}">
    <!-- Style-->
    <link rel="stylesheet" href="{{ asset('assets/custom/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/custom/css/skin_color.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor_plugins/loading_modal/jquery.loadingModal.min.css') }}">
    {{ isset($css) ? $css : '' }}
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary">
    <div class="wrapper">
        <div id="loader"></div>
        @include('sadmininclude.header')
        {{ $content }}
        <!-- /.content-wrapper -->
        @include('sadmininclude.footer')
    </div>
    <!-- ./wrapper -->
    <!-- Vendor JS -->
    <script src="{{ asset('assets/custom/js/vendors.min.js') }}"></script>
    <script src="{{ asset('assets/custom/js/pages/chat-popup.js') }}"></script>
    <script src="{{ asset('assets/icons/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/vendor_components/select2/dist/js/select2.full.js') }}"></script>
    <script src="{{ asset('assets/vendor_components/jquery-toast-plugin-master/src/jquery.toast.js') }}"></script>
    <script src="{{ asset('assets/vendor_components/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('assets/vendor_components/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/vendor_components/bootstrap-touchspin/dist/bootstrap-input-spinner.js') }}"></script>
    <script src="{{ asset('assets/vendor_plugins/loading_modal/jquery.loadingModal.min.js') }}"></script>
    <!-- Joblly App -->
    <script src="{{ asset('assets/custom/js/template.min.js') }}"></script>
    <script src="{{ asset('assets/vendor_components/sweetalert/sweetalert.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/vendor_components/apexcharts-bundle/dist/apexcharts.js') }}"></script> --}}
    <script src="{{ asset('assets/vendor_components/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('assets/vendor_components/fullcalendar/fullcalendar.js') }}"></script>
    {{-- <script src="{{ asset('assets/custom/js/pages/dashboard.js') }}"></script>    --}}
    <script src="{{ asset('assets/custom/js/pages/calendar-dash.js') }}"></script>
    <script>
        $('.select2').select2();
        $(".create_date").flatpickr({
            mode: 'range',
            locale: 'en',
            dateFormat: "m/d/Y",
        });

        $(".create_date_single").flatpickr({
            locale: 'en',
            dateFormat: "m/d/Y",
        });
    </script>
    <!-- mian js -->
    <script src="{{ asset('assets/custom/js/main.softnicrms.min.js') }}"></script>
    <script>
        function showLoader(text_data) {
            $('body').loadingModal({
                text: text_data
            });
            $('body').loadingModal('animation', 'doubleBounce');
        }

        function hideLoader() {
            $('body').loadingModal('hide');
            $('body').loadingModal('destroy');
        }

        function updateBarcodeModal() {
            $.post('action/action.user.php', {
                updateBarcodeModalData: ''
            }, function(res) {
                var dataObj = $.parseJSON(res);

                if (dataObj.status == 'success') {
                    $('#allPrintBarcodeHolder').html(dataObj.htmls);
                }

            });
        }
    </script>
    
    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker
                .register("{{ asset('assets/custom/sw.js') }}")
                .then(() => {
                    console.log('Service Worker Registered');
                });
        }

        let deferredPrompt;
        // const addBtn = document.querySelector('.add-button');
        // addBtn.style.display = 'none';

        window.addEventListener('beforeinstallprompt', (e) => {
            // Prevent Chrome 67 and earlier from automatically showing the prompt
            e.preventDefault();
            // Stash the event so it can be triggered later.
            deferredPrompt = e;
            // Update UI to notify the user they can add to home screen
            addBtn.style.display = 'block';

            addBtn.addEventListener('click', () => {
                // hide our user interface that shows our A2HS button
                addBtn.style.display = 'none';
                // Show the prompt
                deferredPrompt.prompt();
                // Wait for the user to respond to the prompt
                deferredPrompt.userChoice.then((choiceResult) => {
                    if (choiceResult.outcome === 'accepted') {
                        console.log('User accepted the A2HS prompt');
                    } else {
                        console.log('User dismissed the A2HS prompt');
                    }
                    deferredPrompt = null;
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            add_new_banner = function() {
                $("#add_new_banner").toggle();
            }
        });
    </script>
    {{ isset($javascript) ? $javascript : '' }}
</body>

</html>
