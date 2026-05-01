<?php

if (isset($_SESSION['alert'])):

    $type = $_SESSION['alert']['type'] ?? 'info';
    $title = $_SESSION['alert']['title'] ?? '';
    $text = $_SESSION['alert']['text'] ?? '';
    $redirect = $_SESSION['alert']['redirect'] ?? null;

    unset($_SESSION['alert']); // clear after reading
    ?>

    <script>
        document.addEventListener("DOMContentLoaded", function () {

            Swal.fire({
                icon: "<?= $type ?>",
                title: "<?= $title ?>",
                text: "<?= $text ?>",
                confirmButtonColor: "#bc2823"
            }).then(() => {

                <?php if (!empty($redirect)): ?>
                    window.location.href = "<?= $redirect ?>";
                <?php endif; ?>

            });

        });
    </script>

<?php endif; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>