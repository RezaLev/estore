@if(session('success'))
        <div class="alert alert-success alert-dismissible fade show text-center" id="alertSuccess">
            <button type="button" class="close" aria-label="Close" onclick="closeAlert('alertSuccess')">
                <span aria-hidden="true">&times;</span>
            </button>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show text-center" id="alertError">
            <button type="button" class="close" aria-label="Close" onclick="closeAlert('alertError')">
                <span aria-hidden="true">&times;</span>
            </button>
            {{ session('error') }}
        </div>
    @endif
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
        function closeAlert(alertId) {
        var element = document.getElementById(alertId);
        element.style.display = 'none';
    }
</script>