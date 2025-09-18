<footer>
    <p class="footer-item">Aristotle University of Thessaloniki</p>
    <ol class="footer-item">
        <li>Stamoglou Evangelia</li>
        <li>3591</li>
    </ol>
</footer>

<script>
    function toggleMenu() {
        document.querySelector('.sidebar').classList.toggle('active');
    }

    function scrollToTop() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    window.addEventListener('load', () => {
        document.querySelector('.loading').style.display = 'none';
    });

    window.addEventListener('scroll', () => {
        const backToTopButton = document.querySelector('.back-to-top');
        if (window.scrollY > 10) {
            backToTopButton.classList.add('show');
        } else {
            backToTopButton.classList.remove('show');
        }
    });

    window.addEventListener('load', () => {
        document.querySelector('.loading').style.display = 'none';
    });

</script>
</body>
</html>