<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

<script src="{{ asset('assets/js/bundle.js') }}"></script>
<script src="{{ asset('assets/js/form.js') }}"></script>
<script src="{{ asset('assets/js/datepicker.js') }}"></script>
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

<script>
    $(document).on('click', '.modalbttn', function () {
        $(".modalcontainer").fadeIn("slow");
        $(".modal").fadeIn("slow");
    });

    $(document).on('click', '.close', function () {
        $(".modalcontainer").fadeOut("slow");
        $(".modal").fadeOut("slow");
    });

    $(document).on('click', '.buttons', function () {
        $(".modalcontainer").fadeOut("slow");
        $(".modal").fadeOut("slow");
    });
</script>

@stack('scripts')