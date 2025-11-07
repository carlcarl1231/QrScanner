
<?php require 'views/components/header.php' ?>
<?php require 'views/components/nav-links.php' ?>
<?php require 'views/components/body_header.php' ?>


<main>
    <div class="mx-auto max-w-7x1 py sm:px6 lg:px-8">
        <p class=''mb-6>
            <a href="/notes" class="text-blue-500 underline">go back</a>
        </p>

        <p><?= htmlspecialchars($note['body']) ?></p>
    </div>
</main>


<?php require 'views/components/footer.php' ?>