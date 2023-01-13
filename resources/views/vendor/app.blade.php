<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title') - {{ config('app.name') }}</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/main.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/font-awesome/4.7.0/css/font-awesome.min.css') }}"/>
    @yield('styles')
    @stack('styles')
</head>
<body class="app sidebar-mini rtl">
    @include('vendor.partials.header')
    @include('vendor.partials.sidebar')
    <main class="app-content" id="app">
        @yield('content')
    </main>
    <script src="{{ asset('backend/js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('backend/js/popper.min.js') }}"></script>
    <script src="{{ asset('backend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('backend/js/main.js') }}"></script>
    <script src="{{ asset('backend/js/plugins/pace.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.9.5/tinymce.min.js"></script>
      <!--These jQuery libraries for select2 
            need to be included-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"> </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" />

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDulS02jGKU5aYmmR_GbGuyTggLrtdAwu0&v=3.exp&sensor=false&libraries=places"></script>
                   
    <script>
        tinymce.init({
            selector: "textarea:not(.detail_ad)",
            paste_data_images: true,
            height : "250",
            plugins: [
              "advlist autolink lists link image charmap print preview hr anchor pagebreak",
              "searchreplace wordcount visualblocks visualchars code fullscreen",
              "insertdatetime media nonbreaking save table contextmenu directionality",
              "emoticons template paste textcolor colorpicker textpattern"
            ],
            toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
            toolbar2: "print preview media | forecolor backcolor emoticons",
            image_advtab: true,
            file_picker_callback: function(callback, value, meta) {
              if (meta.filetype == 'image') {
                $('#upload').trigger('click');
                $('#upload').on('change', function() {
                  var file = this.files[0];
                  var reader = new FileReader();
                  reader.onload = function(e) {
                    callback(e.target.result, {
                      alt: ''
                    });
                  };
                  reader.readAsDataURL(file);
                });
              }
            },
          });
    </script>
    <script type="text/javascript">
        jQuery( "#page_type" ).on('change',function() {
          if(this.value == 'Categories'){
            $('#category_type select').removeAttr('disabled');
            $('#category_type').show();
            $('#country select').attr('disabled', 'disabled');
            $('#country').hide();
          }else if(this.value == 'Location'){
            $('#country select').removeAttr('disabled');
            $('#country').show();
            $('#category_type select').attr('disabled', 'disabled');
            $('#category_type').hide();
          }
          else{
            $('#category_type select').attr('disabled', 'disabled');
            $('#category_type').hide();
            $('#country select').attr('disabled', 'disabled');
            $('#country').hide();
          }
        });
    </script>
     <script type="text/javascript">
      $(document).ready(function() {
          $('.categorySelect').select2();
       });
  </script>
     <script type="text/javascript">
        function initialize() {
          var input = document.getElementById('searchTextField');
          var autocomplete = new google.maps.places.Autocomplete(input);
            google.maps.event.addListener(autocomplete, 'place_changed', function () {
                var place = autocomplete.getPlace();
                document.getElementById('lat').value = place.geometry.location.lat();
                document.getElementById('long').value = place.geometry.location.lng();
            });
        }
        google.maps.event.addDomListener(window, 'load', initialize);
    </script>
    @stack('scripts')
</body>
</html>