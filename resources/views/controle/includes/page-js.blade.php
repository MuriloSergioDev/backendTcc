<!-- ================== BEGIN BASE JS ================== -->
<script src="{{ asset('assets/js/app.min.js') }}"></script>
<script src="{{ asset('assets/js/theme/default.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"
type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-loadingModal@1.0.2/js/jquery.loadingModal.min.js"></script>

@if (Session::has('msg'))
    <script>
        //SWEETALERT 1
        // swal({
        //     title: "{{ Session::get('msg') }}",
        //     icon: "success",
        //     confirmButtonText: 'OK'
        // });

        //SWEETALERT 2
        Swal.fire({
            title: '{{ Session::get('msg') }}',
            icon: 'success',
            confirmButtonText: 'OK'
        })
    </script>
@endif

@if (Session::has('errors'))
    <script>
        let myhtml = document.createElement("div");
        let message = ''
        @foreach ($errors->all() as $error)
            message = message + '{{ $error }}' +"</br>"
        @endforeach
        myhtml.innerHTML = message;
        // swal({
        //     content: myhtml,
        //     title: 'Oops...',
        //     icon: "error",
        // })

        Swal.fire({
            content: myhtml,
            title: 'Oops...',
            icon: "error",
        })
    </script>
@endif

{{-- BRASIL API PARA ENDEREÇO --}}
<script>
    const cep = document.querySelector('.cep');

    if (cep != null) {
        cep.addEventListener('change', (event) => {
            axios.get(`https://brasilapi.com.br/api/cep/v1/${cep.value}`, {
                    headers: {
                        'Content-type': 'application/json'
                    }
                })
                .then(res => {
                    const bairro = document.querySelector('.bairro');
                    const estado = document.querySelector('.estado');
                    const cidade = document.querySelector('.cidade');
                    const logradouro = document.querySelector('.logradouro');

                    bairro.value = res.data.neighborhood
                    estado.value = res.data.state
                    cidade.value = res.data.city
                    logradouro.value = res.data.street
                })
                .catch(err => {
                    console.error(err);
                })
        })
    }

    const cep2 = document.querySelector('.cep2');

    if (cep2 != null) {
        cep2.addEventListener('change', (event) => {
            axios.get(`https://brasilapi.com.br/api/cep/v1/${cep2.value}`, {
                    headers: {
                        'Content-type': 'application/json'
                    }
                })
                .then(res => {
                    const bairro = document.querySelector('.bairro2');
                    const estado = document.querySelector('.estado2');
                    const cidade = document.querySelector('.cidade2');
                    const logradouro = document.querySelector('.logradouro2');

                    bairro.value = res.data.neighborhood
                    estado.value = res.data.state
                    cidade.value = res.data.city
                    logradouro.value = res.data.street
                })
                .catch(err => {
                    console.error(err);
                })
        })
    }

    $(document).ready(function() {
        $('.cpf').mask('000.000.000-00', {
            reverse: true
        });
        $('.celular').mask('(00) 00000-0000');
        $('.cep').mask('00000-000');
        $(".dinheiro").maskMoney({
            thousands: '.',
            decimal: ',',
        }).maskMoney("mask");

        $('.limpar').click(function() {
            var form = $(this).parents('#form-busca');
            $.each(form[0], function(index, val) {
                $(val).val(null)
                $(val).val('').trigger('change')
            })
        })
    });
</script>
<!-- ================== END BASE JS ================== -->

@stack('scripts')
