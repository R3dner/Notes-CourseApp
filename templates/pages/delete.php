<div class="show">
    <?php $note = $params['note'] ?? null; 
    if($note): ?>
        <ul>
            <li>ID: <?php echo (int) $note['id']; ?></li>
            <li>Tytuł: <?php echo $note['title']; ?></li>
            <li>Opis: <?php echo $note['description']; ?></li>
            <li>Utworzono: <?php echo $note['created']; ?></li>
        </ul>
        <form action="/?action=delete" method="POST">
            <input name="id" type="hidden" value="<?php echo $note['id'] ?>">
            <button><input type="submit" value="Usuń"></button>
        </form>
    <?php else: ?>
        <div>
            Brak notatki do wyświtlenia
        </div>
    <?php endif; ?>
    <a href="/">
        <button>Powrót do listy notatek</button>
    </a>
</div>