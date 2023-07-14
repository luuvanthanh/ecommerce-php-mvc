<?php
class Helper
{
    public function formatNumber($num)
    {
        $numString = '';
        while ($num > 0) {
            $div = $num % 1000;
            $num = floor($num / 1000);

            if ($num != 0) {
                if ($div < 10) {
                    $div = '00' . $div;
                } else if ($div < 100) {
                    $div = '0' . $div;
                }
                $numString = ',' . $div . $numString;
            } else {
                $numString = $div . $numString;
            }
        }

        return $numString;
    }
}
?>