<?php
namespace Helper;

/**
 * A helper trait
 */
trait DataFormaterTrait {

	private function formatAmount($summ)
	{
		return '$' . number_format($summ, 2, '.', '');
	}
}