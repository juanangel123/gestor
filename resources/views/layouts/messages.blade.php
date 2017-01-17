<div class="row">
    <div class="col-md-12">
        <div class="messages">
            <!-- Error messages -->
            @if ($errors->any())
                <div class="message alert alert-danger">{{ $errors->first() }}</div>
            @endif
        </div>
    </div>
</div>