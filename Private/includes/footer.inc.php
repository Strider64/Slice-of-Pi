<footer class="footer-style">
    <p class="footer-name">&copy;<?php echo date("Y"); ?> <span>John R. Pepp</span></p>
</footer>
<script>
    var myButton = document.getElementById('slider');
    var mobileHeader = document.getElementById('mobile-header');
    console.log(myButton);

    myButton.addEventListener("click", function (event) {
        console.log(this.style.left);
        if (this.style.left === '0px') {
            this.style.left = '-200px';
            //mobileHeader.style.left = '30px';
        } else {
            this.style.left = "0px";
            //mobileHeader.style.left = '230px';
        }

    });
</script>
<script src="assets/js/sticky.js"></script>
<script src="assets/js/slideshow.js"></script>
<script src="assets/js/GoogleAnalytics.js"></script>
<script src="assets/js/privacy.js"></script>
</body>
</html>

