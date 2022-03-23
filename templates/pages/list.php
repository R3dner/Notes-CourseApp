<div>
    <section>
    <div class="error">
        <?php if(!empty($params['error'])): ?>
            <?php
                switch($params['error']){
                    case 'noteNotFound':
                        echo 'Nie znaleziono notatki';
                        break;
                    case 'missingNoteId':
                        echo "Brak identyfikatora notatki";
                }
            ?>
        <?php endif; ?>
    </div>
    <div class="message">
        <?php if(!empty($params['before'])): ?>
            <?php
                switch($params['before']){
                    case 'created':
                        echo 'Notatka została utworzona';
                        break;
                    case 'edited':
                        echo 'Notatka została edytowana';
                        break;
                    case 'deleted':
                        echo 'Notatka została usunięta';
                        break;
                }
            ?>
        <?php endif; ?>
    </div>

    <?php
        $sort = $params['sort'] ?? [];
        $by = $sort['by'] ?? 'title';
        $order = $sort['order'] ?? 'asc';

        $page = $params['page'] ?? [];
        $size = $page['size'] ?? 10;
        $currentPage = $page['number'] ?? 1;
        $pages = $page['pages'] ?? 1;

        $phrase = $params['phrase'] ?? null;
        
    ?>

    <div>
        <form class="settings-form" action="/" method="GET">
            <div>
                <label for="phrase">Wyszukaj: <input type="text" name="phrase"
                value="<?php echo $phrase?>"></label>
            </div>
            <div>   
                <div>Sortuj po:</div>
                <label>tytule: <input name="sortby" type="radio" value="title" <?php echo $by === 'title' ? 'checked' : '' ?>></label>
                <label>dacie: <input name="sortby" type="radio" value="date" <?php echo $by === 'created' ? 'checked' : '' ?>></label>
            </div>
            <div>
                <div>Kierunek sortowania:</div>
                <label>rosnąco: <input name="orderby" type="radio" value="asc" <?php echo $order === 'asc' ? 'checked' : '' ?>></label>
                <label>malejąco: <input name="orderby" type="radio" value="desc" <?php echo $order === 'desc' ? 'checked' : '' ?>></label>
            </div>
            <div>
                <div>Liczba wyświetlanych notatek</div>
                <label>1 <input type="radio" name="pagesize" value="1" <?php echo $size === 1 ? 'checked' : '' ?>></label>
                <label>5 <input type="radio" name="pagesize" value="5" <?php echo $size === 5 ? 'checked' : '' ?>></label>
                <label>10 <input type="radio" name="pagesize" value="10" <?php echo $size === 10 ? 'checked' : '' ?>></label>
                <label>15 <input type="radio" name="pagesize" value="15" <?php echo $size === 15 ? 'checked' : '' ?>></label>
                <label>25 <input type="radio" name="pagesize" value="25" <?php echo $size === 25 ? 'checked' : '' ?>></label>
            </div>
            <input type="submit" value="Wyślij">
        </form>
    </div>

    <div class="tbl-header">
        <table cellpadding="0" cellspacing="0" border="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tytuł</th>
                    <th>Data</th>
                    <th>Opcje</th>
                </tr>
            </thead>
        </table>
    </div>
    <div>
        <table cellpadding="0" cellspacing="0" border="0">
            <tbody>
                <?php foreach ($params['notes'] ?? [] as $note): ?>
                <tr>
                    <td><?php echo (int) $note['id']; ?></td>
                    <td><?php echo $note['title']; ?></td>
                    <td><?php echo $note['created']; ?></td>
                    <td>
                        <a href="/?action=show&id=<?php echo (int) $note['id']; ?>">
                            <button>Wyświetl</button>
                        </a>
                        <a href="/?action=delete&id=<?php echo (int) $note['id']; ?>">
                            <button>Usuń</button>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php
        $paginationUrl = "&phrase=$phrase&pagesize=$size&sortby=$by&orderby=$order";
    ?>

    <ul class="pagination">
        <?php if($currentPage > 1): ?>
        <li>
            <a href="/?page=<?php echo $currentPage - 1 . $paginationUrl; ?>">
                <button><<</button>
            </a>
        </li>
        <?php endif; ?>
        <?php for($i = 1; $i <= $pages; $i++): ?>
            <li>
                <a href="/?page=<?php echo $i . $paginationUrl;?>">
                    <button><?php echo $i; ?></button>
                </a>
            </li>
        <?php endfor; ?>
        <?php if($currentPage < $pages): ?>
        <li>
            <a href="/?page=<?php echo $currentPage + 1 . $paginationUrl; ?>">
                <button>>></button>
            </a>
        </li>
        <?php endif; ?>
    </ul>
    </section>
</div>