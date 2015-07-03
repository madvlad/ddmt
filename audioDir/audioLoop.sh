#!/bin/bash

fn="$1"
string=""
count=0
#echo "#This is a comment" > audioMake.txt
for f in "$fn"/*.ogg
do
   string="$string $f"
   count=`expr $count + 1`
done
string="oggz merge -o $fn/$fn.ogg $string"
echo $string >> audioMake.txt
eval $string
