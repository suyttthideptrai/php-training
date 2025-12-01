<!-- END CONTENT -->
    </div>
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            // Chỉ highlight thẻ có class language-php
            document.querySelectorAll('pre code.language-php').forEach((block) => {
            hljs.highlightElement(block);
            });
        });
    </script>
</body>
</html>