<?php

declare(strict_types=1);

namespace App\Y2020;

use Phaoc\DayBase;
use Phaoc\DayInterface;

class Day19 extends DayBase implements DayInterface
{
    private array $r;
    /**
     * @return iterable<string>
     */
    public function testPart1(): iterable
    {
        //        yield '2' => '0: 1 2
        //1: "a"
        //2: 1 3 | 3 1
        //3: "b"
        //
        //aab
        //abb
        //aba
        //bab
        //';

        yield '2' => '0: 4 1 5
1: 2 3 | 3 2
2: 4 4 | 5 5
3: 4 5 | 5 4
4: "a"
5: "b"

ababbb
bababa
abbbab
aaabbb
aaaabbb';
    }

    /**
     * @return iterable<string>
     */
    public function testPart2(): iterable
    {
        yield '12' => '42: 9 14 | 10 1
9: 14 27 | 1 26
10: 23 14 | 28 1
1: "a"
11: 42 31
5: 1 14 | 15 1
19: 14 1 | 14 14
12: 24 14 | 19 1
16: 15 1 | 14 14
31: 14 17 | 1 13
6: 14 14 | 1 14
2: 1 24 | 14 4
0: 8 11
13: 14 3 | 1 12
15: 1 | 14
17: 14 2 | 1 7
23: 25 1 | 22 14
28: 16 1
4: 1 1
20: 14 14 | 1 15
3: 5 14 | 16 1
27: 1 6 | 14 18
14: "b"
21: 14 1 | 1 14
25: 1 1 | 1 14
22: 14 14
8: 42
26: 14 22 | 1 20
18: 15 15
7: 14 5 | 1 21
24: 14 1

abbbbbabbbaaaababbaabbbbabababbbabbbbbbabaaaa
bbabbbbaabaabba
babbbbaabbbbbabbbbbbaabaaabaaa
aaabbbbbbaaaabaababaabababbabaaabbababababaaa
bbbbbbbaaaabbbbaaabbabaaa
bbbababbbbaaaaaaaabbababaaababaabab
ababaaaaaabaaab
ababaaaaabbbaba
baabbaaaabbaaaababbaababb
abbbbabbbbaaaababbbbbbaaaababb
aaaaabbaabaaaaababaa
aaaabbaaaabbaaa
aaaabbaabbaaaaaaabbbabbbaaabbaabaaa
babaaabbbaaabaababbaabababaaab
aabbbbbaabbbaaaaaabbbbbababaaaaabbaaabba';
    }

    public function solvePart1(string $input): string
    {
        list($rules, $data) = explode("\n\n", $input);
        $rules = explode("\n", $rules);
        foreach ($rules as $ruleRow) {
            list($key, $val) = explode(': ', $ruleRow);
            $this->r[$key] = $val;
        }

        $prul = $this->parseRule(0);
        preg_match_all('/^' . $prul . '$/sm', $data, $ar);
        return (string)count($ar[0]);
    }

    public function solvePart2(string $input): string
    {
        $input = $this->parseInput($input);
        return '';
    }

    private function parseRule($int)
    {
        $ret = '';
        if (substr($this->r[$int], 0, 1) == '"') {
            return substr($this->r[$int], 1, 1);
        }
        $a = explode(' | ', $this->r[$int]);
        $irets = [];
        foreach ($a as $r) {
            $nr = explode(' ', $r);
            $iret = '';
            foreach ($nr as $nnr) {
                $iret .= $this->parseRule($nnr);
            }
            $irets[] = $iret;
        }
        if (count($a) == 2) {
            $ret .= '(' . join('|', $irets) . ')';
        } else {
            $ret = join('', $irets);
        }
        //        echo $ret . PHP_EOL;
        return $ret;
    }
}
