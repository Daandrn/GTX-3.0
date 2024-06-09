@if ($errors->any())
    @foreach ($errors->all() as $error => $message)
        <script>
            alert('{{ $message }}');
        </script>
    @endforeach
@endif