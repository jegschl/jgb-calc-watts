<tr role="row">
    <td data-field="artifact" role="cell">
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

    <td  data-field="qty" role="cell">
        <input type="number">
    </td>

    <td  data-field="power" role="cell">
        <input type="number">
    </td>

    <td  data-field="hours-by-day" role="cell">
        <input type="number">
    </td>

    <td data-field="kwh-by-day" role="cell">
        <span class="calc"></span>
    </td>

    <td data-field="kwh-by-month" role="cell">
        <span class="calc"></span>
    </td>

    <td data-field="actions" role="cell">
        <div class="delete"><i aria-hidden="true" class="far fa-trash-alt"></i></div>
    </td>
</tr>