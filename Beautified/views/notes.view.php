<?php require 'components/header.php' ?>
<?php require 'components/nav-links.php' ?>
<?php require 'components/body-header.php' ?>

<main>
    <div class="mx-auto max-w-7x1 py6 sm:px-6 lg:px-8">
        <ul>
  <?php foreach ($notes as $note) : ?>
            <li>
                <a href="/note?id= <?= $note['ID'] ?>" class="text-blue-500 hover:underline">
                    <?= htmlspecialchars($note['body']) ?>
                </a>
            </li>
            <?php endforeach; ?>

            <p class="mt-6">
                <a href="notes/create" class="text-blue-500 hover:underline">Create Note</a>
            </p>
        </ul>
          </div>
</main>
<?php require 'components/footer.php' ?>