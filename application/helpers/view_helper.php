<?php

function FormatHeaderStyle($string)
{
	$header_font = (strlen($string) > 33) ? " style='font-size:17px; top:16px'" : "";
	$header_font = (strlen($string) > 42) ? " style='font-size:14px; top:18px;'" : $header_font;
	return $header_font;
}