<div>
    <h3>Nowa notatka</h3>
    <div>
        <form action="/?action=create"
        method="post">
            <ul>
                <li>
                    <label for="title">Tytuł <span class="required">*</span></label>
                    <input type="text" name="title" class="field-long">
                </li>
                <li>
                    <label for="description">Opis</label>
                    <textarea name="description" id="fields" class="field-long field-textarea"></textarea>
                </li>
                <li>
                    <input type="submit" value="Dodaj">
                </li>
            </ul>
        </form>
    </div>
</div>