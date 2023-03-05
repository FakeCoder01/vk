<?php

class TimeToWordConverter implements TimeToWordConvertingInterface
{
    public function convert(int $hours, int $minutes): string
    {
        $hoursWords = [
            1 => 'Один', 2 => 'Два', 3 => 'Три', 4 => 'Четыре',
            5 => 'Пять', 6 => 'Шесть', 7 => 'Семь', 8 => 'Восемь',
            9 => 'Девять', 10 => 'Десять', 11=> 'Одиннадцать',
            12=> 'Двенадцать'
        ];
        $minutesWords = [
            1 => "одна минута",2=>"две минуты",3=>"три минуты",4=>"четыре минуты",
            5=>"пять минут",6=>"шесть минут",7=>"семь минут",8=>"восемь минут",
            9=>"девять минут",10=>"десять минут",11=>"одиннадцать минут",
            12=>"двенадцать минут",13=>"тринадцать минут",14=>"четырнадцать минут",
            15=>"пятнадцать минут",16=>"шестнадцать минут",17=>"семнадцать минут",
            18=>"восемнадцать минут",19=>"девятнадцать минут"
        ];
        $tensWords = [
            2 => "двадцать",3 => "тридцать",4 => "сорок",
            5 => "пятьдесят"
        ];
        if ($minutes == 0) {
            return $hoursWords[$hours] . ' часов';
        } elseif ($minutes > 0 && $minutes < 30) {
            if ($minutes == 1) {
                return $minutesWords[$minutes] . ' после ' . mb_strtolower($hoursWords[$hours]);
            } elseif ($minutes > 1 && $minutes <20) {
                return $minutesWords[$minutes] . ' после ' . mb_strtolower($hoursWords[$hours]);
            }
        } elseif ($minutes == 15) {
                return 'Четверть ' . mb_strtolower($hoursWords[$hours + 1]);
        } else {
                $tens = intdiv($minutes, 10);
                $ones = $minutes % 10;
                if ($ones == 0) {
                    return $tensWords[$tens] . ' минут после ' . mb_strtolower($hoursWords[$hours]);
                } else {
                    return $tensWords[$tens] . ' ' . $minutesWords[$ones] . ' после ' . mb_strtolower($hoursWords[$hours]);
                } elseif ($minutes >30 && $minutes < 45) {
                $tens = intdiv(60 - $minutes, 10);
                $ones = (60 - $minutes) % 10;
                if ($ones == 0) {
                    return $tensWords[$tens] . ' минут до ' . mb_strtolower($hoursWords[($hours % 12) + 1]);
                } else {
                    return $tensWords[$tens] . ' ' . $minutesWords[$ones] . ' до ' . mb_strtolower($hoursWords[($hours % 12) + 1]);
                }
            } elseif ($minutes == 45) {
                return "Четверть до " . mb_strtolower($hoursWords[($hours % 12) + 1]);
            } else {
                return (60 - $minutes) . " минут до " . mb_strtolower($hoursWords[($hours % 12) + 1]);
            }
        }
    }
}

$converter = new TimeToWordConverter();
echo $converter->convert(7,0); // Семь часов
echo $converter->convert(7,15);
