<?php
$prime[0]=2;
$count=1;
echo "2\n";
for($i=3;$i<1000000;$i++)
{
    $b=true;
    for($j=0;$j<$count;$j++)
    {
        if($i%$prime[$j]==0)
        {
            $b=false;
            break;
        }
    }
    if($b)
    {
        echo $i."\n";
        $prime[$count]=$i;
        $count++;
    }
}