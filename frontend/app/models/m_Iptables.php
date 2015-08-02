<?php
    class Iptables {
        public function parse_chain($chain) {
            $result = shell_exec("iptables -S");
            $result = array_filter(explode("\n", $result));

            unset($result[0]);
            unset($result[1]);
            $result = array_values($result);

            // ToDo: Add this to the database
            $supported_modules = array(
                0 => 'comment',
                1 => 'udp',
                2 => 'tcp',
                3 => 'multiport',
                4 => 'set',
                5 => 'state'
            );

            $supported_options = array(
                0 => 	array(
                    0 => 'type',
                    1 => '-A',
                    2 => '--append'
                ),
                1 => 	array(
                    0 => 'sourceip',
                    1 => '-s',
                    2 => '--source'
                ),
                2 =>	array(
                    0 => 'inint',
                    1 => '-i',
                    2 => '--in-interface'
                ),
                3 =>	array(
                    0 => 'outint',
                    1 => '-o',
                    2 => '--out-interface'
                ),
                4 =>	array(
                    0 => 'proto',
                    1 => '-p',
                    2 => '--protocol'
                ),
                5 =>	array(
                    0 => 'target',
                    1 => '-j',
                    2 => '--jump'
                ),
                6 =>	array(
                    0 => 'policy',
                    1 => '-P',
                    2 => '--policy'
                ),
                7 =>	array(
                    0 => 'sport',
                    1 => '--sport',
                    2 => ''
                ),
                8 =>	array(
                    0 => 'dport',
                    1 => '--dport',
                    2 => ''
                )
            );

            for ($i=0; $i<count($result); $i++) {
                // Seperate rules by space, but keep strings in quotes complete
                preg_match_all('/"(?:\\\\.|[^\\\\"])*"|\S+/', $result[$i], $data2[$i]);

                // Look for supported options
                foreach ($supported_options as $options) {
                    $key = array_search($options[1], $data2[$i][0]);
                    if ($key !== false) {
                        $iptables[$i][$options[0]] = $data2[$i][0][$key+1];
                    } else {
                        $key = array_search($options[2], $data2[$i][0]);

                        if ($key !== false) {
                            $iptables[$i][$options[0]] = $data2[$i][0][$key+1];
                        } else {
                            $iptables[$i][$options[0]] = '';
                        }
                    }
                }

                // Look for used modules
                $keys[$i] = array_keys($data2[$i][0], '-m', true);
                foreach ($keys[$i] as $arraykey => $key) {
                    foreach ($supported_modules as $modules) {
                        if ($data2[$i][0][$key+1] == $modules) {
                            // source and destination port are already handled
                            if ($data2[$i][0][$key+2] != '--sport' && $data2[$i][0][$key+2] != '--dport') {
                                $iptables[$i]['module'][$arraykey] = array(
                                    0 => $data2[$i][0][$key+1],
                                    1 => $data2[$i][0][$key+2],
                                    2 => $data2[$i][0][$key+3]
                                );

                                // If this position is a ! or --tcp-flags, there are 4 or 5 parts
                                if ($data2[$i][0][$key+2] == '!' || $data2[$i][0][$key+2] == '--tcp-flags') {
                                    $iptables[$i]['module'][$arraykey][3] = $data2[$i][0][$key+4];

                                    // If this position is a !, the rule is reversed
                                    // This means there are 4 parts
                                    if ($data2[$i][0][$key+2] == '!') {
                                        $iptables[$i]['module'][$arraykey][4] = $data2[$i][0][$key+5];
                                    }
                                }
                            }
                        }
                        // If modules tcp and upd are filtered, we have to correct the array index
                        // If statement checks if the rule uses a module
                        if (isset($iptables[$i]['module'])) {
                            $iptables[$i]['module'] = array_values($iptables[$i]['module']);
                        }
                    }
                }
            }

            return $iptables;
        }
    }