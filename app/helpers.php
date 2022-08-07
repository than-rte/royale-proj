<?php

/**
 * Checks if string is a valid calendar date
 * @param {string} date - from schedule page
 * @return boolean
 */

function is_schedule_date(string $date) 
{
  $pattern = "/\b([0][1-9]|[1-9]|1[0-2])\b[-](19|[2-9][0-9])\d{2}$/";
  return preg_match($pattern, $date) === 1 ? true : false;
}