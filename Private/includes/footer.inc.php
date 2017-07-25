<footer class="footer-style">
    <p class="footer-name">&copy;<?php echo date("Y"); ?> <span>John R. Pepp</span></p>
</footer>
<script>
    var slides = document.querySelectorAll('#slides .slide');
    var currentSlide = 0;
    var slideInterval = setInterval(nextSlide, 3000);

    function nextSlide() {
        slides[currentSlide].className = 'slide';
        currentSlide = (currentSlide + 1) % slides.length;
        slides[currentSlide].className = 'slide showing';
    }
</script>
<script>
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-102592896-1', 'auto');
    ga('send', 'pageview');

</script>
<script>
    var yesCheck = document.getElementById("yesCheck");
    var noCheck = document.getElementById("noCheck");

    yesCheck.addEventListener('click', function () {
        document.getElementById('imgBtn').style.display = "block";
    });

    noCheck.addEventListener('click', function () {
        document.getElementById('imgBtn').style.display = "none";
    });

</script>
</body>
</html>

