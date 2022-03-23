<div>
    <h3>Edytuj notatkę</h3>
    <div>
        <?php if(!empty($params)): ?>
        <?php $note = $params['note']; ?>
        <form action="/?action=edit"
        method="post">
        <input name='id' type="hidden" value="<?php echo $note['id'] ?>" />
            <ul>
                <li>
                    <label for="title">Tytuł <span class="required">*</span></label>
                    <input type="text" name="title" class="field-long" value="<?php echo $note['title'] ?>" >
                </li>
                <li>
                    <label for="description">Opis</label>
                    <textarea name="description" id="fields" class="field-long field-textarea"><?php echo $note['description'] ?></textarea>
                </li>
                <li>
                    <input type="submit" value="Zapisz">
                    <a href="/">
                        <button>Powrót do lisy notatek</button>
                    </a>
                </li>
            </ul>
            
        </form>
        <?php else: ?>
            <div>
                Nie udało się pobrać danych o notatce
            </div>
            <a href="/">
                <button>Powrót do lisy notatek</button>
            </a>
        <?php endif; ?>
    </div>
</div>