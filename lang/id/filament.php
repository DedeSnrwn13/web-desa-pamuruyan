<?php

return [
    'components' => [
        'form' => [
            'validation' => [
                'required' => 'Wajib diisi',
                'unique' => 'Nilai sudah digunakan',
                'numeric' => 'Harus berupa angka',
                'min' => [
                    'numeric' => 'Nilai minimal :min',
                ],
                'max' => [
                    'numeric' => 'Nilai maksimal :max',
                ],
            ],
        ],
    ],
    ,
];