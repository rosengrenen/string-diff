<?php

use StringDiff;

echo '<pre>';

$stringd = new StringDiff;

$test_array = [
  "Your Cooldown Reduction cap is increased to 41% and you gain 1% Cooldown Reduction",
  "Your Cooldown Reduction cap is increased to 42% and you gain 2% Cooldown Reduction",
  "Your Cooldown Reduction cap is increased to 43% and you gain 3% Cooldown Reduction",
  "Your Cooldown Reduction cap is increased to 44% and you gain 4% Cooldown Reduction",
  "Your Cooldown Reduction cap is increased to 45% and you gain 5% Cooldown Reduction",
];

$stringd->run($test_array);

foreach($stringd->getArgs() as $arg)
{
  echo vsprintf($stringd->getUnformattedString(), $arg) . '<br>';
}

var_dump($stringd->getArgs()) . '<br>';
echo $stringd->getUnformattedString();
