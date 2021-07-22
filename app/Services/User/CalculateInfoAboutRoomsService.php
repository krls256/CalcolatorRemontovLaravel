<?php


namespace App\Services\User;


use App\Services\CoreService;

class CalculateInfoAboutRoomsService extends CoreService
{
    // this class contains bad code TODO: come up the idea to improve it)
    private $type;
    private $typeRem;
    private $roomsQuantity;
    private $area;

    public function __construct($type, $typeRem, $roomsQuantity, $area) {
        $this->type = $type;
        $this->typeRem = $typeRem;
        $this->roomsQuantity = $roomsQuantity;
        $this->area = $area;
    }

    public function run($params = null)
    {
//        $type = (int) $this->type; на случай различного поведения новостройки и вторички
        $typeRemont = $this->getTypeRemont($this->type, $this->typeRem);
        $calcPattern = collect($this->getInfoCore($this->roomsQuantity, $typeRemont, $this->area));

        return $calcPattern;
    }

    private function getInfoCore($rooms, $typeRemont, $area) {
        switch ($rooms) {
            case 0:
                return [
                    "kitchen"   => [
                        array_merge($typeRemont['kitchen'], [
                            "long"    => sqrt( $area*0.20),
                            "width"   => sqrt($area*0.20),
                            "divider" => 2
                        ])
                    ],
                    "badroom"   => [
                        array_merge($typeRemont['badroom'], [
                            "long"    => sqrt($area*0.64),
                            "width"   => sqrt($area*0.64),
                            "windows" => 1
                        ])
                    ],
                    "bathroom"  => [
                        array_merge($typeRemont['bathroom'], [
                            "long"    => sqrt($area*0.16),
                            "width"   => sqrt($area*0.16)
                        ])
                    ]
                ];
            break;
            case 1:
                return [
                    "kitchen"   => [
                        array_merge($typeRemont['kitchen'], [
                            "long"    => sqrt($area*0.25),
                            "width"   => sqrt($area*0.25),
                            "windows" => 1
                        ])
                    ],
                    "badroom"   => [
                        array_merge($typeRemont['badroom'], [
                            "long"    => sqrt($area*0.445),
                            "width"   => sqrt($area*0.445),
                            "windows" => 1
                        ])
                    ],
                    "bathroom"  => [
                        array_merge($typeRemont['bathroom'], [
                            "long"    => sqrt($area*0.11),
                            "width"   => sqrt($area*0.11)
                        ])
                    ],
                    "hallway"   => [
                        array_merge($typeRemont['hallway'], [
                            "long"    => sqrt($area*0.166),
                            "width"   => sqrt($area*0.166)
                        ])
                    ]
                ];
            break;
            case 2:
                return [
                    "kitchen"   => [
                        array_merge($typeRemont['kitchen'], [
                            "long"    => sqrt($area*0.18),
                            "width"   => sqrt($area*0.18),
                            "windows" => 1
                        ])
                    ],
                    "badroom"   => [
                        array_merge($typeRemont['badroom'], [
                            "long"    => sqrt($area*0.32),
                            "width"   => sqrt($area*0.32),
                            "windows" => 1
                        ]),
                        array_merge($typeRemont['badroom'], [
                            "long"    => sqrt($area*0.28),
                            "width"   => sqrt($area*0.28),
                            "windows" => 1
                        ])
                    ],
                    "bathroom"  => [
                        array_merge($typeRemont['bathroom'], [
                            "long"    => sqrt($area*0.08),
                            "width"   => sqrt($area*0.08)
                        ])
                    ],
                    "hallway"   => [
                        array_merge($typeRemont['hallway'], [
                            "long"    => sqrt($area*0.16),
                            "width"   => sqrt($area*0.16)
                        ])
                    ]
                ];
            break;
            case 3:
                return [
                    "kitchen"   => [
                        array_merge($typeRemont['kitchen'], [
                            "long"    => sqrt($area*0.125),
                            "width"   => sqrt($area*0.125),
                            "windows" => 1
                        ])
                    ],
                    "badroom"   => [
                        array_merge($typeRemont['badroom'], [
                            "long"    => sqrt($area*0.222),
                            "width"   => sqrt($area*0.222),
                            "windows" => 1
                        ]),
                        array_merge($typeRemont['badroom'], [
                            "long"    => sqrt($area*0.222),
                            "width"   => sqrt($area*0.222),
                            "windows" => 1
                        ]),
                        array_merge($typeRemont['badroom'], [
                            "long"    => sqrt($area*0.194),
                            "width"   => sqrt($area*0.194),
                            "windows" => 1
                        ])
                    ],
                    "bathroom"  => [
                        array_merge($typeRemont['bathroom'], [
                            "long"    => sqrt($area*0.055),
                            "width"   => sqrt($area*0.055)
                        ])
                    ],
                    "toilet"    => [
                        array_merge($typeRemont['toilet'], [
                            "long"    => sqrt($area*0.027),
                            "width"   => sqrt($area*0.027)
                        ])
                    ],
                    "hallway"   => [
                        array_merge($typeRemont['hallway'], [
                            "long"    => sqrt($area*0.125),
                            "width"   => sqrt($area*0.125)
                        ])
                    ]
                ];
            break;
            case 4:
                return [
                    "kitchen"   => [
                        array_merge($typeRemont['kitchen'], [
                            "long"    => sqrt($area*0.137),
                            "width"   => sqrt($area*0.137),
                            "windows" => 1
                        ])
                    ],
                    "badroom"   => [
                        array_merge($typeRemont['badroom'], [
                            "long"    => sqrt($area*0.196),
                            "width"   => sqrt($area*0.196),
                            "windows" => 1
                        ]),
                        array_merge($typeRemont['badroom'], [
                            "long"    => sqrt($area*0.176),
                            "width"   => sqrt($area*0.176),
                            "windows" => 1
                        ]),
                        array_merge($typeRemont['badroom'], [
                            "long"    => sqrt($area*0.156),
                            "width"   => sqrt($area*0.156),
                            "windows" => 1
                        ]),
                        array_merge($typeRemont['badroom'], [
                            "long"    => sqrt($area*0.137),
                            "width"   => sqrt($area*0.137),
                            "windows" => 1
                        ])
                    ],
                    "bathroom"  => [
                        array_merge($typeRemont['bathroom'], [
                            "long"    => sqrt($area*0.058),
                            "width"   => sqrt($area*0.058)
                        ]),
                        array_merge($typeRemont['bathroom'], [
                            "long"    => sqrt($area*0.039),
                            "width"   => sqrt($area*0.039)
                        ])],
                    "hallway"   => [
                        array_merge($typeRemont['hallway'], [
                            "long"    => sqrt($area*0.098),
                            "width"   => sqrt($area*0.098)
                        ])
                    ]
                ];
            break;
            case 5:
                return [
                    "kitchen"   => [
                        array_merge($typeRemont['kitchen'], [
                            "long"    => sqrt($area*0.118),
                            "width"   => sqrt($area*0.118),
                            "windows" => 1
                        ])
                    ],
                    "badroom"   => [
                        array_merge($typeRemont['badroom'], [
                            "long"    => sqrt($area*0.157),
                            "width"   => sqrt($area*0.157),
                            "windows" => 1
                        ]),
                        array_merge($typeRemont['badroom'], [
                            "long"    => sqrt($area*0.157),
                            "width"   => sqrt($area*0.157),
                            "windows" => 1
                        ]),
                        array_merge($typeRemont['badroom'], [
                            "long"    => sqrt($area*0.141),
                            "width"   => sqrt($area*0.141),
                            "windows" => 1
                        ]),
                        array_merge($typeRemont['badroom'], [
                            "long"    => sqrt($area*0.125),
                            "width"   => sqrt($area*0.125),
                            "windows" => 1
                        ]),
                        array_merge($typeRemont['badroom'], [
                            "long"    => sqrt($area*0.11),
                            "width"   => sqrt($area*0.11),
                            "windows" => 1
                        ])
                    ],
                    "bathroom"  => [
                        array_merge($typeRemont['bathroom'], [
                            "long"    => sqrt($area*0.062),
                            "width"   => sqrt($area*0.062)
                        ]),
                        array_merge($typeRemont['bathroom'], [
                            "long"    => sqrt($area*0.047),
                            "width"   => sqrt($area*0.047)
                        ])
                    ],
                    "hallway"   => [
                        array_merge($typeRemont['hallway'], [
                            "long"    => sqrt($area*0.078),
                            "width"   => sqrt($area*0.078)
                        ])
                    ]
                ];
            break;
            default: return null;
        }
    }

   private function getTypeRemont($type, $typeRem)
    {
        // TODO: simplify it
        switch ($typeRem) {
            case 0:
                return [
                    'kitchen' => [
                        "сeiling" => "stretch",
                        "wall"    => "wallpaper",
                        "floor"   => "laminate",
                        "still"   => [
                            'screed'        => 'floor',
                            'floor_primer'  => 'floor',
                            'plinth'        => 'installing',
                            'wall_primer'   => 'wall',
                            'sink'          => 'installing',
                            'piping'        => 'installing'
                        ]
                    ],
                    'bathroom' => [
                        "сeiling" => "pvc",
                        "wall"    => "tile",
                        "floor"   => "tile",
                        "still"   => [
                            "sink"    => "change",
                            "toilet"  => "change",
                            "bath"    => "change",
                            "sockets" => "change"
                        ]
                    ],
                    'badroom' => [
                        "сeiling" => "stretch",
                        "wall"    => "wallpaper",
                        "floor"   => "laminate",
                        "still"   => $type==1 ? [
                            'screed'        => 'floor',
                            'wall_primer'   => 'wall',
                            'floor_primer'  => 'floor',
                            'plinth'        => 'change'
                        ] : [
                            "screed"        => "floor",
                            'wall_primer'   => 'wall',
                            'floor_primer'  => 'floor',
                            'plinth'        => 'installing'
                        ]
                    ],
                    'toilet'    => [
                        [
                            "сeiling" => "stretch",
                            "wall"    => "wallpaper",
                            "floor"   => "tile",
                            "still"   => [
                                "toilet"  => "change"
                            ]
                        ]
                    ],
                    'hallway' => [
                        "сeiling" => "stretch",
                        "wall"    => "wallpaper",
                        "floor"   => "laminate",
                        "still"   => [
                            'screed'  => 'floor',
                            'plinth'  => 'change'
                        ]
                    ]
                ];
            break;
            case 1:
                return [
                    'kitchen'   => [
                        "сeiling" => "stretch",
                        "wall"    => "wallpaper",
                        "floor"   => "laminate",
                        "still"   => $type == 1 ? [
                            "screed"        => "floor",
                            "floor_primer"  => "floor",
                            "plinth"        => "change",
                            "wall_primer"   => "wall",
                            "plaster"       => "wall",
                            "putty"         => "wall",
                            "sink"          => "change",
                            "piping"        => "installing",
                            "sockets"       => "change"
                        ] : [
                            "screed"        => "floor",
                            "floor_primer"  => "floor",
                            "sink"          => "installing",
                            "plinth"        => "installing",
                            "wall_primer"   => "wall",
                            "plaster"       => "wall",
                            "putty"         => "wall",
                            "piping"        => "installing",
                            "sockets"       => "installing"
                        ]
                    ],
                    'bathroom'  => [
                        "сeiling" => "pvc",
                        "wall"    => ["tile", "wallpaper"],
                        "floor"   => "tile",
                        "still"   => $type == 1 ? [
                            "toilet"    => "change",
                            "bath"      => "change",
                            "towelRail" => "change",
                            "sink"      => "change",
                            "piping"    => "installing",
                            "sockets"   => "change"
                        ] : [
                            "toilet"    => "installing",
                            "bath"      => "installing",
                            "towelRail" => "installing",
                            "sink"      => "installing",
                            "piping"    => "installing",
                            "sockets"   => "installing"
                        ]
                    ],
                    'badroom'   => [
                        "сeiling" => "stretch",
                        "wall"    => "wallpaper",
                        "floor"   => "laminate",
                        "still"   => $type==1 ? [
                            "screed"        => "floor",
                            "floor_primer"  => "floor",
                            "plinth"        => "change",
                            "wall_primer"   => "wall",
                            "plaster"       => "wall",
                            "putty"         => "wall",
                            "sockets"       => "change"
                        ] : [
                            "screed"        => "floor",
                            "floor_primer"  => "floor",
                            "plinth"        => "installing",
                            "wall_primer"   => "wall",
                            "plaster"       => "wall",
                            "putty"         => "wall",
                            "sockets"       => "installing"
                        ]
                    ],
                    'toilet'    => [
                        "сeiling" => "stretch",
                        "wall"    => "wallpaper",
                        "floor"   => "tile",
                        "still"   =>  $type==1 ? [
                            "toilet"  => "change",
                            "floor_primer"  => "floor",
                            "wall_primer"   => "wall",
                            "plaster"       => "wall",
                            "putty"         => "wall"
                        ] : [
                            "toilet"  => "installing",
                            "floor_primer"  => "floor",
                            "wall_primer"   => "wall",
                            "plaster"       => "wall",
                            "putty"         => "wall"
                        ]
                    ],
                    'hallway'   => [
                        "сeiling" => "stretch",
                        "wall"    => "wallpaper",
                        "floor"   => "laminate",
                        "still"   => $type==1 ? [
                            "screed"        => "floor",
                            "floor_primer"  => "floor",
                            "plinth"        => "change",
                            "wall_primer"   => "wall",
                            "plaster"       => "wall",
                            "putty"         => "wall",
                            "sockets"       => "change"
                        ] : [
                            "screed"        => "floor",
                            "floor_primer"  => "floor",
                            "plinth"        => "installing",
                            "wall_primer"   => "wall",
                            "plaster"       => "wall",
                            "putty"         => "wall",
                            "sockets"       => "installing"
                        ]
                    ]
                ];
            break;
            case 2:
                return [
                    'kitchen'   => [
                        "сeiling" => "stretch",
                        "wall"    => "wallpaper",
                        "floor"   => "laminate",
                        "still"   => $type==1 ? [
                            "screed"        => "floor",
                            "floor_primer"  => "floor",
                            "plinth"        => "change",
                            "wall_primer"   => "wall",
                            "plaster"       => "wall",
                            "putty"         => "wall",
                            "sink"          => "installing",
                            "piping"        => "installing",
                            "sockets"       => "change"
                        ] : [
                            "screed"        => "floor",
                            "floor_primer"  => "floor",
                            "plinth"        => "installing",
                            "wall_primer"   => "wall",
                            "plaster"       => "wall",
                            "putty"         => "wall",
                            "sink"          => "installing",
                            "piping"        => "installing",
                            "sockets"       => "installing"
                        ]
                    ],
                    'bathroom'  => [
                        "сeiling" => "pvc",
                        "wall"    => "tile",
                        "floor"   => "tile",
                        "still"   => $type==1 ? [
                            "toilet"    => "change",
                            "bath"      => "change",
                            "towelRail" => "change",
                            "sink"      => "change",
                            "piping"    => "installing",
                            "sockets"   => "change"
                        ] : [
                            "toilet"    => "installing",
                            "bath"      => "installing",
                            "towelRail" => "installing",
                            "sink"      => "installing",
                            "piping"    => "installing",
                            "sockets"   => "installing"
                        ]
                    ],
                    'badroom'   => [
                        "сeiling" => "stretch",
                        "wall"    => "wallpaper",
                        "floor"   => "laminate",
                        "still"   =>  $type==1 ? [
                            "screed"        => "floor",
                            "floor_primer"  => "floor",
                            "plinth"        => "change",
                            "wall_primer"   => "wall",
                            "plaster"       => "wall",
                            "putty"         => "wall",
                            "sockets"       => "change"
                        ]: [
                            "screed"        => "floor",
                            "floor_primer"  => "floor",
                            "plinth"        => "installing",
                            "wall_primer"   => "wall",
                            "plaster"       => "wall",
                            "putty"         => "wall",
                            "sockets"       => "installing"
                        ]
                    ],
                    'toilet'    => [
                        "сeiling" => "stretch",
                        "wall"    => "wallpaper",
                        "floor"   => "tile",
                        "still"   => $type==1 ? [
                            "toilet"  => "change",
                            "floor_primer"  => "floor",
                            "wall_primer"   => "wall",
                            "plaster"       => "wall",
                            "putty"         => "wall"
                        ] : [
                            "toilet"  => "installing",
                            "floor_primer"  => "floor",
                            "wall_primer"   => "wall",
                            "plaster"       => "wall",
                            "putty"         => "wall"
                        ]
                    ],
                    'hallway'   => [
                        "сeiling" => "stretch",
                        "wall"    => "wallpaper",
                        "floor"   => "laminate",
                        "still"   => $type==1 ? [
                            "screed"        => "floor",
                            "floor_primer"  => "floor",
                            "plinth"        => "change",
                            "wall_primer"   => "wall",
                            "plaster"       => "wall",
                            "putty"         => "wall",
                            "sockets"       => "change"
                        ] : [
                            "screed"        => "floor",
                            "floor_primer"  => "floor",
                            "plinth"        => "installing",
                            "wall_primer"   => "wall",
                            "plaster"       => "wall",
                            "putty"         => "wall",
                            "sockets"       => "installing"
                        ]
                    ]
                ];
            break;
            case 3:
                return [
                    'kitchen'   => [
                        "still"   => [
                            'screed'        => 'floor',
                            "floor_primer"  => "floor",
                            "wall_primer"   => "wall",
                            "plaster"       => "wall",
                            "putty"         => "wall",
                        ]
                    ],
                    'bathroom'  => [
                        "сeiling" => "pvc",
                        "wall"    => "tile",
                        "floor"   => "tile",
                        "still"   => [
                            "bath"      => "installing",
                            "piping"    => "installing"
                        ]
                    ],
                    'badroom'   => [
                        "still"   => [
                            "screed"        => "floor",
                            "floor_primer"  => "floor",
                            "wall_primer"   => "wall",
                            "plaster"       => "wall",
                            "putty"         => "wall",
                        ]
                    ],
                    'toilet'    => [
                        "floor"   => "tile",
                        "still"   => [
                            "floor_primer"  => "floor",
                            "wall_primer"   => "wall",
                            "plaster"       => "wall",
                            "putty"         => "wall"
                        ]
                    ],
                    'hallway'   => [
                        "still"   => [
                            'screed'        => "floor",
                            "floor_primer"  => "floor",
                            "wall_primer"   => "wall",
                            "plaster"       => "wall",
                            "putty"         => "wall",
                        ]
                    ]
                ];
            break;
            case 4:
                return [
                    'kitchen'   => [
                        "сeiling" => "stretch",
                        "wall"    => "wallpaper",
                        "floor"   => "laminate",
                        "still"   => [
                            "screed"        => "floor",
                            "floor_primer"  => "floor",
                            "wall_primer"   => "wall",
                            "plinth"        => "change",
                            "sink"          => "change",
                        ]
                    ],
                    'bathroom'  => [
                        "сeiling" => "stretch",
                        "wall"    => "tile",
                        "floor"   => "tile",
                        "still"    => [
                            "toilet"  => "change",
                            "sink"    => "change",
                            "piping"  => "installing"
                        ]
                    ],
                    'badroom'   => [
                        "сeiling" => "stretch",
                        "wall"    => "wallpaper",
                        "floor"   => "laminate",
                        "still"    => [
                            "screed"        => "floor",
                            "floor_primer"  => "floor",
                            "plinth"        => "change",
                            "wall_primer"   => "wall"
                        ]
                    ],
                    'toilet'    => [
                        "сeiling" => "stretch",
                        "wall"    => "wallpaper",
                        "floor"   => "laminate",
                    ],
                    'hallway'   => [
                        "сeiling" => "stretch",
                        "wall"    => "wallpaper",
                        "floor"   => "laminate",
                        "still"   => [
                            "screed"        => "floor",
                            "floor_primer"  => "floor",
                            "plinth"        => "change",
                            "wall_primer"   => "wall",
                        ]
                    ]
                ];
            break;
            default: return null;
        }
    }
}
