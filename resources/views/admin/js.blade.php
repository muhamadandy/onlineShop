<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css">

<script>
    function confirmation(ev) {
        ev.preventDefault();

        var urlToRedirect = ev.currentTarget.getAttribute("href");

        console.log(urlToRedirect);

        swal({
            title: "Are you sure to delete this?",
            text: "This action is irreversible",
            icon: "warning",
            buttons: true,
            dangerMode: true
        })

        .then((willDelete) => {
            if (willDelete) {
                window.location.href = urlToRedirect;
            }
        });
    }
</script>
