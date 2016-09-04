# StringDiff
StringDiff is a small plugin that allows easy manipulation of similarly formatted strings, with very small differences at same places.

## Usage

    new StringDiff
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
    
The `run(array $arr)` method processes the array of data and outputs the unformatted string and an array of arguments, the unformatted string contains `%s` which in turns are replaces by the arguments using `vsprintf($unformatted string, array $args)` after manipulation.

The `getUnformattedString()` method returns the unformatted string which contains the `%s` placeholders.

The `getArgs()` returns an array of arguments formatted as following:

    0 => [
        0 => 41
        1 => 1
    ],
    1 => [
      0 => 42,
      1 => 2
    ]
    ...
