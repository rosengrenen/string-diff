<?php

namespace StringDiff;

class StringDiff
{
    /**
     * The unformatted string to be used in the
     * vsprintf call
     * @var string
     */
    protected $unformattedString = '';
    /**
     * Array with arguments replacing the %s in the
     * unformatted string
     * @var array
     */
    protected $args = [];
    /**
     * Returns the arguments to be used for a vsprintf
     * call along with the format string
     * @return array
     */
    public function getArgs()
    {
        return $this->args;
    }

    /**
     * Returns the unformatted string to be used in
     * a vsprint call along with the arguments
     * @return string
     */
    public function getUnformattedString()
    {
        return $this->unformattedString;
    }

    /**
     * Takes an array argument of very similarly formatted
     * strings and fills in the $unformattedString and $args
     * variables from the data provided
     * @param  array  $strings Group of very similar strings
     * @return void
     */
    public function run(array $strings)
    {

        // If there are no strings, return nothing

        if (count($strings) == 0) return '';

        // Replacing % with %% so the vsprintf call doesn't
        // bug the arguments

        $strings = str_replace('%', '%%', $strings);
        $num_words = 0;

        // Explodes each string into many smaller containing
        // only words

        foreach($strings as $key => $string)
        {
            $strings[$key] = explode(' ', $string);
        }

        $num_words = count($strings[0]);

        // Array containing the indices of the substrings
        // that are different

        $sub_str_nr = [];

        // Loops through all the words in each string

        for ($n = 0; $n < $num_words; $n++)
        {

            // First round only sets the string to be compared with

            $first_round = true;
            for ($s = 0; $s < count($strings); $s++)
            {
                if ($first_round)
                {
                    $first_round = false;
                    $tmp[0] = $strings[$s][$n];
                }
                else
                {
                    $tmp[1] = $strings[$s][$n];
                    if ($tmp[0] == $tmp[1])
                    {
                        $tmp[0] = $tmp[1];
                    }
                    else
                    {
                        if (!in_array($n, $sub_str_nr))
                        {
                            $sub_str_nr[] = $n;
                        }
                    }
                }
            }
        }

        // Array to hold the arguments, i.e. all the strings
        // that differ from each other. From these the differences
        // will be deduced and put into the $this->args variable

        $args = [];
        foreach($sub_str_nr as $nr)
        {
            $tmpArgs = [];
            for ($a = 0; $a < count($strings); $a++)
            {
                $tmpArgs[] = $strings[$a][$nr];
            }

            $args[] = $tmpArgs;
        }

        foreach($args as $key => $arg)
        {

            // Offset from the beginning of the string that is still the same

            $front_offset = 0;

            // If the offset from the beginning has been maxed

            $front_flag = true;

            // Offset from the end of the string that is still the same

            $back_offset = 0;

            // Id the offset from the end has been maxed

            $back_flag = true;

            // The string to be compared against is the first in line

            $tmp = $arg[0];
            while ($front_flag || $back_flag)
            {

                // Flag 1 & 2 limits to only one increase of offset per loop

                $flag1 = true;
                $flag2 = true;
                for ($a = 1; $a < count($strings); $a++)
                {

                    // The two following if statements compare substring
                    // to substring of length one

                    if ($front_flag && $flag1)
                    {
                        if (substr($tmp, $front_offset, 1) != substr($arg[$a], $front_offset, 1) || is_numeric(substr($arg[$a], $front_offset, 1)))
                        {
                            $front_flag = false;
                        }
                        else
                        {
                            $front_offset++;
                            $flag1 = false;
                        }
                    }

                    if ($back_flag && $flag2)
                    {
                        if (substr($tmp, strlen($tmp) - $back_offset - 1, 1) != substr($arg[$a], strlen($arg[$a]) - $back_offset - 1, 1) || is_numeric(substr($arg[$a], strlen($arg[$a]) - $back_offset - 1, 1)))
                        {
                            $back_flag = false;
                        }
                        else
                        {
                            $back_offset++;
                            $flag2 = false;
                        }
                    }
                }
            }

            // Sets the $this->args variable with the found arguments

            foreach($arg as $arkey => $ar)
            {
                $this->args[$arkey][$key] = (float)substr($arg[$arkey], $front_offset, strlen($arg[$arkey]) - $back_offset - $front_offset);
            }

            // Changes the strings for the unformatted string, switches
            // out the varying part to %s

            $strings[0][$sub_str_nr[$key]] = substr($arg[0], 0, $front_offset) . '%s' . substr($arg[0], strlen($arg[0]) - $back_offset, $back_offset);
        }

        // Creates the unformatted string from the array of
        // words, which originates from the original long string

        $unformattedString = '';
        foreach($strings[0] as $string)
        {
            $unformattedString.= ' ' . $string;
        }

        // Trim whitespaces in the beginning and end of the
        // formatted string

        $this->unformattedString = trim($unformattedString);
        return;
    }
}