
<script src="{{ asset('AdminLTE/plugins/form-error-message/form-error-message.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        Pace.restart();
    });

    $.datetimepicker.setLocale('pt-BR');

    var urlBase = '{{ url('') }}/';
    var _token = '{{csrf_token()}}';
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // para adicionar a classe active para o sideNav
    var url = document.location.toString();
    var urlorigin = window.location.origin;
    if( url === urlorigin + "/"){
        $('ul li a[href="' + urlorigin + '"]').parent().addClass('active');
    }
    else{
        $('ul li a[href="' + url + '"]').parent().addClass('active');
        $('ul a').filter(function () {
            return this.href == url;
        }).parent().addClass('active').parent().parent().addClass('active');
    }
</script>
<script type="text/javascript" src="{{ asset('js/filtro-avancado.js') }}"></script>
