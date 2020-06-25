@if (session('status'))
{{-- <div class="d-flex justify-content-center pt-4">
    <div class="w-75 text-center alert alert-success">
        {{ session('status') }}
</div>
</div> --}}

<script>
    new Noty({
        type: 'success',
        layout: 'topRight',
        text: "{{ session('status') }}",
        timeout: 3000,
        kill: true
    }).show();
</script>

@endif
