@if(session('success'))
    <div class="alert alert--success">
        <div class="alert__message">{{ session('success') }}</div>
    </div>
@endif

@if(session('error'))
    <div class="alert alert--error">
        <div class="alert__message">{{ session('error') }}</div>
    </div>
@endif
