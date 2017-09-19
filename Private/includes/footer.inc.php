<footer class="footer-style">
    <p class="footer-name">&copy;<?php echo date("Y"); ?> <span>John R. Pepp</span></p>
</footer>
<script src="assets/js/mobile-nav.js"></script>
<script src="assets/js/sticky.js"></script>
<script src="assets/js/slideshow.js"></script>
<script src="assets/js/GoogleAnalytics.js"></script>
<script src="assets/js/privacy.js"></script>
<?php 
    if ($basename === 'blog.php') {
        echo '<script src="assets/js/blog-user-selection.js"></script>';
    }
?>

</body>
</html>

