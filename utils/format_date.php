<?php

/* Format date */

// j = jour, n = numéro, m = mois, a = année

function format_date($date, $format = 'jnma') {
  // split $format into an array to iterate on it
  $string_array = str_split($format);

  $strftime_format = '';

  for ($i=0; $i < count($string_array); $i++) {
    $letter = $string_array[$i];

    switch ($letter) {
      case 'j':
        $strftime_format .= '%A ';
        break;
      case 'n':
        $strftime_format .= '%d ';
        break;
      case 'm':
        $strftime_format .= '%B ';
        break;
      case 'a':
        $strftime_format .= '%Y ';
        break;

      default: $strftime_format .= $letter;
    }
  }

  return strftime($strftime_format, (strtotime($date)));
}

/* get the date year from a (Y-m-d) formatted date */

function get_date_year($date) {
  $datetime = DateTime::createFromFormat("Y-m-d", $date);
  return $datetime->format("Y");
}

/* Check if a date is between 2 dates */

function date_in_range($start_date, $end_date, $date) {

  // Convert to timestamp
  $start_ts = strtotime($start_date);
  $end_ts = strtotime($end_date);
  $user_ts = strtotime($date);

  return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));
}