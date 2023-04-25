<!-- the footer template -->

<footer>
    <div class="container">
        <h4>Back to top</h4>
        <a href="#" class="arrow-top"><img src="../Media/arrow-up-small.svg" alt="go to top button" /></a>
    </div>
</footer>
</body>
<script>
    var typeObject =
    {
        "Car": {
            "Luxury": ["Rolls Royce Phantom", "Bentley Continental Flying Spur", "Mercedes Benz CLS 350", "Jaguar S Type"],
            "Sports": ["Ferrari F430 Scuderia", "Lamborghini Murcielago LP640", "Porsche Boxster", "Lexus SC430"],
            "Classic": ["Jaguar MK 2", "Rolls Royce Silver Spirit Limousine", "MG TD"]
        }
    }

    window.onload = function () {

        var typeSel = document.getElementById("type");
        var modelSel = document.getElementById("model");
        for (var x in typeObject["Car"]) {
            typeSel.options[typeSel.options.length] = new Option(x, x);
        }
        typeSel.onchange = function () {
            //empty Chapters dropdown
            modelSel.length = 1;
            //display correct values
            var z = typeObject["Car"][this.value];
            for (var i = 0; i < z.length; i++) {
                modelSel.options[modelSel.options.length] = new Option(z[i], z[i]);
            }
        }
    }

    // for booking/modify/cancel show and hide
    var booking = document.getElementById("booking-button");
    var modify = document.getElementById("modify-button");
    var cancel = document.getElementById("cancel-button");
    document.getElementById("modify-table").style.display = "none";
    document.getElementById("cancel-table").style.display = "none";

    booking.onclick = function () {
        if (document.getElementById("booking-table").style.display === "none") {
            document.getElementById("booking-table").style.display = "block";
            document.getElementById("modify-table").style.display = "none";
            document.getElementById("cancel-table").style.display = "none";
        }
        else {
            document.getElementById("booking-table").style.display = "none";
        }
    }
    modify.onclick = function () {
        if (document.getElementById("modify-table").style.display === "none") {
            document.getElementById("booking-table").style.display = "none";
            document.getElementById("modify-table").style.display = "block";
            document.getElementById("cancel-table").style.display = "none";
        }
        else {
            document.getElementById("modify-table").style.display = "none";
        }
    }
    cancel.onclick = function () {
        if (document.getElementById("cancel-table").style.display === "none") {
            document.getElementById("booking-table").style.display = "none";
            document.getElementById("modify-table").style.display = "none";
            document.getElementById("cancel-table").style.display = "block";
        }
        else {
            document.getElementById("cancel-table").style.display = "none";
        }
    }

    //modal
    // Get the <span> element that closes the modal
    var close = document.getElementById("close");
    // When the user clicks on <span> (x), close the modal
    close.onclick = function () {
        var error = document.getElementsByClassName("error-modal")[0];
        error.style.display = "none";
    }

</script>
<script>
    // loaderscreen
    $(window).on("load", function () {
        $('html, body').css({ 'overflow': 'hidden', 'height': '100%' });
        setTimeout(() => {
            $(".loaderwrapper").fadeOut("slow");
            $('html, body').css({ 'overflow': 'visible', 'height': '100%' });
        }, 700);
    });
</script>