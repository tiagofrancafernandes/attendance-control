<?php

return [
    'title' => [
        'default' => 'How do you rate your experience?',
        'pt-br' => 'Como você avalia sua experiência?',
    ],
    'inputs' => [
        [
            'question' => [
                'default' => 'Level of satisfaction',
                'pt-br' => 'Nível de satisfação',
            ],
            'required' => true,

            /*
                'key_for_reports'
                // For chart graphs etc
                'required' NEED BE =true
                'type' NEED BE one of select|binary_option|single_line_text|select_list
                IF 'type' select|select_list NEED BE multi_select=false
             */
            'key_for_reports' => true, // Need be required=true

            'name' => 'vote',
            'validation' => [
                'required',
                'integer',
                'in:1,2,3,4,5',
            ],
            // 'placeholder' => [
            //     'default' => '...',
            //     'pt-br' => '...',
            // ],
            'type' => 'select', // emoji|binary_option|single_line_text|multi_line_text|select_list

            // if 'type' are 'select_list' or 'amoji'
            'multi_select' => false, // TRUE=checkbox/multi_select | FALSE=radio/select
            'emoji_options' => [
                // 😍😔🤩🥰🙂👏😭😐😕😶😠😦👌👎👍
                [
                    'emoji' => '😍',
                    'label' => [
                        'default' => 'I love',
                        'pt-br' => 'Amo',
                    ],
                    'value' => 5,
                ],
                [
                    'emoji' => '🙂',
                    'label' => [
                        'default' => 'I like',
                        'pt-br' => 'Gosto',
                    ],
                    'value' => 4,
                ],
                [
                    'emoji' => '😐',
                    'label' => [
                        'default' => 'Whatever',
                        'pt-br' => 'Tanto faz',
                    ],
                    'value' => 3,
                ],
                [
                    'emoji' => '😕',
                    'label' => [
                        'default' => "I don't like",
                        'pt-br' => 'Não gosto',
                    ],
                    'value' => 2,
                ],
                [
                    'emoji' => '😠',
                    'label' => [
                        'default' => 'I hate',
                        'pt-br' => 'Odiei',
                    ],
                    'value' => 1,
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
            'validation' => [
                'nullable',
                'string',
                'min:5',
                'max:1000',
            ],
            'required' => false,
            'name' => 'message',
            'min' => 5,
            'max' => 1000,
            'type' => 'multi_line_text',
            'placeholder' => [
                'default' => 'Your message here...',
                'pt-br' => 'Sua mensagem aqui...',
            ],
            'help_message' => [
                'default' => '...',
                'pt-br' => '...',
            ],
        ],
    ]
];
