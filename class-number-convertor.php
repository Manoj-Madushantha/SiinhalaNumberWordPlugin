<?php
class Convertor {
  
    private static $counter = 0;
    private static $sep1 = False;
    private static $sep2 = False;
    private static $sep3 = False;
    private static $oneThousandIdentifier = False;
    private static $entranceHundred = False;
    private static $entranceThousand = False;


    public static function ConvertWord ($number) {

        if ($number > 0) {
            return self::numberToWords($number, self::$counter, self::$sep1, self::$sep2, self::$sep3, self::$entranceHundred, self::$entranceThousand, self::$oneThousandIdentifier) . "යි" . PHP_EOL;
        } else {
            if ($number == 0) {
                return "බිංදුවයි" . PHP_EOL;
            } else {
                return "සෘණ " . self::numberToWords(abs($number), self::$counter, self::$sep1, self::$sep2, self::$sep3, self::$entranceHundred, self::$entranceThousand, self::$oneThousandIdentifier) . "යි" . PHP_EOL;
            }
        }
        
    }
  
    function initializeTensMap(&$tensMap) {
        $tensMap[0] = "බිංදුව";
        $tensMap[1] = "දහය";
        $tensMap[2] = "විස්ස";
        $tensMap[3] = "තිහ";
        $tensMap[4] = "හතළිය";
        $tensMap[5] = "පනහ";
        $tensMap[6] = "හැට";
        $tensMap[7] = "හැත්තෑව";
        $tensMap[8] = "අසුව";
        $tensMap[9] = "අනූව";
    }
  
    function initializeTensMapDup(&$tensMapDup) {
        $tensMapDup[0] = "බිංදුව";
        $tensMapDup[1] = "දස";
        $tensMapDup[2] = "විසි";
        $tensMapDup[3] = "තිස්";
        $tensMapDup[4] = "හතළිස්";
        $tensMapDup[5] = "පනස්";
        $tensMapDup[6] = "හැට";
        $tensMapDup[7] = "හැත්තෑ";
        $tensMapDup[8] = "අසූ";
        $tensMapDup[9] = "අනූ";
    }
  
    function initializeUnitMap(&$unitMap) {
        $unitMap[0] = "බිංදුව";
        $unitMap[1] = "එක";
        $unitMap[2] = "දෙක";
        $unitMap[3] = "තුන";
        $unitMap[4] = "හතර";
        $unitMap[5] = "පහ";
        $unitMap[6] = "හය";
        $unitMap[7] = "හත";
        $unitMap[8] = "අට";
        $unitMap[9] = "නවය";
        $unitMap[10] = "දහය";
        $unitMap[11] = "එකොළහ";
        $unitMap[12] = "දොළහ";
        $unitMap[13] = "දහතුන";
        $unitMap[14] = "දහ  හතර";
        $unitMap[15] = "පහළව";
        $unitMap[16] = "දහසය";
        $unitMap[17] = "දහ හත";
        $unitMap[18] = "දහ අට";
        $unitMap[19] = "දහ නවය";
    }
  
    function initializeUnitMapDup(&$unitMapDup) {
        $unitMapDup[0] = "බිංදුව";
        $unitMapDup[1] = "එක්";
        $unitMapDup[2] = "දෙ ";
        $unitMapDup[3] = "තුන්";
        $unitMapDup[4] = "හාර";
        $unitMapDup[5] = "පන්";
        $unitMapDup[6] = "හය";
        $unitMapDup[7] = "හත්";
        $unitMapDup[8] = "අට";
        $unitMapDup[9] = "නව";
        $unitMapDup[10] = "දස ";
        $unitMapDup[11] = "එකොළොස්";
        $unitMapDup[12] = "දොළොස්";
        $unitMapDup[13] = "දහතුන්";
        $unitMapDup[14] = "දහ  හතර";
        $unitMapDup[15] = "පහළොස්";
        $unitMapDup[16] = "දහසය";
        $unitMapDup[17] = "දහ හත්";
        $unitMapDup[18] = "දහ අට";
        $unitMapDup[19] = "දහ නව";
    }
  
    private static function  numberToWords($number, $counter, $sep1, $sep2, $sep3, $entranceHundred, $entranceThousand, $oneThousandIdentifier) {
        # ##numberToWord() is conversion function of the number to sinhala words.
        # 
        # Parameters :
        # 
        # number - number to convert to word
        # Type : Integer
        # 
        # sep1   - use to seperate internal number groups (level 1 seperator)
        # Type : Boolean
        # 
        # sep2   - use to seperate internal number groups (level 2 seperator)
        # Type : Boolean
        # 
        # sep3   - use to seperate internal number groups (level 3 seperator)
        # Type : Boolean
        # 
        # EntranceHundred - use to identify the number is in hundred range to the function
        # Type : Boolean
        # 
        # EntranceThousand - use to identify the number is in thousand range to the function
        # Type : Boolean
        # 
        # OneThousandIdentifier - use to identify is the thousand is one thousand range
        # 
        # return - word
        # Type : String
        
        $unitMap = array();
        $tensMap = array();
        $unitMapDup = array();
        $tensMapDup = array();
        
        $words = "";
        if (intval($number / 1000000) > 0) {
            
            self::$counter = self::$counter + 1;
            
            if ($number % 1000000 > 0) {
                
                self::$sep1 = False;
                
            } else {
                
                self::$sep1 = True;
                
            }
            
            if (intval($number / 1000000) < 100) {
                
                self::$sep2 = False;
                
            } else {
                
                self::$sep2 = True;
                
            }
            
            if (self::$sep1 == False) {
                
                $words = $words . self::numberToWords(intval($number / 1000000), self::$counter , self::$sep1, self::$sep2, self::$sep3, self::$entranceHundred, self::$entranceThousand, self::$oneThousandIdentifier) . " මිලියන ";
            
            } else {
                
                if (intval($number/1000000) == 1) {
                    
                    $words = $words . "මිලියනය";
                    
                } else {
                    
                    $words = $words . self::numberToWords(intval($number / 1000000), self::$counter , self::$sep1, self::$sep2, self::$sep3, self::$entranceHundred, self::$entranceThousand, self::$oneThousandIdentifier) . " මිලියනය ";
                    
                }
                
            }
            
            self::$counter = 1;
            
            $number = $number % 1000000;
            
        }
        
        if (intval($number / 1000) > 0) {
            
            self::$counter = self::$counter + 1;
            
            if (self::$counter == 1) {
                
                self::$entranceThousand = True;
                
            } else {
                
                self::$entranceThousand = False;
                
            }
            
            if (intval($number / 1000) == 1) {
                
                self::$oneThousandIdentifier = True;
                
            } else {
                
                self::$oneThousandIdentifier = False;
                
            }
            
            if ($number % 1000 > 0) {
                
                self::$sep1 = False;
                
            } else {
                
                self::$sep1 = True;
                
            }
            
            if (intval($number / 1000) < 100) {
                
                self::$sep2 = False;
                
            } else {
                
                self::$sep2 = True;
                
            }
            
            if (intval($number / 1000) % 10 > 0) {
                
                self::$sep3 = False;
                
            } else {
                
                self::$sep3 = True;
                
            }
            
            if (self::$sep1 == False) {
                
                $words = $words . self::numberToWords(intval($number / 1000), self::$counter, self::$sep1, self::$sep2, self::$sep3, self::$entranceHundred, self::$entranceThousand, self::$oneThousandIdentifier) . " දහස් ";
                
            } else {

                if (self::$entranceThousand == true && intval($number/1000) == 1) {
                
                    $words = $words . "දහස";
                    
                } else {
                    
                    $words = $words . self::numberToWords(intval($number / 1000), self::$counter, self::$sep1, self::$sep2, self::$sep3, self::$entranceHundred, self::$entranceThousand, self::$oneThousandIdentifier) . " දහස ";
                    
                }

            }
            
            self::$counter = self::$sep2?1:self::$counter;
            
            self::$sep1 = False;
            
            self::$sep2 = False;
            
            self::$sep3 = False;
            
            self::$entranceThousand = False;
            
            self::$oneThousandIdentifier = False;
            
            $number = $number % 1000;
            
            if ($number < 100) {
                
                if ($number % 10 > 0) {
                    
                    self::$sep3 = False;
                    
                } else {
                    
                    self::$sep3 = True;
                    
                }
            }
        }
        if (intval($number / 100) > 0) {
            
            self::$counter = self::$counter + 1;
            
            if (self::$counter == 1) {
                
                self::$entranceHundred = True;
                
            } else {
                
                self::$entranceHundred = False;
                
            }
            
            if ($number % 100 > 0) {
                
                self::$sep1 = False;
                
            } else {
                
                if (self::$sep2 == False) {
                    
                    self::$sep1 = True;
                    
                } else {
                    
                    self::$sep1 = False;
                    
                }
            }
            
            if (self::$sep1 == False) {
                
                $words = $words . self::numberToWords(intval($number / 100), self::$counter, self::$sep1, self::$sep2, self::$sep3, self::$entranceHundred, self::$entranceThousand, self::$oneThousandIdentifier) . " සිය ";
                
            } else {

                if (self::$entranceHundred == true && intval($number/100) == 1) {
                    
                    $words = $words . "සියය";
                    
                } else {
                    
                    $words = $words . self::numberToWords(intval($number / 100), self::$counter, self::$sep1, self::$sep2, self::$sep3, self::$entranceHundred, self::$entranceThousand, self::$oneThousandIdentifier) . " සියය ";
                    
                }
                
            }
            
            self::$sep1 = False;
            //self::$counter = 1;
            
            $number = $number % 100;
            
            self::$counter = self::$counter + 1;
            
            if ($number < 20) {
                
                self::$sep1 = True;
                
            } else {
                
                if ($number % 10 > 0) {
                    
                    self::$sep1 = False;
                    
                } else {
                    
                    self::$sep1 = True;
                    
                }
            }
        }
        
        if ($number > 0) {
            
            self::initializeUnitMap($unitMap);
            
            self::initializeTensMap($tensMap);
            
            self::initializeUnitMapDup($unitMapDup);
            
            self::initializeTensMapDup($tensMapDup);
            
            if ($number < 20) {
                
                if (self::$counter > 0) {
                    
                    if ($number == 1) {
                        
                        if (self::$oneThousandIdentifier == False) {
                            
                            if (self::$counter == 3 && self::$sep1 == False) {
                                
                                $words = $words . $unitMapDup[$number];
                                
                            } else {
                                
                                if (self::$sep2 == False) {
                                
                                    $words = $words . $unitMap[$number];
                                    
                                  } else {
                                  
                                    $words = $words . $unitMapDup[$number];
                                    
                                  }
                                
                            }
                            
                        } else {
                            
                            if (self::$counter == 1) {
                                
                                $words = $words . $unitMapDup[$number];
                                
                            } else {
                                
                                if (self::$counter == 2) {
                                    
                                    $words = $words . $unitMap[$number];
                                    
                                } else {
                                    
                                    if (self::$counter == 3) {
                                        
                                        $words = $words . $unitMap[$number];
                                        
                                    } else {
                                        
                                        $words = $words . $unitMapDup[$number];
                                        
                                    }
                                }
                            }
                        }
                        
                    } else {
                        
                        if (self::$sep1 == False) {
                            
                            if (self::$counter == 1) {
                                
                                if (self::$entranceThousand == False) {
                                    
                                    if (self::$entranceHundred == False) {
                                        
                                        $words = $words . $unitMap[$number];
                                        
                                    } else {
                                        
                                        $words = $words . $unitMapDup[$number];
                                        
                                    }
                                    
                                } else {
                                    
                                    $words = $words . $unitMapDup[$number];
                                    
                                }
                                
                            } else {
                                
                                if (self::$counter == 2) {
                                    
                                    $words = $words . $unitMapDup[$number];
                                    
                                } else {
                                    
                                    $words = $words . $unitMap[$number];

                                }
                            }
                            
                        } else {
                            
                            if (self::$entranceThousand == False) {
                                
                                if (self::$counter == 2) {
                                    
                                    if (self::$entranceHundred == False) {
                                        
                                        $words = $words . $unitMapDup[$number];
                                        
                                    } else {
                                        
                                        $words = $words . $unitMap[$number];
                                        
                                    }
                                    
                                    self::$entranceHundred = False;
                                    
                                } else {
                                    
                                    if (self::$entranceHundred == False) {
                                        
                                        $words = $words . $unitMap[$number];
                                        
                                    } else {
                                        
                                        $words = $words . $unitMapDup[$number];
                                        
                                    }
                                    
                                }
                                
                            } else {
                                
                                if ($number == 4) {
                                    
                                    $words = $words . $unitMap[$number];
                                    
                                } else {
                                    
                                    $words = $words . $unitMapDup[$number];
                                    
                                }                              
                            }
                        }
                    }
                    
                } else {
                    
                    $words = $words . $unitMap[$number];
                    
                }
                
            } else {
                
                if (self::$sep1 == False && self::$sep2 == False && self::$sep3 == False) {
                    
                    if ($number < 100 && self::$counter == 0) {
                        
                        if ($number % 10 > 0) {
                            
                            $words = $words . $tensMapDup[intval($number / 10)];
                            
                        } else {
                            
                            $words = $words . $tensMap[intval($number / 10)];
                            
                        }
                        
                    } else {
                        
                        $words = $words . $tensMapDup[intval($number / 10)];
                        
                    }
                    
                } else {
                    
                    if (self::$entranceThousand == False) {
                        
                        $words = $words . $tensMap[intval($number / 10)];
                        
                    } else {
                        
                        $words = $words . $tensMapDup[intval($number / 10)];
                        
                    }
                }
                
                if ($number % 10 > 0) {
                    
                    if (self::$entranceThousand == False) {
                        
                        if (self::$counter < 3) {
                            
                            $words = $words . $unitMap[$number % 10];
                            
                        } else {
                            
                            if (self::$counter == 3) {
                                
                                $words = $words . $unitMap[$number % 10];
                                
                            } else {
                                
                                $words = $words . $unitMapDup[$number % 10];
                                
                            }
                        }
                        
                    } else {
                        
                        if ($number % 10 == 4) {
                            
                            $words = $words . $unitMap[$number % 10];
                            
                        } else {
                            
                            $words = $words . $unitMapDup[$number % 10];
                            
                        }
                    }
                }
            }
        }

        return $words;
    }
  
    function console_log($output, $with_script_tags = true) {
        $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . ');';
        if ($with_script_tags) {
            $js_code = '<script>' . $js_code . '</script>';
        }
        echo $js_code;
    }
}

?>