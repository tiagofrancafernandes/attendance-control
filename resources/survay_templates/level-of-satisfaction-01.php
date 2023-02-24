<?php

return [
    [
        "question" => [
            "default" => "Level of satisfaction",
            "pt-br" => "Nível de satisfação",
        ],
        "name" => "vote",
        "type" => "emoji", // emoji|binary_option|single_line_text|multi_line_text|range
        "multi_select" => false, // TRUE=checkbox | FALSE=radio
        "emoji_options" => [
            // 😍😔🤩🥰🙂👏😭😐😕😶😠😦👌👎👍
            [
                "emoji" => "😍",
                "label" => [
                    "default" => "I love",
                    "pt-br" => "Amo",
                ],
                "value" => 5,
            ],
            [
                "emoji" => "🙂",
                "label" => [
                    "default" => "I like",
                    "pt-br" => "Gosto",
                ],
                "value" => 4,
            ],
            [
                "emoji" => "😐",
                "label" => [
                    "default" => "Whatever",
                    "pt-br" => "Tanto faz",
                ],
                "value" => 3,
            ],
            [
                "emoji" => "😕",
                "label" => [
                    "default" => "I don't like",
                    "pt-br" => "Não gosto",
                ],
                "value" => 2,
            ],
            [
                "emoji" => "😠",
                "label" => [
                    "default" => "I hate",
                    "pt-br" => "Odiei",
                ],
                "value" => 1,
            ],
        ]
    ]
];
