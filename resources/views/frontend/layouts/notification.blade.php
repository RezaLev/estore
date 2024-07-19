@if(session('success'))
    <div class="alert alert-success alert-dismissable show text-center" id="alertSuccess">
        <button class="close" data-dismiss="alert" aria-label="Close" onclick="closeAlert('alertSuccess')">×</button>
        {{session('success')}}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissable show text-center" id="alertError">
        <button class="close" data-dismiss="alert" aria-label="Close" onclick="closeAlert('alertError')">×</button>
        {{session('error')}}
    </div>
@endif

<script>
    function closeAlert(alertId) {
        $('#' + alertId).alert('close');
    }
</script>
