<?php

?>

<div 
        id="<?= esc_attr($atts['id']); ?>" 
        class="rayssa-calc-offgrid" 
        data-title="<?php echo esc_attr($atts['title']); ?>" 
        data-category="<?php echo esc_attr($atts['category']); ?>"
>
    
  <table class="items">
    <thead>
      <tr>
        <th>Artefacto eléctrico</th>
        <th>Cantidad</th>
        <th>Potencia (Watts)</th>
        <th>Tiempo de uso diario</th>
        <th>KW/h día</th>
        <th>KW/h mes</th>
        <th>Eliminar</th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>
  <div class='actions'>
    
      
    <button id="add-item-button">
      <i aria-hidden="true" class="far fa-plus-square"></i>
      <span>Agregar artefacto</span>
    </button>
    
  </div>

  <div class="results-calculations">
    
    <div class="capacity-results">
      <div class="calc-result daylytotalKWatts">
        <span class="title">Consumo diario:</span>
        <span class="value"></span>
        <span class="unit">KW/h día</span>
      </div>

      <div class="calc-result nominalCapacity">
        <span class="title">Capacidad neta:</span>
        <span class="value"></span>
        <span class="unit">KWatt</span>
      </div>

      <div class="calc-result bruteCapacity">
        <span class="title">Capacidad bruta:</span>
        <span class="value"></span>
        <span class="unit">Watt/h</span>
      </div>

      <div class="calc-result hourly-amperage-container">
        <div class="amp-12v">
          <span class="title">12v:</span>
          <span class="value"></span>
          <span class="unit">ah</span>
        </div>

        <div class="amp-24v">
          <span class="title">24v:</span>
          <span class="value"></span>
          <span class="unit">ah</span>
        </div>

        <div class="amp-48v">
          <span class="title">48v:</span>
          <span class="value"></span>
          <span class="unit">ah</span>
        </div>
      </div>
      
    </div>

    

    

    <div class="panels-calculation">
      <div class="step-1">
        <div class="selection">
          <select id="region-selector">
            <option value="">Seleccione una región</option>
            <?php
                
            foreach($args['hsp_region'] as $hr){
                ?><option value="<?= $hr['value'] ?>"><?= $hr['name'] ?></option>\n<?php
            }
            ?>
          </select>
        </div>
        
        <div class="calc-result peak-power-required">
          <span class="title">Potencia pico necesaria:</span>
          <span class="value"></span>
          <span class="unit"></span>
        </div>
      </div>

      <div class="step-2 panels-count-container">
        <div class="calc-result panel-count 335-340w">
          <span class="title">Panel 335/340w: </span>
          <div class="value-ctnr">
            <span class="value"></span>
            <span class="unit">unidades</span>
          </div>
        </div>

        <div class="calc-result panel-count 445-450w">
          <span class="title">Panel 445/450w: </span>
          <div class="value-ctnr">
            <span class="value"></span>
            <span class="unit">unidades</span>
          </div>
        </div>

        <div class="calc-result panel-count 550-560w">
          <span class="title">Panel 550/560w: </span>
          <div class="value-ctnr">
            <span class="value"></span>
            <span class="unit">unidades</span>
          </div>
        </div>

        <div class="calc-result panel-count 600-610w">
          <span class="title">Panel 600/610w: </span>
          <div class="value-ctnr">
            <span class="value"></span>
            <span class="unit">unidades</span>
          </div>
        </div>

        <div class="calc-result panel-count 650-660w">
          <span class="title">Panel 650/660w: </span>
          <div class="value-ctnr">
            <span class="value"></span>
            <span class="unit">unidades</span>
          </div>
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
