<?php

class Overlap
{
    public function getOverlap(array $range1, array $range2): array
    {
        $a1 = min($range1);
        $a2 = max($range1);
        $b1 = min($range2);
        $b2 = max($range2);

        $overlappingStart = max($a1, $b1);
        $overlappingEnd = min($a2, $b2);

        if ($overlappingStart <= $overlappingEnd) {
            return [
                'Overlapping start:' => $overlappingStart,
                'Overlapping end:' => $overlappingEnd
            ];
        }
        return ['Message:' => 'Overlap not found.'];
    }
}

$a1 = (float)readline('a1:');
$a2 = (float)readline('a2:');
$b1 = (float)readline('b1:');
$b2 = (float)readline('b2:');

$overlap = new Overlap();
$result = $overlap->getOverlap([$a1, $a2], [$b1, $b2]);

foreach ($result as $key => $value) {
    echo $key . $value . PHP_EOL;
}