<?php

?>

<?php do_action('rayssa_load_template_processing_template'); ?>

<?php do_action('rayssa_load_template_calc_tab'); ?>

<div 
        id="<?= esc_attr($args['id']); ?>" 
        class="rayssa-calc-ongrid" 
        data-title="<?php echo esc_attr($args['title']); ?>" 
        data-category="<?php echo esc_attr($args['category']); ?>"
>
    
  <table class="items">
    <thead>
      <tr>
        <th>Potencia del panel</th>
        <th>Cantidad de paneles</th>
        <th>Región</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>
          <select id="potencia">
            <option value="">Seleccionar potencia</option>
            <option value="335">335 Watts</option>
            <option value="450">450 Watts</option>
            <option value="550">550 Watts</option>
            <option value="650">650 Watts</option>
          </select>
        </td>
        <td>
          <input id="panels-qty" type="number" value="1" min="1" max="30" id="cantidad">
        </td>
        <td>
          <select id="region-selector">
            <option value="">Seleccione una región</option>
            <?php
                
            foreach($args['hsp_region'] as $hr){
                ?><option value="<?= $hr['value'] ?>"><?= $hr['name'] ?></option>\n<?php
            }
            ?>
          </select>
        </td>
      </tr>
    </tbody>
  </table>

  <div class="results-calculations">
    
    <div class="capacity-results">
      <div class="calc-result dayly-wh">
        <span class="title">W/H Día:</span>
        <span class="value"></span>
        <span class="unit">W/h</span>
      </div>

      <div class="calc-result dayly-kwh">
        <span class="title">KW/H al Día:</span>
        <span class="value"></span>
        <span class="unit">KW/H</span>
      </div>

      <div class="calc-result monthly-kwh">
        <span class="title">KW/H al Mes:</span>
        <span class="value"></span>
        <span class="unit">KW/H</span>
      </div>

      <div class="calc-result discount">

        <div class="by-month">
          <span class="title">Descuento mensual:</span>
          <span class="value"></span>
          <span class="unit">$</span>
        </div>

        <div class="by-year">
          <span class="title">Descuento anual:</span>
          <span class="value"></span>
          <span class="unit">$</span>
        </div>

        
      </div>
      
    </div>






    <div class="contact-data-container">
      <div class="field names">
        <label for="cofg-field-names">Nombres y apellidos</label>
        <input type="text" id="cofg-names">
      </div>
      <div class="field email">
        <label for="cofg-field-email">Email</label>
        <input type="text" id="cofg-email">
      </div>
      <div class="field phone">
        <label for="cofg-phone">Teléfono</label>
        <input type="text" id="cofg-phone">
      </div>
      <div class="field financiamiento">
        <input type="checkbox" id="cofg-finances">
        <label for="cofg-finances">Interesado en financiamiento</label>
      </div>
      <div class="field submit">
        <button class="submit">Enviar</button>
      </div>
    </div>

  </div>

</div>
