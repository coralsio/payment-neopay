<progress value="0" max="200" id="progressBar">

</progress>

<script type="text/javascript" src="https://psd2.neopay.lt/widget.js"></script>

<script>
    function paymentInitiation() {
        var NEOWidgetHost = "https://psd2.neopay.lt";
        var data = {
            token: "{{ $jwtToken }}",
        }

        NEOWidget.initialize(
            NEOWidgetHost,
            data.token,
            {!! json_encode($initializationObject) !!}
        );
    }

    window.onload = function () {
        let timeLeft = 200;

        let redirectTimer = setInterval(function () {
            if (timeLeft <= 0) {
                clearInterval(redirectTimer);
            }

            document.getElementById("progressBar").value = 200 - timeLeft;

            timeLeft -= 1;
        }, 10);


        setTimeout(paymentInitiation, 2000);
    }
</script>
