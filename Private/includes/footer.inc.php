<footer class="footer-style">
    <p class="footer-name">&copy;<?php echo date("Y"); ?> <span>John R. Pepp</span></p>
</footer>
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

