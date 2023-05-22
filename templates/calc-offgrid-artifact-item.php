<tr>
    <td data-field="artifact">
        <select class="">
            <option value="">Selecciona un artefacto</option>
            <?php
            
            foreach($args['artfcts_demo'] as $ad){
                ?><option value="<?= $ad['id'] ?>"><?= $ad['name'] ?></option>\n<?php
            }
            ?>
            <option value="+">Otro</option>
        </select>
    </td>

    <td  data-field="qty">
        <input type="number">
    </td>

    <td  data-field="power">
        <input type="number">
    </td>

    <td  data-field="hours-by-day">
        <input type="number">
    </td>

    <td data-field="kwh-by-day">
        <span class="calc"></span>
    </td>

    <td data-field="kwh-by-month">
        <span class="calc"></span>
    </td>

    <td data-field="actions">
        <div class="delete"><i aria-hidden="true" class="far fa-trash-alt"></i></div>
    </td>
</tr>