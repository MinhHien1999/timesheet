<?php

namespace App\Enum;

class Day {
    const MONDAY = 'Monday' ;
    const TUESDAY = 'Tuesday' ;
    const WEDNESDAY = 'Wednesday' ;
    const THURSDAY = 'Thursday' ;
    const FRIDAY = 'Friday' ;
    const SATURDAY = 'Saturday' ;
    const SUNDAY = 'Sunday' ;

    const DAY_INSIDE = [
        self::MONDAY => 22,
        self::TUESDAY => 25,
        self::WEDNESDAY => 22,
        self::THURSDAY => 25,
        self::FRIDAY => 22,
    ];
    
    const DAY_OUTSIDE = [
        self::MONDAY => 34,
        self::TUESDAY => 35,
        self::WEDNESDAY => 34,
        self::THURSDAY => 35,
        self::FRIDAY => 34,
    ];

    const WEEKEND = [
        self::SATURDAY => 47,
        self::SUNDAY => 47
    ];

}