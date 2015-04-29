<?php

class Date
{

    public $days = array(
        'Lundi', 'Mardi' , 'Mercredi', 'Jeudi', 'Vendredi',
    );
    
    public $months = array(
        'Janvier', 'Février' , 'Mars', 'Avril', 'Mai', 'juin', 'Juillet',
        'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
    );
    
    function getAll($year)
    {
        $r = array();
        
        $date = new DateTime($year.'-01-01');
        
        while($date->format('Y') <= $year) {
            $y = $date->format('Y');
            $m = $date->format('n');
            $d = $date->format('j');
            $w = str_replace('0', '7', $date->format('w'));

            $r[$y][$m][$d] = $w;
            
            $date->add(new DateInterval('P1D'));
        }
        
        return $r;
    }

    function getWeek($week)
    {
        $r = array();
        
        $date = new DateTime();
        $actual_date = $date->setISODate(date('Y'), $week);
        
        while($actual_date->format('W') <= $week) {
            $y = $date->format('Y');
            $m = $date->format('n');
            $d = $date->format('j');
            $w = $date->format('w');

            $r[] = $date->format('Y-m-d');
            
            $actual_date->add(new DateInterval('P1D'));
        }
        
        return $r;
    }
    
    function getMonday($week)
    {
        
        $date = new DateTime();
        $actual_date = $date->setISODate(date('Y'), $week);
        $r = date($actual_date->format('d/m/Y'), strtotime('last monday'));
        
        return $r;
    }
    
    function getFriday($week)
    {
        
        $date = new DateTime();
        $actual_date = $date->setISODate(date('Y'), $week)->add(new DateInterval('P4D'));
        $r = $actual_date->format('d/m/Y');
        
        return $r;
    }
    
}
