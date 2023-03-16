<?php

return [
    'title' => [
        'default' => 'How do you rate your experience?',
        'pt-br' => 'Como você avalia sua experiência?',
    ],
    'inputs' => [
        [
            'question' => [
                'default' => 'On a scale of 0 to 10, how likely are you to recommend our business to a friend or colleague?',
                'pt-br' => 'Em uma escala de 0 a 10, qual a probabilidade de você recomendar nossa empresa a um amigo ou colega?',
            ],
            'validation' => [
                'required',
                'integer',
                'in:0,1,2,3,4,5,6,7,8,9,10',
            ],
            'required' => true,

            /*
                'key_for_reports'
                // For chart graphs etc
                'required' NEED BE =true
                'type' NEED BE one of select|binary_option|single_line_text|select_list
                IF 'type' select|select_list NEED BE multi_select=false
             */
            'key_for_reports' => true,
            'name' => 'rating',
            'type' => 'select', // emoji|binary_option|single_line_text|multi_line_text|select_list

            // if 'type' are 'select_list' or 'amoji'
            'multi_select' => false, // TRUE=checkbox/multi_select | FALSE=radio/select
            'options' => [
                [
                    'label' => ['default' => '0', ],
                    'value' => 0,
                ],
                [
                    'label' => ['default' => '1', ],
                    'value' => 1,
                ],
                [
                    'label' => ['default' => '2', ],
                    'value' => 2,
                ],
                [
                    'label' => ['default' => '3', ],
                    'value' => 3,
                ],
                [
                    'label' => ['default' => '4', ],
                    'value' => 4,
                ],
                [
                    'label' => ['default' => '5', ],
                    'value' => 5,
                ],
                [
                    'label' => ['default' => '6', ],
                    'value' => 6,
                ],
                [
                    'label' => ['default' => '7', ],
                    'value' => 7,
                ],
                [
                    'label' => ['default' => '8', ],
                    'value' => 8,
                ],
                [
                    'label' => ['default' => '9', ],
                    'value' => 9,
                ],
                [
                    'label' => ['default' => '10', ],
                    'value' => 10,
                ],
            ],
            'help_message' => [
                'default' => '...',
                'pt-br' => '...',
            ],
        ],
        [
            'question' => [
                'default' => 'Would you like to add a message to your reply?',
                'pt-br' => 'Gostaria de adicionar uma mensagem à sua resposta?',
            ],
            'required' => false,
            'validation' => [
                'nullable',
                'string',
                'min:5',
                'max:1000',
            ],
            'name' => 'message',
            'min' => 5,
            'max' => 1000,
            'type' => 'multi_line_text',
            'placeholder' => [
                'default' => 'Your message here...',
                'pt-br' => 'Sua mensagem aqui...',
            ],
            'help_message' => [
                'default' => 'Your message helps us to improve our services.',
                'pt-br' => 'Sua mensagem nos ajuda a melhorar nossos serviços.',
            ],
        ],
    ]
];
