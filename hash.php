<?php
function hashpassword($x){
    $result = "";
    for($i = 0; $i<strlen($x); $i++){
        //lower case
        if($x[$i] == 'a'){$result .= "c0";}
        elseif($x[$i] == 'b'){$result .= "59";}
        elseif($x[$i] == 'c'){$result .= "9d";}
        elseif($x[$i] == 'd'){ $result .= "7f";}
        elseif($x[$i] == 'e'){ $result .= "rc";}
        elseif($x[$i] == 'f'){ $result .= "b6";}
        elseif($x[$i] == 'g'){ $result .= "13";}
        elseif($x[$i] == 'h'){ $result .= "81";}
        elseif($x[$i] == 'i'){ $result .= "ni";}
        elseif($x[$i] == 'j'){ $result .= "1a";}
        elseif($x[$i] == 'k'){ $result .= "a7";}
        elseif($x[$i] == 'l'){ $result .= "pd";}
        elseif($x[$i] == 'm'){ $result .= "xz";}
        elseif($x[$i] == 'n'){ $result .= "io";}
        elseif($x[$i] == 'o'){ $result .= "un";}
        elseif($x[$i] == 'p'){ $result .= "ui";}
        elseif($x[$i] == 'q'){ $result .= "qe";}
        elseif($x[$i] == 'r'){ $result .= "1x";}
        elseif($x[$i] == 's'){ $result .= "4r";}
        elseif($x[$i] == 't'){ $result .= "et";}
        elseif($x[$i] == 'u'){ $result .= "5g";}
        elseif($x[$i] == 'v'){ $result .= "jq";}
        elseif($x[$i] == 'w'){ $result .= "8l";}
        elseif($x[$i] == 'x'){ $result .= "77";}
        elseif($x[$i] == 'y'){ $result .= "v1";}
        elseif($x[$i] == 'z'){ $result .= "mx";}

        //UPPERCASE
        elseif($x[$i] == 'A'){$result .= "Sx";}
        elseif($x[$i] == 'B'){$result .= "5I";}
        elseif($x[$i] == 'C'){$result .= "MJ";}
        elseif($x[$i] == 'D'){ $result .= "Sf";}
        elseif($x[$i] == 'E'){ $result .= "re";}
        elseif($x[$i] == 'F'){ $result .= "aQ";}
        elseif($x[$i] == 'G'){ $result .= "Pw";}
        elseif($x[$i] == 'H'){ $result .= "oL";}
        elseif($x[$i] == 'I'){ $result .= "nf";}
        elseif($x[$i] == 'J'){ $result .= "1e";}
        elseif($x[$i] == 'K'){ $result .= "a2";}
        elseif($x[$i] == 'L'){ $result .= "pq";}
        elseif($x[$i] == 'M'){ $result .= "ax";}
        elseif($x[$i] == 'N'){ $result .= "df";}
        elseif($x[$i] == 'O'){ $result .= "cx";}
        elseif($x[$i] == 'P'){ $result .= "ty";}
        elseif($x[$i] == 'Q'){ $result .= "wg";}
        elseif($x[$i] == 'R'){ $result .= "qd";}
        elseif($x[$i] == 'S'){ $result .= "4z";}
        elseif($x[$i] == 'T'){ $result .= "ex";}
        elseif($x[$i] == 'U'){ $result .= "5M";}
        elseif($x[$i] == 'V'){ $result .= "uO";}
        elseif($x[$i] == 'W'){ $result .= "A8";}
        elseif($x[$i] == 'X'){ $result .= "nI";}
        elseif($x[$i] == 'Y'){ $result .= "R5";}
        elseif($x[$i] == 'Z'){ $result .= "4x";}

        //numbers

       
        elseif($x[$i] == '0'){ $result .= "_Y";}
        elseif($x[$i] == '1'){ $result .= "fB";}
        elseif($x[$i] == '2'){ $result .= "c0";}
        elseif($x[$i] == '3'){ $result .= "P3";}
        elseif($x[$i] == '4'){ $result .= "rX";}
        elseif($x[$i] == '5'){ $result .= "Ry";}
        elseif($x[$i] == '6'){ $result .= "YX";}
        elseif($x[$i] == '7'){ $result .= "72";}
        elseif($x[$i] == '8'){ $result .= "5w";}
        elseif($x[$i] == '9'){ $result .= "Sd";}

    }
    return $result;
}

// echo hashpassword("jonwaithira");
// if($password == "Pw1xc09drc"){
//     echo "Match";
// }else{
//     echo "Dont";
// }
// echo bin2hex(random_bytes(1));
// 006cb570acdab0e0bfc8e3dcb7bb4edf - jon
// 0cc175b9c0f1b6a831c399e269772661 - a
// 7fc56270e7a70fa81a5935b72eacbe29 - A