<div class="show">
    <?php $note = $params['note'] ?? null; 
    if($note): ?>
        <ul>
            <li>ID: <?php echo (int) $note['id']; ?></li>
            <li>Tytuł: <?php echo $note['title']; ?></li>
            <li>Opis: <?php echo $note['description']; ?></li>
            <li>Utworzono: <?php echo $note['created']; ?></li>
        </ul>
        <a href="/?action=edit&id=<?php echo $note['id']; ?>">
            <button>Edytuj</button>
        </a>
    <?php else: ?>
        <div>
            Brak notatki do wyświtlenia
        </div>
    <?php endif; ?>
    <a href="/">
        <button>Powrót do listy notatek</button>
    </a>
</div>