<?php

function genDataListNum($id, $min, $max, $step)
{
	$ret = null;
	$retData = null;
	if ($id) {
		if ($min < $max) {
			if ($step > 0) {
				$ret = '<datalist id="' . $id . '">';
				$numA = $min;
				do {
					$numA = number_format($numA, 2, '.', ',');
					$retData .= '<option value="' . $numA . '">';
					$numA += $step;
				} while ($numA <= $max);
				$ret .= $retData . '</datalist>';
			} else {
				$ret = '<span>Minium step number is 1</span>';
			}
		} else {
			$ret = '<span>Incorrect defined min and max</span>';
		}
	} else {
		$ret = '<span>No ID for datalist</span>';
	}
	return $ret;
}
