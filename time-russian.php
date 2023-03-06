<?php
interface TimeToWordConvertingInterface
{
	public function convert(int $hours, int $minutes): string;
}

class TimeToWordConverter implements TimeToWordConvertingInterface
{
	public function convert(int $hours, int $minutes): string
	{
		$numbers = array(
			1 => 'один',
			2 => 'два',
			3 => 'три',
			4 => 'четыре',
			5 => 'пять',
			6 => 'шесть',
			7 => 'семь',
			8 => 'восемь',
			9 => 'девять',
			10 => 'десять',
			11 => 'одиннадцать',
			12 => 'двенадцать'
		);

		$hour = $numbers[$hours];
		$minute = $this->getMinuteString($minutes);
		$time_description = '';

		if ($minutes === 0) {
			$time_description = "$hour часов.";
		} else if ($minutes === 30) {
			$time_description = "Половина $this->getHourString($hours + 1).";
		} else if ($minutes === 45) {
			$time_description = "Без пятнадцати $this->getHourString($hours + 1).";
		} else if ($minutes === 15 || $minutes === 45) {
			$time_description = "Четверть $this->getHourString($hours + 1).";
		} else if ($minutes < 30) {
			$time_description = "$minute после $hour.";
		} else {
			$time_description = "$minute до " . $this->getHourString($hours + 1) . ".";
		}

		return $time_description;
	}

	private function getHourString(int $hour): string
	{
		$numbers = array(
			1 => 'час',
			2 => 'два',
			3 => 'три',
			4 => 'четыре',
			5 => 'пять',
			6 => 'шесть',
			7 => 'семь',
			8 => 'восемь',
			9 => 'девять',
			10 => 'десять',
			11 => 'одиннадцать',
			12 => 'двенадцать'
		);

		if ($hour > 12) {
			$hour -= 12;
		}

		return $numbers[$hour];
	}


	private function getMinuteString(int $minutes): string
	{
		if ($minutes === 0) {
			return '';
		} elseif ($minutes === 1) {
			return 'одна минута';
		} elseif ($minutes === 59) {
			return 'одна минута';
		} elseif ($minutes === 15) {
			return 'четверть';
		} elseif ($minutes === 30) {
			return 'половина';
		} elseif ($minutes === 45) {
			return 'без пятнадцати';
		}

		$ones = [
			'одна',
			'две',
			'три',
			'четыре',
			'пять',
			'шесть',
			'семь',
			'восемь',
			'девять',
			'десять',
			'одиннадцать',
			'двенадцать',
			'тринадцать',
			'четырнадцать',
			'пятнадцать',
			'шестнадцать',
			'семнадцать',
			'восемнадцать',
			'девятнадцать'];
		$tens = ['двадцать',
			'тридцать',
			'сорок'];

		if ($minutes < 20) {
			return $ones[$minutes - 1] . ' минут';
		} elseif ($minutes % 10 === 0) {
			return $tens[$minutes / 10 - 2] . ' минут';
		} else {
			return $tens[floor($minutes / 10) - 2] . ' ' . $ones[$minutes % 10 - 1] . ' минут';
		}
	}



	private function getHourWord($hour) {
		$hours = [
			1 => "одного",
			2 => "двух",
			3 => "трех",
			4 => "четырех",
			5 => "пяти",
			6 => "шести",
			7 => "семи",
			8 => "восьми",
			9 => "девяти",
			10 => "десяти",
			11 => "одиннадцати",
			12 => "двенадцати",
		];
		return $hours[$hour];
	}

	private function getMinutesWord($minutes) {
		$minutesWords = [
			1 => "одна минута",
			2 => "две минуты",
			3 => "три минуты",
			4 => "четыре минуты",
			5 => "пять минут",
			6 => "шесть минут",
			7 => "семь минут",
			8 => "восемь минут",
			9 => "девять минут",
			10 => "десять минут",
			11 => "одиннадцать минут",
			12 => "двенадцать минут",
			13 => "тринадцать минут",
			14 => "четырнадцать минут",
			15 => "пятнадцать минут",
			16 => "шестнадцать минут",
			17 => "семнадцать минут",
			18 => "восемнадцать минут",
			19 => "девятнадцать минут",
			20 => "двадцать минут",
			21 => "двадцать одна минута",
			22 => "двадцать две минуты",
			23 => "двадцать три минуты",
			24 => "двадцать четыре минуты",
			25 => "двадцать пять минут",
			26 => "двадцать шесть минут",
			27 => "двадцать семь минут",
			28 => "двадцать восемь минут",
			29 => "двадцать девять минут",
			30 => "половина"
		];
		return $minutesWords[$minutes];
	}
}


$converter = new TimeToWordConverter();
echo $converter->convert(7, 0) . "\n"; // Семь часов
echo $converter->convert(7, 15) . "\n"; // Четверть восьмого
echo $converter->convert(7, 22) . "\n"; // Двадцать две минуты после семи
echo $converter->convert(7, 30) . "\n"; // Половина восьмого
echo $converter->convert(7, 41) . "\n"; // Девятнадцать минут до восьми
echo $converter->convert(7, 56) . "\n"; // Четыре минуты до восьми
echo $converter->convert(7, 59) . "\n"; // Одна минута до восьми
