<?php 


function rayssa_get_demo_artifacts(){
    $demoArtfcs = [
        [
            'id'    => 'tv',
            'name'  => 'TV',
            'qty'   => 1,
            'power' => 80,
            'duh'   => 6
        ],
        [
            'id'    => 'lavadora',
            'name'  => 'Lavadora',
            'qty'   => 1,
            'power' => 400,
            'duh'   => 2
        ],
        [
            'id'    => 'computador',
            'name'  => 'Computador',
            'qty'   => 1,
            'power' => 150,
            'duh'   => 2
        ],
        [
            'id'    => 'refrigerador',
            'name'  => 'Refrigerador',
            'qty'   => 1,
            'power' => 24.67,
            'duh'   => 24
        ],
        [
            'id'    => 'iluminacion',
            'name'  => 'Iluminacion',
            'qty'   => 10,
            'power' => 9,
            'duh'   => 6
        ],
        [
            'id'    => 'bomba-agua',
            'name'  => 'BNomba de agua',
            'qty'   => 1,
            'power' => 700,
            'duh'   => 1
        ],
        [
            'id'    => 'cargador-celular',
            'name'  => 'Cargador de celular',
            'qty'   => 3,
            'power' => 20,
            'duh'   => 5
        ],
        [
            'id'    => 'estufa-a-pellet',
            'name'  => 'Estufa a pellet',
            'qty'   => 1,
            'power' => 40,
            'duh'   => 6
        ],
        [
            'id'    => 'juguera',
            'name'  => 'Juguera',
            'qty'   => 1,
            'power' => 60,
            'duh'   => 1
        ],
        [
            'id'    => 'aspiradora',
            'name'  => 'Aspiradora',
            'qty'   => 1,
            'power' => 100,
            'duh'   => 1
        ]
    ];
    return apply_filters('rayssa_demo_artifacts',$demoArtfcs);
}

function rayssa_get_hsp_data(){
    $hsp = [
        [
            'id' => 1,
            'name' => 'Región de Arica y Parinacota',
            'value'   => 2.40
        ],
        [
            'id' => 2,
            'name' => 'Región de Tarapacá',
            'value'   => 2.67
        ],
        [
            'id' => 3,
            'name' => 'Región de Antofagasta',
            'value'   => 2.84
        ],
        [
            'id' => 4,
            'name' => 'Región de Atacama',
            'value'   => 2.70
        ],
        [
            'id' => 5,
            'name' => 'Región de Coquimbo',
            'value'   => 2.54
        ],
        [
            'id' => 6,
            'name' => 'Región de Valparaiso',
            'value'   => 2.41
        ],
        [
            'id' => 7,
            'name' => 'Región Metropolitana',
            'value'   => 2.42
        ],
        [
            'id' => 8,
            'name' => 'Región de O\'Higgins',
            'value'   => 2.18
        ],
        [
            'id' => 9,
            'name' => 'Región del Maule',
            'value'   => 2.31
        ],
        [
            'id' => 10,
            'name' => 'Región del Ñuble',
            'value'   => 2.23
        ],
        [
            'id' => 11,
            'name' => 'Región de Bío Bío',
            'value'   => 2.04
        ],
        [
            'id' => 12,
            'name' => 'Región de la Araucanía',
            'value'   => 1.88
        ],
        [
            'id' => 13,
            'name' => 'Región de los Ríos',
            'value'   => 1.72
        ],
        [
            'id' => 14,
            'name' => 'Región de los Lagos',
            'value'   => 1.56
        ],
        [
            'id' => 15,
            'name' => 'Región de Aysen',
            'value'   => 0.90
        ],
        [
            'id' => 16,
            'name' => 'Región de Magallanes',
            'value'   => 1.14
        ]
    ];

    return apply_filters('rayssa_hsp_regions',$hsp);
}