@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <h5>Versículo do Dia</h5>
                    <div id="versiculo"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('https://bible-api.com/john 3:16')
            .then(response => response.json())
            .then(data => {
                document.getElementById('versiculo').innerText = data.text;
            })
            .catch(error => console.error('Erro ao buscar o versículo:', error));

        // Sessão de logout automático
        let sessionTimeout;
        function resetSessionTimeout() {
            clearTimeout(sessionTimeout);
            sessionTimeout = setTimeout(() => {
                alert('Sessão expirada. Você será deslogado.');
                window.location.href = '{{ route('logout') }}';
            }, 15 * 60 * 1000); // 15 minutos
        }

        document.addEventListener('mousemove', resetSessionTimeout);
        document.addEventListener('keypress', resetSessionTimeout);

        resetSessionTimeout();
    });
</script>
@endpush
@endsection
